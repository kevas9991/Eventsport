<?php
// Activer l'affichage des erreurs (facile à commenter plus tard)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté ET est administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Inclure la connexion à la base de données
include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user']['username']) ?> 👋</h1>
        <p>Vous êtes connecté en tant qu'administrateur.</p>

        <div class="dashboard">
            <div class="card">
                <h3>Utilisateurs</h3>
                <?php
                // Compter les utilisateurs
                $stmt = $pdo->query("SELECT COUNT(*) AS total_users FROM user");
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<p>Total : " . $data['total_users'] . "</p>";
                ?>
                <a href="users.php" class="btn">Gérer les utilisateurs</a>
            </div>

            <div class="card">
                <h3>Événements</h3>
                <?php
                // Compter les événements
                try {
                    $stmt = $pdo->query("SELECT COUNT(*) AS total_events FROM event");
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<p>Total : " . $data['total_events'] . "</p>";
                } catch (PDOException $e) {
                    echo "<p style='color:red;'>Erreur événements : Table absente ?</p>";
                }
                ?>
                <a href="events.php" class="btn">Gérer les événements</a>
            </div>
        </div>

        <!-- Bouton de déconnexion centré -->
        <div class="logout-section">
            <a href="logout.php" class="btn-red">Se déconnecter</a>
        </div>
    </div>
</body>
</html>