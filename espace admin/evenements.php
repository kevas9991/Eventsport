<?php 
session_start();
if(!$_SESSION['mdp']){
    header('location:Accueil.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Page de publication article</h1>
</body>
</html>