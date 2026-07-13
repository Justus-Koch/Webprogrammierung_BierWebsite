<?php
if (!isset($abs_path)) {
  require_once "../../path.php";
}
require_once 'User.php';
require_once 'UserManagementDAO.php';
require_once 'PDOSQLite.php';

class UserManagementPDOSQLite implements UserManagementDAO{
    private static $instance = null;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserManagementPDOSQLite();
        }

        return self::$instance;
    }

    public function saveUser($email, $password, $token, $nickname = null) {
        try {
            if (empty($nickname)) {
                $nickname = "Bierliebhaber";
            }
            $profile_picture = "profile_picture.jpg";
            $db = getConnection();

            $db->exec('BEGIN IMMEDIATE TRANSACTION'); 

            $checkSql = "SELECT 1 FROM user WHERE email = ? AND is_active = 1 LIMIT 1";
            $checkStmt = $db->prepare($checkSql);
            $checkStmt->execute([$email]);
            if ($checkStmt->fetch()) {
                $db->exec('ROLLBACK');
                return false;
            }

            $checkToken = "SELECT user_id FROM user WHERE email = ? AND is_active = 0 LIMIT 1";
            $checkTokenStmt = $db->prepare($checkToken);
            $checkTokenStmt->execute([$email]);
            $inactiveUser = $checkTokenStmt->fetch(PDO::FETCH_ASSOC);

            if ($inactiveUser) {
                $updateSql = "UPDATE user SET token = ?, password = ?, nickname = ? WHERE email = ? AND is_active = 0";
                $updateSqlStmt = $db->prepare($updateSql);
                $updateSqlStmt->execute([$token, $password, $nickname, $email]);
                
                $result = $inactiveUser['user_id'];
            } else {
                $sql = "INSERT INTO user (email, password, nickname, profile_picture, token) VALUES (?, ?, ?, ?, ?)";
                $command = $db->prepare($sql);
                if (!$command->execute([$email, $password, $nickname, $profile_picture, $token])) {
                    throw new InternalErrorException();
                }
                $result = $db->lastInsertId();
            }

            $db->exec('COMMIT');
            return $result;

        } catch (PDOException $exc) {
            if (isset($db)) {
                $db->exec('ROLLBACK');
            }
            throw new InternalErrorException();
        }
    }

    public function confirmUser($token){
        try{
            $db = getConnection();
            $sql = "UPDATE user SET is_active = 1 WHERE token = ?";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            if (!$command->execute(array($token))){
                throw new InternalErrorException();
            }
            if($command->rowCount() == 0){
                throw new UserNotFoundException();
            }
            return true;
        }catch(PDOException $exc){
            // UNIQUE constraint
            if ($exc->getCode() == 23000) {
                return false;
            }
            throw new InternalErrorException();
        }
    }

    public function findUser($id){
        try{
            $db = getConnection();
            $sql = "SELECT * FROM user WHERE user_id = ?";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            if(!$command->execute(array($id))){
                throw new InternalErrorException();
            }
            $userData = $command->fetchObject();
            if(empty($userData)){
                throw new UserNotFoundException();
            }else{
                return new User($id, $userData->email, $userData->password, $userData->nickname, $userData->profile_picture);
            }
        }catch(PDOException $exc){
            throw new InternalErrorException();
        }
    }

    public function updateUser($id, $nickname, $profile_picture=null){
        try {
            $db = getConnection();
            if($profile_picture == null){
                $sql = "UPDATE user SET nickname = ? WHERE user_id = ?";
                $command = $db->prepare($sql);
                if (!$command) {
                    throw new InternalErrorException();
                }
                if (!$command->execute(array($nickname, $id))){
                    throw new InternalErrorException();
                }
            }else{
                $sql = "UPDATE user SET nickname = ?, profile_picture = ? WHERE user_id = ?";
                $command = $db->prepare($sql);
                if (!$command) {
                    throw new InternalErrorException();
                }
                if (!$command->execute(array($nickname, $profile_picture, $id))){
                    throw new InternalErrorException();
                }
            }

        }catch(PDOException $exc){
            throw new UserNotFoundException();
        }
    }

    public function deleteUser($id){
        try {
            $db = getConnection();
            $sql = "DELETE FROM user WHERE user_id = ?";
            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }
            if (!$command->execute(array($id))){
                throw new InternalErrorException();
            }

        }catch(PDOException $exc){
            throw new UserNotFoundException();
        }
    }

    public function login($email, $password){
        try{
            $db = getConnection();
            $sql = "SELECT user_id, password FROM user WHERE email = ? AND is_active = 1";
            $command = $db->prepare($sql);
            $command->execute([$email]);
            $user = $command->fetchObject();

            if ($user && password_verify($password, $user->password)) {
                return $user->user_id;
            }
            return -1;
        }catch(PDOException $exc){
            throw new UserNotFoundException();
        }
    }

    public function toggleFavouriteState($userID, $reviewID){
        try {
            $db = getConnection();
            $db->exec('BEGIN IMMEDIATE TRANSACTION'); 

            $checkReview = $db->prepare("SELECT 1 FROM review WHERE review_id = ?");
            $checkReview->execute([$reviewID]);
            if (!$checkReview->fetch()){
                throw new ReviewNotFoundException();
            }

            $checkUser = $db->prepare("SELECT 1 FROM user WHERE user_id = ?");
            $checkUser->execute([$userID]);
            if (!$checkUser->fetch()){
                throw new UserNotFoundException();
            }

            $checkFavourite = $db->prepare("SELECT 1 FROM likes WHERE user_id = ? AND review_id = ?");
            $checkFavourite->execute([$userID, $reviewID]);

            if ($checkFavourite->fetch()) {
                $deleteFavourite = $db->prepare("DELETE FROM likes WHERE user_id = ? AND review_id = ?");
                $deleteFavourite->execute([$userID, $reviewID]);
                $status = "entfernt";
            } else {
                $insertFavourite = $db->prepare("INSERT INTO likes (user_id, review_id) VALUES (?, ?)");
                $insertFavourite->execute([$userID, $reviewID]);
                $status = "hinzugefügt";
            }

            $db->exec('COMMIT');
            error_log("Favorit $status: Review $reviewID für User $userID");
        } catch (PDOException $e) {
        if (isset($db)) {
            try {
                $db->exec('ROLLBACK');
            } catch (PDOException $rbEx) {
                error_log("Rollback fehlgeschlagen: " . $rbEx->getMessage());
            }
        }
        error_log("Fehler bei toggleFavouriteState: " . $e->getMessage());
        throw new InternalErrorException();
    }

    }

    public function userContainsFavourite($userID, $reviewID){
        try {
            $db = getConnection();
            $checkFavourite = $db->prepare("SELECT 1 FROM likes WHERE user_id = ? AND review_id = ?");
            $checkFavourite->execute([$userID, $reviewID]);

            return $checkFavourite->fetch();
        } catch (PDOException $e) {
            //throw new InternalErrorException();
            return false;
        }
    }
}
?>

