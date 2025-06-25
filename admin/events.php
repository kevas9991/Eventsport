<?php
session_start(); // Démarre la session pour gérer l'authentification utilisateur

// Vérifie si l'utilisateur est connecté ET s'il a le rôle 'admin'
// Sinon, il est redirigé vers la page de connexion admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige vers la page de connexion admin
    exit; // Stoppe l'exécution après la redirection
}

include '../includes/db.php'; // Inclut la connexion à la base de données (remonte d'un niveau)

// Récupère tous les événements dans la base, triés par date décroissante
// Jointure avec la table 'user' pour obtenir le nom du créateur
$stmt = $pdo->query("SELECT e.*, u.username AS creator_name FROM event e JOIN user u ON e.creator_id = u.id ORDER BY e.date DESC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère les résultats sous forme de tableau associatif
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Gestion des événements - Admin - EventSport</title> <link rel="stylesheet" href="../css/style.css"> </head>
<body class="admin-page"> <?php
    // Puisque le fichier est dans admin/, il faut remonter d'un niveau pour inclure includes/navbar_admin.php
    include 'includes/navbar_admin.php';
    // J'ai vu que dans votre code actuel vous avez directement mis la navbar en dur,
    // mais pour la modularité et pour utiliser la navbar_admin.php que nous avons définie,
    // il est préférable d'inclure ce fichier.
    // Si vous préférez la laisser en dur, assurez-vous juste que le code correspond à celui de navbar_admin.php
    ?>

    <div class="main-content-wrapper">
        <main class="main-content">
            <section class="admin-content-section event-showcase">
                <h2>Gestion des événements</h2>

                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] === 'deleted'): ?>
                        <div class="message success">Événement supprimé avec succès !</div>
                    <?php elseif ($_GET['status'] === 'created'): ?>
                        <div class="message success">Événement créé avec succès !</div>
                    <?php elseif ($_GET['status'] === 'updated'): ?>
                        <div class="message success">Événement mis à jour avec succès !</div>
                    <?php elseif ($_GET['status'] === 'error'): ?>
                        <div class="message error">Une erreur est survenue lors de l'opération.</div>
                    <?php endif; ?>
                <?php endif; ?>

                <p style="text-align: center; margin-bottom: 30px;"><a href="create-event.php" class="btn">+ Créer un nouvel événement</a></p>

                <?php if (!empty($events)): ?>
                    <div class="table-responsive"> <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Lieu</th>
                                    <th>Créé par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($event['id']) ?></td>
                                        <td><?= htmlspecialchars($event['title']) ?></td>
                                        <td><?= htmlspecialchars($event['date']) ?></td>
                                        <td><?= htmlspecialchars($event['location']) ?></td>
                                        <td><?= htmlspecialchars($event['creator_name']) ?></td>
                                        <td class="actions-cell">
                                            <a href="edit-event.php?id=<?= $event['id'] ?>" class="btn-action edit">Modifier</a>
                                            <a href="#" onclick="showCustomConfirm('Êtes-vous sûr de vouloir supprimer cet événement ?', 'delete-event.php?id=<?= $event['id'] ?>')" class="btn-action delete">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="text-align: center; margin-top: 30px;">Aucun événement trouvé.</p>
                <?php endif; ?>

                <p style="text-align: center; margin-top: 40px;"><a href="index.php" class="btn">← Retour au tableau de bord</a></p>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport Admin. Tous droits réservés.</p>
            </div>
        </footer>
    </div> <div id="custom-confirm-overlay" class="custom-confirm-overlay">
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