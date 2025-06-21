<?php
session_start();
if(!$_SESSION['mdp']){
    header('Location: connexion.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <a href="./utilisateur.php">Afficher tous les utilisateurs</a>
    <h1>Page principale de notre site web</h1>
    <h2>Titre 2</h2>
</body>
</html>