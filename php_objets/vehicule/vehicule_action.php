<?php
session_start();
include("../bdd/liaison_bdd.php");
include("../class/Controller.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: vehicule.php");
    exit;
}

$controller = new Controller($pdo);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'ajouter' && isset($_POST['modele']) && isset($_POST['marque']) 
        && isset($_POST['immatriculation']) && isset($_POST['type']) 
        && isset($_POST['statut']) && isset($_POST['prix'])) {
        
        $modele = $_POST['modele'];
        $marque = $_POST['marque'];
        $immatriculation = $_POST['immatriculation'];
        $type = $_POST['type'];
        $statut = $_POST['statut'];
        $prix = $_POST['prix'];
        
        $controller->ajouterVehicule($modele, $marque, $immatriculation, $type, $statut, $prix);
        
        header("Location: vehicule.php");
        exit;
    }
    
    if ($_POST['action'] == 'modifier' && isset($_POST['id']) && isset($_POST['modele']) 
        && isset($_POST['marque']) && isset($_POST['immatriculation']) 
        && isset($_POST['type']) && isset($_POST['statut']) && isset($_POST['prix'])) {
        
        $id = $_POST['id'];
        $modele = $_POST['modele'];
        $marque = $_POST['marque'];
        $immatriculation = $_POST['immatriculation'];
        $type = $_POST['type'];
        $statut = $_POST['statut'];
        $prix = $_POST['prix'];
        
        $controller->modifierVehicule($id, $modele, $marque, $immatriculation, $type, $statut, $prix);
        
        header("Location: vehicule.php");
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $controller->supprimerVehicule($id);
    
    header("Location: vehicule.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'louer' && isset($_GET['id']) 
    && isset($_SESSION['user']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
    
    $id_vehicule = $_GET['id'];
    $username = $_SESSION['user'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    
    $resultat = $controller->louerVehicule($id_vehicule, $username, $date_debut, $date_fin);
    
    if ($resultat) {
        header("Location: vehicule.php");
    } else {
        header("Location: vehicule.php");
    }
    exit;
}

header("Location: vehicule.php");
exit;
?>