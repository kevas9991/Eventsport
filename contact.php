<?php
session_start(); // Démarre la session PHP
// include 'includes/db.php'; // Ce fichier n'est pas utilisé directement ici, pas besoin de l'inclure
// include('includes/navbar.php'); // <-- COMMENTEZ OU SUPPRIMEZ CETTE LIGNE
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
    </head>
<body>

    <nav class="navbar-vertical">
        <div class="navbar-header">
            <h1>EVENTSPORT</h1>
        </div>
        <ul class="navbar-menu">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="events.php">Événements</a></li>
            <li><a href="about.php">À propos</a></li>
            <li><a href="contact.php">Contact</a></li> <?php if (isset($_SESSION['user'])): ?>
                <li><a href="admin/index.php">Admin</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="main-content-wrapper">
        <main class="main-content">
            <section class="event-showcase"> <h2>Nous contacter</h2>

                <p>Pour toute demande concernant EventSport, n’hésitez pas à nous écrire via le formulaire ci-dessous.</p>

                <?php if (isset($_GET['sent']) && $_GET['sent'] === 'success'): ?>
                    <div class="message success">
                        Votre message a été envoyé avec succès !
                    </div>
                <?php elseif (isset($_GET['sent']) && $_GET['sent'] === 'error'): ?>
                    <div class="message error">
                        Une erreur s’est produite. Veuillez réessayer.
                    </div>
                <?php endif; ?>

                <form action="send-contact.php" method="POST" class="contact-form"> <label for="name">Nom :</label>
                    <input type="text" name="name" id="name" required>

                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" required>

                    <label for="subject">Sujet :</label>
                    <input type="text" name="subject" id="subject" required>

                    <label for="message">Message :</label>
                    <textarea name="message" id="message" required></textarea>

                    <button type="submit" class="btn">Envoyer</button> </form>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport. Tous droits réservés.</p>
            </div>
        </footer>
    </div> </body>
</html>