<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - EventSport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>EventSport</h1>
            <nav>
                <a href="index.php">Accueil</a>
                <a href="about.php">À propos</a>
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
        <h2>Nous contacter</h2>

        <p>Pour toute demande concernant EventSport, n’hésitez pas à nous écrire via le formulaire ci-dessous.</p>

        <!-- Message de confirmation -->
        <?php if (isset($_GET['sent']) && $_GET['sent'] === 'success'): ?>
            <div class="message success">
                Votre message a été envoyé avec succès !
            </div>
        <?php elseif (isset($_GET['sent']) && $_GET['sent'] === 'error'): ?>
            <div class="message error">
                Une erreur s’est produite. Veuillez réessayer.
            </div>
        <?php endif; ?>

        <form action="send-contact.php" method="POST">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="subject">Sujet :</label>
            <input type="text" name="subject" id="subject" required>

            <label for="message">Message :</label>
            <textarea name="message" id="message" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 EventSport. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>