<?php
require_once('dataBase.php');

class Partenier_categorie_model {

    public function get_Partenaire_category_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Categorie";
        $r = $db->requite($c, $qtf);
        $result = $r->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
    public function get_categorie_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Categorie WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
    
    public function ajouter_categorie($categorie, $description) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO Categorie (categorie, description) VALUES (?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $categorie, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    
    public function modifier_categorie($id, $categorie, $description) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE Categorie SET categorie = ?, description = ? WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $categorie, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    
    public function supprimer_categorie($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "DELETE FROM Categorie WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    

}
?>