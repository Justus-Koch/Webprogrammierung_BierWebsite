<?php
    require_once 'User.php';
    require_once 'UserManagementDAO.php';

    class UserManagementSession implements UserManagementDAO{
        private static $instance = null;
        /**
         * Returns the current instance of UserManagementSession.
         * Initializes a new UserManagementSession if it does not exist yet.
         */
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new UserManagementSession();
            }

            return self::$instance;
        }

        private $users = array();

        private function __construct(){
            if(isset($_SESSION["users"])){
                $this->users = unserialize($_SESSION["users"]);
            }else{
                // Dummy Daten einfügen
                $numOfUsers = 3;
                for ($i=0; $i < $numOfUsers; $i++){
                    $newUser = new User($i, "bier@bier.de", password_hash("123", PASSWORD_DEFAULT), "abc", "Bierliebhaber".$i, "bier.jpg");
                    $newUser->activate();
                    $this->users[$i] = $newUser;
                }
                $_SESSION["users"] = serialize($this->users);
                $_SESSION["nextID"] = $numOfUsers;
            }
        }

        public function saveUser($email, $password, $token, $nickname=null){
            $id = $_SESSION["nextID"];
            if(empty($nickname)){
                $nickname="Bierliebhaber".$id;
            }
            if(empty($profile_picture)){
                $profile_picture="profile_picture.jpg";
            }
            
            $newUser = new User($id, $email, $password, $token, $nickname, $profile_picture);
            $this->users[$id] = $newUser;
            $_SESSION["nextID"] = $id + 1;
            $_SESSION["users"] = serialize($this->users);
            return true;
        }

        public function confirmUser($token) {
            $userFound = false;

            foreach ($this->users as $user) {
                if ($user->getToken() === $token) {
                    $user->activate();
                    $userFound = true;
                    break;
                }
            }

            if (!$userFound) {
                throw new UserNotFoundException();
            }

            $_SESSION["users"] = serialize($this->users);

            return true;
        }

        public function findUser($id){
            if (isset($this->users[$id])){
                return $this->users[$id];
            }else{
                throw new UserNotFoundException();
            }
        }
        
        public function updateUser($id, $nickname=null, $profile_picture=null){
            if (isset($this->users[$id])){
                $this->users[$id]->update($nickname, $profile_picture);
                $_SESSION["users"] = serialize($this->users);
            }else{
                throw new UserNotFoundException();
            }
        }

        public function deleteUser($id){
            if (isset($this->users[$id])){
                unset($this->users[$id]);
                $_SESSION["users"] = serialize($this->users);
                error_log("User gelöscht: ".$id);
            }else{
                throw new UserNotFoundException();
            }
        }

        public function login($email, $password){
            foreach ($this->users as $user){
                if($email === $user->getEmail() && password_verify($password, $user->getPassword())){
                    return $user->getID();
                }
            }
            return -1;
        }

        public function toggleFavouriteState($userID, $reviewID){
            $user = $this->findUser($userID);
            if ($user->containsFavorite($reviewID)){
                $user->removeFavorite($reviewID);
                error_log("Favorit entfernt: ". $reviewID);
            }else{
                $user->addFavorite($reviewID);
                error_log("Favorit hinzugefügt: ". $reviewID);
            }
            $_SESSION["users"] = serialize($this->users);
            
        }

        public function userContainsFavourite($userID, $reviewID){
            $user = $this->findUser($userID);
            return $user->containsFavorite($reviewID);
        }
    }
?>