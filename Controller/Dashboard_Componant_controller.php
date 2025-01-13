<?php
    
    require_once __DIR__ . '/../View/Dashboard_Componant_view.php';
    require_once __DIR__ . '/../View/Modifier_Dashbord_view.php';
    require_once __DIR__ . '/../View/Detail_Dashbord_view.php';
    require_once __DIR__ . '/../View/Ajouter_Dashbord_view.php';
    
    class Dashboard_Componant_controller {
        public function construire_Dashboard($className ,$functionName, $fields, $args) {
            // Charger le modèle
            require_once './Controller/'.$className.'.php';
            $controller = new $className();
            // echo $className;

            // Vérifier si la fonction existe dans le modèle
            if (!method_exists($controller, $functionName)) {
                echo "Erreur : La fonction $functionName n'existe pas dans le modèle.";
                return;
            }

            // Appeler dynamiquement la fonction du modèle
            // echo '<pre>';
            // $d = $functionName . '(' . implode(', ', array_map('htmlspecialchars', $args)) . ')';
            // echo $d; // Utilise implode pour afficher les arguments séparés par des virgules
            // echo '</pre>';
            // $data = $controller->$functionName();
            $data = $controller->$functionName(implode(', ', array_map('htmlspecialchars', $args)) );
            
            //         $data = $data->fetchAll(PDO::FETCH_ASSOC);
                
                
                return $data;
                       
            // Charger la vue et transmettre les données
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
            // echo '<pre>';
            // echo 'Action dashbord:<br>';
            // echo 'Classe : ' . htmlspecialchars($nomClass) . '<br>';
            // echo 'Fonction : ' . htmlspecialchars($functionName) . '<br>';
            // echo 'Paramètres : ' . htmlspecialchars(implode(', ', $parametres)) . '<br>';
            // echo '</pre>';
            require_once $nomClass.'.php';
            $controller = new $nomClass();  
            
            $result = $controller->$functionName(...$parametres);
            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'Ajout réussi !',
                ];
            } else {
                echo "Hello!";
                return [
                    'status' => 'error',
                    'message' => 'Erreur lors de l\'ajout.',
                ];
            }
            // $controller->modifier_news_controller(1, "Amine Sortie en plein air pour les membres", "L&#039;association organise une sortie en plein air pour tous ses membres le 10 mars 2024. Au programme : randonnée, jeux et pique-nique. Venez nombreux !", 1, "2024-03-10T08:00", "2024-03-10T17:00", "2023-12-21T10:00", 1);
            
        }       
}
?>