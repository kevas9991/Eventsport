<?php
session_start(); // Démarre la session PHP (même si pas directement utilisée ici, c'est une bonne pratique si vous avez des liens conditionnels)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - EventSport</title>
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
            <li><a href="about.php">À propos</a></li> <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user'])): ?>
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
            <section class="event-showcase"> <h2>À propos d'EventSport</h2>

                <p>Bienvenue sur <strong>EventSport</strong>, votre plateforme dédiée à la gestion et à la découverte d'événements sportifs locaux et nationaux.</p>

                <p>Notre objectif est simple : connecter les passionnés de sport avec les événements près de chez eux, que ce soit pour participer, s’organiser ou simplement suivre.</p>

                <section class="about-subsection"> <h3>Notre mission</h3>
                    <p>Faciliter l’accès aux événements sportifs amateurs et professionnels, en offrant un outil intuitif pour créer, gérer et suivre les compétitions.</p>
                </section>

                <section class="about-subsection"> <h3>Nos valeurs</h3>
                    <ul class="values-list"> <li>⚽ Passion du sport</li>
                        <li>🌍 Accès local et global</li>
                        <li>🛠️ Simplicité d’utilisation</li>
                        <li>👥 Communauté active</li>
                    </ul>
                </section>

                <section class="about-subsection"> <h3>Rejoignez-nous</h3>
                    <p>Vous êtes organisateur ? Participant ? Venez partager votre amour du sport avec notre communauté !</p>
                    <p><a href="contact.php" class="btn">Nous contacter</a></p>
                </section>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?= date('Y') ?> EventSport. Tous droits réservés.</p>
            </div>
        </footer>
    </div> </body>
</html>