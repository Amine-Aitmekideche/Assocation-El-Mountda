<?php
    require_once(__DIR__ . '/../Model/News_type_model.php');
    require_once(__DIR__ . '/../View/News_view.php');
    require_once 'menu_composant_controller.php';
    require_once 'Footer_controller.php';
    require_once 'Head_controller.php';
    require_once 'Dashboard_Componant_controller.php';
    
    class News_type_controller{
        public function get_News_type_controller(){
            $mtf= new News_type_model();
            $r=$mtf->get_News_type_model();
            return $r;
        }

        public function get_News_type_id_controller($id){
            $mtf= new News_type_model();
            $r=$mtf->get_News_type_id_model($id);
            return $r;
        }
        public function ajouter_type_controller($type, $description) {
            $type_model = new News_type_model();
            $result = $type_model->ajouter_type($type, $description);
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Ajout type News réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de l\'ajout de type news.',
                ];
            }
        }
    
        public function modifier_type_controller($id, $type, $description) {
            $type_model = new News_type_model();
            $result = $type_model->modifier_type($id, $type, $description);
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Modification type News réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de la modification de type news.',
                ];
            }
        }
    
        public function supprimer_type_controller($id) {
            $type_model = new News_type_model();
            $result = $type_model->supprimer_type($id);
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

        public function affiche_type_news(){
            $v= new News_view();
            $r=$v->display_news();
        }

        public function affiche_type_new_page(){
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
            $jsFiles = [];
            $libraries = ['jquery', 'icons'];
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);

            echo '<h1>News Types Dashboard</h1>';

            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');

            $controller = new Dashboard_Componant_controller();
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Type', 'attribute' => 'type', 'type' => 'text'],
                ['label' => 'Description', 'attribute' => 'description', 'type' => 'text'],
            ];
            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_type_news/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Supprimer',
                    'url' => './user',
                    // 'class' => 'btn-delete',
                    // 'id' => 'action_button',
                    // 'onclick' => '',
                    // 'data' => [
                    //     'action' => 'supprimer',
                    //     'nomclass' => 'News_type_controller',
                    //     'functionname' => 'supprimer_type_controller',
                    //     'pathfile' => ''
                    // ],
                ],
            ];
            echo 'jjjjj';
            $controller->affiche_Dashbord('News_Type_controller', 'get_News_type_controller', $fields, [], $actions, 'News_Type_controller', 'supprimer_news_controller');

            echo '</body>';
        }
        // public function affiche_type_news_page() {
        //     // $userController = new User_controller();
        //     // $userId = $userController->verify_cookie('admin'); 
        //     // if ($userId !== null) {
        //         $pageName = "ElMountada | News Dashboard";
        //         $cssFiles = [
        //             '../public/style/varaibles.css',
        //             '../public/style/dashbord_table.css',
        //             '../public/style/menu_left.css',
        //             '../public/style/Footer.css'
        //         ];
        //         $jsFiles = ['../js/scrpt.js'];
        //         $libraries = ['jquery','icons']; 
        //         $headController = new Head_controller();
        //         $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        //     echo '<h1>News Types Dashboard</h1>';

        //     $menu = new menu_composant_controller();
        //     $menu->display_menu_by_role('admin');
        //     $controller = new Dashboard_Componant_controller();
        //     $fields = [
        //         ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
        //         ['label' => 'Type', 'attribute' => 'type', 'type' => 'text'],
        //         ['label' => 'Description', 'attribute' => 'description', 'type' => 'text'],
        //     ];
        //     $actions = [
        //         [
        //             'label' => 'Modifier',
        //             'url' => '../admin/modifier_type_news/{id}', 
        //             'class' => 'btn-edit'
        //         ],
        //         [
        //             'label' => 'Supprimer',
        //             'url' => '#', 
        //             'class' => 'btn-delete',
        //             'id' => 'action_button',
        //             'onclick' => '', 
        //             'data' => [ 
        //                 'action' => 'supprimer',
        //                 'nomclass' => 'News_type_controller',
        //                 'functionname' => 'supprimer_type_controller',
        //                 'pathfile' => ''
        //             ],
        //         ],
        //     ];

        //     $controller->affiche_Dashbord('News_Type_controller', 'get_News_type_controller', $fields, [], $actions, 'News_Type_controller', 'supprimer_news_controller');


        //     echo '</body>';


        // }
    }
?>