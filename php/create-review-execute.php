<?php
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/session-start.php";
require_once $abs_path . '/php/csrf.php';

if (!verifyCsrfToken()) {
  $_SESSION['message'] = 'invalid_token';
  header('Location: /php/view/index.php');
  exit;
}
require_once $abs_path . "/php/controller/ReviewController.php";

$reviewController = new ReviewController();
$reviewController->createReview();
?>
