<?php
session_start(); // Démarre la session pour accéder aux données de session

session_destroy(); // Détruit toutes les données associées à la session en cours (déconnexion)

header('Location: login.php'); // Redirige l'utilisateur vers la page de connexion
exit; // Termine le script après la redirection
?>
