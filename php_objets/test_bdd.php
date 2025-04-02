<?php
// Afficher les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
$host = 'localhost';
$db = 'locations';
$user = 'root';
$pass = '';
$port = '3306';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "<p>Connexion à la base de données réussie !</p>";
    
    // Test simple pour vérifier la table vehicule
    $sql = "SELECT COUNT(*) as total FROM vehicule";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch();
    
    echo "<p>Nombre total de véhicules dans la base : " . $result['total'] . "</p>";
    
    if ($result['total'] > 0) {
        echo "<h3>Voici les véhicules trouvés :</h3>";
        $sql = "SELECT * FROM vehicule";
        $stmt = $pdo->query($sql);
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Modèle</th><th>Marque</th><th>Immatriculation</th><th>Type</th><th>Statut</th><th>Prix</th></tr>";
        
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['modele'] . "</td>";
            echo "<td>" . $row['marque'] . "</td>";
            echo "<td>" . $row['immatriculation'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['statut'] . "</td>";
            echo "<td>" . (isset($row['prix_jour']) ? $row['prix_jour'] : 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun véhicule trouvé dans la base de données.</p>";
    }
} catch(PDOException $e) {
    echo "<p>Erreur de connexion : " . $e->getMessage() . "</p>";
}
?>