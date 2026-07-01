<?php
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/session-start.php";
require_once $abs_path . '/php/controller/ReviewController.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($query) < 2) {
  exit;
}

$controller = new ReviewController();
$reviews = $controller->searchReviews($query);

if (empty($reviews)) {
  echo '<p>Keine Ergebnisse gefunden.</p>';
  exit;
}

include_once $abs_path . '/php/view/show-review.php';
exit;
