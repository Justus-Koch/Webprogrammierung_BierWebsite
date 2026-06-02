<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/controller/UserController.php";

if (!isset($_SESSION["userID"])) {
    header("Location: /php/view/login.php");
    exit;
}

$userController = new UserController();
$userController->updateUser();

header("Location: /php/view/profile.php");
exit;
?>