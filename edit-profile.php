<?php $title = 'Profil bearbeiten'; ?>
<?php include_once 'includes/header.php'; ?>

<div class="layout">
  <?php include_once 'includes/sidebar.php'; ?>

  <main>
    <div class="form-card">
      <h1>Profil bearbeiten</h1>

      <form method="post" class="review-form" novalidate>

        <div class="form-group">
          <label for="nickname">Nickname <span aria-hidden="true">*</span></label>
          <input type="text" id="nickname" name="nickname"
                 value="Nickname"
                 required aria-required="true">
        </div>

        <div class="form-group">
          <label for="profile_picture">Profilbild ändern</label>
          <div class="file-input-wrapper">
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            <img src="./img/profile_picture.jpg" alt="Aktuelles Profilbild" width="50" height="50">
          </div>
        </div>

        <div class="form-footer-actions">
          <div class="left-actions">
            <button type="submit" class="btn-submit">Speichern</button>
            <a href="profile.php" class="button-secondary">Abbrechen</a>
          </div>
          <button type="button" class="btn-delete"
                  aria-label="Profil unwiderruflich löschen"
                  onclick="return confirm('Möchtest du dein Profil wirklich löschen?')">
            Profil löschen
          </button>
        </div>

      </form>
    </div>
  </main>
</div>

<?php include_once 'includes/footer.php'; ?>
