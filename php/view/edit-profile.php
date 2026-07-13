<?php
  $title = 'Profil bearbeiten';
  if (!isset($abs_path)) {
      require_once "../../path.php";
  }
  require_once $abs_path . "/php/session-start.php";
  require_once $abs_path . '/php/csrf.php';
  require_once $abs_path.'/php/profile-load.php';

  $profile_picture = ROOT."img/".htmlspecialchars($profile_user->getProfilePicture());

  $nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : $profile_user->getNickname();
  unset($_SESSION["nickname"]);
?>

<?php include_once $abs_path.'/php/include/header.php'; ?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <div class="form-card">
      <h1>Profil bearbeiten</h1>
      
      <div class="alert">
        <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "upload_error"): ?>
          <p>Fehler beim Hochladen der Datei.</p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "upload_too_large"): ?>
          <p>Datei zu groß.</p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "upload_type_not_allowed"): ?>
          <p>Dateityp nicht erlaubt.</p>
        <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "nickname_too_long"): ?>
          <p>Spitzname zu lang.</p>
        <?php endif; ?>
        <?php unset($_SESSION["message"]); ?>
      </div>

      <form method="post" class="review-form" enctype="multipart/form-data" action="<?php echo ROOT; ?>php/profile-edit.php" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
        
        <div class="form-group">
          <label for="nickname">Spitzname (max. 50 Zeichen)<span aria-hidden="true">*</span></label>
          <input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($nickname) ?>" required aria-required="true">
        </div>

        <div class="form-group">
          <label for="picture">Profilbild ändern</label>
          <div class="file-input-wrapper">
            <input type="file" id="picture" name="profile_picture" accept="image/*">
            <img src="<?=$profile_picture?>" alt="Aktuelles Profilbild" id="preview_image" width="120" height="120">
          </div>
        </div>

        <div class="form-footer-actions">
          <div class="left-actions">
            <button type="submit" class="btn-submit" name="submit">Speichern</button>
            <a href="<?php echo ROOT; ?>php/view/profile.php" class="button-secondary">Abbrechen</a>
          </div>
      </form>

      <form method="post" class="review-form" onsubmit="return confirm('Möchtest du dein Profil wirklich löschen?')" action="<?php echo ROOT; ?>php/profile-delete.php" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
        <button type="submit" name="submit" class="btn-delete" aria-label="Profil unwiderruflich löschen">Profil löschen</button>
      </form>
      </div>

    </div>
  </main>
</div>

<?php include_once $abs_path.'/php/include/footer.php'; ?>
<script src="<?php echo ROOT; ?>js/picture-preview.js"></script>

</body>
</html>