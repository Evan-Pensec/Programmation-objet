<?php
include("liaison_bdd.php");
session_start();

if ($_SESSION['admin'] != 1) {
    header("Location: vehicule.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM vehicule WHERE id = " . $id;
    $pdo->exec($sql);
    
    header("Location: vehicule.php");
}
?>