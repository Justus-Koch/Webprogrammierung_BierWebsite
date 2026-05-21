<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anmeldung – Prost-Protokoll</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/components.css">
</head>
<body>

<main>
  <div class="form-card">
    <h1>Anmeldung</h1>

    <form action="/login" method="POST" class="review-form" novalidate>

      <div class="form-group">
        <label for="username">E-Mail <span aria-hidden="true">*</span></label>
        <input type="email" id="username" name="username"
               required aria-required="true"
               autocomplete="username">
      </div>

      <div class="form-group">
        <label for="password">Passwort <span aria-hidden="true">*</span></label>
        <input type="password" id="password" name="password"
               required aria-required="true"
               autocomplete="current-password">
      </div>

      <div class="form-footer-actions">
        <div class="left-actions">
          <button type="submit" class="btn-submit">Einloggen</button>
          <a href="registration.php" class="button-secondary">Registrieren</a>
        </div>
        <a href="index.php" class="button-secondary">Abbrechen</a>
      </div>

    </form>
  </div>
</main>

<?php include_once 'includes/footer.php'; ?>
