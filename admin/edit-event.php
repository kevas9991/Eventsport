<?php
session_start(); // Démarre la session PHP pour gérer l'authentification utilisateur

// Vérifie si l'utilisateur est connecté et s'il a le rôle 'admin'
// Sinon, redirige vers la page de connexion admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige vers la page de connexion admin
    exit; // Arrête l'exécution après la redirection
}

include '../includes/db.php'; // Inclusion du fichier de connexion à la base de données (remonte d'un niveau)

$id = $_GET['id'] ?? null; // Récupère l'identifiant de l'événement à modifier depuis l'URL, ou null

// Vérifie si un ID est fourni
if (!$id) {
    header('Location: events.php?status=error&message=Événement non spécifié.'); // Redirige si pas d'ID
    exit;
}

// Charge les données de l'événement correspondant à cet ID depuis la base de données
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Si aucun événement n'est trouvé, redirige vers la liste avec un message d'erreur
if (!$event) {
    header('Location: events.php?status=error&message=Événement introuvable.');
    exit;
}

$message = ''; // Variable pour stocker un message de confirmation ou d'erreur
$message_type = ''; // Pour le type de message (success/error)

// Si le formulaire a été soumis en POST, on traite la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les valeurs envoyées via le formulaire
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $date = $_POST['date'] ?? '';
    $location = $_POST['location'] ?? '';

    // Validation des champs (simple, peut être étendue)
    if (empty($title) || empty($date) || empty($location)) {
        $message = "Veuillez remplir tous les champs obligatoires (Titre, Date, Lieu).";
        $message_type = 'error';
    } else {
        try {
            // Prépare et exécute la requête SQL de mise à jour de l'événement dans la base
            $stmt = $pdo->prepare("UPDATE event SET title=?, description=?, date=?, location=? WHERE id=?");
            $stmt->execute([$title, $description, $date, $location, $id]);

            $message = "Événement mis à jour avec succès !"; // Message de succès pour l'utilisateur
            $message_type = 'success';

            // Optionnel: Recharger les données de l'événement après mise à jour pour affichage immédiat
            $stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
            $stmt->execute([$id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $message = "Erreur lors de la mise à jour de l'événement : " . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un événement - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <nav class="navbar-vertical">
        <div class="navbar-header">
            <h1>ADMIN PANEL</h1>
        </div>
        <ul class="navbar-menu">
            <li><a href="index.php">🏠 Tableau de bord</a></li>
            <li><a href="users.php">👥 Gérer les utilisateurs</a></li>
            <li><a href="events.php">📅 Gérer les événements</a></li>
            <li><a href="create-event.php">➕ Créer un événement</a></li>
            <li><a href="../index.php">⬅ Retour au site public</a></li>
            <li><a href="../logout.php" class="btn-red">❌ Se déconnecter</a></li>
        </ul>
    </nav>

    <div class="main-content-wrapper">
        <main class="main-content">
            <section class="admin-content-section event-showcase">
                <h1>Modifier l'événement : <?= htmlspecialchars($event['title']) ?></h1>

                <?php if ($message): ?>
                    <div class="message <?= $message_type ?>"><?= $message ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="admin-form">
                    <label for="title">Titre :</label>
                    <input type="text" name="title" id="title" value="<?= htmlspecialchars($event['title']) ?>" required>

                    <label for="description">Description :</label>
                    <textarea name="description" id="description"><?= htmlspecialchars($event['description']) ?></textarea>

                    <label for="date">Date et heure :</label>
                    <input type="datetime-local" name="date" id="date" value="<?= date('Y-m-d\TH:i', strtotime($event['date'])) ?>" required>

                    <label for="location">Lieu :</label>
                    <input type="text" name="location" id="location" value="<?= htmlspecialchars($event['location']) ?>" required>

                    <button type="submit" class="btn">Mettre à jour l'événement</button>
                </form>

                <p style="text-align: center; margin-top: 30px;"><a href="events.php" class="btn">← Retour à la liste des événements</a></p>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport Admin. Tous droits réservés.</p>
            </div>
        </footer>
    </div> </body>
</html>