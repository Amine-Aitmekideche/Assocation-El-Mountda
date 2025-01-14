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
    
    public function modifier_news_model($id, $titre, $description, $type, $date_debut, $date_fin, $image = null) {
        $db = new dataBase();
        $c = $db->connexion();
    
        try {
            $query = "UPDATE news SET titre = ?, description = ?, type = ?, date_debut = ?, date_fin = ?";
            
            if ($image) {
                $query .= ", image = ?";
            }
            
            $query .= " WHERE id = ?";
            $stmt = $c->prepare($query);
            
            $stmt->bindParam(1, $titre);
            $stmt->bindParam(2, $description);
            $stmt->bindParam(3, $type);
            $stmt->bindParam(4, $date_debut);
            $stmt->bindParam(5, $date_fin);
    
            if ($image) {
                $stmt->bindParam(6, $image);
                $stmt->bindParam(7, $id);
            } else {
                $stmt->bindParam(6, $id);
            }
    
            $stmt->execute();
            $db->deconnexion($c);
    
            return true;
        } catch (Exception $e) {
            $db->deconnexion($c);
            return false;
        }
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
