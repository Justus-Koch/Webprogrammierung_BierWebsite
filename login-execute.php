<?php
session_start();
require_once "path.php"; // Passe den Pfad an
require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
$userController->login(); // Ruft deine oben definierte Methode auf
?>