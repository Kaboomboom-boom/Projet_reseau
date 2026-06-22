<?php

    $token = $_GET['token'] ?? null;

?>

<?php
    require "recommandations.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Boo - Valide ton compte</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="main-form">
            <section class="form">
                <h1>Compte créé !!</h1>
                <p>Ton compte a été créé avec succes !</p>
                 <a class="bn1" href="validation.php?token=<?=  htmlspecialchars($token) ?>">
                    Activer mon compte
                 </a>
            </section>
        </main>
    </body>
</html>