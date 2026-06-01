<?php
require_once "DummyReviewManagementDAO.php";

class ReviewManagement
{
  public static function getInstance()
  {
    return DummyReviewManagementDAO::getInstance();
  }
}
