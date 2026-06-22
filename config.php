<?php
    $host = "localhost";
    $dbname = "boo_data";
    $user = "root";
    $password = "lannion";

    try{
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        die("Erreur de connexion : " . $e->getMessage());
    }
?>
