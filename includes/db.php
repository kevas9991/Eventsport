<?php
$host = 'localhost'; // Adresse du serveur de base de données (localhost pour WAMP)
$dbname = 'event_sport'; // Nom de la base de données (à adapter si différent)
$username = 'root'; // Nom d'utilisateur pour accéder à MySQL (par défaut root sur WAMP)
$password = ''; // Mot de passe pour MySQL (souvent vide sur WAMP)

// Bloc try/catch pour capturer les erreurs de connexion à la base de données
try {
    // Création d'une instance PDO pour la connexion à MySQL avec encodage UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configuration pour que les erreurs PDO soient levées sous forme d'exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message et arrêter l'exécution
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
