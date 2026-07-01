<?php
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/session-start.php";
require_once $abs_path . "/php/controller/UserController.php";

if (!isset($_SESSION["userID"])) {
    header("Location: ". ROOT . "php/view/login.php");
    exit;
}

$userController = new UserController();
$current_user = $userController->getUser();

require_once $abs_path . '/php/controller/ReviewController.php';

$reviewController = new ReviewController();
$userReviews = $reviewController->loadReviewsByUser($_SESSION['userID']);
?>

