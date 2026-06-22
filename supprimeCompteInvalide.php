<?php

    require "config.php";

    $requete = $pdo->prepare("
        DELETE FROM utilisateur
        WHERE compteVerifie = 0
    ");

    $requete->execute();

    echo "Tous les comptes invalides ont été supprimés !";

?>