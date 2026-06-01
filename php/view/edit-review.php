<?php $title = 'Review bearbeiten';
if (!isset($abs_path)) {
  require_once "../../path.php";
}
include_once $abs_path . '/php/include/header.php';

require_once '../model/Review.php';
require_once '../model/ReviewManagementDAO.php';
require_once '../model/ReviewManagement.php';

$dao = ReviewManagement::getInstance();

$id = 2; //replacement id should come from URL from profile


  //$id = intval($_GET["id"]);

$reviewToEdit = $dao->findById($id);

if ($reviewToEdit === null) {
  header('Location: profile.php');
  exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $beerName = trim(isset($_POST['beer_name']) ? $_POST['beer_name'] : '');
  $beerType = isset($_POST['beer_type']) ? $_POST['beer_type'] : '';
  $alcoholContent = isset($_POST['alcohol_content']) ? $_POST['alcohol_content'] : '';
  $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
  $content = trim(isset($_POST['content']) ? $_POST['content'] : '');
  $originalExtract = isset($_POST['original_extract']) ? $_POST['original_extract'] : '';

  if (empty($beerName)) {
    $errors[] = 'Biername ist erforderlich.';
  }
  if (empty($rating)) {
    $errors[] = 'Bitte eine Bewertung angeben.';
  }

  if (empty($errors)) {
    $review = new Review(
      $id,
      $beerName,
      $beerType,
      $alcoholContent,
      $rating,
      1,              // author_id kommt später aus der Session
      date('d/m/Y')
    );
    $review->setContent($content);
    $review->setOriginalExtract($originalExtract);

    $dao->update($review);
    header('Location: profile.php');
    exit;
  }
}

?>
<div class="layout">
  <?php include_once '../include/sidebar.php'; ?>

  <main>
    <div class="form-card">
      <h1>Review bearbeiten</h1>
      <?php if (!empty($errors)): ?>
        <ul class="error-list">
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <form method="post" class="review-form" novalidate>

        <div class="form-group">
          <label for="picture">Bild ändern (optional)</label>
          <div class="file-input-wrapper">
            <input type="file" name="picture" id="picture" accept="image/*">
            <img src="<?php echo htmlspecialchars($reviewToEdit->getPicture()); ?>" width="50" height="50" alt="Kein Foto vorhanden">
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
                   name="original_extract" id="original_extract" value="<?php echo htmlspecialchars($reviewToEdit->getOriginalExtract()); ?>">
          </div>
          <div class="form-group flex-1">
            <label for="alcohol_content">Alkoholgehalt (%)</label>
            <input type="number" min="0" max="20" step="0.01"
                   name="alcohol_content" id="alcohol_content" value="<?php echo htmlspecialchars($reviewToEdit->getAlcoholContent()); ?>">
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
            <button type="submit" class="btn-submit">Änderungen speichern</button>
            <a href="profile.php" class="button-secondary">Abbrechen</a>
          </div>
          <button type="button" class="btn-delete"
                  aria-label="Dieses Review unwiderruflich löschen"
                  onclick="return confirm('Möchtest du dieses Review wirklich löschen?')">
            Löschen
          </button>
        </div>

      </form>
    </div>
  </main>
</div>

<?php include_once '../include/footer.php'; ?>

</body>
</html>
