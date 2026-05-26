<?php 
  $title = 'Profil bearbeiten';
  if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

  if (!isset($abs_path)) {
      require_once "../../path.php";
  } 

  require_once $abs_path.'/profile-load.php';
?>


<?php include_once $abs_path.'/php/include/header.php'; ?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <div class="form-card">
      <h1>Profil bearbeiten</h1>

      <form method="post" class="review-form" action="/profile-edit.php" novalidate>

        <div class="form-group">
          <label for="nickname">Spitzname<span aria-hidden="true">*</span></label>
          <input type="text" id="nickname" name="nickname"
                 value="<?=htmlspecialchars($current_user->getNickname())?>"
                 required aria-required="true">
        </div>

        <div class="form-group">
          <label for="profile_picture">Profilbild ändern</label>
          <div class="file-input-wrapper">
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            <img src="<?= "../../img/" . htmlspecialchars($current_user->getProfilePicture()) ?>" alt="Aktuelles Profilbild" width="50" height="50">
          </div>
        </div>

        <div class="form-footer-actions">
          <div class="left-actions">
            <button type="submit" class="btn-submit" name="submit">Speichern</button>
            <a href="profile.php" class="button-secondary">Abbrechen</a>
          </div>
      </form>
      <form method="post" class="review-form" onsubmit="return confirm('Möchtest du dein Profil wirklich löschen?')" action="/profile-delete.php" novalidate>
        <button type="submit" name="submit" type="button" class="btn-delete" aria-label="Profil unwiderruflich löschen">Profil löschen</button> 
      </form>
      </div>

    </div>
  </main>
</div>

<?php include_once $abs_path.'/php/include/footer.php'; ?>
