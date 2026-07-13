<?php
$title = 'Feed';

if (!isset($abs_path)) {
    require_once '../../path.php';
}

require_once $abs_path . "/php/session-start.php";

include_once $abs_path . '/php/include/header.php';
require_once $abs_path . "/php/reviews-load.php";
?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <?php if (isset($_SESSION["message"]) && in_array($_SESSION["message"], ["login_success", "logout_success", "delete_user_success"])): ?>
      <div class="success">
        <?php if ($_SESSION["message"] == "login_success"): ?>
          <p>Anmelden erfolgreich.</p>
        <?php elseif ($_SESSION["message"] == "logout_success"): ?>
          <p>Abmelden erfolgreich.</p>
        <?php elseif ($_SESSION["message"] == "delete_user_success"): ?>
          <p>Benutzer erfolgreich gelöscht.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION["message"]) && in_array($_SESSION["message"], ["internal_error", "missing_user_id", "user_not_found", "review_not_found", "invalid_token"])): ?>
      <div class="alert">
        <?php if ($_SESSION["message"] == "internal_error"): ?>
          <p>Es gibt einen internen Fehler.</p>
        <?php elseif ($_SESSION["message"] == "missing_user_id"): ?>
          <p>Benutzer-ID nicht gefunden.</p>
        <?php elseif ($_SESSION["message"] == "user_not_found"): ?>
          <p>Benutzer nicht gefunden.</p>
        <?php elseif ($_SESSION["message"] == "review_not_found"): ?>
          <p>Review nicht gefunden.</p>
        <?php elseif ($_SESSION["message"] == "invalid_token"): ?>
          <p>Token invalid.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php unset($_SESSION["message"]); ?>

    <h2>Bier-Feed</h2>

    <?php include_once $abs_path.'/php/view/show-review.php'; ?>
  </main>
</div>

<?php include_once $abs_path.'/php/include/footer.php'; ?>

</body>
</html>