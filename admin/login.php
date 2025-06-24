<?php
// Activer l'affichage des erreurs (facultatif mais utile en dev)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Inclure la connexion à la base de données
include '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $message = "Veuillez saisir votre email et mot de passe.";
    } else {
        // Requête pour récupérer l'utilisateur
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Connexion réussie → on stocke l'utilisateur dans la session
                $_SESSION['user'] = $user;

                // Redirection selon le rôle
                if (!empty($user['role']) && $user['role'] === 'admin') {
                    header('Location: index.php');
                } else {
                    header('Location: ../index.php'); // Page utilisateur normal
                }
                exit;
            } else {
                $message = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $message = "Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Connexion Administrateur</h1>

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

        <p><a href="../login.php">← Retour à la connexion utilisateur</a></p>
    </div>
</body>
</html>