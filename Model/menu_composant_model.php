<?php
require_once('dataBase.php');
class menu_composant_model{

    public function get_menu_item_model(){
        $db = new dataBase();
        $c = $db->connexion();
        $qtf="SELECT * from menu_item";
        $stmt = $c->prepare($qtf);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
    
    public function get_menu_item_by_role_model($role){
        $db = new dataBase();
        $c = $db->connexion();
        $qtf="SELECT * from menu_item where role= ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $role, PDO::PARAM_STR);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_sous_menu_item_model($id){
        $db = new dataBase();
        $c = $db->connexion();
        $qtf="SELECT * from menu_sous_item where menu_id= ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
}
?>



