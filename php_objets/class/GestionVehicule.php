<?php
class GestionVehicule {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function ajouter($modele, $marque, $immatriculation, $type, $statut, $prix) {
        try {
            $sql = "INSERT INTO vehicule (modele, marque, immatriculation, type, statut, prix) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$modele, $marque, $immatriculation, $type, $statut, $prix]);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur d'ajout de véhicule: " . $e->getMessage());
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
            error_log("Erreur de récupération de véhicule: " . $e->getMessage());
            return null;
        }
    }
    
    public function modifier($id, $modele, $marque, $immatriculation, $type, $statut, $prix) {
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
            error_log("Erreur de modification de véhicule: " . $e->getMessage());
            return false;
        }
    }
    
    public function supprimer($id) {
        try {
            $sql = "DELETE FROM vehicule WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur de suppression de véhicule: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllVehicules() {
        try {
            $sql = "SELECT * FROM vehicule";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur de récupération des véhicules: " . $e->getMessage());
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
            error_log("Erreur de recherche de véhicules: " . $e->getMessage());
            return [];
        }
    }
    
    public function authentifier($username, $password) {
        try {
            $sql = "SELECT * FROM user WHERE user = ? AND password = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $password]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur d'authentification: " . $e->getMessage());
            return false;
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
            error_log("Erreur de vérification admin: " . $e->getMessage());
            return false;
        }
    }
    
    public function louerVehicule($id_vehicule, $username, $date_debut, $date_fin) {
        try {
            $this->pdo->beginTransaction();
            
            $vehicule = $this->getVehiculeById($id_vehicule);
            if (!$vehicule || $vehicule['statut'] != 1) {
                return false;
            }
            
            $date1 = new DateTime($date_debut);
            $date2 = new DateTime($date_fin);
            $interval = $date1->diff($date2);
            $nombre_jours = $interval->days + 1;
            $prix_total = $nombre_jours * $vehicule['prix'];
            
            $sql = "INSERT INTO locations (id_vehicule, username, date_debut, date_fin, prix_total) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_vehicule, $username, $date_debut, $date_fin, $prix_total]);
            
            $sql = "UPDATE vehicule SET statut = 0 WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_vehicule]);
            
            $this->pdo->commit();
            return true;
            
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log("Erreur de location de véhicule: " . $e->getMessage());
            return false;
        }
    }
}
?>