<?php
    require_once "./php/model/User.php";
    require_once "./php/model/UserManagement.php";

    class UserController{

    public function login(){
        $this->checkLoginParam();
        try{
            $userManagement = UserManagement::getInstance();
            $userID = $userManagement.login($_POST["email"], $_POST["password"]);

            if($userID >= 0){
                $_SESSION["message"] = "login_success";
                $_SESSION["userID"] = $userID;
                header("Location: index.php");
                exit;
            }else{
                $_SESSION["message"] = "login_failed";
                header("Location: login.php");
                exit; 
            }
        }catch(InternalErrorException $e){
            handleInternalErrorException();
        }
    }

    public function logout(){
        checkValidUserID();
        unset($_SESSION["userID"]);
        $_SESSION["message"] = "logout_success";
        header("Location: index.php");
    }

    public function registrate(){
        $this->checkRegistrationParam();
        try{
            $userManagement = UserManagement::getInstance();
            
            // profilbild?
            $userManagement->saveUser($_POST["email"], $_POST["password"], $_POST["nickname"]);

            $_SESSION["message"] = "registration_success";
            header("Location: login.php");
            exit;
        }catch(InternalErrorException $e){
            handleInternalErrorException();
        }

    }

    public function updateUser(){
        $this->checkUpdateParam();
        try{
            $userManagement = UserManagement::getInstance();
            $userManagement->updateUser($_SESSION["userID"], $_POST["nickname"], $_POST["profile_picture"]);

            $_SESSION["message"] = "update_profile_success";
            header("Location: profile.php");
            exit;
        }catch(UserNotFoundException $e){
            handleUserNotFoundException();
        }catch(InternalErrorException $e){
            handleInternalErrorException();
        }
    }

    public function deleteUser(){
        $this->checkValidUserID();
        try{
            $userManagement = UserManagement::getInstance();
            $userManagement->deleteUser($_SESSION["userID"]);

            $_SESSION["message"] = "delete_user_success";
            header("Location: index.php");
            exit;
        }catch(UserNotFoundException $e){
            handleUserNotFoundException();
        }catch(InternalErrorException $e){
            handleInternalErrorException();
        }
    }

    /**
     * Checks if all parameters are set and if required parameters are not empty.
     */

    private function checkLoginParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: login.php");
            exit;
        }else if(empty($_POST["email"]) || empty($_POST["password"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            header("Location: login.php");
            exit;
        }
    }

    /**
     * Checks if all parameters are set, required parameters are not empty, email is valid and if passwords are equal.
     */

    private function checkRegistrationParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["password_confirm"]) || !isset($_POST["nickname"])|| !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: registration.php");
            exit;
        }else if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_confirm"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            header("Location: registration.php");
            exit;
        }else if ($_POST["password"] !== $_POST["password_confirm"]){
            $_SESSION["message"] = "passwords_not_equal";
            header("Location: registration.php");
            exit;
        }
        checkValidEmail();
    }

    private function checkUpdateParam(){
        if (!isset($_POST["nickname"]) || !isset($_POST["profile_picture"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: edit-profile.php");
            exit;
        }
        checkValidUserID();
    }

    private function checkValidEmail(){
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $_SESSION["message"] = "invalid_email";
            header("Location: registration.php");
            exit;
        }
    }

    private function checkValidUserID(){
        if(empty($_SESSION("userID"))){
            $_SESSION["message"] = "missing_userID";
            header("Location: index.php");
            exit;
        }
    }

    private function handleUserNotFoundException()
    {
        $_SESSION["message"] = "User_not_found";
        header("Location: index.php");
        exit;
    }
    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        header("Location: index.php");
        exit;
    }
    }
?>