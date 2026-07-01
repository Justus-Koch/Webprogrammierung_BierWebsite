<?php
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/session-start.php";
require_once $abs_path . "/php/controller/ReviewController.php";

$controller = new ReviewController();
$reviews = $controller->loadReviews();

?>

