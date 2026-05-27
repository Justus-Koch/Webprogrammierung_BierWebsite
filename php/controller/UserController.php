<?php
    if (!isset($abs_path)) {
        require_once "../../path.php";
    }
    require_once $abs_path."/php/model/User.php";
    require_once $abs_path."/php/model/UserManagement.php";
    define("IMAGE_PATH", $abs_path."/img/");

    class UserController{

    public function login(){
        $this->checkLoginParam();
        try{
            $userManagement = UserManagement::getInstance();
            $userID = $userManagement->login($_POST["email"], $_POST["password"]);

            if($userID >= 0){
                $_SESSION["message"] = "login_success";
                $_SESSION["userID"] = $userID;
                error_log("user id bei login gesetzt". $_SESSION["userID"]);
                header("Location: /php/view/index.php");
                exit;
            }else{
                $_SESSION["message"] = "login_failed";
                header("Location: /php/view/login.php");
                exit; 
            }
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function logout(){
        unset($_SESSION["userID"]);
        $_SESSION["message"] = "logout_success";
        header("Location: /php/view/index.php");
        exit;
    }

    public function registrate(){
        $this->checkRegistrationParam();
        try{
            $userManagement = UserManagement::getInstance();
            
            $userManagement->saveUser($_POST["email"], $_POST["password"], $_POST["nickname"]);

            $_SESSION["message"] = "registration_success";
            header("Location: /php/view/login.php");
            exit;
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }

    }

    public function updateUser(){
        error_log("Update gestartet: ".$_SESSION["userID"]);
        $this->checkUpdateParam();
        try{   
            if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] !== UPLOAD_ERR_NO_FILE){
                if(!$_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK){
                    $_SESSION["message"] = "upload_error";
                    header("Location: /php/view/edit-profile.php");
                    exit;
                }
                $types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if(!in_array($_FILES["profile_picture"]["type"], $types)){
                    $_SESSION["message"] = "upload_type_not_allowed";
                    header("Location: /php/view/edit-profile.php");
                    exit;
                }
                //Namen prüfen
                $file_type = ".". explode("/", $_FILES["profile_picture"]["type"])[1];
                $new_name = $_SESSION["userID"].time().$file_type;
                $new_dest = IMAGE_PATH.$new_name;
                error_log("New destination: ".$new_dest);
                $success = move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $new_dest);
                if($success){
                    $userManagement = UserManagement::getInstance();
                    $userManagement->updateUser($_SESSION["userID"], $_POST["nickname"], $new_name);
                }else{
                    $_SESSION["message"] = "upload_error";
                    header("Location: /php/view/edit-profile.php");
                    exit;
                }

            }else{
                $userManagement = UserManagement::getInstance();
                $userManagement->updateUser($_SESSION["userID"], $_POST["nickname"]);
            }

            error_log("User geupdatet: ".$_POST["nickname"]);
            $_SESSION["message"] = "update_profile_success";
            header("Location: /php/view/profile.php");
            exit;
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function deleteUser(){
        if(!$this->checkValidUserID()){
            header("Location: php/view/edit-profile.php");
            exit;
        }
        try{
            $userManagement = UserManagement::getInstance();
            error_log("User löschen: ".$_SESSION["userID"]);
            $userManagement->deleteUser($_SESSION["userID"]);
            unset($_SESSION["userID"]);

        
            $_SESSION["message"] = "delete_user_success";
            header("Location: php/view/index.php");
            exit;
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function getUser(){
        if(!$this->checkValidUserID()){
            header("Location: ./index.php");
            exit;
        }
        try{
            $userManagement = UserManagement::getInstance();
            return $userManagement->findUser($_SESSION["userID"]);
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    /**
     * Checks if all parameters are set and if required parameters are not empty.
     */

    private function checkLoginParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: /php/view/login.php");
            exit;
        }else if(empty($_POST["email"]) || empty($_POST["password"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            header("Location: /php/view/login.php");
            exit;
        }
    }

    /**
     * Checks if all parameters are set, required parameters are not empty, email is valid and if passwords are equal.
     */

    private function checkRegistrationParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["password_confirm"]) || !isset($_POST["nickname"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: /php/view/registration.php");
            exit;
        }else if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_confirm"]) || empty($_POST["nickname"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            header("Location: /php/view/registration.php");
            exit;
        }else if ($_POST["password"] !== $_POST["password_confirm"]){
            $_SESSION["message"] = "passwords_not_equal";
            header("Location: /php/view/registration.php");
            exit;
        }else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $_SESSION["message"] = "invalid_email";
            header("Location: /php/view/registration.php");
            exit;
        }
    }

    private function checkUpdateParam(){
        if (!isset($_POST["nickname"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: /php/view/edit-profile.php");
            exit;
        }
        else if(!$this->checkValidUserID()){
            header("Location: /php/view/edit-profile.php");
            exit;
        }
    }


    private function checkValidUserID(){
        if(!isset($_SESSION["userID"])){
            $_SESSION["message"] = "missing_userID";
            return false;
        }
        return true;
    }

    private function handleUserNotFoundException()
    {
        $_SESSION["message"] = "user_not_found";
        header("Location: /php/view/index.php");
        exit;
    }
    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        header("Location: /php/view/index.php");
        exit;
    }
    }
    ?>