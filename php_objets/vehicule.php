<?php
include("liaison_bdd.php");

$username=$_GET['user'];
$password=$_GET['password'];

$sql = "SELECT * FROM user WHERE user='$username' AND password='$password'";
$result = $pdo->query($sql);
$user = $result->fetch();

$is_admin = false;

if($user && $user['admin'] == 1){
    $is_admin = true;
}

?>
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Objet</title>
        <meta name="description" content="">
        <link rel="stylesheet" href="testjs.css">
        <style>
            table, th, td {
            border:1px solid black;
            padding: 5px;
        }
        </style>
    </head>

    <body>
            <table>
            <tr>
                <th>Modele</th>
                <th>Marque</th>
                <th>Immatriculation</th>
                <th>Type</th>
                <th>Statut</td>
                <th>Prix par jour</th>
                <?php if($is_admin) ?>
                    <th>Actions</th>
            </tr>
        
        
<?php

            $sql="SELECT * FROM vehicule";
            $resultat = $pdo->query($sql);

            while($vehicule=$resultat->fetch()){
                echo "<tr>";
                echo "<td>" . $vehicule['modele'] . "</td>";
                echo "<td>" . $vehicule['marque'] . "</td>";
                echo "<td>" . $vehicule['immatriculation'] . "</td>";
                echo "<td>" . $vehicule['type'] . "</td>";
                echo "<td>" . $vehicule['statut'] . "</td>";
                echo "<td>" . $vehicule['prix_jour'] . "</td>";
                echo "</tr>";
            }


    if(isset($_GET['type'])){
            $type=$_GET['type'];
        if($type=='vehicule'){
            while($resultats = $temp->fetch()) {
                echo '<tr><td>' . $resultats['modele'] . '</td><td>' . $resultats['marque'] . '</td><td>' . $resultats['immatriculation'] . '</td><td>' . $resultats['type'] . '</td><td>' . $resultats['statut'] . '</td><td>' . $resultats['prix_jour'] . '</td><td>' . "<a href=''>Ajouter</a>" . '</td><td>' . "<a href=''>Modifier</a>" . '</td><td>' . "<a href=''>Supprimer</a>" . '</td>';
            }
        }
    }

?>
        </table>
        <script src="testjs.js"></script>
    </body>
    </html>