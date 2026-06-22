<?php
    session_start();
    require "config.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: connexion.html");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_album'])){
        header("Location: album.html?playlist=erreur");
        exit();
    }

    $idAlbum = (int) $_POST['id_album'];
    $idUtilisateur = (int) $_SESSION['user_id'];

    $albumRequete = $pdo->prepare("
        SELECT id
        FROM album
        WHERE id = ?
    ");
    $albumRequete->execute([$idAlbum]);

    if(!$albumRequete->fetch()){
        header("Location: album.html?playlist=erreur");
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

    $titresRequete = $pdo->prepare("
        SELECT id
        FROM chanson
        WHERE id_album = ?
    ");
    $titresRequete->execute([$idAlbum]);
    $titres = $titresRequete->fetchAll();

    if(count($titres) === 0){
        header("Location: album.html?playlist=vide");
        exit();
    }

    $ajout = $pdo->prepare("
        INSERT IGNORE INTO playlist_chanson(id_playlist, id_chanson)
        VALUES(?, ?)
    ");

    $nombreAjoutes = 0;

    foreach($titres as $titre){
        $ajout->execute([$idPlaylist, $titre['id']]);
        $nombreAjoutes += $ajout->rowCount();
    }

    if($nombreAjoutes === 0){
        header("Location: album.html?playlist=deja");
        exit();
    }

    header("Location: album.html?playlist=ajoute");
    exit();
?>
