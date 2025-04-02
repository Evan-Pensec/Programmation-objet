<?php
session_start();
include("liaison_bdd.php");


if ($_SESSION['admin'] != 1) {
    header("Location: vehicule.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM vehicule WHERE id = " . $id;
    $resultat = $pdo->query($sql);
    $vehicule = $resultat->fetch();
}

if (isset($_POST['modele']) && isset($_POST['marque']) && isset($_POST['immatriculation']) && isset($_POST['type']) && isset($_POST['statut']) && isset($_POST['prix_jour'])) {
    $id = $_POST['id'];
    $modele = $_POST['modele'];
    $marque = $_POST['marque'];
    $immatriculation = $_POST['immatriculation'];
    $type = $_POST['type'];
    $statut = $_POST['statut'];
    $prix = $_POST['prix_jour'];
    
    $sql = "UPDATE vehicule SET modele = '$modele', marque = '$marque', immatriculation = '$immatriculation', type = '$type', statut = '$statut', prix_jour = '$prix' WHERE id = " . $id;
    $pdo->exec($sql);
    
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
    
    <?php if (isset($vehicule)) ?>
        <form action="modifier_vehicule.php" method="POST">
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
        
        <p><a href="vehicule.php">Retour à la liste</a></p>
    
</body>
</html>