<?php
require_once "SessionReviewManagementDAO.php";

class ReviewManagement
{
  public static function getInstance()
  {
    return SessionReviewManagementDAO::getInstance();
  }
}
