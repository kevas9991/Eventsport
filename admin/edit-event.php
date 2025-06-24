<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

$id = $_GET['id'];

// Charger l'événement
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Événement introuvable.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    $stmt = $pdo->prepare("UPDATE event SET title=?, description=?, date=?, location=? WHERE id=?");
    $stmt->execute([$title, $description, $date, $location, $id]);

    $message = "Événement mis à jour avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un événement - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Modifier l'événement</h1>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($event['title']) ?>" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description"><?= htmlspecialchars($event['description']) ?></textarea>

            <label for="date">Date et heure :</label>
            <input type="datetime-local" name="date" id="date" value="<?= substr($event['date'], 0, 16) ?>" required>

            <label for="location">Lieu :</label>
            <input type="text" name="location" id="location" value="<?= htmlspecialchars($event['location']) ?>" required>

            <button type="submit">Mettre à jour</button>
        </form>

        <p><a href="events.php">← Retour à la liste</a></p>
    </div>
</body>
</html>