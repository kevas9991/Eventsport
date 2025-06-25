<?php
// Vérifie si la session n'est pas déjà démarrée avant de la démarrer
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fonction utilitaire pour déterminer si un lien est actif
function is_public_link_active($page_name) {
    // basename($_SERVER['PHP_SELF']) retourne le nom du fichier actuel (ex: "index.php")
    return basename($_SERVER['PHP_SELF']) == $page_name ? 'active' : '';
}
?>

<nav class="public-navbar-vertical">
    <div class="navbar-header-public">
        <h1>EVENTSPORT</h1>
    </div>
    <ul class="navbar-menu-public">
        <li><a href="index.php" class="<?php echo is_public_link_active('index.php'); ?>">Accueil</a></li>
        <li><a href="events.php" class="<?php echo is_public_link_active('events.php'); ?>">Événements</a></li>
        <li><a href="about.php" class="<?php echo is_public_link_active('about.php'); ?>">À propos</a></li>
        <li><a href="contact.php" class="<?php echo is_public_link_active('contact.php'); ?>">Contact</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <li><a href="admin/index.php">Tableau de bord Admin</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="login.php" class="<?php echo is_public_link_active('login.php'); ?>">Connexion</a></li>
            <li><a href="register.php" class="<?php echo is_public_link_active('register.php'); ?>">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>