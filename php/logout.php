<?php
if (!isset($abs_path)) {
  require_once "../path.php";
}

require_once $abs_path . "/php/session-start.php";

require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
$userController->logout();
session_destroy();
?>

