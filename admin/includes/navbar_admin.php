<?php
// Vérifie si la session n'est pas déjà démarrée avant de la démarrer
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fonction utilitaire pour déterminer si un lien est actif (spécifique à l'admin)
function is_admin_link_active($page_name) {
    // basename($_SERVER['PHP_SELF']) retourne le nom du fichier actuel (ex: "index.php" pour admin/index.php)
    return basename($_SERVER['PHP_SELF']) == $page_name ? 'active' : '';
}
?>

<nav class="navbar-vertical">
    <div class="navbar-header">
        <h1>ADMIN PANEL</h1>
    </div>
    <ul class="navbar-menu">
        <li><a href="index.php" class="<?php echo is_admin_link_active('index.php'); ?>">🏠 Tableau de bord</a></li>
        <li><a href="users.php" class="<?php echo is_admin_link_active('users.php'); ?>">👥 Gérer les utilisateurs</a></li>
        <li><a href="events.php" class="<?php echo is_admin_link_active('events.php'); ?>">📅 Gérer les événements</a></li>
        <li><a href="create-event.php" class="<?php echo is_admin_link_active('create-event.php'); ?>">➕ Créer un événement</a></li>
        <li><a href="../index.php">⬅ Retour au site public</a></li>
        <li><a href="../logout.php" class="btn-red">❌ Se déconnecter</a></li>
    </ul>
</nav>