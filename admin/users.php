<?php
// admin/users.php - Gestion des utilisateurs

session_start();

// Vérifie si l'utilisateur est connecté ET a le rôle admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include '../includes/db.php';

// Charger tous les utilisateurs
$stmt = $pdo->query("SELECT * FROM user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Liste des utilisateurs</h1>

        <?php if (!empty($users)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= strtoupper(htmlspecialchars($user['role'])) ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td class="actions">
                                <a href="edit-user.php?id=<?= $user['id'] ?>" class="action-btn">Modifier</a>
                                <a href="delete-user.php?id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="action-btn">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>

        <p><a href="index.php">← Retour au tableau de bord</a></p>
    </div>
</body>
</html>