<?php
require_once('dataBase.php');

class News_model {

    public function get_News_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM News";
        $stmt = $c->prepare($qtf);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
    
    public function get_News_by_type_model($type) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM News WHERE type = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $type, PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
    
        return $result;
    }
   
    public function get_News_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM News WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
    
    public function modifier_model($id, $titre, $description, $type, $date_debut, $date_fin, $image) {
        $db = new dataBase();
        $c = $db->connexion();
        if ($image){
            $qtf = "UPDATE News SET titre = ?, description = ?, type = ?, date_debut = ?, date_fin = ? , image = ? WHERE id = ?";
        }else{
            $qtf = "UPDATE News SET titre = ?, description = ?, type = ?, date_debut = ?, date_fin = ? WHERE id = ?";
        }
        
        $stmt = $c->prepare($qtf);
        
        $stmt->bindParam(1, $titre, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $type, PDO::PARAM_INT);
        $stmt->bindParam(4, $date_debut, PDO::PARAM_STR);
        $stmt->bindParam(5, $date_fin, PDO::PARAM_STR);
        if ($image){
            $stmt->bindParam(6, $image, PDO::PARAM_STR);
            $stmt->bindParam(7, $id, PDO::PARAM_INT);
        }else{
            $stmt->bindParam(6, $id, PDO::PARAM_INT);
        }
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    
    public function ajouter_model($titre, $description, $type, $date_debut, $date_fin, $image) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO News (titre, description, type, date_debut, date_fin, image, date_publication) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $c->prepare($qtf);
        
        $stmt->bindParam(1, $titre, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $type, PDO::PARAM_INT);
        $stmt->bindParam(4, $date_debut, PDO::PARAM_STR);
        $stmt->bindParam(5, $date_fin, PDO::PARAM_STR);
        $stmt->bindParam(6, $image, PDO::PARAM_STR);
        $stmt->bindParam(7, (new \DateTime())->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    
    public function supprimer_modele($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $query = "DELETE FROM news WHERE id = ?";
        $stmt = $c->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
}
?>
