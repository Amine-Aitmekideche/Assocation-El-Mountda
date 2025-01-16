<?php
    
    require_once __DIR__ . '/../View/Dashboard_Componant_view.php';
    require_once __DIR__ . '/../View/Modifier_Dashbord_view.php';
    require_once __DIR__ . '/../View/Detail_Dashbord_view.php';
    require_once __DIR__ . '/../View/Ajouter_Dashbord_view.php';
    
    class Dashboard_Componant_controller {
        public function construire_Dashboard($className ,$functionName, $fields, $args) {
            require_once './Controller/'.$className.'.php';
            $controller = new $className();

            if (!method_exists($controller, $functionName)) {
                echo "Erreur : La fonction $functionName n'existe pas dans le modèle.";
                return;
            }
            $data = $controller->$functionName(implode(', ', array_map('htmlspecialchars', $args)) );                
            return $data;
        }
        public function affiche_Dashbord($className ,$functionName, $fields,$args, $actions , $classSuppName , $functionSuppName){
            $data = $this->construire_Dashboard($className ,$functionName, $fields,$args);
            $v= new Dashboard_Componant_view();
            $r=$v->display_Dashbord($data,$fields,$actions,$classSuppName , $functionSuppName);
        }

        public function display_ModifierForm($className ,$functionName, $fields,$args ,$action , $nomClass, $nameFunction ,$pathfile, $rederection , $titrePage){
            $data = $this->construire_Dashboard($className ,$functionName, $fields,$args);
            $v= new Modifier_Dashbord_view();
            $r=$v->display_ModifierForm($data,$fields,$action , $nomClass, $nameFunction, $pathfile, $rederection, $titrePage);
        }
        public function display_DetailView($className ,$functionName, $fields,$args ,$titrePage ){
            $data = $this->construire_Dashboard($className ,$functionName, $fields,$args);
            $v= new Detail_Dashbord_view();
            $r=$v->display_DetailView($data,$fields,$titrePage);
        }
        public function display_AjouterForm($fields,$action , $nomClass, $nameFunction ,$pathfile,$rederection,$titrePage){
            $v= new Ajouter_Dashbord_view();
            $r=$v->display_AjouterForm($fields,$action , $nomClass, $nameFunction ,$pathfile,$rederection,$titrePage);
        }

        public function action_dashbord($nomClass, $functionName, $parametres = []) {
            
            require_once $nomClass.'.php';
            $controller = new $nomClass();  
            
            $result = $controller->$functionName(...$parametres);
        }       
}
?>