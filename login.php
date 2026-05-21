<?php
    require_once './model/User.php';
    require_once './model/UserDAO.php';
    require_once './model/MockUser.php';

    session_start();

    $err_message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
      $email = $_POST['username'] ?? '';
      $password = $_POST['password'] ?? '';

      if (empty($email) || empty($password)){
          $err_message = "Beide Felder müssen für einen Login ausgefüllt sein.";
      }else{
          $userDAO = new MockUser();
          $user = $userDAO->findUser($email);

          if($user && password_verify($password, $user->getPassword())){
            $_SESSION['authenticated_user'] = $user;

            header("Location: index.php");
            exit;
          }else{
            $err_message = "Zugangsdaten ungültig";
          }
      }
    }

?>


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

    <?php if (!empty($err_message)): ?>
      <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
        <?php echo htmlspecialchars($err_message); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="review-form" novalidate>

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
