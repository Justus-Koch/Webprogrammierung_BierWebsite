<?php
$title = 'Feed';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (!isset($abs_path)) {
  require_once "../../path.php";
}
include_once $abs_path . '/php/include/header.php';

  require_once $abs_path . "/php/reviews-load.php";
?>

<div class="layout">
  <?php include_once $abs_path.'/php/include/sidebar.php'; ?>

  <main>
    <div class="alert">
      <?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
        <p>Es gibt einen internen Fehler.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "login_success"): ?>
        <p>Anmelden erfolgreich.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "logout_success"): ?>
        <p>Abmelden erfolgreich.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "delete_user_success"): ?>
        <p>Benutzer erfolgreich gelöscht.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_userID"): ?>
        <p>Benutzer-ID nicht gefunden.</p>
      <?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "user_not_found"): ?>
        <p>Benutzer nicht gefunden.</p>
      <?php endif; ?>
      <?php
          unset($_SESSION["message"]);
      ?>
    </div>
    <h2>Bier-Feed</h2>

    <?php foreach ($reviews as $review):
      $id = $review->getId();?>
      <article class="post">
        <header class="post-header">
          <span class="username">User #<?php echo htmlspecialchars($review->getAuthorId()); ?></span>
          <div class="post-actions">
            <div class="favourite">
              <input type="checkbox" id="favourite_<?php echo $id; ?>" name="favourite_<?php echo $id; ?>"
                     class="favourite-checkbox"
                     aria-label="Diesen Post zu Favoriten hinzufügen">
              <label for="favourite_<?php echo $id; ?>" class="favourite-label">
                <span class="favourite-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Favorisieren</span>
              </label>
            </div>
          </div>
        </header>
        <h3><?php echo htmlspecialchars($review->getBeerName()); ?></h3>
        <div class="facts">
          <img src="<?php echo $review->getPicture(); ?>" alt="Kein Bild vorhanden" width="70">
          <p>Biername:<br> <?php echo htmlspecialchars($review->getBeerName()); ?></p>
          <p>Bierart:<br> <?php echo htmlspecialchars($review->getBeerType()); ?></p>
          <p>Alkoholgehalt:<br> <?php echo htmlspecialchars($review->getAlcoholContent()); ?></p>
          <p>Stammwürze:<br> <?php echo htmlspecialchars($review->getOriginalExtract()); ?></p>
          <p>Bewertung:<br> <?php echo htmlspecialchars($review->getRating()); ?>/5</p>
        </div>
        <div class="content">
          <p><?php echo htmlspecialchars($review->getContent()); ?></p>
        </div>
        <time><?php echo htmlspecialchars($review->getCreatedAt()); ?></time>
      </article>
    <?php endforeach; ?>
  </main>
</div>

<?php include_once '../include/footer.php'; ?>

</body>
</html>
