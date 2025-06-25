<?php
// admin/users.php - Page de gestion des utilisateurs par un administrateur

session_start(); // Démarre la session pour gérer l'authentification

// Vérifie que l'utilisateur est connecté et a le rôle 'admin'
// Sinon, il est redirigé vers la page de connexion
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php'); // Redirige vers la page de connexion (à la racine)
    exit; // Stoppe l'exécution après la redirection
}

include '../includes/db.php'; // Inclusion du fichier de connexion à la base de données (remonte d'un niveau)

// Récupère tous les utilisateurs depuis la table 'user'
$stmt = $pdo->query("SELECT * FROM user ORDER BY id ASC"); // Ajout d'un tri pour l'ordre
$users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère les résultats sous forme de tableau associatif
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - Admin - EventSport</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-page"> <!-- MODIFICATION IMPORTANTE ICI : Ajout de la classe "admin-page" -->

    <!-- Inclusion de la barre de navigation verticale (Navbar latérale rouge) pour l'ADMIN -->
    <?php include 'includes/navbar_admin.php'; ?> <!-- MODIFICATION IMPORTANTE ICI : Inclusion du fichier navbar_admin.php -->

    <!-- Wrapper pour le contenu principal et le pied de page -->
    <div class="main-content-wrapper">
        <!-- Contenu principal : Liste des utilisateurs -->
        <main class="main-content">
            <section class="admin-content-section event-showcase">
                <h2>Gestion des utilisateurs</h2>

                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] === 'deleted'): ?>
                        <div class="message success">Utilisateur supprimé avec succès !</div>
                    <?php elseif ($_GET['status'] === 'error'): ?>
                        <div class="message error">Une erreur est survenue lors de l'opération.</div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="data-table">
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
                                        <td>
                                            <span class="role-<?= htmlspecialchars($user['role']) ?>">
                                                <?= strtoupper(htmlspecialchars($user['role'])) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                                        <td class="actions-cell">
                                            <a href="edit-user.php?id=<?= $user['id'] ?>" class="btn-action edit">Modifier</a>
                                            <!-- MODIFICATION IMPORTANTE ICI : Remplacement de confirm() par showCustomConfirm() -->
                                            <a href="#" onclick="showCustomConfirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?', 'delete-user.php?id=<?= $user['id'] ?>')" class="btn-action delete">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="text-align: center; margin-top: 30px;">Aucun utilisateur trouvé.</p>
                <?php endif; ?>

                <p style="text-align: center; margin-top: 40px;"><a href="index.php" class="btn">← Retour au tableau de bord</a></p>
            </section>
        </main>

        <!-- Pied de page -->
        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport Admin. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
    <!-- MODIFICATION IMPORTANTE ICI : Ajout du script pour la boîte de dialogue de confirmation personnalisée -->
    <!-- Assurez-vous que ce bloc est présent une seule fois dans votre page ou qu'il est externalisé dans un fichier JS si nécessaire -->
    <div id="custom-confirm-overlay" class="custom-confirm-overlay">
        <div class="custom-confirm-box">
            <p id="custom-confirm-message"></p>
            <div class="custom-confirm-buttons">
                <button id="custom-confirm-cancel" class="btn-cancel">Annuler</button>
                <button id="custom-confirm-ok" class="btn-ok">Confirmer</button>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour afficher la boîte de dialogue de confirmation personnalisée
        function showCustomConfirm(message, confirmUrl) {
            const overlay = document.getElementById('custom-confirm-overlay');
            const msgElement = document.getElementById('custom-confirm-message');
            const okButton = document.getElementById('custom-confirm-ok');
            const cancelButton = document.getElementById('custom-confirm-cancel');

            msgElement.textContent = message; // Définit le message
            overlay.style.display = 'flex'; // Affiche l'overlay

            // Gère le clic sur le bouton "Confirmer"
            okButton.onclick = function() {
                overlay.style.display = 'none'; // Cache l'overlay
                window.location.href = confirmUrl; // Redirige vers l'URL de confirmation
            };

            // Gère le clic sur le bouton "Annuler"
            cancelButton.onclick = function() {
                overlay.style.display = 'none'; // Cache l'overlay
            };

            // Gère le clic en dehors de la boîte de dialogue pour annuler
            overlay.onclick = function(event) {
                if (event.target === overlay) {
                    overlay.style.display = 'none';
                }
            };
        }
    </script>
</body>
</html>