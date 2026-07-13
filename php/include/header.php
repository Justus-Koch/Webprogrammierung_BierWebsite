<?php
if (!isset($abs_path)) {
  require_once '../../path.php';;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($title); ?> – Prost-Protokoll</title>
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/components.css">
</head>
<body>

<input type="checkbox" id="sidebar-toggle" class="sidebar-toggle-checkbox" aria-label="Menü öffnen">
<header>
  <nav class="navbar-horizontal" aria-label="Hauptnavigation">
    <div class="navbar-left">
      <label for="sidebar-toggle" class="menuButton" title="Menü öffnen">
        <span></span>
        <span></span>
        <span></span>
      </label>

      <form action="<?php echo ROOT; ?>php/view/search.php" method="GET" class="search-form" role="search">
        <label for="site-search" class="visually-hidden">Website durchsuchen:</label>
        <input type="search" id="site-search" name="q" placeholder="Suchen...">
        <button type="submit">Suchen</button>
      </form>
    </div>
    <div class="navbar-middle">
      <h1>Prost-Protokoll</h1>
    </div>
    <div class="navbar-right">
      <?php if (isset($_SESSION["userID"])): ?>
        <a href="<?php echo ROOT; ?>php/logout.php" class="button-secondary">Abmelden</a>
      <?php else: ?>
        <a href="<?php echo ROOT; ?>php/view/login.php" class="button-secondary">Anmelden</a>
      <?php endif; ?>
    </div>
  </nav>
</header>
