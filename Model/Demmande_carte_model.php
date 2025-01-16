<?php
require_once('dataBase.php');

class Demmande_carte_model {

    public function get_all_demmandes() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM demmandeCarte";
        $r = $db->requite($c, $qtf);
        $result = $r->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_all_noeffectue_demmandes() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM demmandeCarte WHERE accpter = 0";
        $r = $db->requite($c, $qtf);
        $result = $r->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_demmande_by_id($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM demmandeCarte WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $db->execute($stmt);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_demmande_by_userid($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM demmandeCarte WHERE user = ? AND accpter = 1";
        $stmt = $c->prepare($qtf);
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $db->execute($stmt);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function ajouter_demmande($user, $photo, $type, $date, $accepter = 0) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO demmandeCarte (user, photo, type, date, accpter) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $user, PDO::PARAM_INT);
        $stmt->bindParam(2, $photo, PDO::PARAM_STR);
        $stmt->bindParam(3, $type, PDO::PARAM_STR);
        $stmt->bindParam(4, $date, PDO::PARAM_STR);
        $stmt->bindParam(5, $accepter, PDO::PARAM_BOOL);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function modifier_demmande($id, $user, $photo, $type, $date, $accepter) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE demmandeCarte SET user = ?, photo = ?, type = ?, date = ?, accpter = ? WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $user, PDO::PARAM_INT);
        $stmt->bindParam(2, $photo, PDO::PARAM_STR);
        $stmt->bindParam(3, $type, PDO::PARAM_STR);
        $stmt->bindParam(4, $date, PDO::PARAM_STR);
        $stmt->bindParam(5, $accepter, PDO::PARAM_BOOL);
        $stmt->bindParam(6, $id, PDO::PARAM_INT);
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function supprimer_demmande($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "DELETE FROM demmandeCarte WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function get_demmandes_by_user($user) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM demmandeCarte WHERE user = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $user, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function changer_statut_demmande($id, $statut) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE demmandeCarte SET accpter = ? WHERE id = ?";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $statut, PDO::PARAM_INT);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        
        $db->deconnexion($c);
        return $result;
    }
    
}
?>
