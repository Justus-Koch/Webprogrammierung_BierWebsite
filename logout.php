<?php
session_start();
require_once "path.php";
require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
$userController->logout();
?>