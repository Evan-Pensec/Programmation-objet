<?php
class Controller {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function ajouterVehicule($modele, $marque, $immatriculation, $type, $statut, $prix) {
        try {
            $sql = "INSERT INTO vehicule (modele, marque, immatriculation, type, statut, prix) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$modele, $marque, $immatriculation, $type, $statut, $prix]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function modifierVehicule($id, $modele, $marque, $immatriculation, $type, $statut, $prix) {
        try {
            $sql = "UPDATE vehicule 
                    SET modele = ?, 
                        marque = ?, 
                        immatriculation = ?, 
                        type = ?, 
                        statut = ?, 
                        prix = ? 
                    WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$modele, $marque, $immatriculation, $type, $statut, $prix, $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function supprimerVehicule($id) {
        try {
            $sql = "DELETE FROM vehicule WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function getVehiculeById($id) {
        try {
            $sql = "SELECT * FROM vehicule WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function getAllVehicules() {
        try {
            $sql = "SELECT * FROM vehicule";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function rechercherVehicules($recherche, $critere = 'tous') {
        try {
            $sql = "SELECT * FROM vehicule WHERE 1=1";
            $params = [];
            
            if (!empty($recherche)) {
                if ($critere == 'tous') {
                    $sql .= " AND (modele LIKE ? OR marque LIKE ? OR immatriculation LIKE ?)";
                    $params = ["%$recherche%", "%$recherche%", "%$recherche%"];
                } else {
                    $sql .= " AND $critere LIKE ?";
                    $params = ["%$recherche%"];
                }
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function estAdmin($username) {
        try {
            $sql = "SELECT admin FROM user WHERE user = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            $result = $stmt->fetch();
            
            return ($result && $result['admin'] == 1);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function authentifier($username, $password) {
        try {
            $sql = "SELECT * FROM user WHERE user = ? AND password = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $password]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>