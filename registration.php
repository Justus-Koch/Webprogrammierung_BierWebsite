<?php
    require_once './model/User.php';
    require_once './model/UserDAO.php';
    require_once './model/MockUser.php';

    session_start();

    $err_message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
      $nickname = $_POST['nickname'] ?? '';
      $email = $_POST['email'] ?? '';
      $password = $_POST['password'] ?? '';
      $password_confirm = $_POST['password_confirm'] ?? '';


      if (empty($email) || empty($password) || empty($password_confirm)){
          $err_message = "Alle notwendigen Felder müssen für eine Registrierung ausgefüllt sein.";
      }else{
          if(!password_verify($password, $password_confirm)){
            $err_message = "Die Passwörter stimmen nicht überein.";
          }else{

            $userDAO = new MockUser();
            $newUser = new User($email, $password, $nickname);
            $userDAO->saveUser($newUser); // the user is not actually registrated, only the mock user
            $_SESSION['authenticated_user'] = $userDAO->findUser("mock");

            header("Location: index.php");
            exit;
          }
      }
    }

?>

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

    <?php if (!empty($err_message)): ?>
      <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
        <?php echo htmlspecialchars($err_message); ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="review-form" novalidate>

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
