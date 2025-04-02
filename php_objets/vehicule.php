<?php
require_once 'Database.php';
require_once 'Voiture.php';
require_once 'Session.php';

Session::start();

if (!Session::get('admin')) {
    Session::set('admin', 0);
}

$vehicules = Voiture::getAllVoiture();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des véhicules</title>
    <link rel="stylesheet" href="testjs.css">
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <p>Liste des véhicules</p>
    
    <table>
        <tr>
            <th>Modele</th>
            <th>Marque</th>
            <th>Immatriculation</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Prix par jour</th>
            <?php if (Session::isAdmin()): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php
        foreach($vehicules as $vehicule) {
            echo "<tr>
                <td>" . $vehicule->modele . "</td>
                <td>" . $vehicule->marque . "</td>
                <td>" . $vehicule->immatriculation . "</td>
                <td>" . $vehicule->type . "</td>
                <td>" . $vehicule->statut . "</td>
                <td>" . $vehicule->prix . "</td>";
            
            if (Session::isAdmin()) {
                echo "<td>
                    <a href='modifier_vehicule.php?id=" . $vehicule->id . "'>Modifier</a> 
                    <a href='supprimer_vehicule.php?id=" . $vehicule->id . "'>Supprimer</a>
                </td>";
            }
            echo "</tr>";
        }
        ?>
    </table>

    <?php if (Session::isAdmin()): ?>
        <p>Ajouter</p>
        <form action="ajouter_vehicule.php" method="POST">
            <input type="text" name="modele" placeholder="Modèle" required>
            <input type="text" name="marque" placeholder="Marque" required>
            <input type="text" name="immatriculation" placeholder="Immatriculation" required>
            <input type="text" name="type" placeholder="Type" required>
            <select name="statut">
                <option value="1">Peut être loué</option>
                <option value="0">Ne peut pas être loué</option>
            </select>
            <input type="number" name="prix_jour" placeholder="Prix par jour" required>
            <input type="submit" value="Ajouter">
        </form>
    <?php endif; ?>
    
    <?php if (Session::get('user')): ?>
        <p><a href="deconnexion.php">Déconnexion</a></p>
    <?php else: ?>
        <p><a href="authentification.php">Connexion</a></p>
    <?php endif; ?>
</body>
</html>