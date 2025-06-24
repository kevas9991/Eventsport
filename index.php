<?php
// index.php - Page d'accueil publique

session_start();
include 'includes/db.php';

// Récupérer tous les événements
$stmt = $pdo->query("SELECT * FROM event ORDER BY date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>EventSport</h1>
            <nav>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="admin/index.php">Espace Admin</a>
                    <a href="logout.php">Se déconnecter</a>
                <?php else: ?>
                    <a href="login.php">Se connecter</a>
                    <a href="register.php">S'inscrire</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Événements à venir</h2>

        <?php if (!empty($events)): ?>
            <div class="event-list">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <h3><?= htmlspecialchars($event['title']) ?></h3>
                        <p><strong>Date :</strong> <?= $event['date'] ?></p>
                        <p><strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?></p>
                        <p><strong>Description :</strong> <?= htmlspecialchars($event['description']) ?></p>
                        <a href="event.php?id=<?= $event['id'] ?>" class="btn">Voir les détails</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun événement prévu pour le moment.</p>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 EventSport. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>