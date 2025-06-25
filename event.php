<?php
session_start();
include 'includes/db.php'; // Chemin vers votre fichier de connexion à la base de données

// Vérifie si un ID d'événement est passé dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = $_GET['id'];

    // Prépare et exécute la requête pour récupérer l'événement spécifique
    $stmt = $pdo->prepare("SELECT e.*, u.username AS creator_name 
                           FROM event e 
                           JOIN user u ON e.creator_id = u.id 
                           WHERE e.id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'événement n'existe pas, redirige vers la page des événements
    if (!$event) {
        header('Location: events.php');
        exit;
    }
} else {
    // Si aucun ID n'est fourni, redirige vers la page des événements
    header('Location: events.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?> - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="public-page">
    <?php include 'includes/navbar.php'; // Inclusion de la navbar publique ?>

    <div class="main-content-public">
        <div class="main-content">
            <section class="event-detail-page">
                <div class="event-detail-card">
                    <?php if ($event['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" class="event-detail-image">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/800x400?text=Pas+d'image+pour+l'événement" alt="Image par défaut" class="event-detail-image">
                    <?php endif; ?>

                    <h1><?= htmlspecialchars($event['title']) ?></h1>
                    <p class="event-meta">
                        <strong>Date :</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($event['date']))) ?><br>
                        <strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?><br>
                        <strong>Créé par :</strong> <?= htmlspecialchars($event['creator_name']) ?>
                    </p>
                    <div class="event-description">
                        <h3>Description de l'événement :</h3>
                        <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                    </div>

                    <a href="events.php" class="btn">← Retour aux événements</a>
                </div>
            </section>
        </div><footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport. Tous droits réservés.</p>
            </div>
        </footer>
    </div></body>
</html>