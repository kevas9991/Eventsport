<?php
session_start();

// Vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

include 'includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Code pour la connexion utilisateur
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Se connecter</h1>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Se connecter</button>
        </form>

        <p><a href="register.php">Pas encore inscrit ? S'inscrire ici</a></p>
    </div>
</body>
</html>