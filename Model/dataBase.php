<?php
class dataBase{
    private $dbname = 'Assocaition_Elhana';
    private $host = '127.0.0.1';
    private $user = 'amine';
    private $password = '13a12345';

    public function connexion() {
        // Utilisation correcte des propriétés avec $this->
        $dsn = "mysql:dbname=" . $this->dbname . "; host=" . $this->host . ";port=8889";

        try {
            $c = new PDO($dsn, $this->user, $this->password);
            $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            return $c; // Retourne la connexion
        } catch (PDOException $e) {
            printf("Échec de la connexion : " . $e->getMessage());
            exit();
        }
    }
     
    
    public function deconnexion(&$c){
        $c= null;
    }

    public function requite($c, $r){
        return $c->query($r);
    }
    public function execute($r){
        return $r->execute();
    }

    public function get_menu_item_model(){
        $c= $this->connexion("TDW","127.0.0.1","amine","13a12345");
        $qtf="SELECT * from menuItem";
        $r=$this->requite($c,$qtf);
        $this->deconnexion($c);
        return $r;
    }
    
    public function get_sous_menu_item_model($v){
        $c= $this->connexion("TDW","127.0.0.1","amine","13a12345");
        if(isset($v)){
            $qtf="SELECT * from sousItemMenu where menu_id=".$v.";";
        }else{
            $qtf="SELECT * from sousItemMenu";
        }
        
        $r=$this->requite($c,$qtf);
        $this->deconnexion($c);
        return $r;
    }
}
?>



