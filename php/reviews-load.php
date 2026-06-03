<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/controller/ReviewController.php";
require_once $abs_path . "/php/controller/UserController.php";

require_once $abs_path . '/php/model/Review.php';

$controller = new ReviewController();
$reviews = $controller->loadReviews();

function isFavourite($review_id){
  $userController = new UserController();
  if($userController->isFavourite($review_id)){
      error_log("Favorit: ".$review_id);
  }else{
    error_log("Kein Favorit: ".$review_id);
  }
  return $userController->isFavourite($review_id);
}
?>

