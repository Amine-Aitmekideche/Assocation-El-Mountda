<?php
require_once(__DIR__ . '/../Model/Demmande_carte_model.php');
require_once(__DIR__ . '/../View/Demmande_carte_view.php');
require_once 'menu_composant_controller.php';
require_once 'Footer_controller.php';
require_once 'Head_controller.php';
require_once 'User_controller.php';
require_once 'Dashboard_Componant_controller.php';
require_once 'file_controller.php';

class Demmande_carte_controller {
    public function get_all_cartes() {
        $model = new Carte_model();
        $cartes = $model->get_all_cartes();
        return $cartes;
    }

    public function get_all_noeffectue_demmandes() {
        $model = new Demmande_carte_model();
        $cartes = $model->get_all_noeffectue_demmandes();
        return $cartes;
    }
    public function get_demmande_by_id_controller($id) {
        $model = new Demmande_Carte_model();
        $carte = $model->get_demmande_by_id($id);
        return $carte;
    }

    public function get_demmande_by_userid_controller($id) {
        $model = new Demmande_Carte_model();
        $carte = $model->get_demmande_by_userid($id);
        print_r($carte);
        return $carte;
        header('Location: ../../partenaire');

    }

    public function ajouter_demmande_controller($user, $photo, $type, $date, $accepter) {
        $model = new Demmande_carte_model();
        $accepter = 0;
        $result = $model->ajouter_demmande($user, $photo, $type, $date, $accepter) ;

    }

