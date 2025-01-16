<?php
require_once(__DIR__ . '/../Model/Offers_model.php');
require_once(__DIR__ . '/../View/Offers_view.php');
require_once __DIR__ . '/../Controller/file_controller.php';
require_once 'menu_composant_controller.php';
require_once 'Footer_controller.php';
require_once 'Head_controller.php';
class Offers_controller {

    public function get_Offres_controller() {
        $model = new Offres_model();
        $offres = $model->get_Offres_model();
        return $offres;
    }
    public function get_Offre_by_id_controller($id) {
        $model = new Offres_model();
        $offres = $model->get_Offre_by_id_model($id);
        return $offres;
    }
    public function get_Offres_by_partenaire_controller($partenaire_id) {
        $model = new Offres_model();
        $offres = $model->get_Offres_by_partenaire_model($partenaire_id);
        return $offres;
    }
    public function display_offers_table($partenaireId) {
        $offersView = new Offers_view();
        $offers =  $offersView->display_offers_table($partenaireId);
        return $offers;
    }

    public function display_all_offers_table($limite) {
        $offersView = new Offers_view();
        $offers =  $offersView->display_all_offers_table($limite);
        return $offers;
    }
    public function display_all_offers_table_home(){
        $v= new Offers_view();
        $r=$v->display_all_offers_table_home();
    }

    public function display_offers_page() {
        
        


        $pageName = "ElMountada | Offers Avantages";
         $cssFiles = ['./public/style/varaibles.css', './public/style/menu_user.css','./public/style/offer.css','./public/style/composant.css', './public/style/footer.css'];
         $jsFiles = [];
         $libraries = ['icons']; 
         $headController = new Head_controller();
         $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
         
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('user');
            echo '<h3>Découvrez Nos Offres Spéciales et Remises Exceptionnelles</h3>';
            $this->display_all_offers_table(true); 
            echo '<h3>Nos Offres et Avantages Partenaires</h3>';
            $this->display_all_offers_table(false); 
            $menu = new Footer_controller();
            $menu->display_footer();
            echo '</body>';
    }

