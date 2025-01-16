<?php
require_once('dataBase.php');

class Offres_model {

    public function get_Offres_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Offre";
        $r = $db->requite($c, $qtf);
        $result = $r->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }


    public function get_Offres_by_partenaire_model($partenaire_id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Offre WHERE partainer = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $partenaire_id, PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_Offre_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Offre WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        if (!$result) {
            throw new Exception("Aucune offre trouvée avec l'ID $id.");
        }
        return $result;
    }
    public function ajouter_offre_model($partainer, $carte, $reduction, $date_fin, $avantage) {
        $db = new dataBase();
        $c = $db->connexion();
        $date_fin = !empty(trim($date_fin)) ? $date_fin : null;
        $sql = "INSERT INTO Offre (partainer, carte, reduction, date_fin, avantage) 
                VALUES (:partainer, :carte, :reduction, :date_fin, :avantage)";
        $stmt = $c->prepare($sql);
    
        $stmt->bindParam(':partainer', $partainer, PDO::PARAM_INT);
        $stmt->bindParam(':carte', $carte, PDO::PARAM_STR);
        $stmt->bindParam(':reduction', $reduction, PDO::PARAM_INT);
        $stmt->bindParam(':date_fin', $date_fin, PDO::PARAM_STR);
        $stmt->bindParam(':avantage', $avantage, PDO::PARAM_STR);
    
        $db->execute($stmt);
    
        $db->deconnexion($c);
    }
    public function supprimer_offre_model($id) {
        try {
            $db = new dataBase();
            $c = $db->connexion();
            $sql = "DELETE FROM Offre WHERE id = :id";
            $stmt = $c->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $db->execute($stmt);
            $db->deconnexion($c);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'offre : " . $e->getMessage());
        }
    }

    public function modifier_offre_model($id, $partainer, $carte, $reduction, $date_fin, $avantage) {
        try {
            $db = new dataBase();
            $c = $db->connexion();
    
            $date_fin = !empty(trim($date_fin)) ? $date_fin : null;
    
            $sql = "UPDATE Offre 
                    SET partainer = :partainer, 
                        carte = :carte, 
                        reduction = :reduction, 
                        date_fin = :date_fin, 
                        avantage = :avantage 
                    WHERE id = :id";
            $stmt = $c->prepare($sql);
    
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':partainer', $partainer, PDO::PARAM_INT);
            $stmt->bindParam(':carte', $carte, PDO::PARAM_STR);
            $stmt->bindParam(':reduction', $reduction, PDO::PARAM_INT);
            $stmt->bindParam(':date_fin', $date_fin, $date_fin === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindParam(':avantage', $avantage, PDO::PARAM_STR);
    
            $db->execute($stmt);
            $db->deconnexion($c);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la modification de l'offre : " . $e->getMessage());
        }
    }

    public function get_Offres_by_carte_model($carte) {
        $db = new dataBase();
        $c = $db->connexion();
        
        try {
            $sql = "
                SELECT *
                FROM Offre o
                JOIN Partenaires p ON o.partainer = p.id
                WHERE o.carte = :carte
            ";
    
            $stmt = $c->prepare($sql);
            $stmt->bindParam(':carte', $carte, PDO::PARAM_STR);
            $db->execute($stmt);
    
            // Récupérer les résultats
            $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db->deconnexion($c);
            
            return $offres;
        } catch (Exception $e) {
            $db->deconnexion($c);
            echo "Erreur SQL : " . $e->getMessage();
            return false;
        }
    }
    

}

?>