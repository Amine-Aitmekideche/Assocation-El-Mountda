<?php

require_once __DIR__ . '/../Controller/News_controller.php';
require_once __DIR__ . '/../Controller/Partenaire_controller.php';
require_once __DIR__ . '/../Controller/Offers_controller.php';
require_once __DIR__ . '/../Controller/menu_composant_controller.php';
require_once __DIR__ . '/../Controller/Head_controller.php';
require_once __DIR__ . '/../Controller/Footer_controller.php';

class Home_controller {
    public function affiche_home_page() {
        $pageName = "ElMountada | Accueil";
        $cssFiles = [
            './public/style/varaibles.css',
            './public/style/menu_user.css',
            './public/style/home.css',
            './public/style/news.css',
            './public/style/footer.css'
        ];
        $jsFiles = [];
        $libraries = ['icons']; 

        // Afficher le head
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);

        // Afficher le menu
        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('user');

        // Afficher le diaporama de news
        $newsController = new News_controller();
        $newsController->display_news_diaporama();

        // Section "Annonces et événements"
        echo '<h1>Annonces et événements</h1>';
        $newsController->display_home_news();

        // Section "Avantages"
        echo '<h1>Avantages</h1>';
        $offersController = new Offers_controller();
        $offersController->display_all_offers_table_home();

        // Section "Nos Partenaires"
        echo '<h1>Nos Partenaires</h1>';
        $partenaireController = new Partenaire_controller();
        $partenaireController->display_logs_diaporama();
      
        // Afficher le pied de page
        $footer = new Footer_controller();
        $footer->display_footer();
        echo '</body>';
    }
}
