<?php
session_start();
if(isset($_POST['valider'])){
    if(!empty($_POST['pseudo']) and !empty($_POST['mdp'])){
      
        if($psuedo_saisi == $psuedo_par_defaut and $mdp_saisi == $mdp_par_defaut){
            $_SESSION['mdp'] = $mdp_saisi;
            header('Location:index.php');

        }else{
            echo "Votre pseudo ou mot de passe est incorrect";
        }

    }else{
        echo "Veuillez remplir tous les champs";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    
</head>
<body>
    <form method="POST" action="" align="center">

        <input type="text" name="pseudo" autocomplete="off">
        <br>
        <input type="password" name="mdp">
        <br><br>
        <input type="submit" class="valider">

    </form>

</body>
</html>