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

$userID = isset($_GET['id']) ? intval($_GET['id']) : $_SESSION['userID'];
$userController = new UserController();
$profile_user = $userController->getUser($userID);

$is_own_profile = ($profile_user->getId() == $_SESSION['userID']);

require_once $abs_path . '/php/controller/ReviewController.php';

$reviewController = new ReviewController();
$reviews = $reviewController->loadReviewsByUser($userID);
?>

