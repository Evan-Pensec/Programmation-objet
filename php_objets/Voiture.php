<?php
class Voiture {
    public $id;
    public $modele;
    public $marque;
    public $immatriculation;
    public $type;
    public $statut;
    public $prix;

public function __construct($id, $modele, $marque, $immatriculation, $type, $statut, $prix){
    $this->id = $id;
    $this->modele = $modele;
    $this->marque = $marque;
    $this->immatriculation = $immatriculation;
    $this->type = $type;
    $this->statut = $statut;
    $this->prix = $prix;
}

public static function getAllVoiture(){
    global $pdo;
    $sql = "SELECT * FROM vehicule";
    $resultat = $pdo->query($sql);
    $vehicules = [];

    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $vehicule[] = new Voiture(
            $row['id'],
            $row['modele'],
            $row['marque'],  
            $row['immatriculation'],
            $row['type'],
            $row['statut'],  
            $row['prix']
        );
    }
    return $vehicules;
}

public function afficherVoiture(){
    return "<tr>
    <td>" . $this->modele . "</td>
    <td>" . $this->marque . "</td>
    <td>" . $this->immatriculation . "</td>
    <td>" . $this->type . "</td>
    <td>" . $this->statut . "</td>
    <td>" . $this->prix . "</td>
    </tr>";
}
}


?>