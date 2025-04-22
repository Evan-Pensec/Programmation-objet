<?php
session_start();
include("../bdd/liaison_bdd.php");
include("../class/GestionVehicule.php");

$gestionVehicule = new GestionVehicule($pdo);

if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = 0;
}

$vehicules = $gestionVehicule->getAllVehicules();

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
            border-collapse: collapse;
            padding: 8px;
        }
        
    </style>
</head>

<body>
    <div id="header">
        <h1>Location de voiture</h1>
    </div>


    <p>Chercher un véhicule :</p>

    <main>
        <form action="searchdb.php" method="get">
            <input type="text" name="recherche" placeholder="Rechercher...">
            <select name="critere">
                <option value="tous">Tous les critères</option>
                <option value="modele">Modèle</option>
                <option value="marque">Marque</option>
                <option value="immatriculation">Immatriculation</option>
                <option value="prix">Prix</option>
            </select>
            <button type="submit">Rechercher</button>
        </form>
    </main>

    <p>Liste des véhicules :</p>
    
    <table>
        <tr>
            <th>Modèle</th>
            <th>Marque</th>
            <th>Immatriculation</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Prix par jour</th>
            <?php if ($_SESSION['admin'] == 1): ?>
                <th>Actions</th>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <th>Location</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($vehicules as $v): ?>
        <tr>
            <td><?php echo $v['modele']; ?></td>
            <td><?php echo $v['marque']; ?></td>
            <td><?php echo $v['immatriculation']; ?></td>
            <td><?php echo $v['type']; ?></td>
            <td><?php echo $v['statut'] == 1 ? 'Disponible' : 'Indisponible'; ?></td>
            <td><?php echo $v['prix']; ?> €</td>
            
            <?php if ($_SESSION['admin'] == 1): ?>
            <td class="actions">
                <a href="form_vehicule.php?id=<?php echo $v['id']; ?>" class="btn-modifier">Modifier</a>
                <a href="vehicule_action.php?action=supprimer&id=<?php echo $v['id']; ?>" class="btn-supprimer" 
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">Supprimer</a>
            </td>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user'])): ?>
            <td>
                <?php if ($v['statut'] == 1): ?>
                    <a href="louer_vehicule.php?id=<?php echo $v['id']; ?>" class="btn-louer">Louer</a>
                <?php else: ?>
                    Non disponible
                <?php endif; ?>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($_SESSION['admin'] == 1): ?>
        <p><a href="form_vehicule.php" class="btn-ajouter">Ajouter un véhicule</a></p>
    <?php endif; ?>
    
    <div class="navigation">
        <?php if (isset($_SESSION['user'])): ?>
            <p><a href="../connexion/deconnexion.php">Déconnexion</a></p>
        <?php else: ?>
            <p><a href="../connexion/authentification.php">Connexion</a></p>
        <?php endif; ?>
    </div>
</body>
</html>