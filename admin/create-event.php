<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db.php';

// Chemin absolu vers le dossier uploads
define('UPLOADS_DIR', __DIR__ . '/../../uploads');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $creator_id = $_SESSION['user']['id'];

    // Gestion de l'upload d'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = UPLOADS_DIR;
        $target_file = $target_dir . '/' . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérification du format de l'image
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $message = "Format d'image non pris en charge. Formats autorisés : JPG, JPEG, PNG, GIF.";
        } else {
            // Déplacer le fichier uploadé
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = basename($_FILES["image"]["name"]);
            } else {
                $message = "Erreur lors du déplacement de l'image. Vérifie les permissions du dossier uploads.";
            }
        }
    }

    if ($message === '') { // Pas d'erreurs jusqu'à présent
        try {
            // Insérer les données dans la base
            $stmt = $pdo->prepare("INSERT INTO event (title, description, date, location, creator_id, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $date, $location, $creator_id, $image_path ?? null]);

            $message = "Événement créé avec succès !";
        } catch (PDOException $e) {
            $message = "Erreur lors de la création : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un événement - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Créer un événement</h1>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description"></textarea>

            <label for="date">Date et heure :</label>
            <input type="datetime-local" name="date" id="date" required>

            <label for="location">Lieu :</label>
            <input type="text" name="location" id="location" required>

            <label for="image">Image de l'événement :</label>
            <input type="file" name="image" id="image" accept="image/*">

            <button type="submit">Créer l'événement</button>
        </form>

        <p><a href="index.php">← Retour au tableau de bord</a></p>
    </div>
</body>
</html>