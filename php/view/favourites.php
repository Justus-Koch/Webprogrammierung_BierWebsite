<?php
$title = 'Feed';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (!isset($abs_path)) {
  require_once "../../path.php";
}
include_once $abs_path . '/php/include/header.php';

require_once $abs_path . "/php/favourites-load.php";
require_once $abs_path . "/php/is-favourite.php";
?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <h2>Favoriten</h2>
    <div class="alert">
      <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p>Es gibt einen internen Fehler.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_userID"): ?>
        <p>Benutzer-ID nicht gefunden.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_not_found"): ?>
        <p>Benutzer nicht gefunden.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "favourites_not_found"): ?>
        <p>Favoriten nicht gefunden.</p>
      <?php else: ?>
      <?php
          unset($_SESSION["message"]);
      ?>
    </div>
    <?php include_once $abs_path.'/php/view/show-review.php'; ?>
    <?php endif;?>
</main>
</div>

<?php include_once '../include/footer.php'; ?>

</body>
</html>
