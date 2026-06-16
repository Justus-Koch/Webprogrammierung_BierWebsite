<?php

if (!isset($abs_path)) {
  require_once "../../path.php";
}
require_once $abs_path . '/php/model/Review.php';
require_once $abs_path . '/php/model/ReviewManagementDAO.php';
require_once $abs_path . '/php/model/DummyReviewManagementDAO.php';
require_once $abs_path . '/php/model/ReviewManagement.php';
require_once $abs_path . '/php/util/imageHandling.php';

class ReviewController
{
  public function loadReviews() {
    try {
      $instance = ReviewManagement::getInstance();
      return $instance->findAll();
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function loadFavourites(){
    if (!isset($_SESSION["userID"])) {
      $this->redirect("login.php");
    }
    try {
      $instance = ReviewManagement::getInstance();
      $favourites = $instance->findFavouritesByUserId($_SESSION["userID"]);
      if(empty($favourites)){
        $_SESSION["message"] = "favourites_not_found";
      }
      return $favourites;
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function loadReviewsByUser($authorId) {
    try {
      $instance = ReviewManagement::getInstance();
      return $instance->findByUserId($authorId);
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function loadReviewById($id) {
    try {
      $instance = ReviewManagement::getInstance();
      return $instance->findById($id);
    } catch (ReviewNotFoundException $e) {
      $this->handleReviewNotFoundException();
    }catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function searchReviews($query) {
    try {
      $instance = ReviewManagement::getInstance();
      return $instance->search($query);
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function createReview() {
    if (!isset($_SESSION["userID"])) {
      $this->redirect("login.php");
    }
    $_SESSION['form_data'] = $_POST;
    $this->checkReviewParam();
    try {
      $picture_key = "picture";
      $new_name = "bier.jpg";
      if(isImageSet($picture_key)){
        $new_name = checkAndUploadImage($picture_key);
        error_log("Neuer Name null?: ". $new_name ?? "null");
        if($new_name == null){
           $this->redirect("create-review.php");
        }
      }
      $this->checkInputLengths();
      $instance = ReviewManagement::getInstance();
      $instance->createReview($_POST['beer_name'],
          $_POST['beer_type'],
          $_POST['alcohol_content'],
          $_POST['rating'],
          $_SESSION['userID'],
          date('d/m/Y'),
          $_POST['content'],
          $_POST['original_extract'],
          $new_name);


      $_SESSION['message'] = 'create_review_success';
      $this->redirect("profile.php");
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function updateReview() {
    if (!isset($_SESSION["userID"])) {
      $this->redirect("login.php");
    }
    $_SESSION['form_data'] = $_POST;
    $this->checkReviewParam();
    $this->checkReviewId();
    try {
      
      $instance = ReviewManagement::getInstance();
      $id = intval($_POST['review_id']);

      // Sicherstellen dass das Review dem eingeloggten User gehört
      $existing = $instance->findById($id);
      if ($existing === null || $existing->getAuthorId() !== $_SESSION['userID']) {
        $_SESSION['message'] = 'review_not_found';
        $this->redirect("profile.php");
      }

      $picture_key = "picture";
      $new_name = null;
      if(isImageSet($picture_key)){
        $new_name = checkAndUploadImage($picture_key);
        if($new_name == null){
          $this->redirect("edit-review.php?id=" . intval($_POST['review_id']));
        }
      }
      $this->checkInputLengths();

      $review = new Review(
        $id,
        $_POST['beer_name'],
        $_POST['beer_type'],
        $_POST['alcohol_content'],
        $_POST['rating'],
        $_SESSION['userID'],
        $existing->getCreatedAt() // ursprüngliches Datum behalten
      );
      $review->setContent($_POST['content'] ?? '');
      $review->setOriginalExtract($_POST['original_extract'] ?? '');
      $review->setPicture($new_name ?? $existing->getPicture());

      $instance->update($review, $_SESSION["userID"]);

      $_SESSION['message'] = 'update_review_success';
      $this->redirect("profile.php");
    } catch (ReviewNotFoundException $e) {
      $this->handleReviewNotFoundException();
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function deleteReview() {
    if (!isset($_SESSION["userID"])) {
      $this->redirect("login.php");
    }
    if (!isset($_POST['review_id'])) {
      $_SESSION['message'] = 'missing_parameters';
      $this->redirect("profile.php");
    }
    try {
      $instance = ReviewManagement::getInstance();
      $id = intval($_POST['review_id']);

      // Sicherstellen dass das Review dem eingeloggten User gehört
      $existing = $instance->findById($id);
      if ($existing === null || $existing->getAuthorId() !== $_SESSION['userID']) {
        $_SESSION['message'] = 'review_not_found';
        $this->redirect("profile.php");
      }

      $instance->delete($id, $_SESSION["userID"]);

      $_SESSION['message'] = 'delete_review_success';
      $this->redirect("profile.php");
    } catch (ReviewNotFoundException $e) {
      $this->handleReviewNotFoundException();
    }catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  private function checkReviewParam() {
    if (!isset($_POST['beer_name']) || !isset($_POST['beer_type']) ||
      !isset($_POST['alcohol_content'])) {
      $_SESSION['message'] = 'missing_parameters';
      $this->redirect("create-review.php");
    }
    if (empty(trim($_POST['beer_name'])) || !isset($_POST['rating']) || empty($_POST['rating'])) {
      $_SESSION['message'] = 'missing_required_parameters';
      $this->redirect("create-review.php");
    }
  }

  private function checkReviewId() {
    if (!isset($_POST['review_id'])) {
      $_SESSION['message'] = 'missing_parameters';
      $this->redirect("profile.php");
    }
  }

  private function handleInternalErrorException() {
    $_SESSION['message'] = 'internal_error';
    $this->redirect("index.php");
  }

  private function handleReviewNotFoundException()
    {
        $_SESSION["message"] = "review_not_found";
        $this->redirect("index.php");
    }

  private function checkInputLengths(){
    if (strlen($_POST['beer_name']) > 50 || 
          strlen($_POST['beer_type']) > 50 || 
          strlen($_POST['content']) > 500) {
          $_SESSION["message"] = "input_too_long";
          $this->redirect("edit-review.php");
      }
  }

  private function redirect($newPage){
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");  
    header("Pragma: no-cache"); // Kompatibilität HTTP/1.0  
    header("Expires: 0"); // Kompatibilität für alte Proxies 
    header("Location: ". ROOT . "php/view/" . $newPage);
    exit;
  }
}
