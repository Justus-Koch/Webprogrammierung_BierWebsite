<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($title); ?> – Prost-Protokoll</title>
  <link rel="stylesheet" href= "../../css/style.css">
  <link rel="stylesheet" href= "../../css/components.css">
</head>
<body>

<header>
  <nav class="navbar-horizontal" aria-label="Hauptnavigation">
    <div class="navbar-left">
      <button class="menuButton" onclick="toggleSidebar()" aria-controls="sidebar-nav" aria-expanded="false">Menü</button>
      <form action="search.php" method="GET" class="search-form" role="search">
        <label for="site-search" class="visually-hidden">Website durchsuchen:</label>
        <input type="search" id="site-search" name="q" placeholder="Suchen...">
        <button type="submit">Suchen</button>
      </form>
    </div>
    <div class="navbar-middle">
      <h1>Prost-Protokoll</h1>
    </div>
    <div class="navbar-right">
        <a href="login.php" class="button-secondary">Anmelden</a>
    </div>
  </nav>
</header>