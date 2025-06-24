<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>À propos - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>EventSport</h1>
            <nav>
                <a href="index.php">Accueil</a>
                <a href="contact.php">Contact</a>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="admin/index.php">Espace Admin</a>
                    <a href="logout.php">Se déconnecter</a>
                <?php else: ?>
                    <a href="login.php">Se connecter</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>À propos d'EventSport</h2>

        <p>Bienvenue sur <strong>EventSport</strong>, votre plateforme dédiée à la gestion et à la découverte d'événements sportifs locaux et nationaux.</p>

        <p>Notre objectif est simple : connecter les passionnés de sport avec les événements près de chez eux, que ce soit pour participer, s’organiser ou simplement suivre.</p>

        <section>
            <h3>Notre mission</h3>
            <p>Faciliter l’accès aux événements sportifs amateurs et professionnels, en offrant un outil intuitif pour créer, gérer et suivre les compétitions.</p>
        </section>

        <section>
            <h3>Nos valeurs</h3>
            <ul>
                <li>⚽ Passion du sport</li>
                <li>🌍 Accès local et global</li>
                <li>🛠️ Simplicité d’utilisation</li>
                <li>👥 Communauté active</li>
            </ul>
        </section>

        <section>
            <h3>Rejoignez-nous</h3>
            <p>Vous êtes organisateur ? Participant ? Venez partager votre amour du sport avec notre communauté !</p>
            <p><a href="contact.php" class="btn">Nous contacter</a></p>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 EventSport. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>