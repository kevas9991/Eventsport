<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db.php';

$id = $_GET['id'];

// Charger les données de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_role = $_POST['role'];

    // Mettre à jour le rôle
    $stmt = $pdo->prepare("UPDATE user SET role = ? WHERE id = ?");
    $stmt->execute([$new_role, $id]);

    $message = "Rôle mis à jour avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Modifier l'utilisateur <?= htmlspecialchars($user['username']) ?></h1>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="role">Rôle :</label>
            <select name="role" id="role" required>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>

            <button type="submit">Mettre à jour</button>
        </form>

        <p><a href="users.php">← Retour à la liste</a></p>
    </div>
</body>
</html>