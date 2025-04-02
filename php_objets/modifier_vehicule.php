<?php
require_once 'Database.php';
require_once 'Voiture.php';
require_once 'Session.php';

Session::start();

if (!Session::isAdmin()) {
    header("Location: vehicule.php");
    exit;
}

$vehicule = null;

if (isset($_GET['id'])) {
    $vehicule = Voiture::getVoitureById($_GET['id']);
    if (!$vehicule) {
        header("Location: vehicule.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['modele']) && 
    isset($_POST['marque']) && isset($_POST['immatriculation']) && 
    isset($_POST['type']) && isset($_POST['statut']) && isset($_POST['prix_jour'])) {
    
    $voiture = new Voiture(
        $_POST['id'], 
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un véhicule</title>
    <link rel="stylesheet" href="testjs.css">
</head>
<body>
    <p>Modifier</p>
    
    <?php if ($vehicule): ?>
        <form action="modifier_vehicule.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $vehicule->id; ?>">
            
            <label for="modele">Modèle:</label>
            <input type="text" name="modele" value="<?php echo $vehicule->modele; ?>" required>
            
            <label for="marque">Marque:</label>
            <input type="text" name="marque" value="<?php echo $vehicule->marque; ?>" required>
            
            <label for="immatriculation">Immatriculation:</label>
            <input type="text" name="immatriculation" value="<?php echo $vehicule->immatriculation; ?>" required>
            
            <label for="type">Type:</label>
            <input type="text" name="type" value="<?php echo $vehicule->type; ?>" required>
            
            <label for="statut">Statut:</label>
            <select name="statut">
                <option value="1" <?php if ($vehicule->statut == 1) echo "selected"; ?>>Peut être loué</option>
                <option value="0" <?php if ($vehicule->statut == 0) echo "selected"; ?>>Ne peut pas être loué</option>
            </select>
            
            <label for="prix_jour">Prix par jour:</label>
            <input type="number" name="prix_jour" value="<?php echo $vehicule->prix; ?>" required>
            
            <input type="submit" value="Modifier">
        </form>
        
        <p><a href="vehicule.php">Retour à la liste</a></p>
    <?php else: ?>
        <p>Véhicule non trouvé. <a href="vehicule.php">Retour à la liste</a></p>
    <?php endif; ?>
</body>
</html>