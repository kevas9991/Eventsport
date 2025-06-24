<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db.php';

// Charger tous les événements
$stmt = $pdo->query("SELECT * FROM event ORDER BY date DESC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des événements - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Liste des événements</h1>

        <p><a href="create-event.php" class="btn">+ Créer un nouvel événement</a></p>

        <?php if (!empty($events)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Créé par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= $event['id'] ?></td>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= htmlspecialchars($event['date']) ?></td>
                            <td><?= htmlspecialchars($event['location']) ?></td>
                            <td><?= htmlspecialchars($event['creator_id']) ?></td>
                            <td>
                                <a href="edit-event.php?id=<?= $event['id'] ?>">Modifier</a> |
                                <a href="#" onclick="confirmEventDelete(<?= $event['id'] ?>)">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun événement trouvé.</p>
        <?php endif; ?>

        <p><a href="index.php">← Retour au tableau de bord</a></p>

        <script>
            function confirmEventDelete(eventId) {
                if (confirm("Êtes-vous sûr de vouloir supprimer cet événement ?")) {
                    window.location.href = "delete-event.php?id=" + eventId;
                }
            }
        </script>
    </div>
</body>
</html>