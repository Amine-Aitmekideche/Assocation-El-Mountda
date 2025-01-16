<?php
require_once __DIR__ . '/../Model/Carte_model.php';
require_once(__DIR__ . '/../View/Carte_view.php');
require_once(__DIR__ . '/../Controller/file_controller.php');
require_once 'menu_composant_controller.php';
require_once 'Offers_controller.php';
require_once 'Footer_controller.php';
require_once 'Head_controller.php';
require_once 'Dashboard_Componant_controller.php';
require_once 'User_controller.php';
class Carte_controller {
    public function get_all_cartes() {
        $model = new Carte_model();
        $cartes = $model->get_all_cartes();
        return $cartes;
    }

    public function get_carte_by_id($id) {
        $model = new Carte_model();
        $carte = $model->get_carte_by_id($id);
        return $carte;
    }

    public function ajouter_carte($type, $description, $prix) {
        $model = new Carte_model();
        $result = $model->ajouter_carte($type, $description, $prix);

        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Ajout de la carte réussi !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de l\'ajout de la carte.',
            ];
        }
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

    public function affiche_cartes() {
        $v = new Carte_view();
        $v->affiche_page_cartes();
    }
    
    public function affiche_carte_page() {
        
            $pageName = "ElMountada | Cartes";
            $cssFiles = ['./public/style/variables.css', './public/style/menu_user.css', './public/style/carte.css', './public/style/footer.css'];
            $jsFiles = ["js/script.js"];
            $libraries = ['jquery', 'icons'];
        
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('user');
        
            echo '<h1 class="page-title">Liste des Cartes</h1>';
        
            $this->affiche_cartes();
        
            $footer = new Footer_controller();
            $footer->display_footer();
            echo '</body>';
        
    }


    public function affiche_offers_by_carte_page($carte) {
        
            $pageName = "ElMountada | Offres pour la carte : " . htmlspecialchars($carte);
            $cssFiles = ['../public/style/varaibles.css', '../public/style/menu_user.css', '../public/style/offer.css', '../public/style/footer.css'];
            $jsFiles = ["js/scrpt.js"];
            $libraries = ['jquery', 'icons'];
        
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('user');
            
            echo '<h1 class="page-title">Offres pour la carte : ' . htmlspecialchars($carte) . '</h1>';
        
            // Récupérer les offres pour la carte spécifiée
            $offresController = new Offers_controller();
            $offres = $offresController->display_offers_table_carte($carte); // Appeler la fonction pour récupérer les offres
        
            
            $menu = new Footer_controller();
            $menu->display_footer();
        
            echo '</body>';
        
    }
    
    
}
?>
