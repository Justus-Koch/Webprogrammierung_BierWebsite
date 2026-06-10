<?php
$title = 'Review erstellen';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($abs_path)) {
  require_once "../../path.php";
}

$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

$rating = $form_data["rating"] ?? '';

// Nur eingeloggte Nutzer dürfen diese Seite sehen
if (!isset($_SESSION["userID"])) {
  header("Location: " . ROOT ."php/view/login.php");
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
          <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'upload_type_not_allowed'): ?>
            <p>Dateityp nicht erlaubt.</p>
          <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'upload_error'): ?>
            <p>Fehler beim Hochladen des Bildes.</p>
          <?php endif; ?>
          <?php unset($_SESSION['message']); ?>
        </div>

        <form method="POST" action="<?php echo ROOT; ?>php/create-review-execute.php" class="review-form" enctype="multipart/form-data" novalidate>

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
              value="<?= htmlspecialchars($form_data['beer_name'] ?? '') ?>"
              placeholder="z.B. Augustiner Helles" required aria-required="true">
          </div>

          <div class="form-group">
            <label for="beer_type">Bierart</label>
            <select name="beer_type" id="beer_type">
                <option value="Pils" <?= ($form_data['beer_type'] ?? '') == 'Pils' ? 'selected' : '' ?>>Pils</option>
                <option value="Weizen" <?= ($form_data['beer_type'] ?? '') == 'Weizen' ? 'selected' : '' ?>>Weizen</option>
                <option value="Helles" <?= ($form_data['beer_type'] ?? '') == 'Helles' ? 'selected' : '' ?>>Helles</option>
                <option value="Dunkles" <?= ($form_data['beer_type'] ?? '') == 'Dunkles' ? 'selected' : '' ?>>Dunkles</option>
            </select>
          </div>

          <div class="form-row">
            <legend class="visually-hidden">Technische Details</legend>
            <div class="form-group flex-1">
              <label for="original_extract">Stammwürze (%)</label>
              <input type="number" min="0" max="30" step="0.01"
                  name="original_extract" id="original_extract"
                  value="<?= htmlspecialchars($form_data['original_extract'] ?? '') ?>">
            </div>
            <div class="form-group flex-1">
              <label for="alcohol_content">Alkoholgehalt (%)</label>
              <input type="number" min="0" max="30" step="0.01"
                  name="alcohol_content" id="alcohol_content"
                value="<?= htmlspecialchars($form_data['alcohol_content'] ?? '') ?>">
            </div>
          </div>

          <fieldset class="form-group">
            <legend>Bewertung bearbeiten (1 bis 5 Sterne)</legend>
            <div class="star-rating-accessible">
              <input type="radio" id="star1" name="rating" value="1"
                <?php echo $rating == 1 ? 'checked' : ''; ?>>
              <label for="star1"><span class="visually-hidden">1 Stern</span>★</label>

              <input type="radio" id="star2" name="rating" value="2"
                <?php echo $rating == 2 ? 'checked' : ''; ?>>
              <label for="star2"><span class="visually-hidden">2 Sterne</span>★</label>

              <input type="radio" id="star3" name="rating" value="3"
                <?php echo $rating ? 'checked' : ''; ?>>
              <label for="star3"><span class="visually-hidden">3 Sterne</span>★</label>

              <input type="radio" id="star4" name="rating" value="4"
                <?php echo $rating == 4 ? 'checked' : ''; ?>>
              <label for="star4"><span class="visually-hidden">4 Sterne</span>★</label>

              <input type="radio" id="star5" name="rating" value="5"
                <?php echo $rating == 5 ? 'checked' : ''; ?>>
              <label for="star5"><span class="visually-hidden">5 Sterne</span>★</label>
            </div>
          </fieldset>

          <div class="form-group">
            <label for="content">Deine Meinung</label>
            <textarea name="content" id="content" cols="50" rows="6"
                    placeholder="Beschreibe Geschmack, Geruch und Aussehen..."><?= htmlspecialchars($form_data['content'] ?? '') ?></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-submit" name="submit">Review veröffentlichen</button>
            <a href="<?php echo ROOT; ?>php/view/index.php" class="button-secondary">Abbrechen</a>
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

