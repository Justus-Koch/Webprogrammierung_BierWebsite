<?php $title = 'Profil'; ?>
<?php include_once 'includes/header.php'; ?>

<div class="layout">
  <?php include_once 'includes/sidebar.php'; ?>

  <main>
    <section class="profile-card" aria-labelledby="profile-heading">
      <div class="profile-header">
        <img src="./img/profile_picture.jpg" alt="Profilbild von User_Schluckspecht" class="profile-img">
        <div class="profile-info">
          <h2 id="profile-heading">Profil</h2>
          <h3 class="username">@User_Schluckspecht</h3>
        </div>
      </div>
      <div class="profile-bio">
        <p>Der Schluckspecht schluckt schlecht</p>
      </div>
      <div class="profile-actions">
        <a href="./edit-profile.php" class="button-secondary">Profil bearbeiten</a>
      </div>
    </section>

    <h2>Meine Reviews</h2>

    <article class="post">
      <header class="post-header">
        <span class="username">@User_Schluckspecht</span>
        <div class="post-actions">
          <a class="button-secondary" href="./edit-review.php">Bearbeiten</a>
          <div class="favourite">
            <input type="checkbox" id="favorite1" name="favorite1"
                   class="favourite-checkbox"
                   aria-label="Diesen Post zu Favoriten hinzufügen">
            <label for="favorite1" class="favourite-label">
              <span class="favourite-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Favorisieren</span>
            </label>
          </div>
        </div>
      </header>
      <h3>Beispieltitel 1</h3>
      <div class="facts">
        <img src="./img/bier.jpg" alt="Bier" width="70">
        <p>Biername:<br> Krombacher</p>
        <p>Bierart:<br> Pilsener</p>
        <p>Alkoholgehalt:<br> 4,9%</p>
        <p>Stammwürze:<br> 11,5%</p>
        <p>Bewertung:<br> 5/5</p>
      </div>
      <div class="content">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
          sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          Ut enim ad minim veniam, quis nostrud exercitation ullamco
          laboris nisi ut aliquip ex ea commodo consequat. Duis aute
          irure dolor in reprehenderit in voluptate velit esse cillum
          dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
          non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <time datetime="2026-04-21">21.04.2026</time>
    </article>
  </main>
</div>

<?php include_once 'includes/footer.php'; ?>
