<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Session.php';

Session::start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user']) && isset($_POST['password'])) {
    $username = $_POST['user'];
    $password = $_POST['password'];

    $user = User::authenticate($username, $password);
    
    if ($user) {
        Session::set('user', $username);
        Session::set('admin', $user->admin);
        header("Location: vehicule.php");
        exit;
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
    
    <p><a href="vehicule.php">Voir les véhicules</a></p>
    
    <script src="testjs.js"></script>
</body>
</html>