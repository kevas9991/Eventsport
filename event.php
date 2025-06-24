<?php
// event.php - Détail d'un événement

session_start();
include 'includes/db.php';

// Vérifier si l'ID est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Événement introuvable.");
}

$event_id = $_GET['id'];

// Charger les données de l'événement
$stmt = $pdo->prepare("SELECT e.*, u.username AS creator_name FROM event e JOIN user u ON e.creator_id = u.id WHERE e.id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Événement introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['title']) ?> - EventSport</title>
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
        <h2>Détails de l’événement</h2>

        <div class="event-detail">
            <h3><?= htmlspecialchars($event['title']) ?></h3>
            <p><strong>Date :</strong> <?= $event['date'] ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?></p>
            <p><strong>Description :</strong></p>
            <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
            <p><strong>Créé par :</strong> <?= htmlspecialchars($event['creator_name']) ?></p>
        </div>

        <!-- Formulaire optionnel pour s'inscrire -->
        <?php if (isset($_SESSION['user'])): ?>
            <div class="action">
                <form method="POST" action="join-event.php">
                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                    <button type="submit" class="btn">Je participe</button>
                </form>
            </div>
        <?php else: ?>
            <div class="info">
                <p>Connectez-vous pour vous inscrire à cet événement.</p>
            </div>
        <?php endif; ?>

        <p><a href="index.php" class="btn-back">← Retour aux événements</a></p>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 EventSport. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>