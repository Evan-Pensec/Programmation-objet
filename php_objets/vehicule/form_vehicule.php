<?php
session_start();
include("../bdd/liaison_bdd.php");
include("../class/GestionVehicule.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: vehicule.php");
    exit;
}

$gestionVehicule = new GestionVehicule($pdo);
$vehicule = null;
$action = "ajouter";
$titre = "Ajouter un véhicule";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $vehicule = $gestionVehicule->getVehiculeById($id);
    
    if ($vehicule) {
        $action = "modifier";
        $titre = "Modifier un véhicule";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titre; ?></title>
    <link rel="stylesheet" href="../styles/vehicule.css">
</head>
<body>
    <div id="header">
        <h1>Location de voiture</h1>
    </div>
    
    <h2><?php echo $titre; ?></h2>
    
    <form action="vehicule_action.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        
        <?php if ($action == "modifier"): ?>
            <input type="hidden" name="id" value="<?php echo $vehicule['id']; ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="modele">Modèle:</label>
            <input type="text" id="modele" name="modele" value="<?php echo $vehicule ? $vehicule['modele'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="marque">Marque:</label>
            <input type="text" id="marque" name="marque" value="<?php echo $vehicule ? $vehicule['marque'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="immatriculation">Immatriculation:</label>
            <input type="text" id="immatriculation" name="immatriculation" value="<?php echo $vehicule ? $vehicule['immatriculation'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" value="<?php echo $vehicule ? $vehicule['type'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="statut">Statut:</label>
            <select id="statut" name="statut">
                <option value="1" <?php echo ($vehicule && $vehicule['statut'] == 1) ? 'selected' : ''; ?>>Peut être loué</option>
                <option value="0" <?php echo ($vehicule && $vehicule['statut'] == 0) ? 'selected' : ''; ?>>Ne peut pas être loué</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="prix">Prix par jour:</label>
            <input type="number" id="prix" name="prix" value="<?php echo $vehicule ? $vehicule['prix'] : ''; ?>" required>
        </div>
        
        <div class="form-buttons">
            <button type="submit" class="btn-submit"><?php echo $action == "ajouter" ? "Ajouter" : "Modifier"; ?></button>
            <a href="vehicule.php" class="btn-cancel">Annuler</a>
        </div>
    </form>
</body>
</html>