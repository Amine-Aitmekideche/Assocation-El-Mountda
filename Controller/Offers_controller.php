<?php
require_once(__DIR__ . '/../Model/Offers_model.php');
require_once(__DIR__ . '/../View/Offers_view.php');
require_once 'menu_composant_controller.php';
require_once 'Footer_controller.php';
require_once 'Head_controller.php';
class Offers_controller {

    public function get_Offres_controller() {
        $model = new Offres_model();
        $offres = $model->get_Offres_model();
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
    
}

?>