<?php
session_start(); // Démarre la session pour gérer l'état de connexion
include 'includes/db.php'; // Inclusion du fichier de connexion à la base de données

$message = ''; // Variable pour afficher un message d’erreur ou de confirmation

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']); // Récupère et sécurise le nom d'utilisateur
    $email = htmlspecialchars($_POST['email']); // Récupère et sécurise l'email
    $password = $_POST['password']; // Récupère le mot de passe (non encore haché)
    $confirm_password = $_POST['confirm_password']; // Récupère la confirmation du mot de passe

    // Vérifie que tous les champs sont remplis
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Tous les champs sont obligatoires."; // Message si un champ est vide
    } elseif ($password !== $confirm_password) {
        $message = "Les mots de passe ne correspondent pas."; // Message si les mots de passe sont différents
    } else {
        // Hachage du mot de passe pour plus de sécurité
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Préparation et exécution de la requête SQL d'insertion
            $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);

            // Redirige l'utilisateur vers la page d'accueil après inscription réussie
            header('Location: index.php');
            exit; // Termine le script après redirection
        } catch (PDOException $e) {
            // Affiche un message d’erreur si l’insertion échoue (ex : email déjà utilisé)
            $message = "<div class='error'>Erreur lors de l'inscription : " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr"> <head>
    <meta charset="UTF-8"> <title>Inscription - EventSport</title> <link rel="stylesheet" href="css/style.css"> </head>
<body class="auth-page"> <div class="auth-container"> <h1>S'inscrire</h1> <?php if ($message): ?> <div class="message"><?= $message ?></div> <?php endif; ?>

        <form method="POST" action=""> <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required> <label for="email">Email :</label>
            <input type="email" name="email" id="email" required> <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required> <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password" required> <button type="submit">S'inscrire</button> </form>

        <p>Déjà inscrit ? <a href="login.php">Se connecter ici</a></p>
    </div>
</body>
</html>