<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anmeldung – Prost-Protokoll</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/components.css">
</head>
<body>

<main>
  <div class="form-card">
    <h1>Anmeldung</h1>

    <div class="alert">
    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "login_failed"): ?>
      <p>E-Mail oder Passwort ist falsch.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_parameters"): ?>
      <p>Es fehlen Parameter.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_required_parameters"): ?>
      <p>Es fehlen notwendige Parameter.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "registration_success"): ?>
      <p>Registrierung erfolgreich.</p>
    <?php endif; ?>
    <?php
        unset($_SESSION["message"]);
    ?>

    <form method="POST" action="../../login-execute.php" class="review-form" novalidate>

      <div class="form-group">
        <label for="username">E-Mail <span aria-hidden="true">*</span></label>
        <input type="email" id="username" name="email"
               required aria-required="true">
      </div>

      <div class="form-group">
        <label for="password">Passwort <span aria-hidden="true">*</span></label>
        <input type="password" id="password" name="password"
               required aria-required="true">
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

<?php include_once '../include/footer.php'; ?>
</body>
</html>