    public function modifier_carte($id, $type, $description, $prix) {
        $model = new Carte_model();
        $result = $model->modifier_carte($id, $type, $description, $prix);

        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Modification de la carte réussie !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de la modification de la carte.',
            ];
        }
    }

    public function supprimer_carte($id) {
        $model = new Carte_model();
        $result = $model->supprimer_carte($id);

        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Suppression de la carte réussie !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de la suppression de la carte.',
            ];
        }
    }

    public function affiche_formulaire_demmande(){
        $controller = new Demmande_carte_view();
        $controller->affiche_formulaire_demmande();
    }
    public function demmande_membre_page() {
        $pageName = "ElMountada | Demande de Carte";
        $cssFiles = ['../public/style/variables.css', '../public/style/menu_user.css', '../public/style/demmande.css', '../public/style/footer.css'];
        $jsFiles = ["js/script.js"];
        $libraries = ['jquery', 'icons'];
    
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('membre');
    
        // Titre principal
        echo '<h1 class="page-title">Faire une Demande de Carte</h1>';
    
        $this->affiche_formulaire_demmande();
    
        
        echo '</body>';
    }

    public function demmande_post() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? null;
            $photoFile = $_FILES['photo'] ?? null;
            $photoPath = null;
            $controller = new User_controller();
            $userId = $controller->verify_cookie('user');
            $uploadDir = 'public/image/demmandes';
            
            try {
                if (isset($photoFile) && $photoFile['error'] === UPLOAD_ERR_OK) {
                    $photoPath = file_controller::chargerFile($photoFile, $uploadDir);
                    $photoPath = $uploadDir . $photoPath;
                }
            } catch (Exception $e) {
                $_SESSION['errorsdemmand'] = ["Erreur lors du téléchargement de la photo : " . $e->getMessage()];
                 header('Location: ../user/membre_transform');
                exit();
            }
    
            if ($type && $photoPath) {
                $date = date('Y-m-d'); 
                $accpter = 0; 
    
                $this->ajouter_demmande_controller($userId, $photoPath, $type, $date, $accpter);
                 header('Location: ../user');
                 exit();
            } else {
                $_SESSION['errorsdemmand'] = ["Tous les champs sont obligatoires."];
                header('Location: ../user/membre_transform');
                exit();
            }
        } else {
            $_SESSION['errorsdemmand'] = ["Requête invalide."];
            header('Location: ../user/membre_transform');
            exit();
        }
    }

    public function affiche_demmande_carte_page() {
        $pageName = "ElMountada | Dashboard des Demandes de Cartes";
        $cssFiles = [
            '../public/style/varaibles.css',
            '../public/style/dashbord_table.css',
            '../public/style/menu_left.css',
            '../public/style/footer.css'
        ];
        $jsFiles = ['../js/script.js'];
        $libraries = ['jquery', 'icons'];
    
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        echo '<h1>Dashboard des Demandes de Cartes</h1>';

        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('admin');  

        $fields = [
            ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
            ['label' => 'Utilisateur', 'attribute' => 'user', 'type' => 'cle', 'class'=> 'User_controller', 'methode' =>  'get_membre_by_id_controller', 'att_option_affiche' => 'nom', 'att_option_arg' => 'id'],
            ['label' => 'Type de Carte', 'attribute' => 'type', 'type' => 'text'],
            ['label' => 'Photo', 'attribute' => 'photo', 'type' => 'image'],
            ['label' => 'Date de Demande', 'attribute' => 'date', 'type' => 'date'],
        ];
    
        $actions = [
            [
                'label' => 'Accepter',
                'url' => '../admin/accepter_demmande/{id}', 
                'class' => 'btn-accept',
                'onclick' => "return confirm('Êtes-vous sûr de vouloir accepter cette demande ?');"
            ],
            [
                'label' => 'Refuser',
                'url' => '../admin/refuser_demmande/{id}', 
                'class' => 'btn-reject',
                'onclick' => "return confirm('Êtes-vous sûr de vouloir refuser cette demande ?');"
            ],
            [
                'label' => 'Voir plus',
                'url' => '../admin/details_demmande/{id}', 
                'class' => 'btn-view'
            ]
        ];
    
        // Controller pour récupérer et afficher les données des demandes de cartes
        $controller = new Dashboard_Componant_controller();
        $controller->affiche_Dashbord(
            'Demmande_carte_controller', 
            'get_all_noeffectue_demmandes', 
            $fields, 
            [], 
            $actions, 
            'Demmande_carte_controller', 
            'supprimer_demmande'
        );
    
        echo '</body>';
    }

    public function accepter_demmande($id_demmande) {
        session_start();
        
        if (isset($id_demmande) && is_numeric($id_demmande)) {
            $result = $this->modifier_statut_demmande($id_demmande, 1);
            
            if ($result) {
                $_SESSION['message'] = "La demande a été acceptée avec succès.";
                header('Location: ../../admin/dash_dev_membre');
                exit();
            } else {
                $_SESSION['errors'] = ["Une erreur est survenue lors de l'acceptation de la demande."];
                header('Location: ../../admin/dash_dev_membre');
                exit();
            }
        } else {
            $_SESSION['errors'] = ["ID de demande invalide."];
            header('Location: ../../admin/dash_dev_membre');
            exit();
        }
    }
    
    public function refuser_demmande($id_demmande) {
        session_start();
        
        if (isset($id_demmande) && is_numeric($id_demmande)) {
            $result = $this->modifier_statut_demmande($id_demmande, 2);
            
            if ($result) {
                $_SESSION['message'] = "La demande a été refusée avec succès.";
                header('Location: ../../admin/dash_dev_membre');
                exit();
            } else {
                $_SESSION['errors'] = ["Une erreur est survenue lors du refus de la demande."];
                header('Location: ../../admin/dash_dev_membre');
                exit();
            }
        } else {
            $_SESSION['errors'] = ["ID de demande invalide."];
            header('Location: ../../admin/dash_dev_membre');
            exit();
        }
    }
    
    function modifier_statut_demmande($id,$status){
        $controller = new Demmande_carte_model();
        $controller->changer_statut_demmande($id,$status);
    }   
    public function affiche_details_demmande_page($id) {
        // Configuration de la page
        $pageName = "ElMountada | Détails demmande";
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
            ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
            ['label' => 'Utilisateur', 'attribute' => 'user', 'type' => 'cle', 'class'=> 'User_controller', 'methode' =>  'get_membre_by_id_controller', 'att_option_affiche' => 'nom', 'att_option_arg' => 'id'],
            ['label' => 'Type de Carte', 'attribute' => 'type', 'type' => 'text'],
            ['label' => 'Photo', 'attribute' => 'photo', 'type' => 'image'],
            ['label' => 'Date de Demande', 'attribute' => 'date', 'type' => 'date'],
        ];

    
        $controller = new Dashboard_Componant_controller();
        $controller->display_DetailView(
            'Demmande_carte_controller', 
            'get_demmande_by_id_controller',
            $fields,
            [$id],
            'Détails des demmandes'
        );
    
        $footer = new Footer_controller();
        $footer->display_footer();
    
        echo '</body>';
    }


}
?>
