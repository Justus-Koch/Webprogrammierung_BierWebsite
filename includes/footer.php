<footer class="footer">
  <nav class="footer-content" aria-label="Rechtliche Links">
    <a href="impressum.php">Impressum</a>
    <a href="datenschutz.php">Datenschutz</a>
    <a href="nutzungsbedingungen.php">Nutzungsbedingungen</a>
    <a href="barrierefreiheit.php">Barrierefreiheitserklärung</a>
  </nav>
</footer>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar-nav');
    const btn = document.querySelector('.menuButton');
    const isOpen = sidebar.classList.toggle('active');
    btn.setAttribute('aria-expanded', isOpen);
  }
</script>
</body>
</html>
