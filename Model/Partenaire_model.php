<?php
require_once('dataBase.php');

class Partenaire_model {

    public function get_Partenaire_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Partenaires";
        $stmt = $c->prepare($qtf);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_Partenaires_by_category_model($category) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Partenaires Where categorie = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $category ,PDO::PARAM_STR);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_Partenaires_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Partenaires Where id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id ,PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function supprimer_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $query = "DELETE FROM Partenaires WHERE id = ?";
        $stmt = $c->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function modifier_model($id, $nom, $willya, $adresse, $categorie, $logo, $description) {
        $db = new dataBase();
        $c = $db->connexion();
        
        if ($logo) {
            $qtf = "UPDATE Partenaires SET nom = ?, willya = ?, adresse = ?, categorie = ?, logo = ?, description = ? WHERE id = ?";
        } else {
            $qtf = "UPDATE Partenaires SET nom = ?, willya = ?, adresse = ?, categorie = ?, description = ? WHERE id = ?";
        }
        
        $stmt = $c->prepare($qtf);
        
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $willya, PDO::PARAM_STR);
        $stmt->bindParam(3, $adresse, PDO::PARAM_STR);
        $stmt->bindParam(4, $categorie, PDO::PARAM_STR);
        if ($logo) {
            $stmt->bindParam(5, $logo, PDO::PARAM_STR);
            $stmt->bindParam(6, $description, PDO::PARAM_STR);
            $stmt->bindParam(7, $id, PDO::PARAM_INT);
        } else {
            $stmt->bindParam(5, $description, PDO::PARAM_STR);
            $stmt->bindParam(6, $id, PDO::PARAM_INT);
        }
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function ajouter_model($nom, $willya, $adresse, $categorie, $logo, $description, $date_ajouter) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO Partenaires (nom, willya, adresse, categorie, logo, description, date_ajouter) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $willya, PDO::PARAM_STR);
        $stmt->bindParam(3, $adresse, PDO::PARAM_STR);
        $stmt->bindParam(4, $categorie, PDO::PARAM_STR);
        $stmt->bindParam(5, $logo, PDO::PARAM_STR);
        $stmt->bindParam(6, $description, PDO::PARAM_STR);
        $stmt->bindParam(7, $date_ajouter, PDO::PARAM_STR);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    
    
}
?>
