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
    <title>Afficher les utilisateurs</title>
</head>
<body>
    <!-- Affichage des utilisateurs -->
    <!-- Fin affichage des utilisateurs -->
</body>
</html>