<?php
session_start();
include 'includes/db.php'; // Ce chemin est correct pour votre db.php

$stmt = $pdo->query("SELECT * FROM event ORDER BY date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="public-page"> <?php // <-- MODIFICATION ICI : Ajout de la classe "public-page"
    include 'includes/navbar.php'; // Ce chemin est correct et inclura la navbar publique bleue
    ?>

    <div class="main-content-public"> <?php // <-- MODIFICATION ICI : Changement de la classe du wrapper
        // Assurez-vous que le contenu de votre hero-section et events-section est bien à l'intérieur de ce div.
        // Vous pouvez aussi ajouter une div .main-content directement à l'intérieur de main-content-public pour avoir le padding général défini
        // dans .main-content si vous voulez que les sections aient un padding interne différent.
        // Pour l'instant, le padding est géré par .main-content-public lui-même.
        ?>
        <div class="main-content"> <header class="hero-section">
                <div class="hero-content">
                    <h1>Bienvenue sur EventSport !</h1>
                    <p>Trouvez et participez aux meilleurs événements sportifs autour de vous.</p>
                    <a href="events.php" class="btn">Voir les événements</a>
                </div>
                <div class="hero-image">
                    <img src="https://via.placeholder.com/600x400?text=EventSport+Hero" alt="Sport Event">
                </div>
            </header>

            <section class="events-section">
                <h2>Événements à venir</h2>
                <?php if (!empty($events)): ?>
                    <div class="event-grid">
                        <?php foreach ($events as $event): ?>
                            <div class="event-card">
                                <?php if ($event['image']): ?>
                                    <img src="uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x200?text=Pas+d'image" alt="Image par défaut">
                                <?php endif; ?>
                                <h3><?= htmlspecialchars($event['title']) ?></h3>
                                <p><strong>Date :</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($event['date']))) ?></p>
                                <p><strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?></p>
                                <p><?= nl2br(htmlspecialchars(substr($event['description'], 0, 100))) ?><?= strlen($event['description']) > 100 ? '...' : '' ?></p>
                                <a href="event.php?id=<?= $event['id'] ?>" class="btn-sm">Voir Détails</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-events-message">Aucun événement prévu pour le moment.</p>
                <?php endif; ?>
            </section>

            <section class="about-us-preview">
                <h2>À propos d'EventSport</h2>
                <p>EventSport est votre plateforme dédiée pour découvrir et organiser des événements sportifs locaux. Que vous soyez un athlète passionné ou un organisateur cherchant à toucher un public plus large, nous sommes là pour vous connecter.</p>
                <a href="about.php" class="btn">En savoir plus</a>
            </section>
        </div> <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</body>
</html>