<?php
// Active l'affichage des erreurs PHP (utile en phase de développement, à désactiver en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarre la session pour gérer les données utilisateur entre les pages
session_start();

// Inclut la connexion à la base de données (PDO)
include '../includes/db.php'; // Chemin ajusté pour remonter d'un dossier

$message = ''; // Variable pour stocker un message d'erreur ou d'information

// Vérifie si le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire ou chaîne vide si non définies
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifie que l'email et le mot de passe ne sont pas vides
    if (empty($email) || empty($password)) {
        $message = "Veuillez saisir votre email et mot de passe.";
    } else {
        // Prépare et exécute la requête pour récupérer l'utilisateur correspondant à l'email
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifie que l'utilisateur existe et que le mot de passe correspond via password_verify (hash sécurisé)
            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie : stocke les infos utilisateur dans la session
                $_SESSION['user'] = $user;

                // Redirige selon le rôle de l'utilisateur
                if (!empty($user['role']) && $user['role'] === 'admin') {
                    header('Location: index.php'); // Tableau de bord admin (dans le même dossier)
                } else {
                    // Si l'utilisateur n'est pas admin, le rediriger vers la page d'accueil publique
                    header('Location: ../index.php'); // Page utilisateur classique (remonter d'un dossier)
                }
                exit; // Arrête le script après redirection
            } else {
                // Si identifiants incorrects
                $message = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            // En cas d'erreur lors de la requête SQL
            $message = "Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Connexion Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css"> </head>
<body class="auth-page"> <div class="auth-container"> <h1>Connexion Administrateur</h1>

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

        <p><a href="../login.php">← Retour à la connexion utilisateur</a></p> </div>
</body>
</html>