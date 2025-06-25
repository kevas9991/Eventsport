<?php
session_start(); // Démarre une session PHP pour gérer les données utilisateur entre les pages

// Vérifie si l'utilisateur est connecté et a le rôle 'admin', sinon redirige vers la page de connexion admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php'); // Redirige vers la page de connexion (remonte d'un niveau)
    exit; // Stoppe l'exécution du script après la redirection
}

include '../includes/db.php'; // Inclut le fichier de connexion à la base de données (remonte d'un niveau)

// Définit une constante pour le chemin absolu vers le dossier 'uploads'
// Le chemin est ../uploads car create-event.php est dans admin/,
// donc remonter d'un niveau pour atteindre le dossier racine, puis 'uploads'.
define('UPLOADS_DIR', __DIR__ . '/../uploads'); // Correction du chemin: remonte d'un seul niveau pour uploads

$message = ''; // Initialise une variable pour stocker les messages d'erreur ou de succès
$message_type = ''; // Pour le type de message (success/error)

// Vérifie si le formulaire a été soumis via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire, avec des valeurs par défaut pour éviter les erreurs "Undefined index"
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $date = $_POST['date'] ?? '';
    $location = $_POST['location'] ?? '';
    $creator_id = $_SESSION['user']['id']; // Identifiant de l'utilisateur créateur depuis la session
    $image_path = null; // Initialise le chemin de l'image à null

    // Validation des champs obligatoires
    if (empty($title) || empty($date) || empty($location)) {
        $message = "Veuillez remplir tous les champs obligatoires (Titre, Date et heure, Lieu).";
        $message_type = 'error';
    } else {
        // Gestion de l'upload d'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Assurez-vous que le dossier uploads existe et est inscriptible
            if (!is_dir(UPLOADS_DIR)) {
                mkdir(UPLOADS_DIR, 0777, true); // Crée le dossier avec permissions si inexistant
            }

            $target_file = UPLOADS_DIR . '/' . basename($_FILES["image"]["name"]); // Chemin complet du fichier à enregistrer
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Récupère l'extension

            // Liste des formats d'images autorisés
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            // Vérifie que l'extension de l'image est bien dans la liste des formats acceptés
            if (!in_array($imageFileType, $allowed_types)) {
                $message = "Format d'image non pris en charge. Formats autorisés : JPG, JPEG, PNG, GIF.";
                $message_type = 'error';
            } else {
                // Pour éviter les conflits de noms, vous pouvez ajouter un timestamp ou un UUID au nom de fichier
                // Exemple : $new_file_name = uniqid() . '_' . basename($_FILES["image"]["name"]);
                // $target_file = UPLOADS_DIR . '/' . $new_file_name;
                // $image_path = $new_file_name;

                // Tente de déplacer le fichier temporaire vers le dossier uploads
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = basename($_FILES["image"]["name"]); // Stocke le nom du fichier pour l'enregistrer en base
                } else {
                    $message = "Erreur lors du déplacement de l'image. Vérifiez les permissions du dossier uploads.";
                    $message_type = 'error';
                }
            }
        }

        // Si aucune erreur détectée jusque-là (après validation des champs et de l'image)
        if ($message === '') {
            try {
                // Prépare et exécute la requête SQL d'insertion d'un nouvel événement avec les données du formulaire
                $stmt = $pdo->prepare("INSERT INTO event (title, description, date, location, creator_id, image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $description, $date, $location, $creator_id, $image_path]);

                $message = "Événement créé avec succès !"; // Message de succès
                $message_type = 'success';

                // Optionnel: Rediriger après succès pour éviter la soumission multiple du formulaire
                // header('Location: events.php?status=created');
                // exit;

            } catch (PDOException $e) {
                // En cas d'erreur lors de l'insertion, affiche le message d'erreur PDO
                $message = "Erreur lors de la création : " . $e->getMessage();
                $message_type = 'error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un événement - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css"> </head>
<body class="admin-page"> <?php include 'includes/navbar_admin.php'; ?> <div class="main-content-wrapper">
        <main class="main-content">
            <section class="admin-content-section event-showcase">
                <h1>Créer un nouvel événement</h1>

                <?php if ($message): ?>
                    <div class="message <?= $message_type ?>"><?= $message ?></div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data" class="admin-form">
                    <label for="title">Titre :</label>
                    <input type="text" name="title" id="title" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">

                    <label for="description">Description :</label>
                    <textarea name="description" id="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

                    <label for="date">Date et heure :</label>
                    <input type="datetime-local" name="date" id="date" required value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">

                    <label for="location">Lieu :</label>
                    <input type="text" name="location" id="location" required value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">

                    <label for="image">Image de l'événement :</label>
                    <input type="file" name="image" id="image" accept="image/*">

                    <button type="submit" class="btn">Créer l'événement</button>
                </form>

                <p style="text-align: center; margin-top: 30px;"><a href="events.php" class="btn">← Retour à la liste des événements</a></p>
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