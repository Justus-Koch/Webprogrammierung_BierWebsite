<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrierung – Prost-Protokoll</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/components.css">
</head>
<body>

<main>
  <div class="form-card">
    <h1>Registrieren</h1>

    <form method="post" action="/register" class="review-form" novalidate>

      <div class="form-group">
        <label for="nickname">Nickname <span aria-hidden="true">*</span></label>
        <input type="text" id="nickname" name="nickname"
               placeholder="Dein Nickname"
               required aria-required="true"
               autocomplete="nickname">
      </div>

      <div class="form-group">
        <label for="email">E-Mail Adresse <span aria-hidden="true">*</span></label>
        <input type="email" id="email" name="email"
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
          <button type="submit" class="btn-submit">Konto erstellen</button>
          <a href="login.php" class="button-secondary">Zum Login</a>
        </div>
      </div>

    </form>
  </div>
</main>

<footer class="footer">
  <nav class="footer-content" aria-label="Rechtliche Links">
    <a href="impressum.php">Impressum</a>
    <a href="datenschutz.php">Datenschutz</a>
    <a href="nutzungsbedingungen.php">Nutzungsbedingungen</a>
    <a href="barrierefreiheit.php">Barrierefreiheitserklärung</a>
  </nav>
</footer>

</body>
</html>
