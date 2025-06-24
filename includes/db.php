<?php
$host = 'localhost';
$dbname = 'event_sport'; // Assure-toi que c’est le nom exact de ta base
$username = 'root';      // Généralement root sous Wamp
$password = '';          // Généralement vide sous Wamp

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>