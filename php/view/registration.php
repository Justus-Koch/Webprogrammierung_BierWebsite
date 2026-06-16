<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($abs_path)) {
  require_once "../../path.php";
}

$nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : "";
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
unset($_SESSION["nickname"]);
unset($_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrierung – Prost-Protokoll</title>
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/components.css">
</head>
<body>

<main>
  <div class="form-card">
    <h1>Registrieren</h1>

    <div class="alert">
    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "passwords_not_equal"): ?>
      <p>Die Passwörter stimmen nicht überein.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_parameters"): ?>
      <p>Es fehlen Parameter.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_required_parameters"): ?>
      <p>Es fehlen notwendige Parameter.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_email"): ?>
      <p>Die eingegebene EMail ist nicht gültig.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "input_too_long"): ?>
      <p>Eingegebene Werte sind zu lang.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "email_already_in_use"): ?>
      <p>Ein Benutzer mit dieser Email existiert schon.</p>
    <?php endif; ?>
    <?php
        unset($_SESSION["message"]);
    ?>

    <form method="post" action="<?php echo ROOT; ?>php/registration-execute.php" class="review-form" novalidate>

      <div class="form-group">
        <label for="nickname">Nickname <span aria-hidden="true">*</span></label>
        <input type="text" id="nickname" name="nickname"
               value="<?= htmlspecialchars($nickname)?>"
               placeholder="Dein Nickname"
               required aria-required="true"
               autocomplete="nickname">
      </div>

      <div class="form-group">
        <label for="email">E-Mail Adresse <span aria-hidden="true">*</span></label>
        <input type="email" id="email" name="email"
              value="<?= htmlspecialchars($email)?>"
               placeholder="beispiel@mail.de"
               required aria-required="true"
               autocomplete="email">
      </div>

      <div class="form-group">
        <label for="password">Passwort <span aria-hidden="true">*</span></label>
        <input type="password" id="password" name="password"
               required aria-required="true"
               autocomplete="new-password">
      </div>

      <div class="form-group">
        <label for="password_confirm">Passwort bestätigen <span aria-hidden="true">*</span></label>
        <input type="password" id="password_confirm" name="password_confirm"
               required aria-required="true"
               autocomplete="new-password">
      </div>

      <div class="form-footer-actions">
        <div class="left-actions">
          <button type="submit" class="btn-submit" name="submit">Konto erstellen</button>
          <a href="login.php" class="button-secondary">Zum Login</a>
        </div>
      </div>

    </form>
  </div>
</main>

<?php include_once $abs_path.'/php/include/footer.php'; ?>
<script src="<?php echo ROOT; ?>js/form-helpers.js"></script>
<script src="<?php echo ROOT; ?>js/registration-validation.js"></script>
</body>
</html>
