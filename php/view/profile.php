<?php
if (!isset($abs_path)) {
  require_once "../../path.php";
}
require_once $abs_path . "/php/session-start.php";

require_once $abs_path . '/php/profile-load.php';

$title = $is_own_profile ? 'Mein Profil' : 'Profil von ' . htmlspecialchars($profile_user->getNickname());

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
            <?php endif; ?>
            <?php unset($_SESSION['message']); ?>
        </div>

        <section class="profile-card" aria-labelledby="profile-heading">
            <div class="profile-header">
                <img src="<?php echo ROOT; ?>img/<?php echo htmlspecialchars($profile_user->getProfilePicture()); ?>"
                     alt="Profilbild" class="profile-img">
                <div class="profile-info">
                    <h2 id="profile-heading"><?php echo $is_own_profile ? 'Mein Profil' : 'Profil'; ?></h2>
                    <h3 class="username">@<?php echo htmlspecialchars($profile_user->getNickname()); ?></h3>
                </div>
            </div>
            
            <?php if ($is_own_profile): ?>
                <div class="profile-actions">
                    <a href="<?php echo ROOT; ?>php/view/edit-profile.php" class="button-secondary">Profil bearbeiten</a>
                </div>
            <?php endif; ?>
        </section>

        <h2><?php echo $is_own_profile ? 'Meine Reviews' : 'Reviews von @' . htmlspecialchars($profile_user->getNickname()); ?></h2>

        <?php include_once $abs_path . '/php/view/show-review.php'; ?>

    </main>
</div>

<?php include_once $abs_path . '/php/include/footer.php'; ?>