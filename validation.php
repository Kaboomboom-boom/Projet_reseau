<?php

    require "config.php";

    $token = $_GET['token'] ?? null;

    if(!$token){
        die("Oh oh, token invalide !!!");
    }

    $requete = $pdo->prepare("
        SELECT id
        FROM utilisateur
        WHERE token = ? AND compteVerifie = 0
    ");

    $requete->execute([$token]);

    $user = $requete->fetch();

    if($user){

        $update = $pdo->prepare("
            UPDATE utilisateur
            SET compteVerifie = 1,
                token = NULL
            WHERE id = ?
        ");

        $update->execute([$user['id']]);

        echo"
        <h1>Compte activé (◕ᴗ◕✿)</h1>
        <a href='connexion.html'>Se connecter</a>
        ";
    }else{
        echo"
        <h1>X LIEN INVALIDE X</h1> 
        ";
    }

?>