<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/session-start.php";
require_once $abs_path . '/php/csrf.php';

$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
unset($_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anmeldung – Prost-Protokoll</title>
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/components.css">
</head>
<body>

<main>
  <div class="form-card">
    <h1>Anmeldung</h1>

    <?php if (isset($_SESSION["message"]) && in_array($_SESSION["message"], ["login_failed", "missing_parameters", "missing_required_parameters", "registration_success"])): ?>
      <div class="alert">
        <?php if ($_SESSION["message"] == "login_failed"): ?>
          <p>E-Mail oder Passwort ist falsch.</p>
        <?php elseif ($_SESSION["message"] == "missing_parameters"): ?>
          <p>Es fehlen Parameter.</p>
        <?php elseif ($_SESSION["message"] == "missing_required_parameters"): ?>
          <p>Es fehlen notwendige Parameter.</p>
        <?php elseif ($_SESSION["message"] == "registration_success"): ?>
          <p class="success">Registrierung erfolgreich.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php unset($_SESSION["message"]); ?>

    <form method="POST" action="<?php echo ROOT; ?>php/login-execute.php" class="review-form" novalidate>
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
      
      <div class="form-group">
        <label for="email">E-Mail <span aria-hidden="true">*</span></label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required aria-required="true">
      </div>

      <div class="form-group">
        <label for="password">Passwort <span aria-hidden="true">*</span></label>
        <input type="password" id="password" name="password" required aria-required="true">
      </div>

      <div class="form-footer-actions">
        <div class="left-actions">
          <button type="submit" class="btn-submit" name="submit">Einloggen</button>
          <a href="registration.php" class="button-secondary">Registrieren</a>
        </div>
        <a href="index.php" class="button-secondary">Abbrechen</a>
      </div>
    </form>

  </div>
</main>

<?php include_once $abs_path.'/php/include/footer.php'; ?>

<script src="<?php echo ROOT; ?>js/form-helpers.js"></script>
<script src="<?php echo ROOT; ?>js/login-validation.js"></script>
</body>
</html>