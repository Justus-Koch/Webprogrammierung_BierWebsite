<?php
if (!isset($abs_path)) {
  require_once "../../path.php";
}

require_once $abs_path . "/php/session-start.php";

// Nur eingeloggte Nutzer dürfen diese Seite sehen
if (!isset($_SESSION["userID"])) {
  header("Location: ". ROOT . "php/view/login.php");
  exit;
}

require_once $abs_path . '/php/controller/ReviewController.php';

// ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

$reviewController = new ReviewController();
$reviewToEdit = $reviewController->loadReviewById($id);

if ($form_data) {
    $beerName        = $form_data['beer_name'] ?? $reviewToEdit->getBeerName();
    $beerType        = $form_data['beer_type'] ?? $reviewToEdit->getBeerType();
    $originalExtract = $form_data['original_extract'] ?? $reviewToEdit->getOriginalExtract();
    $alcoholContent  = $form_data['alcohol_content'] ?? $reviewToEdit->getAlcoholContent();
    $rating          = $form_data['rating'] ?? $reviewToEdit->getRating();
    $content         = $form_data['content'] ?? $reviewToEdit->getContent();
} else {
    $beerName        = $reviewToEdit->getBeerName();
    $beerType        = $reviewToEdit->getBeerType();
    $originalExtract = $reviewToEdit->getOriginalExtract();
    $alcoholContent  = $reviewToEdit->getAlcoholContent();
    $rating          = $reviewToEdit->getRating();
    $content         = $reviewToEdit->getContent();
}
?>