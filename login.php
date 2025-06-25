<?php
session_start(); // Démarre la session PHP pour gérer l'état de connexion
include 'includes/db.php'; // Inclut la connexion à la base de données

$message = ''; // Variable pour stocker un message d'erreur ou de succès

// Si le formulaire a été soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']); // Récupère l'email saisi et le sécurise
    $password = $_POST['password']; // Récupère le mot de passe (non modifié car vérifié avec hash)

    // Requête pour vérifier si l'utilisateur avec cet email existe
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère l'utilisateur s'il existe

    // Si l'utilisateur existe et que le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user; // Stocke les infos utilisateur dans la session

        // Redirection selon le rôle de l'utilisateur
        if ($user['role'] === 'admin') {
            header('Location: admin/index.php'); // Redirige vers l'espace admin
        } else {
            header('Location: index.php'); // Redirige vers l'accueil public
        }
        exit; // Arrête l'exécution après la redirection
    } else {
        // Si l'authentification échoue, on prépare un message d'erreur
        $message = "<div class='error'>Email ou mot de passe incorrect.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr"> <head>
    <meta charset="UTF-8"> <title>Connexion - EventSport</title> <link rel="stylesheet" href="css/style.css"> </head>
<body class="auth-page"> <div class="auth-container"> <h1>Se connecter</h1> <?php if ($message): ?> <div class="message"><?= $message ?></div> <?php endif; ?>

        <form method="POST" action=""> <label for="email">Email :</label>
            <input type="email" name="email" id="email" required> <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required> <button type="submit">Se connecter</button> </form>

        <p><a href="register.php">Pas encore inscrit ? S'inscrire ici</a></p>
    </div>
</body>
</html>