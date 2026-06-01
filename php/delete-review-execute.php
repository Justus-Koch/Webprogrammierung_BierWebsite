<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/controller/ReviewController.php";

// Nur eingeloggte Nutzer dürfen Reviews löschen
if (!isset($_SESSION["userID"])) {
    header("Location: /php/view/login.php");
    exit;
}

$reviewController = new ReviewController();
$reviewController->deleteReview();

// deleteReview() leitet intern weiter
header("Location: /php/view/profile.php");
exit;
