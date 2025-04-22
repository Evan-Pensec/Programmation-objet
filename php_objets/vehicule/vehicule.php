<?php

include("../bdd/liaison_bdd.php");
session_start();

if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = 0;
}

$sql = "SELECT * FROM vehicule";
$resultat = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des véhicules</title>
    <link rel="stylesheet" href="../styles/vehicule.css">
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1>Location de voiture</h1>
    </div>

    <p>Chercher un véhicule :</p>

    <main>
	<form action="searchdb.php" method="post">
		<button type="submit" name="submit">Effectuer une recherche</button>
	</form>
</main>

    <p>Liste des véhicules :</p>
    
    <table>
        <tr>
            <th>Modele</th>
            <th>Marque</th>
            <th>Immatriculation</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Prix par jour</th>
            <?php if ($_SESSION['admin'] == 1): ?>
                <th>Actions</th>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <th>Locations</th>
            <?php endif; ?>
        </tr>
        <?php
        while ($row = $resultat->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['modele'] . "</td>";
            echo "<td>" . $row['marque'] . "</td>";
            echo "<td>" . $row['immatriculation'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['statut'] . "</td>";
            echo "<td>" . $row['prix'] . "</td>";
            
            if ($_SESSION['admin'] == 1) {
                echo "<td>";
                echo "<a href='gestion_vehicules.php?action=modifier&id=" . $row['id'] . "'>Modifier</a> ";
                echo "<a href='gestion_vehicules.php?action=supprimer&id=" . $row['id'] . "'>Supprimer</a>";
                echo "</td>";
            }
            
            echo "<td>";
            if ($row['statut'] == 1) {
                echo "<a href='louer_vehicule.php?id=" . $row['id'] . "' class='btn-louer'>Louer</a>";
            } else {
                echo "Non disponible";
            }
            echo "</td>";
            
            echo "</tr>";
        }
        ?>
    </table>

    <?php if ($_SESSION['admin'] == 1): ?>
        <p>Ajouter :</p>
        <form action="gestion_vehicules.php" method="POST">
        <input type="hidden" name="action" value="ajouter">
            <input type="text" name="modele" placeholder="Modèle" required>
            <input type="text" name="marque" placeholder="Marque" required>
            <input type="text" name="immatriculation" placeholder="Immatriculation" required>
            <input type="text" name="type" placeholder="Type" required>
            <select name="statut">
                <option value="1">Peut être loué</option>
                <option value="0">Ne peut pas être loué</option>
            </select>
            <input type="number" name="prix" placeholder="Prix par jour" required>
            <input type="submit" value="Ajouter">
        </form>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['user'])): ?>
        <p><a href="../connexion/deconnexion.php">Déconnexion</a></p>
    <?php else: ?>
        <p><a href="../connexion/authentification.php">Connexion</a></p>
    <?php endif; ?>
</body>
</html>