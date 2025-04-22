<?php
session_start();
include("../bdd/liaison_bdd.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../connexion/authentification.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: vehicule.php");
    exit;
}

$id_vehicule = $_GET['id'];

$sql = "SELECT * FROM vehicule WHERE id = ? AND statut = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_vehicule]);
$vehicule = $stmt->fetch();

if (!$vehicule) {
    header("Location: vehicule.php");
    exit;
}

if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $username = $_SESSION['user'];
    
    $sql = "INSERT INTO locations (id_vehicule, username, date_debut, date_fin, prix_total) 
            VALUES (?, ?, ?, ?, ?)";
    
    $date1 = new DateTime($date_debut);
    $date2 = new DateTime($date_fin);
    $interval = $date1->diff($date2);
    $nombre_jours = $interval->days + 1;
    $prix_total = $nombre_jours * $vehicule['prix'];
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_vehicule, $username, $date_debut, $date_fin, $prix_total]);
    
    $sql = "UPDATE vehicule SET statut = 0 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_vehicule]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Louer un véhicule</title>
    <link rel="stylesheet" href="../styles/vehicule.css">
</head>
<body>
    <div id="header">
        <h1>Location de voiture</h1>
    </div>
    
    <h2>Louer ce véhicule</h2>
    
    <div class="vehicle-details">
        <p>Modèle: <?php echo $vehicule['modele']; ?></p>
        <p>Marque: <?php echo $vehicule['marque']; ?></p>
        <p>Immatriculation: <?php echo $vehicule['immatriculation']; ?></p>
        <p>Type: <?php echo $vehicule['type']; ?></p>
        <p>Prix par jour: <?php echo $vehicule['prix']; ?> €</p>
    </div>
    
    <form action="louer_vehicule.php?id=<?php echo $id_vehicule; ?>" method="POST">
        <div class="form-group">
            <label for="date_debut">Date de début:</label>
            <input type="date" id="date_debut" name="date_debut" required 
                min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="date_fin">Date de fin:</label>
            <input type="date" id="date_fin" name="date_fin" required 
                min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        </div>
        
        <button type="submit" class="btn-submit">Confirmer la location</button>
    </form>
    
    <p><a href="vehicule.php">Retour à la liste des véhicules</a></p>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateDébut = document.getElementById('date_debut');
            const dateFin = document.getElementById('date_fin');
            const prixJour = <?php echo $vehicule['prix']; ?>;
            
            function calculerPrix() {
                if (dateDébut.value && dateFin.value) {
                    const debut = new Date(dateDébut.value);
                    const fin = new Date(dateFin.value);
                    
                    if (fin >= debut) {
                        const diffTemps = fin.getTime() - debut.getTime();
                        const diffJours = Math.ceil(diffTemps / (1000 * 3600 * 24)) + 1;
                        const prixTotal = diffJours * prixJour;
                        
                        document.querySelector('.vehicle-details').innerHTML += 
                            `<p id="prix-total">Prix total estimé: ${prixTotal} € (${diffJours} jours)</p>`;
                    }
                }
            }
            
            dateDébut.addEventListener('change', calculerPrix);
            dateFin.addEventListener('change', calculerPrix);
        });
    </script>
</body>
</html>