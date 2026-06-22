<?php

$host = "localhost";
$user = "root";
$password = "lannion";

try{


    $pdo = new PDO("mysql:host=$host;charset=utf8",
                    $user,
                    $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Création de la base de données

    $pdo->exec("
        CREATE DATABASE IF NOT EXISTS boo_data
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci  
    ");

    echo "La base est créée !!!";

    //Set le schema à boo_data pour créer les tables dedans
    $pdo->exec("USE boo_data");



    //Création de la table utilisateur
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS utilisateur (

            id INT AUTO_INCREMENT,
            pseudo VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            motDePasse VARCHAR(255) NOT NULL,
            compteVerifie TINYINT DEFAULT 0,
            dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
            token VARCHAR(255),
            
            CONSTRAINT utilisateur_pk PRIMARY KEY (id)
        )
    ");

    //Table artiste

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS artiste(
        
            id INT AUTO_INCREMENT,
            nomScene VARCHAR(100) NOT NULL,
            photo VARCHAR(255) DEFAULT '/',
            
            CONSTRAINT artiste_pk PRIMARY KEY (id)
        )
    ");


    //Table album
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS album(
            id INT AUTO_INCREMENT,
            nom VARCHAR(100) NOT NULL,
            pochette VARCHAR(255) DEFAULT '/',
            genre VARCHAR(50) NOT NULL,
            id_artiste INT,

            CONSTRAINT album_pk PRIMARY KEY (id),
            CONSTRAINT album_fk_artiste
                FOREIGN KEY (id_artiste)
                    REFERENCES artiste(id)
        )
    ");

    //Table chanson
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS chanson(
            id INT AUTO_INCREMENT,
            titre VARCHAR(100) NOT NULL,
            duree TIME NOT NULL,
            genre VARCHAR(50) NOT NULL,
            id_album INT,
            id_artiste INT,

            CONSTRAINT chanson_pk PRIMARY KEY (id),
            CONSTRAINT chanson_fk_album 
                FOREIGN KEY (id_album)
                    REFERENCES album(id),
            CONSTRAINT chanson_fk_artiste 
                FOREIGN KEY (id_artiste)
                    REFERENCES artiste(id)
        )
    ");


    //Playlist favoris
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS playlist(
            id INT AUTO_INCREMENT,
            nom VARCHAR(100) DEFAULT 'Favoris',
            pochette VARCHAR(255),
            dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP,
            id_utilisateur INT,

            CONSTRAINT playlist_pk PRIMARY KEY (id),
            CONSTRAINT playlist_fk_utilisateur
                FOREIGN KEY (id_utilisateur)
                    REFERENCES utilisateur(id)
        )
    ");

    //Association playlist - chanson
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS playlist_chanson(
            id_playlist INT,
            id_chanson INT,

            CONSTRAINT playlist_chanson_pk 
                PRIMARY KEY (id_playlist, id_chanson),
            CONSTRAINT playlist_chanson_fk_playlist
                FOREIGN KEY (id_playlist)
                    REFERENCES playlist(id),
            CONSTRAINT playlist_chanson_fk_chanson
                FOREIGN KEY (id_chanson)
                    REFERENCES chanson(id)
        )
    ");

    echo "Tous va bien !!!!";

}catch(PDOException $e){
    die("Erreur : " . $e->getMessage());
}


?>
