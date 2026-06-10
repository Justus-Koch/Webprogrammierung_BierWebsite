<?php
    if (!isset($abs_path)) {
        require_once "../../path.php";
    }
    require_once $abs_path."/php/model/User.php";
    require_once $abs_path."/php/model/UserManagement.php";
    require_once $abs_path."/php/util/imageHandling.php";

    class UserController{

    public function login(){
        $_SESSION["email"] = $_POST["email"];
        $this->checkLoginParam();
        try{
            $userManagement = UserManagement::getInstance();
            $userID = $userManagement->login($_POST["email"], $_POST["password"]);

            if($userID >= 0){
                $_SESSION["message"] = "login_success";
                $_SESSION["userID"] = $userID;
                error_log("user id bei login gesetzt". $_SESSION["userID"]);
                header("Location: ". ROOT . "php/view/index.php");
                exit;
            }else{
                $_SESSION["message"] = "login_failed";
                header("Location: ". ROOT . "php/view/login.php");
                exit;
            }
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function logout(){
        unset($_SESSION["userID"]);
        $_SESSION["message"] = "logout_success";
        header("Location: ". ROOT . "php/view/index.php");
        exit;
    }

    public function registrate(){
        $_SESSION["nickname"] = $_POST["nickname"];
        $_SESSION["email"] = $_POST["email"];
        $this->checkRegistrationParam();
        try{
            $userManagement = UserManagement::getInstance();

            if($userManagement->saveUser($_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["nickname"])){
                $_SESSION["message"] = "registration_success";
                header("Location: ". ROOT . "php/view/login.php");
                exit;
            }else{
                $_SESSION["message"] = "email_already_in_use";
                header("Location: ". ROOT . "php/view/registration.php");
                exit;
            }
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }

    }

    public function updateUser(){
        if (!isset($_SESSION["userID"])) {
            header("Location: ". ROOT . "php/view/login.php");
            exit;
        }
        $_SESSION["nickname"] = $_POST["nickname"];
        $this->checkUpdateParam();
        try{
            $userManagement = UserManagement::getInstance();
            if(isImageSet("profile_picture")){
                $new_name = checkAndUploadImage("profile_picture");
                if($new_name != null){
                    $userManagement->updateUser($_SESSION["userID"], $_POST["nickname"], $new_name);
                }else{
                    header("Location: ". ROOT . "php/view/edit-profile.php");
                    exit;
                }
                
            }else{
                $userManagement->updateUser($_SESSION["userID"], $_POST["nickname"]);
            }

            $_SESSION["message"] = "update_profile_success";
            header("Location: ". ROOT . "php/view/profile.php");
            exit;
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function deleteUser(){
        if (!isset($_SESSION["userID"])) {
            header("Location: ". ROOT . "php/view/login.php");
            exit;
        }
        try{
            $userManagement = UserManagement::getInstance();
            error_log("User löschen: ".$_SESSION["userID"]);
            $userManagement->deleteUser($_SESSION["userID"]);
            unset($_SESSION["userID"]);


            $_SESSION["message"] = "delete_user_success";
            header("Location: ". ROOT . "php/view/index.php");
            exit;
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function getUser(){
        if(!isset($_SESSION["userID"])){
            $_SESSION["message"] = "missing_user_id";
            header("Location: ". ROOT . "php/view/index.php");
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

    public function isFavourite($review_id){
        if(!isset($_SESSION["userID"])){
            return false;
        }
        try{
            $userManagement = UserManagement::getInstance();
            return $userManagement->userContainsFavourite($_SESSION["userID"], $review_id);
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function addFavourite(){
        if (!isset($_SESSION["userID"])) {
            header("Location: ". ROOT . "php/view/login.php");
            exit;
        }
        try{
            $userManagement = UserManagement::getInstance();
            $review_id = $_POST["review_id"];
            $userManagement->toggleFavouriteState($_SESSION["userID"], $review_id);
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
            header("Location: ". ROOT . "php/view/login.php");
            exit;
        }else if(empty($_POST["email"]) || empty($_POST["password"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            header("Location: ". ROOT . "php/view/login.php");
            exit;
        }
    }

    /**
     * Checks if all parameters are set, required parameters are not empty, email is valid and if passwords are equal.
     */

    private function checkRegistrationParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["password_confirm"]) || !isset($_POST["nickname"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: ". ROOT . "php/view/registration.php");
            exit;
        }else if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_confirm"]) || empty($_POST["nickname"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            header("Location: ". ROOT . "php/view/registration.php");
            exit;
        }else if ($_POST["password"] !== $_POST["password_confirm"]){
            $_SESSION["message"] = "passwords_not_equal";
            header("Location: ". ROOT . "php/view/registration.php");
            exit;
        }else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $_SESSION["message"] = "invalid_email";
            header("Location: ". ROOT . "php/view/registration.php");
            exit;
        }
        if (mb_strlen($_POST["nickname"], 'UTF-8') > 50 || mb_strlen($_POST["email"], 'UTF-8') > 50 || mb_strlen($_POST["password"], 'UTF-8') > 50) {
            $_SESSION["message"] = "input_too_long";
            header("Location: ". ROOT . "php/view/registration.php");
            exit;
        }
    }

    private function checkUpdateParam(){
        if (!isset($_POST["nickname"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            header("Location: ". ROOT . "php/view/edit-profile.php");
            exit;
        }
        if (mb_strlen($_POST["nickname"], 'UTF-8') > 50) {
            $_SESSION["message"] = "nickname_too_long";
            header("Location: ". ROOT . "php/view/edit-profile.php");
            exit;
        }
    }

    private function handleUserNotFoundException()
    {
        $_SESSION["message"] = "user_not_found";
        header("Location: ". ROOT . "php/view/index.php");
        exit;
    }
    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        header("Location: ". ROOT . "php/view/index.php");
        exit;
    }
    }
    ?>
