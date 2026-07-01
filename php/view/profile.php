<?php
$title = 'Profil';

if (!isset($abs_path)) {
  require_once "../../path.php";
}
require_once $abs_path . "/php/session-start.php";

require_once $abs_path . '/php/profile-load.php';

include_once $abs_path . '/php/include/header.php';
?>

  <div class="layout">
    <?php include_once $abs_path . '/php/include/sidebar.php'; ?>

    <main>
      <div class="success">
        <?php if (isset($_SESSION['message']) && $_SESSION['message'] == 'update_profile_success'): ?>
          <p>Profiländerungen wurden erfolgreich gespeichert.</p>
        <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'create_review_success'): ?>
          <p>Review erfolgreich erstellt.</p>
        <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'update_review_success'): ?>
          <p>Review erfolgreich aktualisiert.</p>
        <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'delete_review_success'): ?>
          <p>Review erfolgreich gelöscht.</p>
        <?php elseif (isset($_SESSION['message']) && $_SESSION['message'] == 'user_not_found'): ?>
          <p class="alert">Kein Benutzer eingeloggt.</p>
        <?php endif; ?>
        <?php unset($_SESSION['message']); ?>
      </div>

      <section class="profile-card" aria-labelledby="profile-heading">
        <div class="profile-header">
          <img src="<?php echo ROOT; ?>img/<?php echo htmlspecialchars($current_user->getProfilePicture()); ?>"
               alt="Profilbild" class="profile-img">
          <div class="profile-info">
            <h2 id="profile-heading">Profil</h2>
            <h3 class="username">@<?php echo htmlspecialchars($current_user->getNickname()); ?></h3>
          </div>
        </div>
        <div class="profile-actions">
          <a href="<?php echo ROOT; ?>php/view/edit-profile.php" class="button-secondary">Profil bearbeiten</a>
        </div>
      </section>

      <h2>Meine Reviews</h2>

      <?php if (empty($userReviews)): ?>
        <p style="text-align:center;">
          Noch keine Reviews vorhanden.
          <a href="<?php echo ROOT; ?>php/view/create-review.php">Jetzt erstes Review erstellen!</a>
        </p>
      <?php else: ?>
        <?php foreach ($userReviews as $review):
          $rid = $review->getId(); ?>
          <article class="post">
            <header class="post-header">
              <span class="username">@<?php echo htmlspecialchars($current_user->getNickname()); ?></span>
              <div class="post-actions">
                <a class="button-secondary"
                   href="<?php echo ROOT; ?>php/view/edit-review.php?id=<?php echo $rid; ?>">Bearbeiten</a>
              </div>
            </header>
            <h3><?php echo htmlspecialchars($review->getBeerName()); ?></h3>
            <div class="facts">
              <img src="<?php echo ROOT; ?>/img/<?php echo htmlspecialchars($review->getPicture()); ?>"
                   alt="Foto von <?php echo htmlspecialchars($review->getBeerName()); ?>" width="70">
              <p>Bierart:<br> <?php echo htmlspecialchars($review->getBeerType()); ?></p>
              <p>Alkoholgehalt:<br> <?php echo htmlspecialchars($review->getAlcoholContent()); ?>%</p>
              <p>Stammwürze:<br> <?php echo htmlspecialchars($review->getOriginalExtract()); ?>%</p>
              <p>Bewertung:<br> <?php echo htmlspecialchars($review->getRating()); ?>/5</p>
            </div>
            <div class="content">
              <p><?php echo htmlspecialchars($review->getContent()); ?></p>
            </div>
            <time><?php echo htmlspecialchars($review->getCreatedAt()); ?></time>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>

    </main>
  </div>

<?php include_once $abs_path . '/php/include/footer.php'; ?>