    public function affiche_offres_dashbord_page() {
        // $userController = new User_controller();
        // $userId = $userController->verify_cookie('admin'); 
        // if ($userId !== null) {
            $pageName = "ElMountada | Offres Dashboard";
            $cssFiles = [
                '../public/style/varaibles.css',
                '../public/style/dashbord_table.css',
                '../public/style/menu_left.css',
                '../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
            echo '<h1>Offres Dashboard</h1>';
    
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
    
            $controller = new Dashboard_Componant_controller();
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Partenaire', 'attribute' => 'partainer', 'type' => 'cle', 'class'=> 'Partenaire_controller', 'methode' =>  'get_Partenaire_by_id_controller', 'att_option_affiche' => 'nom', 'att_option_arg' => 'id'],
                ['label' => 'Carte', 'attribute' => 'carte', 'type' => 'text'],
                ['label' => 'Réduction', 'attribute' => 'reduction', 'type' => 'text'],
                ['label' => 'Avantage', 'attribute' => 'avantage', 'type' => 'text'],
                ['label' => 'Date de fin', 'attribute' => 'date_fin', 'type' => 'date'],
            ];
    
            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_offre/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Voir plus',
                    'url' => '../admin/details_offre/{id}',
                    'class' => 'btn-view'
                ],
                [
                    'label' => 'Supprimer',
                    'url' => '../admin/supprime_offre_post/{id}',
                    'onclick' => "return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');"
                ],
            ];
    
            $controller->affiche_Dashbord(
                'Offers_controller',
                'get_Offres_controller',
                $fields,
                [],
                $actions,
                'Offers_controller',
                'supprimer_offre_controller'
            );
    
            $footer = new Footer_controller();
            $footer->display_footer();
    
            echo '</body>';
        // }
    }
    public function affiche_offre_details_page($id) {
        $pageName = "ElMountada | Détails Offre";
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
            ['label' => 'Partenaire', 'attribute' => 'partainer', 'type' => 'cle', 'class'=> 'Partenaire_controller', 'methode' =>  'get_Partenaire_by_id_controller', 'att_option_affiche' => 'nom', 'att_option_arg' => 'partainer'],
            ['label' => 'Carte', 'attribute' => 'carte', 'type' => 'text'],
            ['label' => 'Réduction', 'attribute' => 'reduction', 'type' => 'text'],
            ['label' => 'Date de fin', 'attribute' => 'date_fin', 'type' => 'date'],
            ['label' => 'Avantage', 'attribute' => 'avantage', 'type' => 'text'],
        ];
    
        $controller = new Dashboard_Componant_controller();
        $controller->display_DetailView(
            'Offers_controller',
            'get_Offre_by_id_controller',
            $fields,
            [$id],
            'Détails de l\'Offre'
        );
    
        $footer = new Footer_controller();
        $footer->display_footer();
    
        echo '</body>';
    }
    public function affiche_offre_ajouter_page() {
        $pageName = "ElMountada | Ajouter Offre";
        $cssFiles = [
            '../public/style/varaibles.css',
            '../public/style/dashbord_ajouter.css',
            '../public/style/menu_left.css'
        ];
        $jsFiles = ['../js/scrpt.js'];
        $libraries = ['jquery', 'icons'];
    
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('admin');
    
        $controller = new Dashboard_Componant_controller();
    
        $fields = [
            [
                'label' => 'Partenaire', 
                'attribute' => 'partainer', 
                'type' => 'select',
                'options' => $controller->construire_Dashboard('Partenaire_controller', 'get_Partenaire_controller', [], []), 
                'att_option_affiche' => 'nom', 
                'att_option_return' => 'id'
            ],
            [
                'label' => 'Carte', 
                'attribute' => 'carte', 
                'type' => 'select',
                'options' => $controller->construire_Dashboard('Carte_controller', 'get_all_cartes', [], []), 
                'att_option_affiche' => 'type', 
                'att_option_return' => 'type'
            ],
            ['label' => 'Réduction', 'attribute' => 'reduction', 'type' => 'numbre'],
            ['label' => 'Date de fin', 'attribute' => 'date_fin', 'type' => 'datetime-local'],
            ['label' => 'Avantage', 'attribute' => 'avantage', 'type' => 'textarea'],
        ];
    
        $controller->display_AjouterForm(
            $fields,
            '../admin/ajouter_offre_post',
            'Offre_controller',
            'ajouter_offre_controller',
            null, // Pas de fichier image pour les offres
            '../admin/dash_offers',
            'Ajouter Offre'
        );
    
        echo '</body>';
    }

    public function ajouter_offre_controller($partainer, $carte, $reduction, $date_fin, $avantage) {
        $controller = new Offres_model();
        $controller->ajouter_offre_model($partainer, $carte, $reduction, $date_fin, $avantage);
    }
    public function ajouter_offre() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $partainer = $_POST['partainer'] ?? null;
            $carte = $_POST['carte'] ?? null;
            $reduction = $_POST['reduction'] ?? 0;
            $reduction = !empty($_POST['reduction']) ? $_POST['reduction'] : 0;
            $date_fin = $_POST['date_fin'] ?? null;
            $avantage = !empty($_POST['avantage']) ? $_POST['avantage'] : '/';
            if (empty($_POST['reduction']) && empty($_POST['avantage'])) {
                $_SESSION['errorsAjout'] = ["Au moins l'un des champs 'Réduction' ou 'Avantage' doit être renseigné."];
                header('Location: ../admin/ajouter_offre');
                exit();
            }
            if (!filter_var($reduction, FILTER_VALIDATE_FLOAT)) {
                $_SESSION['errorsAjout'] = ["La réduction doit être un nombre décimal."];
                header('Location: ../admin/ajouter_offre');
                exit();
            }
            echo "Partenaire: $partainer, Carte: $carte, Réduction: $reduction, Date de fin: $date_fin, Avantage: $avantage";
            if ($partainer && $carte && $reduction && $avantage) {
                try {
                    $this->ajouter_offre_controller($partainer, $carte, $reduction, $date_fin, $avantage);
                    $_SESSION['successAjout'] = "L'offre a été ajoutée avec succès.";
                    header('Location: ../admin/dash_offers');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['errorsAjout'] = ["Erreur lors de l'ajout de l'offre : " . $e->getMessage()];
                    header('Location: ../admin/ajouter_offre');
                    exit();
                }
            } else {
                $_SESSION['errorsAjout'] = ["Tous les champs sont obligatoires."];
                header('Location: ../admin/ajouter_offre');
                exit();
            }
        } else {
            $_SESSION['errorsAjout'] = ["Requête invalide."];
            header('Location: ../admin/ajouter_offre');
            exit();
        }
    }


    public function affiche_offre_modifier_page($id) {
        $pageName = "ElMountada | Modifier Offre";
        $cssFiles = [
            '../../public/style/varaibles.css',
            '../../public/style/dashbord_modifier.css',
            '../../public/style/footer.css'
        ];
        $jsFiles = ['../../js/scrpt.js'];
        $libraries = ['jquery', 'icons'];
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $controller = new Dashboard_Componant_controller();
    
        $fields = [
            ['label' => 'ID', 'attribute' => 'id', 'type' => 'id'],
            [
                'label' => 'Partenaire', 
                'attribute' => 'partainer', 
                'type' => 'select',
                'options' => $controller->construire_Dashboard('Partenaire_controller', 'get_Partenaire_controller', [], []), 
                'att_option_affiche' => 'nom', 
                'att_option_return' => 'id'
            ],
            [
                'label' => 'Carte', 
                'attribute' => 'carte', 
                'type' => 'select',
                'options' => $controller->construire_Dashboard('Carte_controller', 'get_all_cartes', [], []), 
                'att_option_affiche' => 'type', 
                'att_option_return' => 'type'
            ],
            ['label' => 'Réduction', 'attribute' => 'reduction', 'type' => 'numbre'],
            ['label' => 'Date de fin', 'attribute' => 'date_fin', 'type' => 'datetime-local'],
            ['label' => 'Avantage', 'attribute' => 'avantage', 'type' => 'textarea'],
        ];
    
        $controller->display_ModifierForm(
            'Offers_controller',
            'get_Offre_by_id_controller',
            $fields,
            [$id],
            '../../admin/modifier_offre_post',
            'Offers_controller',
            'modifier_offre_controller',
            null, // Pas de fichier image pour les offres
            '../../admin/dash_offres',
            'Modifier Offre'
        );
    
        echo '</body>';
    }
    public function modifier_offre_controller($id,$partainer, $carte, $reduction, $date_fin, $avantage) {
        $controller = new Offres_model();
        $controller->modifier_offre_model($id,$partainer, $carte, $reduction, $date_fin, $avantage);
    }
    public function modifier_offre() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $partainer = $_POST['partainer'] ?? null;
            $carte = $_POST['carte'] ?? null;
            $reduction = $_POST['reduction'] ?? 0;
            $reduction = !empty($_POST['reduction']) ? $_POST['reduction'] : 0;
            $date_fin = $_POST['date_fin'] ?? null;
            $avantage = !empty($_POST['avantage']) ? $_POST['avantage'] : '/';
            if (empty($_POST['reduction']) && empty($_POST['avantage'])) {
                $_SESSION['errorsModifier'] = ["Au moins l'un des champs 'Réduction' ou 'Avantage' doit être renseigné."];
                header('Location: ../admin/modifier_offre/'.$id);
                exit();
            }
            if (!filter_var($reduction, FILTER_VALIDATE_FLOAT)) {
                $_SESSION['errorsModifier'] = ["La réduction doit être un nombre décimal."];
                header('Location: ../admin/modifier_offre/'.$id);
                exit();
            }
    
            if (!$id || !$partainer || !$carte ) {
                $_SESSION['errorsModifier'] = ["il existe des champs obligatoires doivent être renseignés."];
                header('Location: ../../admin/modifier_offre/' . $id);
                exit();
            }
    

            try {
                $this->modifier_offre_controller($id, $partainer, $carte, $reduction, $date_fin, $avantage);
    
                $_SESSION['successModifier'] = "L'offre a été modifiée avec succès.";
                header('Location: ../admin/dash_offers');
                exit();
            } catch (Exception $e) {
                // Gérer les erreurs
                $_SESSION['errorsModifier'] = ["Erreur lors de la modification de l'offre : " . $e->getMessage()];
                header('Location: ../../admin/modifier_offre/' . $id);
                exit();
            }
        } else {
            // Si la méthode HTTP n'est pas POST
            $_SESSION['errorsModifier'] = ["Requête invalide."];
            header('Location: ../../admin/modifier_offre/' . $id);
            exit();
        }
    }
    public function supprimer_offre_controller($id) {
        $model = new Offres_model();
        return $model->supprimer_offre_model($id);
    }
    public function supprimer_offre($id) {
        session_start();
        if ($id) {
            try {
                $result = $this->supprimer_offre_controller($id);
                if ($result) {
                    $_SESSION['successDelite'] = "L'offre a été supprimée avec succès.";
                } else {
                    $_SESSION['errorsDelite'] = ["Erreur lors de la suppression de l'offre."];
                }
    
                header('Location: ../dash_offers');
                exit();
    
            } catch (Exception $e) {
                $_SESSION['errorsDelite'] = [$e->getMessage()];
                header('Location: ../dash_offers');
                exit();
            }
        } else {
            $_SESSION['errorsDelite'] = ["L'ID de l'offre est manquant."];
            header('Location: ../dash_offers');
            exit();
        }
    }

    public function get_Offres_by_carte_controller($carte) {
        $controller = new Offres_model();
        return $controller->get_Offres_by_carte_model($carte);
    }
    public function display_offers_table_carte($carte) {
        $controller = new Offers_view();
        $controller->display_offers_table_carte($carte);
    }
    
    
}

?>