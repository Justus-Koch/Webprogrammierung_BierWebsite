<?php foreach ($reviews as $review):
      $id = $review->getId();?>
      <article class="post">
        <header class="post-header">
          <span class="username">User #<?php try {
              echo htmlspecialchars($userManagement->findUser($review->getAuthorId())->getNickname());
            } catch (UserNotFoundException $e) {
              echo "Username not found";
            } ?></span>
          <div class="post-actions">
            <div class="favourite">
              <form action="../add-favourite.php" method="POST">
                <input type="hidden" name="review_id" value="<?php echo $id; ?>">
                <input type="checkbox" id="favourite_<?php echo $id; ?>" name="favourite_<?php echo $id; ?>"
                     class="favourite-checkbox"
                     aria-label="Diesen Post zu Favoriten hinzufügen"
                     onchange="this.form.submit()"
                     <?php echo (isFavourite($id) ? 'checked' : ''); ?>>
                <label for="favourite_<?php echo $id; ?>" class="favourite-label">
                  <span class="favourite-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Favorisieren</span>
                </label>
              </form>
            </div>
          </div>
        </header>
        <h3><?php echo htmlspecialchars($review->getBeerName()); ?></h3>
        <div class="facts">
          <img src="../../img/<?php echo htmlspecialchars($review->getPicture()); ?>"
                   alt="Foto von <?php echo htmlspecialchars($review->getBeerName()); ?>" width="70">
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