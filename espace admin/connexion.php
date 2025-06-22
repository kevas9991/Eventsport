<?php
// login.php - Page de connexion

// Inclure la connexion à la base (optionnel pour le moment)
// include 'includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ce code sera activé plus tard, pour l'instant on affiche juste un message
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Ici, on simule une tentative de connexion
    $message = "Formulaire soumis !<br>Email : $email";
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
            <div class="message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore de compte ? <a href="register.php">S'inscrire ici</a></p>
    </div>
</body>
</html>