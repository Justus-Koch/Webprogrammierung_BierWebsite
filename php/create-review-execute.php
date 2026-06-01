<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/controller/ReviewController.php";

if (!isset($_SESSION["userID"])) {
    header("Location: /php/view/login.php");
    exit;
}

$reviewController = new ReviewController();
$reviewController->createReview();

header("Location: /php/view/create-review.php");
exit;
