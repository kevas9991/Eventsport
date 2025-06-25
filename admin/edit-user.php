<?php
session_start(); // Démarre la session pour gérer l'authentification et les variables utilisateur

// Vérifie si l'utilisateur est connecté et a le rôle 'admin'
// Sinon, redirige vers la page de connexion admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit; // Stoppe l'exécution après la redirection
}

include '../includes/db.php'; // Inclusion de la connexion à la base de données (remonte d'un niveau)

$id = $_GET['id'] ?? null; // Récupère l'id de l'utilisateur à modifier depuis l'URL, ou null si non défini

// Vérifie si un ID est fourni
if (!$id) {
    header('Location: users.php'); // Redirige vers la liste des utilisateurs si pas d'ID
    exit;
}

// Charge les données complètes de cet utilisateur depuis la base
$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Si aucun utilisateur n'est trouvé, redirige vers la liste avec un message d'erreur
if (!$user) {
    header('Location: users.php?status=error&message=Utilisateur introuvable.'); // Redirection avec message
    exit;
}

$message = ''; // Initialise la variable pour stocker un message de succès ou d'erreur
$message_type = ''; // Pour le type de message (success/error)

// Si le formulaire est soumis en méthode POST, on traite la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_role = $_POST['role'] ?? ''; // Récupère le nouveau rôle sélectionné dans le formulaire

    if (empty($new_role)) {
        $message = "Veuillez sélectionner un rôle.";
        $message_type = 'error';
    } else {
        // Prépare et exécute la requête SQL pour mettre à jour le rôle de l'utilisateur dans la base
        try {
            $stmt = $pdo->prepare("UPDATE user SET role = ? WHERE id = ?");
            $stmt->execute([$new_role, $id]);

            $message = "Rôle mis à jour avec succès !"; // Message de confirmation pour l'utilisateur
            $message_type = 'success';
            // Optionnel: Recharger les données de l'utilisateur après mise à jour pour affichage immédiat
            $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $message = "Erreur lors de la mise à jour : " . $e->getMessage();
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
    <title>Modifier un utilisateur - Admin - EventSport</title>
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
                <h1>Modifier l'utilisateur : <?= htmlspecialchars($user['username']) ?></h1>

                <?php if ($message): ?>
                    <div class="message <?= $message_type ?>"><?= $message ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="admin-form"> <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" value="<?= htmlspecialchars($user['username']) ?>" disabled> <label for="email">Email :</label>
                    <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled> <label for="role">Rôle :</label>
                    <select name="role" id="role" required>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>

                    <button type="submit" class="btn">Mettre à jour le rôle</button>
                </form>

                <p style="text-align: center; margin-top: 30px;"><a href="users.php" class="btn">← Retour à la liste des utilisateurs</a></p>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport Admin. Tous droits réservés.</p>
            </div>
        </footer>
    </div> </body>
</html>