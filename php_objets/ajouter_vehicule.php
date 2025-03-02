<?php
include("liaison_bdd.php");
session_start();

if ($_SESSION['admin'] != 1) {
    header("Location: vehicule.php");
    exit;
}

if (isset($_POST['modele']) && isset($_POST['marque']) && isset($_POST['immatriculation']) && isset($_POST['type']) && isset($_POST['statut']) && isset($_POST['prix_jour'])) {
    
    $modele = $_POST['modele'];
    $marque = $_POST['marque'];
    $immatriculation = $_POST['immatriculation'];
    $type = $_POST['type'];
    $statut = $_POST['statut'];
    $prix = $_POST['prix_jour'];
    
    $sql = "INSERT INTO vehicule (modele, marque, immatriculation, type, statut, prix_jour) VALUES ('$modele', '$marque', '$immatriculation', '$type', '$statut', '$prix')";
    $pdo->exec($sql);
    
    header("Location: vehicule.php");
}
?>