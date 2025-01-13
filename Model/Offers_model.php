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
}

?>