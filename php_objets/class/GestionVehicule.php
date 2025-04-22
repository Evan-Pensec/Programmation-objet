<?php
class GestionVehicule {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function ajouter($modele, $marque, $immatriculation, $type, $statut, $prix) {
        $sql = "INSERT INTO vehicule (modele, marque, immatriculation, type, statut, prix) 
                VALUES ('$modele', '$marque', '$immatriculation', '$type', '$statut', '$prix')";
        
        $this->pdo->exec($sql);
        
        return true;
    }
    
    public function getVehiculeById($id) {
        $sql = "SELECT * FROM vehicule WHERE id = " . $id;
        
        $resultat = $this->pdo->query($sql);
        
        return $resultat->fetch();
    }
    
    public function modifier($id, $modele, $marque, $immatriculation, $type, $statut, $prix) {
        $sql = "UPDATE vehicule 
                SET modele = '$modele', 
                    marque = '$marque', 
                    immatriculation = '$immatriculation', 
                    type = '$type', 
                    statut = '$statut', 
                    prix = '$prix' 
                WHERE id = " . $id;
        
        $this->pdo->exec($sql);
        
        return true;
    }
    
    public function supprimer($id) {
        $sql = "DELETE FROM vehicule WHERE id = " . $id;
        
        $this->pdo->exec($sql);
        
        return true;
    }
    
    public function getAllVehicules() {
        $sql = "SELECT * FROM vehicule";
        
        $resultat = $this->pdo->query($sql);
        
        $vehicules = [];
        
        while ($row = $resultat->fetch()) {
            $vehicules[] = $row;
        }
        
        return $vehicules;
    }
}
?>