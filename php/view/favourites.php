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
$userManagement = UserManagement::getInstance();
?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <h2>Favoriten</h2>
    <div class="alert">
      <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p>Es gibt einen internen Fehler.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_not_found"): ?>
        <p>Benutzer nicht gefunden.</p>
      <?php endif;?>
    </div>
      <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "favourites_not_found"): ?>
        <p style="text-align:center;">
          Noch keine Reviews vorhanden.
        </p>
      <?php else: ?>
      
    <?php include_once $abs_path.'/php/view/show-review.php'; ?>
    <?php endif;?>
    <?php
          unset($_SESSION["message"]);
      ?>
</main>
</div>

<?php include_once '../include/footer.php'; ?>

</body>
</html>
