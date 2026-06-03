<?php
$title = 'Review erstellen';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($abs_path)) {
  require_once "../../path.php";
}

// Nur eingeloggte Nutzer dürfen diese Seite sehen
if (!isset($_SESSION["userID"])) {
  header("Location: /php/view/login.php");
  exit;
}

include_once $abs_path . '/php/include/header.php';
?>

  <div class="layout">
    <?php include_once $abs_path . '/php/include/sidebar.php'; ?>

    <main>
      <div class="form-card">
        <h1>Review erstellen</h1>

        <div class="alert">
          <?php if (isset($_SESSION['message']) && $_SESSION['message'] == 'missing_required_parameters'): ?>
            <p>Biername und Bewertung sind erforderlich.</p>
          <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'missing_parameters'): ?>
            <p>Es fehlen Parameter.</p>
          <?php endif; ?>
          <?php unset($_SESSION['message']); ?>
        </div>

        <form method="POST" action="../create-review-execute.php" class="review-form" enctype="multipart/form-data" novalidate>

          <div class="form-group">
            <label for="picture">Bier-Foto hochladen (optional)</label>
            <div class="file-input-wrapper">
              <input type="file" name="picture" id="picture" accept="image/*">
              <img src="" id="preview_image" width="50" height="50" alt="Vorschau des ausgewählten Bildes">
            </div>
          </div>

          <div class="form-group">
            <label for="beer_name">Biername <span aria-hidden="true">*</span></label>
            <input type="text" name="beer_name" id="beer_name"
                   placeholder="z.B. Augustiner Helles"
                   required aria-required="true">
          </div>

          <div class="form-group">
            <label for="beer_type">Bierart</label>
            <select name="beer_type" id="beer_type">
              <option value="Pils">Pils</option>
              <option value="Weizen">Weizen</option>
              <option value="Helles">Helles</option>
              <option value="Dunkles">Dunkles</option>
            </select>
          </div>

          <fieldset class="form-row">
            <legend class="visually-hidden">Technische Details</legend>
            <div class="form-group flex-1">
              <label for="original_extract">Stammwürze (%)</label>
              <input type="number" min="0" max="30" step="0.01"
                     name="original_extract" id="original_extract">
            </div>
            <div class="form-group flex-1">
              <label for="alcohol_content">Alkoholgehalt (%)</label>
              <input type="number" min="0" max="20" step="0.01"
                     name="alcohol_content" id="alcohol_content">
            </div>
          </fieldset>

          <fieldset class="form-group">
            <legend>Bewertung (1 bis 5 Sterne)</legend>
            <div class="star-rating-accessible">
              <input type="radio" id="star1" name="rating" value="1" required aria-required="true">
              <label for="star1"><span class="visually-hidden">1 Stern</span>★</label>

              <input type="radio" id="star2" name="rating" value="2">
              <label for="star2"><span class="visually-hidden">2 Sterne</span>★</label>

              <input type="radio" id="star3" name="rating" value="3">
              <label for="star3"><span class="visually-hidden">3 Sterne</span>★</label>

              <input type="radio" id="star4" name="rating" value="4">
              <label for="star4"><span class="visually-hidden">4 Sterne</span>★</label>

              <input type="radio" id="star5" name="rating" value="5">
              <label for="star5"><span class="visually-hidden">5 Sterne</span>★</label>
            </div>
          </fieldset>

          <div class="form-group">
            <label for="content">Deine Meinung</label>
            <textarea name="content" id="content" cols="50" rows="6"
                      placeholder="Beschreibe Geschmack, Geruch und Aussehen..."></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-submit" name="submit">Review veröffentlichen</button>
            <a href="index.php" class="button-secondary">Abbrechen</a>
          </div>

        </form>
      </div>
    </main>
  </div>

<?php include_once $abs_path.'/php/include/footer.php'; ?>

<script>
document.getElementById('picture').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // Ändert das src des Bildes zur Vorschau
            document.getElementById('preview_image').src = e.target.result;
        }

        reader.readAsDataURL(file); // Liest das Bild lokal ein
    }
});
</script>

</body>
</html>

