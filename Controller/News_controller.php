<?php
    require_once(__DIR__ . '/../Model/News_model.php');
    require_once(__DIR__ . '/../View/News_view.php');
    require_once 'menu_composant_controller.php';
    require_once 'Footer_controller.php';
    require_once 'Head_controller.php';
    require_once 'User_controller.php';
    require_once 'Dashboard_Componant_controller.php';
    require_once 'file_controller.php';
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
        // public function modifier_news_controller($id, $titre, $description, $type, $date_debut, $date_fin, $image=null) {
        //     // if ($image === null) {
        //     //     $image = '';
        //     // }
        //     $news_model = new News_model();
        //     $result = $news_model->modifier_model($id, $titre, $description, $type, $date_debut, $date_fin, $image);
        //     if ($result) {
        //         return [
        //             'status' => 'true',
        //             'message' => 'Modification  News réussi !',
        //         ];
        //     } else {
        //         return [
        //             'status' => 'false',
        //             'message' => 'Erreur lors de la modification de  news.',
        //         ];
        //     }
            
        // }

        public function modifier_news_controller($id, $titre, $description, $type, $date_debut, $date_fin, $image) {
            $news_model = new News_model();
            $news_model->modifier_news_model($id, $titre, $description, $type, $date_debut, $date_fin, $image);
        }
        
        public function ajouter_news_controller($titre, $description, $type, $date_debut, $date_fin,  $image) {
            $news_model = new News_model();
            $result = $news_model->ajouter_model($titre, $description, $type, $date_debut, $date_fin, $image );
            
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
        
        public function affiche_news_details_page($id) {
            // $userController = new User_controller();
            // $userId = $userController->verify_cookie('admin'); 
            // if ($userId !== null) {
                $pageName = "ElMountada | News Details";
                $cssFiles = [
                    '../../public/style/varaibles.css',
                    '../../public/style/dashbord_details.css',
                    '../../public/style/footer.css'
                ];
                $jsFiles = [];
                $libraries = []; 
                $headController = new Head_controller();
                $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
                
        
                $fields = [
                    ['label' => 'Titre', 'attribute' => 'titre', 'type' => 'text'],   
                    ['label' => 'Image', 'attribute' => 'image', 'type' => 'image'],    
                    ['label' => 'Description', 'attribute' => 'description', 'type' => 'text'],  
                    ['label' => 'Type', 'attribute' => 'type', 'type' => 'select'],  
                    ['label' => 'Date Début', 'attribute' => 'date_debut', 'type' => 'text'],  
                    ['label' => 'Date Fin', 'attribute' => 'date_fin', 'type' => 'text'],  
                    ['label' => 'Date Publication', 'attribute' => 'date_publication', 'type' => 'text'],  
                ];
        
                $controller = new Dashboard_Componant_controller();
                $controller->display_DetailView(
                    'News_controller', 
                    'get_News_by_id_controller', 
                    $fields, 
                    [$id], 
                    'Détails de la News'
                );
        
                $footer = new Footer_controller();
                $footer->display_footer();
        
                echo '</body>';
            // }
        }
        public function affiche_news_modifier_page($id) {
            // $userController = new User_controller();
            // $userId = $userController->verify_cookie('admin'); 
            // if ($userId !== null) {
                $pageName = "ElMountada | Modifier News";
                $cssFiles = [
                    '../../public/style/varaibles.css',
                    '../../public/style/dashbord_modifier.css',
                    '../../public/style/footer.css'
                ];
                $jsFiles = ['../../js/scrpt.js'];
                $libraries = ['jquery','icons']; 
                $headController = new Head_controller();
                $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
                $controller = new Dashboard_Componant_controller();
    
                $fields = [
                    ['label' => 'ID', 'attribute' => 'id', 'type' => 'id'],
                    ['label' => 'Image', 'attribute' => 'image', 'type' => 'image'],  
                    ['label' => 'Titre', 'attribute' => 'titre', 'type' => 'text'],      
                    ['label' => 'Description', 'attribute' => 'description', 'type' => 'textarea'],  
                    ['label' => 'Type', 'attribute' => 'type', 'type' => 'select', 'options' => $controller->construire_Dashboard('News_type_controller','get_News_type_controller', [] , []), 'att_option_affiche' => 'type' , 'att_option_return' => 'id'],  
                    ['label' => 'Date Début', 'attribute' => 'date_debut', 'type' => 'datetime-local'],  
                    ['label' => 'Date Fin', 'attribute' => 'date_fin', 'type' => 'datetime-local'],  
                ];
                
        
                $controller->display_ModifierForm(
                    'News_controller', 
                    'get_News_by_id_controller', 
                    $fields, 
                    [$id], 
                    '../../admin/modifier_news_post', 
                    'News_controller', 
                    'modifier_news_controller', 
                    'public/image/news', 
                    '../../admin/dash_news', 
                    'Modifier News'
                );
        
                $footer = new Footer_controller();
                $footer->display_footer();
        
                echo '</body>';
            // }
        }

        public function modifier_news() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = $_POST['id'] ?? null;
                $titre = $_POST['titre'] ?? null;
                $description = $_POST['description'] ?? null;
                $type = $_POST['type'] ?? null;
                $date_debut = $_POST['date_debut'] ?? null;
                $date_fin = $_POST['date_fin'] ?? null;
        
                $imageFile = $_FILES['image'] ?? null;
                $imagePath = null;
                echo $id, $titre; 
                print_r($imageFile); 

                $uploadDir = 'public/image/news/';
                try {
                    if (isset($imageFile) && $imageFile['error'] === UPLOAD_ERR_OK) {
                        $imagePath = file_controller::chargerFile($imageFile, $uploadDir);
                        $imagePath= $uploadDir.$imagePath;
                    }
                } catch (Exception $e) {
                    $_SESSION['errorsModifier'] = ["Erreur lors du téléchargement de l'image : " . $e->getMessage()];
                    header('Location: ./modifier_news?id=' . $id);
                    exit();
                }

        
                if ($id && $titre && $description && $type && $date_debut && $date_fin) {
                    $this->modifier_news_controller($id, $titre, $description, $type, $date_debut, $date_fin, $imagePath);
                    header('Location: ./dash_news');
                } else {
                    $_SESSION['errorsModifier'] = ["Tous les champs sont obligatoires."];
                    header('Location: ./modifier_news?id=' . $id);
                    exit();
                }
            } else {
                $_SESSION['errorsModifier'] = ["Requête invalide."];
                header('Location: ./modifier_news?id=' . $id);
                exit();
            }
        }
        public function affiche_news_ajout_page() {
            $pageName = "ElMountada | Ajouter News";
            $cssFiles = [
                '../public/style/varaibles.css',
                '../public/style/dashbord_ajouter.css',
                '../public/style/menu_left.css',
                '../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery','icons'];
            
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
            $controller = new Dashboard_Componant_controller();

            $fields = [
                ['label' => 'Image', 'attribute' => 'image', 'type' => 'image'],
                ['label' => 'Titre', 'attribute' => 'titre', 'type' => 'text'],
                ['label' => 'Description', 'attribute' => 'description', 'type' => 'textarea'],
                [
                    'label' => 'Type', 
                    'attribute' => 'type', 
                    'type' => 'select',
                    'options' => $controller->construire_Dashboard('News_type_controller', 'get_News_type_controller', [], []), 
                    'att_option_affiche' => 'type', 
                    'att_option_return' => 'id'
                ],
                ['label' => 'Date Début', 'attribute' => 'date_debut', 'type' => 'datetime-local'],
                ['label' => 'Date Fin', 'attribute' => 'date_fin', 'type' => 'datetime-local']
            ];
        
            // Appel de la fonction qui affiche le formulaire d'ajout
            $controller->display_AjouterForm(
                $fields, 
                '../admin/ajouter_news_post', 
                'News_controller', 
                'ajouter_news_controller',
                'public/image/news',
                '../admin/dash_news',
                'Ajouter News'
            );
        
            // Affichage du footer
            $footer = new Footer_controller();
            $footer->display_footer();
        
            echo '</body>';
        }
        public function ajouter_news() {
            session_start();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titre = $_POST['titre'] ?? null;
                $description = $_POST['description'] ?? null;
                $type = $_POST['type'] ?? null;
                $date_debut = $_POST['date_debut'] ?? null;
                $date_fin = $_POST['date_fin'] ?? null;
        
                $imageFile = $_FILES['image'] ?? null;
                $imagePath = null;
        
                $uploadDir = 'public/image/news/';
                try {
                    if (isset($imageFile) && $imageFile['error'] === UPLOAD_ERR_OK) {
                        $imagePath = file_controller::chargerFile($imageFile, $uploadDir);
                        $imagePath = $uploadDir . $imagePath;
                    }
                } catch (Exception $e) {
                    $_SESSION['errorsAjout'] = ["Erreur lors du téléchargement de l'image : " . $e->getMessage()];
                    // header('Location: ./ajoute_news');
                    // exit();
                }
        
                if ($titre && $description && $type && $date_debut && $date_fin) {
                    $this->ajouter_news_controller($titre, $description, $type, $date_debut, $date_fin, $imagePath);
                    header('Location: ../admin/dash_news');
                } else {
                    $_SESSION['errorsAjout'] = ["Tous les champs sont obligatoires."];
                    echo "Tous les champs sont obligatoires.";
                    header('Location: ./ajoute_news');
                    exit();
                }
            } else {
                $_SESSION['errorsAjout'] = ["Requête invalide."];
                header('Location: ./ajoute_news');
                exit();
            }
        }
        
    }
?>