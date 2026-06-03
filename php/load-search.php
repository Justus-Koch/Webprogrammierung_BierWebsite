<?php

require_once $abs_path . '/php/controller/ReviewController.php';
require_once $abs_path . '/php/model/User.php';
require_once $abs_path . '/php/model/UserManagement.php';

$reviewController = new ReviewController();
$userManagement = UserManagement::getInstance();

// Suchanfrage und Filter aus der URL holen
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$typeFilter = isset($_GET['type']) ? $_GET['type'] : [];

// Reviews laden
if (!empty($query)) {
  $results = $reviewController->searchReviews($query);
} else {
  // Kein Suchbegriff — alle Reviews zeigen
  $results = $reviewController->loadReviews();
}

// Typ-Filter clientseitig anwenden falls gesetzt
if (!empty($typeFilter)) {
  $results = array_filter($results, function($review) use ($typeFilter) {
    return in_array(strtolower($review->getBeerType()), array_map('strtolower', $typeFilter));
  });
}
?>