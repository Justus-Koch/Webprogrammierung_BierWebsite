<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }
require_once "path.php";
require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
$userController->logout();
session_destroy();

header("Location: /php/view/index.php");
exit;
?>