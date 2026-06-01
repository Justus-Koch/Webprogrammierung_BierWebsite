<?php

require_once '../model/ReviewManagementDAO.php';
require_once '../model/DummyReviewManagementDAO.php';
require_once '../model/ReviewManagement.php';

class ReviewController
{
  public function loadReviews() {
    try{
      $instance = ReviewManagement::getInstance();
      return $instance->findAll();
    } catch(InternalErrorException $e){
      $this->handleInternalErrorException();
    }
  }

  private function handleInternalErrorException()
  {
    $_SESSION["message"] = "internal_error";
    header("Location: /php/view/index.php");
    exit;
  }
}
