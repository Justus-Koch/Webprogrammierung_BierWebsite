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
                $this->redirect("index.php");
            }else{
                $_SESSION["message"] = "login_failed";
                $this->redirect("login.php");
            }
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function logout(){
        unset($_SESSION["userID"]);
        $_SESSION["message"] = "logout_success";
        $this->redirect("index.php");
    }

    public function registrate(){
        $_SESSION["nickname"] = $_POST["nickname"];
        $_SESSION["email"] = $_POST["email"];
        $this->checkRegistrationParam();
        try{
            $userManagement = UserManagement::getInstance();

            if($userManagement->saveUser($_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["nickname"])){
                $_SESSION["message"] = "registration_success";
                $this->redirect("login.php");
            }else{
                $_SESSION["message"] = "user_already_exists";
                $this->redirect("registration.php");
            }
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }

    }

    public function updateUser(){
        if (!isset($_SESSION["userID"])) {
            $this->redirect("login.php");
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
                    $this->redirect("edit-profile.php");
                }
                
            }else{
                $userManagement->updateUser($_SESSION["userID"], $_POST["nickname"]);
            }

            $_SESSION["message"] = "update_profile_success";
            $this->redirect("profile.php");
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function deleteUser(){
        if (!isset($_SESSION["userID"])) {
            $this->redirect("login.php");
        }
        try{
            $userManagement = UserManagement::getInstance();
            error_log("User löschen: ".$_SESSION["userID"]);
            $userManagement->deleteUser($_SESSION["userID"]);
            unset($_SESSION["userID"]);


            $_SESSION["message"] = "delete_user_success";
            $this->redirect("index.php");
        }catch(UserNotFoundException $e){
            $this->handleUserNotFoundException();
        }catch(InternalErrorException $e){
            $this->handleInternalErrorException();
        }
    }

    public function getUser(){
        if(!isset($_SESSION["userID"])){
            $_SESSION["message"] = "missing_user_id";
            $this->redirect("index.php");
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

    public function addFavourite(bool $isAjax = false) {
        if (!isset($_SESSION["userID"])) {
            if ($isAjax) {
                echo json_encode([
                    "success" => false,
                    "error" => "not_logged_in",
                    "redirect" => ROOT . "php/view/login.php"
                ]);
                exit;
                }
            $this->redirect("login.php");
        }
        try {
            $userManagement = UserManagement::getInstance();
            $userManagement->toggleFavouriteState($_SESSION["userID"], $_POST["review_id"]);
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(["success" => true]);
                exit;
            }
        } catch (UserNotFoundException $e) {
            if ($isAjax) {
                echo json_encode(["success" => false, "error" => "user_not_found"]);
                exit;
            }
            $this->handleUserNotFoundException();
        } catch (InternalErrorException $e) {
            if ($isAjax) {
                echo json_encode(["success" => false, "error" => "internal_error"]);
                exit;
            }
            $this->handleInternalErrorException();
        }
        $previousPage = $_SERVER['HTTP_REFERER'] ?? ROOT . "php/view/index.php";
        header("Location: " . $previousPage);
        exit;
    }

    /**
     * Checks if all parameters are set and if required parameters are not empty.
     */

    private function checkLoginParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            $this->redirect("login.php");
        }else if(empty($_POST["email"]) || empty($_POST["password"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            $this->redirect("login.php");
        }
    }

    /**
     * Checks if all parameters are set, required parameters are not empty, email is valid and if passwords are equal.
     */

    private function checkRegistrationParam(){
        if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["password_confirm"]) || !isset($_POST["nickname"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            $this->redirect("registration.php");
        }else if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_confirm"]) || empty($_POST["nickname"]) ){
            $_SESSION["message"] = "missing_required_parameters";
            $this->redirect("registration.php");
        }else if ($_POST["password"] !== $_POST["password_confirm"]){
            $_SESSION["message"] = "passwords_not_equal";
            $this->redirect("registration.php");
        }else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $_SESSION["message"] = "invalid_email";
            $this->redirect("registration.php");
        }else if (!isset($_POST["checkbox_privacy"]) || $_POST["checkbox_privacy"] !== "1") {
            $_SESSION["message"] = "checkbox_privacy_not_accepted";
            $this->redirect("registration.php");
        }
        if (mb_strlen($_POST["nickname"], 'UTF-8') > 50 || mb_strlen($_POST["email"], 'UTF-8') > 50 || mb_strlen($_POST["password"], 'UTF-8') > 50) {
            $_SESSION["message"] = "input_too_long";
            $this->redirect("registration.php");
        }
    }

    private function checkUpdateParam(){
        if (!isset($_POST["nickname"]) || !isset($_POST["submit"])) {
            $_SESSION["message"] = "missing_parameters";
            $this->redirect("edit-profile.php");
        }
        if (mb_strlen($_POST["nickname"], 'UTF-8') > 50) {
            $_SESSION["message"] = "nickname_too_long";
            $this->redirect("edit-profile.php");
        }
    }

    private function handleUserNotFoundException()
    {
        $_SESSION["message"] = "user_not_found";
        $this->redirect("index.php");
    }
    private function handleInternalErrorException()
    {
        $_SESSION["message"] = "internal_error";
        $this->redirect("index.php");
    }

    private function redirect($newPage){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");  
        header("Pragma: no-cache"); // Kompatibilität HTTP/1.0  
        header("Expires: 0"); // Kompatibilität für alte Proxies 
        header("Location: ". ROOT . "php/view/" . $newPage);
        exit;
    }
}
?>
