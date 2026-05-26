<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }
require_once "path.php";
require_once $abs_path . "/php/controller/UserController.php";

if (!isset($_SESSION["userID"])) {
    header("Location: ./login.php");
    exit;
}

$userController = new UserController();
$current_user = $userController->getUser();
?>