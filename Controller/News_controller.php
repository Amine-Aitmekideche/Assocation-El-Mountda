<?php
    require_once(__DIR__ . '/../Model/News_model.php');
    require_once(__DIR__ . '/../View/News_view.php');
    require_once 'menu_composant_controller.php';
    require_once 'Footer_controller.php';
    require_once 'Head_controller.php';
    require_once 'User_controller.php';
    require_once 'Dashboard_Componant_controller.php';
    class News_controller{
        public function get_News_controller(){
            $mtf= new News_model();
            $r=$mtf->get_News_model();
            return $r;
        }

        public function get_News_by_type_controller($type){
            $mtf= new News_model();
            $r=$mtf->get_News_by_type_model($type);
            return $r;
        }

        public function get_News_by_id_controller($id){
            $mtf= new News_model();
            $r=$mtf->get_News_by_id_model($id);
            return $r;
        }
        public function modifier_news_controller($id, $titre, $description, $type, $date_debut, $date_fin, $image=null) {
            // if ($image === null) {
            //     $image = '';
            // }
            $news_model = new News_model();
            $result = $news_model->modifier_model($id, $titre, $description, $type, $date_debut, $date_fin, $image);
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Modification  News réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de la modification de  news.',
                ];
            }
            
        }
        public function ajouter_news_controller($titre, $description, $type, $date_debut, $date_fin,  $image) {
            $news_model = new News_model();
            // $dateCreation = new DateTime(); 
            // $dateTimeString = $dateCreation->format('Y-m-d H:i:s');
            $result = $news_model->ajouter_model($titre, $description, $type, $date_debut, $date_fin, $image );
            
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Ajout  News réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de l\'ajout de  news.',
                ];
            }
        }

        public function supprimer_news_controller($id) {
            $news_model = new News_Model();
            $result = $news_model->supprimer_modele($id);
        
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Supprision type news réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de la Supprision  de type news.',
                ];
            }
        }
        
        public function affiche_news(){
            $v= new News_view();
            $r=$v->display_news();
        }
        public function display_home_news(){
            $v= new News_view();
            $r=$v->display_home_news();
        }
        public function display_news_diaporama(){
            $v= new News_view();
            $r=$v->display_news_diaporama();
        }

        public function affiche_news_page(){
            // $userController = new User_controller();
            // $userId = $userController->verify_cookie('admin'); 
            // if ($userId !== null) {
                $pageName = "ElMountada | News";
                $cssFiles = ['./public/style/varaibles.css', './public/style/menu_user.css','./public/style/news.css', './public/style/footer.css'];
                $jsFiles = [];
                $libraries = ['icons']; 
                $headController = new Head_controller();
                $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
                
                $menu = new menu_composant_controller();
                $menu->display_menu_by_role('user');
        
                $this->affiche_news();
                $menu = new Footer_controller();
                $menu->display_footer();
                echo '</body>';
            // }           
         
        }

        public function affiche_news_dashbord_page() {
            // $userController = new User_controller();
            // $userId = $userController->verify_cookie('admin'); 
            // if ($userId !== null) {
                $pageName = "ElMountada | News Dashboard";
                $cssFiles = [
                    '../public/style/varaibles.css',
                    '../public/style/dashbord_table.css',
                    '../public/style/menu_left.css',
                    '../public/style/Footer.css'
                ];
                $jsFiles = ['../js/scrpt.js'];
                $libraries = ['jquery','icons']; 
                $headController = new Head_controller();
                $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
                
                echo '<h1>News Dashboard</h1>';
        
                $menu = new menu_composant_controller();
                $menu->display_menu_by_role('admin');
        
                $fields = [
                    ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                    ['label' => 'Image', 'attribute' => 'image', 'type' => 'image'],
                    ['label' => 'Titre', 'attribute' => 'titre', 'type' => 'text'],
                    ['label' => 'Type', 'attribute' => 'type', 'type' => 'cle', 'class'=> 'News_type_controller', 'methode' =>  'get_News_type_id_controller', 'att_option_affiche' => 'type', 'att_option_arg' => 'id'],
                    ['label' => 'Date Début', 'attribute' => 'date_debut', 'type' => 'date'],
                    ['label' => 'Date Fin', 'attribute' => 'date_fin', 'type' => 'date'],
                    ['label' => 'Date Publication', 'attribute' => 'date_publication', 'type' => 'date'],
                    ['label' => 'Publicateur', 'attribute' => 'publicateur', 'type' => 'text']
                ];
        
                $actions = [
                    [
                        'label' => 'Modifier',
                        'url' => '/admin/modifier_news/{id}', 
                        'class' => 'btn-edit'
                    ],
                    [
                        'label' => 'Voir plus',
                        'url' => '/admin/details_news/{id}', 
                        'class' => 'btn-view'
                    ],
                    [
                        'label' => 'Supprimer',
                        'url' => '#', 
                        'class' => 'btn-delete',
                        'id' => 'action_button',
                        'onclick' => '', 
                        'data' => [ 
                            'action' => 'supprimer',
                            'nomclass' => 'News_controller',
                            'functionname' => 'supprimer_news_controller',
                            'pathfile' => '/public/images/news'
                        ],
                    ],
                ];
        
                $controller = new Dashboard_Componant_controller();
                $controller->affiche_Dashbord(
                    'News_controller', 
                    'get_News_controller', 
                    $fields, 
                    [], 
                    $actions, 
                    'News_controller', 
                    'supprimer_news_controller'
                );
        
                $footer = new Footer_controller();
                $footer->display_footer();
        
                echo '</body>';
            // }
        }
        
        
    }
?>