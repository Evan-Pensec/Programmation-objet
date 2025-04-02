<?php
session_start();
include("liaison_bdd.php");
include("GestionVehicule.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: vehicule.php");
    exit;
}

$gestionVehicule = new GestionVehicule($pdo);

if (isset($_POST['action']) && $_POST['action'] == 'ajouter') {
    if (isset($_POST['modele']) && isset($_POST['marque']) && isset($_POST['immatriculation']) 
        && isset($_POST['type']) && isset($_POST['statut']) && isset($_POST['prix'])) {
        
        $modele = $_POST['modele'];
        $marque = $_POST['marque'];
        $immatriculation = $_POST['immatriculation'];
        $type = $_POST['type'];
        $statut = $_POST['statut'];
        $prix = $_POST['prix'];
        
        $gestionVehicule->ajouter($modele, $marque, $immatriculation, $type, $statut, $prix);
        
        header("Location: vehicule.php");
        exit;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'modifier') {
    if (isset($_POST['id']) && isset($_POST['modele']) && isset($_POST['marque']) && isset($_POST['immatriculation']) 
        && isset($_POST['type']) && isset($_POST['statut']) && isset($_POST['prix'])) {
        
        $id = $_POST['id'];
        $modele = $_POST['modele'];
        $marque = $_POST['marque'];
        $immatriculation = $_POST['immatriculation'];
        $type = $_POST['type'];
        $statut = $_POST['statut'];
        $prix = $_POST['prix'];
        
        $gestionVehicule->modifier($id, $modele, $marque, $immatriculation, $type, $statut, $prix);
        
        header("Location: vehicule.php");
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $gestionVehicule->supprimer($id);
    
    header("Location: vehicule.php");
    exit;
}

$vehicule = null;
if (isset($_GET['action']) && $_GET['action'] == 'modifier' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $vehicule = $gestionVehicule->getVehiculeById($id);
}

$vehicules = $gestionVehicule->getAllVehicules();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des véhicules</title>
    <link rel="stylesheet" href="testjs.css">
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Gestion des véhicules</h1>
    
    <?php if ($vehicule): ?>
        <h2>Modifier un véhicule</h2>
        <form action="gestion_vehicules.php" method="POST">
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id" value="<?php echo $vehicule['id']; ?>">
            
            <label for="modele">Modèle:</label>
            <input type="text" name="modele" value="<?php echo $vehicule['modele']; ?>" required>
            
            <label for="marque">Marque:</label>
            <input type="text" name="marque" value="<?php echo $vehicule['marque']; ?>" required>
            
            <label for="immatriculation">Immatriculation:</label>
            <input type="text" name="immatriculation" value="<?php echo $vehicule['immatriculation']; ?>" required>
            
            <label for="type">Type:</label>
            <input type="text" name="type" value="<?php echo $vehicule['type']; ?>" required>
            
            <label for="statut">Statut:</label>
            <select name="statut">
                <option value="1" <?php if ($vehicule['statut'] == 1) echo "selected"; ?>>Peut être loué</option>
                <option value="0" <?php if ($vehicule['statut'] == 0) echo "selected"; ?>>Ne peut pas être loué</option>
            </select>
            
            <label for="prix">Prix par jour:</label>
            <input type="number" name="prix" value="<?php echo $vehicule['prix']; ?>" required>
            
            <input type="submit" value="Modifier">
        </form>
        <p><a href="vehicule.php">Annuler la modification</a></p>
    <?php else: ?>
        <h2>Ajouter un véhicule</h2>
        <form action="gestion_vehicules.php" method="POST">
            <input type="hidden" name="action" value="ajouter">
            
            <label for="modele">Modèle:</label>
            <input type="text" name="modele" required>
            
            <label for="marque">Marque:</label>
            <input type="text" name="marque" required>
            
            <label for="immatriculation">Immatriculation:</label>
            <input type="text" name="immatriculation" required>
            
            <label for="type">Type:</label>
            <input type="text" name="type" required>
            
            <label for="statut">Statut:</label>
            <select name="statut">
                <option value="1">Peut être loué</option>
                <option value="0">Ne peut pas être loué</option>
            </select>
            
            <label for="prix">Prix par jour:</label>
            <input type="number" name="prix" required>
            
            <input type="submit" value="Ajouter">
        </form>
    <?php endif; ?>
    
    <h2>Liste des véhicules</h2>
    <table>
        <tr>
            <th>Modèle</th>
            <th>Marque</th>
            <th>Immatriculation</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Prix par jour</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($vehicules as $v): ?>
        <tr>
            <td><?php echo $v['modele']; ?></td>
            <td><?php echo $v['marque']; ?></td>
            <td><?php echo $v['immatriculation']; ?></td>
            <td><?php echo $v['type']; ?></td>
            <td><?php echo $v['statut'] == 1 ? 'Disponible' : 'Indisponible'; ?></td>
            <td><?php echo $v['prix']; ?></td>
            <td>
                <a href="gestion_vehicules.php?action=modifier&id=<?php echo $v['id']; ?>">Modifier</a> 
                <a href="gestion_vehicules.php?action=supprimer&id=<?php echo $v['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <p><a href="vehicule.php">Retour à la liste des véhicules</a></p>
</body>
</html>