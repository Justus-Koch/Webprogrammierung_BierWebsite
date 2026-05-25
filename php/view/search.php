<?php $title = 'Suche'; ?>
<?php include_once './php/include/header.php'; ?>

<div class="layout">
  <?php include_once './php/include/sidebar.php'; ?>

  <main>
    <div class="form-card search-results-container">
      <h2>Suchergebnisse</h2>

      <form method="GET" action="./search.php" class="filter-form">
        <fieldset class="form-group fieldset-reset">
          <legend>Ergebnisse filtern</legend>
          <div class="filter-options">
            <div class="filter-item">
              <input type="checkbox" id="filter1" name="type[]" value="pils">
              <label for="filter1">Pilsner</label>
            </div>
            <div class="filter-item">
              <input type="checkbox" id="filter2" name="type[]" value="weizen">
              <label for="filter2">Weizen</label>
            </div>
            <div class="filter-item">
              <input type="checkbox" id="filter3" name="type[]" value="helles">
              <label for="filter3">Helles</label>
            </div>
            <button type="submit" class="btn-submit btn-small">Filter anwenden</button>
          </div>
        </fieldset>
      </form>
    </div>

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
        <img src="./img/bier.jpg" alt="Bier" width="70">
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
  </main>
</div>

<?php include_once './php/include/footer.php'; ?>
