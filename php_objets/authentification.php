<?php

    include("liaison_bdd.php");
?>
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Option</title>
        <meta name="description" content="">
        <link rel="stylesheet" href="testjs.css">
    </head>
    <body>
        <form action="vehicule.php" method="GET">
            <input type="text" name="user" placeholder="Nom d'utilisateur">
            <input type="text" name="password" placeholder="Mot de passe">
            <button type="submit">Se connecter</button>
        </form>
        <script src="testjs.js"></script>
    </body>
    </html>