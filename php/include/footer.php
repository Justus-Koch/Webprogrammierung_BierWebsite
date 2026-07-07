<?php
if (!isset($abs_path)) {
  require_once '../../path.php';;
}
?>

<footer class="footer">
  <nav class="footer-content" aria-label="Rechtliche Links">
    <a href="<?php echo ROOT; ?>php/view/impressum.php">Impressum</a>
    <a href="<?php echo ROOT; ?>php/view/datenschutz.php">Datenschutz</a>
    <a href="<?php echo ROOT; ?>php/view/nutzungsbedingungen.php">Nutzungsbedingungen</a>
    <a href="<?php echo ROOT; ?>php/view/barrierefreiheit.php">Barrierefreiheitserklärung</a>
  </nav>
</footer>

<script src="<?php echo ROOT; ?>js/favourites.js"></script>

<script>
  window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
      window.location.reload();
    }
  });
</script>
