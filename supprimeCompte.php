<?php
    session_start();

    if(!isset($_SESSION['user_id'])){
        header("Locattion : connexion.php");
    }



    $userId = $_SESSION['user_id'];

    $pdo->prepare("DELETE FROM playlist WHERE id_playlist IN (
        SELECT id FROM playlist WHERE id_utilisateur = ?)
    ")->execute([$userId]);

    $pdo->prepare("DELETE FROM playlist WHERE id_utilisateur = ?"
    )->execute([$userId]);

    $pdo->prepare("DELETE FROM utilisateur WHERE id = ?"
    )->execute([$userId]);

    session_destroy();

    header("Location : index.html");
    exit;
?>