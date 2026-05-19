<?php $title = 'Review erstellen'; ?>
<?php include './includes/header.php'; ?>

<div class="layout">
  <?php include './includes/sidebar.php'; ?>

  <main>
    <div class="form-card">
      <h1>Review erstellen</h1>

      <form method="post" class="review-form" novalidate>

        <div class="form-group">
          <label for="picture">Bier-Foto hochladen (optional)</label>
          <div class="file-input-wrapper">
            <input type="file" name="picture" id="picture" accept="image/*">
            <img src="./img/bier.jpg" width="50" height="50" alt="Vorschau des ausgewählten Bildes">
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
            <option value="pils">Pils</option>
            <option value="weizen">Weizen</option>
            <option value="helles">Helles</option>
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
          <button type="submit" class="btn-submit">Review veröffentlichen</button>
          <a href="./index.php" class="button-secondary">Abbrechen</a>
        </div>

      </form>
    </div>
  </main>
</div>

<?php include './includes/footer.php'; ?>
