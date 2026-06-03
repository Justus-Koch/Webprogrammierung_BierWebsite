<?php
$title = 'Feed';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (!isset($abs_path)) {
  require_once "../../path.php";
}
include_once $abs_path . '/php/include/header.php';
require_once $abs_path."/php/model/User.php";
require_once $abs_path."/php/model/UserManagement.php";
$userManagement = UserManagement::getInstance();

require_once $abs_path . "/php/reviews-load.php";
require_once $abs_path . "/php/is-favourite.php";
?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <div class="alert">
      <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p>Es gibt einen internen Fehler.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "login_success"): ?>
        <p>Anmelden erfolgreich.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "logout_success"): ?>
        <p>Abmelden erfolgreich.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "delete_user_success"): ?>
        <p>Benutzer erfolgreich gelöscht.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_userID"): ?>
        <p>Benutzer-ID nicht gefunden.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_not_found"): ?>
        <p>Benutzer nicht gefunden.</p>
      <?php endif; ?>
      <?php
          unset($_SESSION["message"]);
      ?>
    </div>
    <h2>Bier-Feed</h2>

    <?php include_once $abs_path.'/php/view/show-review.php'; ?>
  </main>
</div>

<?php include_once '../include/footer.php'; ?>

</body>
</html>
