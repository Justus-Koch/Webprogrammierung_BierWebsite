<?php
$title = 'Review bearbeiten';

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

require_once $abs_path . '/php/controller/ReviewController.php';

// ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id === null) {
  header("Location: /php/view/profile.php");
  exit;
}

$reviewController = new ReviewController();
$reviewToEdit = $reviewController->loadReviewById($id);

if ($reviewToEdit === null) {
  header("Location: /php/view/profile.php");
  exit;
}

include_once $abs_path . '/php/include/header.php';
?>

  <div class="layout">
    <?php include_once $abs_path . '/php/include/sidebar.php'; ?>

    <main>
      <div class="form-card">
        <h1>Review bearbeiten</h1>

        <div class="alert">
          <?php if (isset($_SESSION['message']) && $_SESSION['message'] == 'missing_required_parameters'): ?>
            <p>Biername und Bewertung sind erforderlich.</p>
          <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'review_not_found'): ?>
            <p>Review nicht gefunden.</p>
          <?php endif; ?>
          <?php unset($_SESSION['message']); ?>
        </div>

        <form method="POST" action="../edit-review-execute.php" class="review-form" enctype="multipart/form-data" novalidate>

          <!-- Review-ID as Hidden Field -->
          <input type="hidden" name="review_id" value="<?php echo $reviewToEdit->getId(); ?>">

          <div class="form-group">
            <label for="picture">Bild ändern (optional)</label>
            <div class="file-input-wrapper">
              <input type="file" name="picture" id="picture" accept="image/*">
              <img src="../../img/<?php echo htmlspecialchars($reviewToEdit->getPicture()); ?>"
                   width="50" height="50" alt="Aktuelles Foto" id="preview_image">
            </div>
          </div>

          <div class="form-group">
            <label for="beer_name">Biername <span aria-hidden="true">*</span></label>
            <input type="text" name="beer_name" id="beer_name"
                   value="<?php echo htmlspecialchars($reviewToEdit->getBeerName()); ?>"
                   required aria-required="true">
          </div>

          <div class="form-group">
            <label for="beer_type">Bierart</label>
            <select name="beer_type" id="beer_type">
              <option value="Pils" <?php echo $reviewToEdit->getBeerType() === 'Pils' ? 'selected' : ''; ?>>Pils</option>
              <option value="Weizen" <?php echo $reviewToEdit->getBeerType() === 'Weizen' ? 'selected' : ''; ?>>Weizen</option>
              <option value="Helles" <?php echo $reviewToEdit->getBeerType() === 'Helles' ? 'selected' : ''; ?>>Helles</option>
              <option value="Dunkles" <?php echo $reviewToEdit->getBeerType() === 'Dunkles' ? 'selected' : ''; ?>>Dunkles</option>
            </select>
          </div>

          <fieldset class="form-row">
            <legend class="visually-hidden">Technische Details zum Bier</legend>
            <div class="form-group flex-1">
              <label for="original_extract">Stammwürze (%)</label>
              <input type="number" min="0" max="30" step="0.01"
                     name="original_extract" id="original_extract"
                     value="<?php echo htmlspecialchars($reviewToEdit->getOriginalExtract()); ?>">
            </div>
            <div class="form-group flex-1">
              <label for="alcohol_content">Alkoholgehalt (%)</label>
              <input type="number" min="0" max="20" step="0.01"
                     name="alcohol_content" id="alcohol_content"
                     value="<?php echo htmlspecialchars($reviewToEdit->getAlcoholContent()); ?>">
            </div>
          </fieldset>

          <fieldset class="form-group">
            <legend>Bewertung bearbeiten (1 bis 5 Sterne)</legend>
            <div class="star-rating-accessible">
              <input type="radio" id="star1" name="rating" value="1"
                <?php echo $reviewToEdit->getRating() == 1 ? 'checked' : ''; ?>>
              <label for="star1"><span class="visually-hidden">1 Stern</span>★</label>

              <input type="radio" id="star2" name="rating" value="2"
                <?php echo $reviewToEdit->getRating() == 2 ? 'checked' : ''; ?>>
              <label for="star2"><span class="visually-hidden">2 Sterne</span>★</label>

              <input type="radio" id="star3" name="rating" value="3"
                <?php echo $reviewToEdit->getRating() == 3 ? 'checked' : ''; ?>>
              <label for="star3"><span class="visually-hidden">3 Sterne</span>★</label>

              <input type="radio" id="star4" name="rating" value="4"
                <?php echo $reviewToEdit->getRating() == 4 ? 'checked' : ''; ?>>
              <label for="star4"><span class="visually-hidden">4 Sterne</span>★</label>

              <input type="radio" id="star5" name="rating" value="5"
                <?php echo $reviewToEdit->getRating() == 5 ? 'checked' : ''; ?>>
              <label for="star5"><span class="visually-hidden">5 Sterne</span>★</label>
            </div>
          </fieldset>

          <div class="form-group">
            <label for="content">Inhalt</label>
            <textarea name="content" id="content" cols="50" rows="6"><?php echo htmlspecialchars($reviewToEdit->getContent()); ?></textarea>
          </div>

          <div class="form-footer-actions">
            <div class="left-actions">
              <button type="submit" class="btn-submit" name="submit">Änderungen speichern</button>
              <a href="/php/view/profile.php" class="button-secondary">Abbrechen</a>
            </div>
          

        </form>

        <!-- Löschen als eigenes Formular, damit es einen separaten execute hat -->
        <form method="POST" action="../delete-review-execute.php"
              onsubmit="return confirm('Möchtest du dieses Review wirklich löschen?')">
          <input type="hidden" name="review_id" value="<?php echo $reviewToEdit->getId(); ?>">
          <button type="submit" class="btn-delete" aria-label="Dieses Review unwiderruflich löschen">
            Löschen
          </button>
        </form>

        </div>

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

