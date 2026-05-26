<?php 
  if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
  }

  if (!isset($abs_path)) {
      require_once "../../path.php";
  }
  $title = 'Feed'; 
?>


<?php include_once $abs_path.'/php/include/header.php'; ?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <div class="alert">
    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
      <p>Es gibt einen internen Fehler.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "login_success"): ?>
      <p>Anmelden erfolgreich.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "logout_success"): ?>
      <p>Abmelden erfolgreich.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "delete_user_success"): ?>
      <p>Benutzer erfolgreich gelöscht.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_userID"): ?>
      <p>Benutzer-ID nicht gefunden.</p>
    <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_not_found"): ?>
      <p>Benutzer nicht gefunden.</p>
    <?php endif; ?>
    <?php 
        unset($_SESSION["message"]); 
    ?>
  </div>

  <main>
    <h2>Bier-Feed</h2>

    <article class="post">
      <header class="post-header">
        <span class="username">@User_Schluckspecht</span>
        <div class="post-actions">
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
        <img src= "../../img/bier.jpg" alt="Bier" width="70">
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

    <article class="post">
      <header class="post-header">
        <span class="username">@User_Bierabetiker</span>
        <div class="post-actions">
          <div class="favourite">
            <input type="checkbox" id="favorite2" name="favorite2"
                   class="favourite-checkbox"
                   aria-label="Diesen Post zu Favoriten hinzufügen">
            <label for="favorite2" class="favourite-label">
              <span class="favourite-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Favorisieren</span>
            </label>
          </div>
        </div>
      </header>
      <h3>Beispieltitel 2</h3>
      <div class="facts">
        <img src="../../img/bier.jpg" alt="Bier" width="70">
        <p>Biername:<br> Jever</p>
        <p>Bierart:<br> Pilsener</p>
        <p>Alkoholgehalt:<br> 4,9%</p>
        <p>Stammwürze:<br> 11,7%</p>
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

    <article class="post">
      <header class="post-header">
        <span class="username">@User_Vergenussferkler</span>
        <div class="post-actions">
          <div class="favourite">
            <input type="checkbox" id="favorite3" name="favorite3"
                   class="favourite-checkbox"
                   aria-label="Diesen Post zu Favoriten hinzufügen">
            <label for="favorite3" class="favourite-label">
              <span class="favourite-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Favorisieren</span>
            </label>
          </div>
        </div>
      </header>
      <h3>Beispieltitel 3</h3>
      <div class="facts">
        <img src="../../img/bier.jpg" alt="Bier" width="70">
        <p>Biername:<br> Spaten</p>
        <p>Bierart:<br> Helles</p>
        <p>Alkoholgehalt:<br> 5,0%</p>
        <p>Stammwürze:<br> 12%</p>
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

<?php include_once $abs_path.'/php/include/footer.php'; ?>
