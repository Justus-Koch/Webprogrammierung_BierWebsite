<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}
require_once $abs_path . "/php/session-start.php";
require_once $abs_path . '/php/csrf.php';

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

    <?php if (isset($_SESSION["message"]) && in_array($_SESSION["message"], ["passwords_not_equal", "missing_parameters", "missing_required_parameters", "invalid_email", "input_too_long", "checkbox_privacy_not_accepted", "password_unsafe", "registration_confirmation_failed", "user_already_registrated", "invalid_registration_link", "email_sent"])): ?>
      <div class="alert">
        <?php if ($_SESSION["message"] == "passwords_not_equal"): ?>
          <p>Die Passwörter stimmen nicht überein.</p>
        <?php elseif ($_SESSION["message"] == "missing_parameters"): ?>
          <p>Es fehlen Parameter.</p>
        <?php elseif ($_SESSION["message"] == "missing_required_parameters"): ?>
          <p>Es fehlen notwendige Parameter.</p>
        <?php elseif ($_SESSION["message"] == "invalid_email"): ?>
          <p>Die eingegebene EMail ist nicht gültig.</p>
        <?php elseif ($_SESSION["message"] == "input_too_long"): ?>
          <p>Eingegebene Werte sind zu lang.</p>
        <?php elseif ($_SESSION["message"] == "checkbox_privacy_not_accepted"): ?>
          <p>Die Datenschutzerklärung und die Nutzungsbedingungen müssen akzeptiert werden.</p>
        <?php elseif ($_SESSION["message"] == "password_unsafe"): ?>
          <p>Das Passwort muss mindestens 8 Zeichen lang sein und einen Großbuchstaben und ein Sonderzeichen enthalten.</p>
        <?php elseif ($_SESSION["message"] == "registration_confirmation_failed"): ?>
          <p>Es gab einen Fehler bei der Registrierung.</p>
        <?php elseif ($_SESSION["message"] == "user_already_registrated"): ?>
          <p>Diese E-Mail ist bereits registriert.</p>
        <?php elseif ($_SESSION["message"] == "invalid_registration_link"): ?>
          <p>Dieser Registrierungslink ist ungültig.</p>
        <?php elseif ($_SESSION["message"] == "email_sent"): ?>
          <p class="success">
            Weitere Infos finden Sie in der hier:
            <a href="<?php echo htmlspecialchars($_SESSION["mail_file"] ?? ''); ?>" target="_blank">Registrierung abschließen</a>.
          </p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php 
      unset($_SESSION["message"]); 
      unset($_SESSION["mail_file"]);
    ?>

    <form method="post" action="<?php echo ROOT; ?>php/registration-execute.php" class="review-form" novalidate>
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
      
      <div class="form-group">
        <label for="nickname">Nickname (max. 50 Zeichen)<span aria-hidden="true">*</span></label>
        <input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($nickname) ?>" placeholder="Dein Nickname" required aria-required="true" autocomplete="nickname">
      </div>

      <div class="form-group">
        <label for="email">E-Mail Adresse <span aria-hidden="true">*</span></label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="beispiel@mail.de" required aria-required="true" autocomplete="email">
      </div>

      <div class="form-group">
        <label for="password">Passwort (muss mind. 8 Zeichen lang und einen Großbuchstaben und ein Sonderzeichen enthalten)<span aria-hidden="true">*</span></label>
        <input type="password" id="password" name="password" required aria-required="true" autocomplete="new-password">
      </div>

      <div class="form-group">
        <label for="password_confirm">Passwort bestätigen <span aria-hidden="true">*</span></label>
        <input type="password" id="password_confirm" name="password_confirm" required aria-required="true" autocomplete="new-password">
      </div>

      <div class="checkbox-group">
        <input type="checkbox" id="checkbox_privacy" name="checkbox_privacy" value="1" required aria-required="true">
        <label for="checkbox_privacy">
          Ich akzeptiere die <a href="<?php echo ROOT; ?>php/view/datenschutz.php">Datenschutzerklärung</a>
          und die <a href="<?php echo ROOT; ?>php/view/nutzungsbedingungen.php">Nutzungsbedingungen</a>.<span aria-hidden="true">*</span>
        </label>
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