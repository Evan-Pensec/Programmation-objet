<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locations";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
$critere = isset($_GET['critere']) ? $_GET['critere'] : 'tous';
$sql = "SELECT * FROM vehicule WHERE 1=1";

if (!empty($recherche)) {
    if ($critere == 'tous') {
        $sql .= " AND (modele LIKE '%$recherche%' OR marque LIKE '%$recherche%' OR immatriculation LIKE '%$recherche%')";
    } else {
        $sql .= " AND $critere LIKE '%$recherche%'";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des véhicules</title>
    <link rel="stylesheet" href="../styles/vehicule.css">
        
    </style>
</head>
<body>
    <div id="header">
        <h1>Location de voiture</h1>
    </div>
    <h2>Recherche de véhicules</h2>
    
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="recherche" placeholder="Rechercher..." value="<?php echo htmlspecialchars($recherche); ?>">
            
            <select name="critere">
                <option value="tous" <?php if($critere == 'tous') echo 'selected'; ?>>Tous les critères</option>
                <option value="modele" <?php if($critere == 'modele') echo 'selected'; ?>>Modèle</option>
                <option value="marque" <?php if($critere == 'marque') echo 'selected'; ?>>Marque</option>
                <option value="immatriculation" <?php if($critere == 'immatriculation') echo 'selected'; ?>>Immatriculation</option>
                <option value="prix" <?php if($critere == 'prix') echo 'selected'; ?>>Prix</option>
            </select>
            
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
    <table>
        <tr>
            <th>Modèle</th>
            <th>Marque</th>
            <th>Immatriculation</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Prix</th>
        </tr>
        
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["modele"] . "</td>";
                echo "<td>" . $row["marque"] . "</td>";
                echo "<td>" . $row["immatriculation"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["statut"] . "</td>";
                echo "<td>" . $row["prix"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucun résultat trouvé</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="vehicule.php">Acceuil</a>
    <?php
    $conn->close();
    ?>
</body>
</html>