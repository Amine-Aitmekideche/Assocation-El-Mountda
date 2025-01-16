<?php
require_once('dataBase.php');

class Carte_model {
    public function get_all_cartes() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Type_carte";
        $r = $db->requite($c, $qtf);
        $result = $r->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_carte_by_id($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Type_carte WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function ajouter_carte($type, $description, $prix) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO Type_carte (type, description, prix) VALUES (?, ?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $prix, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function modifier_carte($id, $type, $description, $prix) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE Type_carte SET type = ?, description = ?, prix = ? WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $prix, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function supprimer_carte($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "DELETE FROM Type_carte WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
}
?>
