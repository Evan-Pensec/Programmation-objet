<?php
require_once 'Database.php';
require_once 'Voiture.php';
require_once 'Session.php';

Session::start();

if (!Session::isAdmin()) {
    header("Location: vehicule.php");
    exit;
}

if (isset($_GET['id'])) {
    $vehicule = Voiture::getVoitureById($_GET['id']);
    if ($vehicule) {
        $vehicule->delete();
    }
}

header("Location: vehicule.php");