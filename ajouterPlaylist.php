<?php
    session_start();
    require "config.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: connexion.html");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_chanson'])){
        header("Location: titre.html?playlist=erreur");
        exit();
    }

    $idChanson = (int) $_POST['id_chanson'];
    $idUtilisateur = (int) $_SESSION['user_id'];

    $chansonRequete = $pdo->prepare("
        SELECT id
        FROM chanson
        WHERE id = ?
    ");
    $chansonRequete->execute([$idChanson]);

    if(!$chansonRequete->fetch()){
        header("Location: titre.html?playlist=erreur");
        exit();
    }

    $playlistRequete = $pdo->prepare("
        SELECT id
        FROM playlist
        WHERE id_utilisateur = ?
        ORDER BY dateCreation
        LIMIT 1
    ");
    $playlistRequete->execute([$idUtilisateur]);
    $playlist = $playlistRequete->fetch();

    if(!$playlist){
        $creationPlaylist = $pdo->prepare("
            INSERT INTO playlist(nom, id_utilisateur)
            VALUES('Favoris', ?)
        ");
        $creationPlaylist->execute([$idUtilisateur]);
        $idPlaylist = (int) $pdo->lastInsertId();
    }else{
        $idPlaylist = (int) $playlist['id'];
    }

    $dejaPresent = $pdo->prepare("
        SELECT 1
        FROM playlist_chanson
        WHERE id_playlist = ? AND id_chanson = ?
    ");
    $dejaPresent->execute([$idPlaylist, $idChanson]);

    if($dejaPresent->fetch()){
        header("Location: titre.html?playlist=deja");
        exit();
    }

    $ajout = $pdo->prepare("
        INSERT INTO playlist_chanson(id_playlist, id_chanson)
        VALUES(?, ?)
    ");
    $ajout->execute([$idPlaylist, $idChanson]);

    header("Location: titre.html?playlist=ajoute");
    exit();
?>
