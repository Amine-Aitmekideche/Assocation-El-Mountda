<?php
require_once('dataBase.php');

class News_type_model {

    public function get_News_type_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Type_News";
        $stmt = $c->prepare($qtf);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_News_type_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Type_News Where id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;

    }

    public function ajouter_type($type, $description) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO Type_News (type, description) VALUES (?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function modifier_type($id, $type, $description) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE Type_News SET type = ?, description = ? WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    public function supprimer_type($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "DELETE FROM Type_News WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
        
}
?>



