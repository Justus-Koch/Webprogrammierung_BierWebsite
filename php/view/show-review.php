<?php
if (!isset($abs_path)) {
  require_once "../path.php";
}
require_once $abs_path . "/php/session-start.php";

require_once $abs_path . "/php/is-favourite.php";
require_once $abs_path . "/php/model/User.php";
require_once $abs_path . "/php/model/UserManagement.php";
$userManagement = UserManagement::getInstance();

if (!isset($is_own_profile)) {
  $is_own_profile = FALSE;
}

if (empty($reviews)): ?>
  <p style="text-align:center;">
    Noch keine Reviews vorhanden.
    <?php if ($is_own_profile): ?>
      <a href="<?php echo ROOT; ?>php/view/create-review.php">Jetzt erstes Review erstellen!</a>
    <?php endif; ?>
  </p>
<?php else: ?>
  <?php foreach ($reviews as $review): 
    $id = $review->getId(); 
  ?>
    <article class="post">
      <header class="post-header">
        <span class="username">
          <?php try {
            $user = $userManagement->findUser($review->getAuthorId());
            $nickname = htmlspecialchars($user->getNickname());
            $authorId = urlencode($review->getAuthorId());  
            echo "<a href='" . ROOT . "php/view/profile.php?id={$authorId}'>@{$nickname}</a>";  
          } catch (UserNotFoundException $e) {
            echo "Username not found";
          } ?>
        </span>
        
        <div class="post-actions">
          <?php if ($is_own_profile): ?>
            <a class="button-secondary"
               href="<?php echo ROOT; ?>php/view/edit-review.php?id=<?php echo $id; ?>">Bearbeiten</a>

          <?php else: ?>
            <div class="favourite">
              <form action="<?php echo ROOT; ?>php/add-favourite.php" method="POST">
                <input type="hidden" name="review_id" value="<?php echo $id; ?>">
                <input type="checkbox" id="favourite_<?php echo $id; ?>"
                      name="favourite_<?php echo $id; ?>"
                      class="favourite-checkbox"
                      aria-label="Diesen Post zu Favoriten hinzufügen"
                      data-review-id="<?php echo $id; ?>"
                      <?php echo (isFavourite($id) ? 'checked' : ''); ?>>
                <label for="favourite_<?php echo $id; ?>" class="favourite-label">
                  <span class="favourite-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Favorisieren</span>
                </label>
                <noscript>
                  <button class="button-secondary" type="submit">Favorisieren</button>
                </noscript>
              </form>
            </div>
          <?php endif; ?>
        </div>
      </header>

      <h3><?php echo htmlspecialchars($review->getBeerName()); ?></h3>
      <div class="facts">
        <img src="<?php echo ROOT; ?>img/<?php echo htmlspecialchars($review->getPicture()); ?>"
             alt="Foto von <?php echo htmlspecialchars($review->getBeerName()); ?>" width="70">
        <p>Biername:<br> <?php echo htmlspecialchars($review->getBeerName()); ?></p>
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
