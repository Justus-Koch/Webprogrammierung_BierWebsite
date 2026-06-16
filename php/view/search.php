<?php
$title = 'Suche';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($abs_path)) {
  require_once "../../path.php";
}

require_once $abs_path . '/php/load-search.php';

include_once $abs_path . '/php/include/header.php';
?>

  <div class="layout">
    <?php include_once $abs_path . '/php/include/sidebar.php'; ?>

    <main>
      <div class="form-card search-results-container">
        <h2>Suchergebnisse</h2>

        <form method="GET" action="search.php" class="filter-form" role="search">
          <!-- Suchbegriff als Hidden Field mitführen damit er beim Filtern erhalten bleibt -->
          <input type="hidden" name="q" value="<?php echo htmlspecialchars($query); ?>">

          <fieldset class="form-group fieldset-reset">
            <legend>Ergebnisse filtern</legend>
            <div class="filter-options">
              <div class="filter-item">
                <input type="checkbox" id="filter1" name="type[]" value="Pils"
                  <?php echo in_array('Pils', $typeFilter) ? 'checked' : ''; ?>>
                <label for="filter1">Pils</label>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="filter2" name="type[]" value="Weizen"
                  <?php echo in_array('Weizen', $typeFilter) ? 'checked' : ''; ?>>
                <label for="filter2">Weizen</label>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="filter3" name="type[]" value="Helles"
                  <?php echo in_array('Helles', $typeFilter) ? 'checked' : ''; ?>>
                <label for="filter3">Helles</label>
              </div>
              <div class="filter-item">
                <input type="checkbox" id="filter4" name="type[]" value="Dunkles"
                  <?php echo in_array('Dunkles', $typeFilter) ? 'checked' : ''; ?>>
                <label for="filter4">Dunkles</label>
              </div>
              <button type="submit" class="btn-submit btn-small">Filter anwenden</button>
            </div>
          </fieldset>
        </form>

        <?php if (!empty($query)): ?>
          <p>Ergebnisse für: <strong><?php echo htmlspecialchars($query); ?></strong></p>
        <?php endif; ?>
      </div>

      <div id="ajax-results">
        <?php if (!empty($reviews)): ?>
          <?php include_once $abs_path.'/php/view/show-review.php'; ?>
        <?php elseif (!empty($query)): ?>
          <p>Keine Ergebnisse gefunden.</p>
        <?php endif; ?>
      </div>

    </main>
  </div>

<?php include_once $abs_path . '/php/include/footer.php'; ?>
<script>
  const ROOT = "<?php echo ROOT; ?>";
</script>
<script src="<?php echo ROOT; ?>js/ajax-search-helper.js"></script>
