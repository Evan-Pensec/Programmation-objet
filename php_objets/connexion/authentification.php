<?php

session_start();
include("../bdd/liaison_bdd.php");

if (isset($_POST['user']) && isset($_POST['password'])) {
    $username = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE user = '$username' AND password = '$password'";
    $resultat = $pdo->query($sql);
    $utilisateur = $resultat->fetch();
    
    if ($utilisateur) {
        $_SESSION['user'] = $username;
        $_SESSION['admin'] = $utilisateur['admin'];
        header("Location: ../vehicule/index.php");
    exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="testjs.css">
</head>
<body>
    <p>Connexion</p>

    
    <form action="authentification.php" method="POST">
        <input type="text" name="user" placeholder="Nom d'utilisateur">
        <input type="password" name="password" placeholder="Mot de passe">
        <button type="submit">Se connecter</button>
    </form>
    
    <p><a href="../vehicule/index.php">Voir les véhicules</a></p>
    
    <script src="testjs.js"></script>
</body>
</html>