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
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM vehicule";
        $resultat = $pdo->query($sql);
        $vehicules = [];

        while ($row = $resultat->fetch()) {
            $vehicules[] = new Voiture(
                $row['id'],
                $row['modele'],
                $row['marque'],  
                $row['immatriculation'],
                $row['type'],
                $row['statut'],  
                $row['prix_jour']
            );
        }
        return $vehicules;
    }
    
    public static function getVoitureById($id) {
        $pdo = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM vehicule WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        
        if ($row) {
            return new Voiture(
                $row['id'],
                $row['modele'],
                $row['marque'],  
                $row['immatriculation'],
                $row['type'],
                $row['statut'],  
                $row['prix_jour']
            );
        }
        return null;
    }
    
    public function save() {
        $pdo = Database::getInstance()->getConnection();
        
        if ($this->id) {
            // Update
            $sql = "UPDATE vehicule SET modele = :modele, marque = :marque, 
                    immatriculation = :immatriculation, type = :type, 
                    statut = :statut, prix_jour = :prix 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'modele' => $this->modele,
                'marque' => $this->marque,
                'immatriculation' => $this->immatriculation,
                'type' => $this->type,
                'statut' => $this->statut,
                'prix' => $this->prix,
                'id' => $this->id
            ]);
        } else {
            // Insert
            $sql = "INSERT INTO vehicule (modele, marque, immatriculation, type, statut, prix_jour) 
                    VALUES (:modele, :marque, :immatriculation, :type, :statut, :prix)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'modele' => $this->modele,
                'marque' => $this->marque,
                'immatriculation' => $this->immatriculation,
                'type' => $this->type,
                'statut' => $this->statut,
                'prix' => $this->prix
            ]);
            $this->id = $pdo->lastInsertId();
        }
        return $this;
    }
    
    public function delete() {
        if ($this->id) {
            $pdo = Database::getInstance()->getConnection();
            $sql = "DELETE FROM vehicule WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $this->id]);
            return true;
        }
        return false;
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