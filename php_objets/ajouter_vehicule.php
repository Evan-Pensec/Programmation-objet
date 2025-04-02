<?php
require_once 'Database.php';
require_once 'Voiture.php';
require_once 'Session.php';

Session::start();

if (!Session::isAdmin()) {
    header("Location: vehicule.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modele']) && isset($_POST['marque']) && 
    isset($_POST['immatriculation']) && isset($_POST['type']) && 
    isset($_POST['statut']) && isset($_POST['prix_jour'])) {
    
    $voiture = new Voiture(
        null, 
        $_POST['modele'], 
        $_POST['marque'], 
        $_POST['immatriculation'], 
        $_POST['type'], 
        $_POST['statut'], 
        $_POST['prix_jour']
    );
    
    $voiture->save();
    
    header("Location: vehicule.php");
    exit;
}

header("Location: vehicule.php");