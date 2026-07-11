<?php
if (!isset($abs_path)) {
  require_once '../../path.php';;
}
?>
<nav class="navbar-vertical" id="sidebar-nav" aria-label="Seitennavigation">
  <ul>
    <li><a href="<?php echo ROOT; ?>php/view/index.php">Startseite</a></li>
    <li><a href="<?php echo ROOT; ?>php/view/create-review.php">Review erstellen</a></li>
    <li><a href="<?php echo ROOT; ?>php/view/favourites.php">Favoriten</a></li>
    <li><a href="<?php echo ROOT; ?>php/view/profile.php">Profil</a></li>
  </ul>
</nav>
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>
