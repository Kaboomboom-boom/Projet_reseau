<?php

    require "config.php";

    $idUser = 1;

    $genreQuery = $pdo->prepare("
        SELECT c.genre, COUNT(*) nb
        FROM playlist_chanson pc
            JOIN chanson c 
                ON pc.id_chanson = c.id
            JOIN playlist p
                ON pc.id_playlist = p.id
        WHERE p.id_utilisateur = ?
        GROUP BY c.genre
        ORDER BT nb DESC
        LIMIT 1
    ");

    $genreQuery->execute([$idUser]);
    $genreFav = $genreQuery->fetchColumn();

    $artisteQuery = $pdo->prepare("
        SELECT *
        FROM artiste
        WHERE id IN (
            SELECT id_artiste
            FROM chanson
            WHERE genre = ?
        )
        LIMIT 6
    ");

    $artisteQuery->execute([$genreFav]);
    $artistesRecommande = $artisteQuery->fetchAll();


    $albumQuery = $pdo->prepare("
        SELECT *
        FROM album
        WHERE genre = ?
        LIMIT 6
    ");

    $albumQuery->execute([$genreFav]);
    $albumsRecommande = $albumQuery->fetchAll();

?>