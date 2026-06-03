<?php
error_log("Add favorite");
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/controller/UserController.php";

$userController = new UserController();
$userController->addFavourite();

$previousPage = $_SERVER['HTTP_REFERER'] ?? '/';
header("Location: " . $previousPage);
exit;

?>
