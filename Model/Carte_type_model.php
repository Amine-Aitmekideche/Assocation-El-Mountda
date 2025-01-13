<?php
require_once('dataBase.php');

class Carte_type_model {

    public function get_Carte_model() {
        $db = new dataBase();
        $c = $db->connexion();

        $qtf = "SELECT * FROM Type_carte";  
        $r = $db->requite($c, $qtf);
        $db->deconnexion($c);
        return $r;
    }

    // public function get_Carte_by_type_model($type) {
    //     $db = new dataBase();
    //     $c = $db->connexion();
    //     $qtf = "SELECT * FROM Type_Carte WHERE type = ?"; 
    //     $stmt = $c->prepare($qtf);
    //     $stmt->bindParam(1, $type, PDO::PARAM_STR); 
    //     $db->execute($stmt);
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    //     $db->deconnexion($c);
    
    //     return $result;
    // }
    
}
?>
