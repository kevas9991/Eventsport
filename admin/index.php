<?php
session_start(); // Démarre une session PHP

// Vérifie si l'utilisateur est connecté et a le rôle 'admin', sinon redirige vers la page de connexion
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php'); // Redirige vers la page de connexion, qui est à la racine
    exit; // Arrête l'exécution du script
}

include '../includes/db.php'; // Inclut le fichier de connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css"> </head>
<body class="admin-page"> <?php include 'includes/navbar_admin.php'; ?> <div class="main-content-wrapper">
        <main class="main-content">
            <section class="admin-content-section event-showcase">
                <h1>Tableau de bord Administrateur</h1>
                <p>Bienvenue, <span style="color: #e74c3c; font-weight: bold;"><?= htmlspecialchars($_SESSION['user']['username']) ?></span> !</p>
                <p>Ceci est votre panneau d'administration où vous pouvez gérer les utilisateurs et les événements.</p>

                <div class="event-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                    <div class="event-card" style="text-align: center;">
                        <h3 style="color: #2c3e50;">Gérer les utilisateurs</h3>
                        <p>Ajoutez, modifiez ou supprimez des comptes utilisateurs.</p>
                        <a href="users.php" class="btn">Accéder aux utilisateurs</a>
                    </div>

                    <div class="event-card" style="text-align: center;">
                        <h3 style="color: #2c3e50;">Gérer les événements</h3>
                        <p>Créez, modifiez ou supprimez des événements.</p>
                        <a href="events.php" class="btn">Accéder aux événements</a>
                    </div>

                    <div class="event-card" style="text-align: center;">
                        <h3 style="color: #2c3e50;">Créer un événement</h3>
                        <p>Ajoutez un nouvel événement à la plateforme.</p>
                        <a href="create-event.php" class="btn">Créer un événement</a>
                    </div>
                </div>

            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport Admin. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</body>
</html>