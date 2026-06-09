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
      header("Location: ". ROOT . "php/view/login.php");
      exit;
    }
    try {
      $instance = ReviewManagement::getInstance();
      $favourites = $instance->findFavouritesByUserId($_SESSION["userID"]);
      if(empty($favourites)){
        $_SESSION["message"] = "favourites_not_found";
      }
      return $favourites;
    } catch(UserNotFoundException $e){
      $this->handleUserNotFoundException();
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
    } catch (InternalErrorException $e) {
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
      header("Location: ". ROOT . "php/view/login.php");
      exit;
    }
    $_SESSION['form_data'] = $_POST;
    $this->checkReviewParam();
    try {
      $picture_key = "picture";
      $new_name = null;
      if(isImageSet($picture_key)){
        $new_name = checkAndUploadImage($picture_key);
        error_log("Neuer Name null?: ". $new_name ?? "null");
        if($new_name == null){
          error_log("Zurücl zu edit review");
          header('Location: ' . ROOT . 'php/view/create-review.php');
          exit;
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
      header('Location: ' . ROOT . 'php/view/profile.php');
      exit;
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function updateReview() {
    if (!isset($_SESSION["userID"])) {
      header("Location: ". ROOT . "php/view/login.php");
      exit;
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
        header('Location: ' . ROOT . 'php/view/profile.php');
        exit;
      }

      $picture_key = "picture";
      $new_name = null;
      if(isImageSet($picture_key)){
        $new_name = checkAndUploadImage($picture_key);
        if($new_name == null){
          header('Location: '. ROOT . 'php/view/edit-review.php?id=' . intval($_POST['review_id']));
          exit;
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

      $instance->update($review);

      $_SESSION['message'] = 'update_review_success';
      header('Location: ' . ROOT . 'php/view/profile.php');
      exit;
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  public function deleteReview() {
    if (!isset($_SESSION["userID"])) {
      header("Location: ". ROOT . "php/view/login.php");
      exit;
    }
    if (!isset($_POST['review_id'])) {
      $_SESSION['message'] = 'missing_parameters';
      header('Location: ' . ROOT . 'php/view/profile.php');
      exit;
    }
    try {
      $instance = ReviewManagement::getInstance();
      $id = intval($_POST['review_id']);

      // Sicherstellen dass das Review dem eingeloggten User gehört
      $existing = $instance->findById($id);
      if ($existing === null || $existing->getAuthorId() !== $_SESSION['userID']) {
        $_SESSION['message'] = 'review_not_found';
        header('Location: ' . ROOT . 'php/view/profile.php');
        exit;
      }

      $instance->delete($id);

      $_SESSION['message'] = 'delete_review_success';
      header('Location: ' . ROOT . 'php/view/profile.php');
      exit;
    } catch (InternalErrorException $e) {
      $this->handleInternalErrorException();
    }
  }

  private function checkReviewParam() {
    if (!isset($_POST['beer_name']) || !isset($_POST['beer_type']) ||
      !isset($_POST['alcohol_content']) || !isset($_POST['rating'])) {
      $_SESSION['message'] = 'missing_parameters';
      header('Location: ' . ROOT . 'php/view/create-review.php');
      exit;
    }
    if (empty(trim($_POST['beer_name'])) || empty($_POST['rating'])) {
      $_SESSION['message'] = 'missing_required_parameters';
      header('Location: ' . ROOT . 'php/view/create-review.php');
      exit;
    }
  }

  private function checkReviewId() {
    if (!isset($_POST['review_id'])) {
      $_SESSION['message'] = 'missing_parameters';
      header('Location: ' . ROOT . 'php/view/profile.php');
      exit;
    }
  }

  private function handleInternalErrorException() {
    $_SESSION['message'] = 'internal_error';
    header('Location: ' . ROOT . 'php/view/index.php');
    exit;
  }

  private function handleUserNotFoundException()
    {
        $_SESSION["message"] = "user_not_found";
        header("Location: '. ROOT . 'php/view/index.php");
        exit;
    }

  private function checkInputLengths(){
    if (strlen($_POST['beer_name']) > 50 || 
          strlen($_POST['beer_type']) > 50 || 
          strlen($_POST['content']) > 500) {
          $_SESSION["message"] = "input_too_long";
          header("Location: ". ROOT . "php/view/edit-review.php");
          exit;
      }
  }
}
