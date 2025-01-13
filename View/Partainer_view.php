<?php
require_once(__DIR__ . '/../Controller/Partenaire_controller.php');
require_once(__DIR__ . '/../Controller/Partenaire_categorie_controller.php');
require_once(__DIR__ . '/../Controller/Offers_controller.php');
require_once(__DIR__ . '/../Controller/lien_controller.php');



class Partenier_view{
    
    public function filter_partainers(){
        echo '<input type="text" name="searchInputpartainer" id="searchInputpartainer" placeholder="Rechercher...">';
    }

    public function tri_partainers($id, $text) {
        echo '<p>
                ' . htmlspecialchars($text) . ' :
                <select id="' . htmlspecialchars($id) . '" name="' . htmlspecialchars($id) . '">
                    <option value="non">Non</option>
                    <option value="ascendante">Ascendante</option>
                    <option value="descendante">Descendante</option>
                </select>
              </p>';
    }

    public function display_partenaires() {
        
        echo '<div class="partenaire-container">';
    
        try {
            $categorieController = new Partenaire_categorie_controller();
            $partenaireController = new Partenaire_controller();
            $offersController = new Offers_controller();
            $categories = $categorieController->get_Partenaire_category_controller();
    
            foreach ($categories as $categorie) {
                $offres = $partenaireController->get_Partenaires_by_category_controller($categorie['categorie']);
    
                if (count($offres) > 0) {
                    echo '<div class="partenaire-category">';
                    echo '<h2 class="category-title">' . htmlspecialchars($categorie['categorie']) . '</h2>';
                    echo '<div class="offres-items">';
    
                    foreach ($offres as $offre) {
                        $remises = $offersController->get_Offres_by_partenaire_controller($offre['id']) ;
                        echo '<div class="offre-item">';
                        echo '<div>';
                        if (!empty($offre['logo'])) {
                            echo '<img class="partenaire-logo" src="' . htmlspecialchars(base_url($offre['logo'])) . '" alt="Logo de ' . htmlspecialchars($offre['nom']) . '">';
                        }
                        echo '<h3 class="partenaire-name">' . htmlspecialchars($offre['nom']) . '</h3>';
                        echo '<div class="partenaire-offre">';
                        echo '<h3 class="partenaire-willaya">' . htmlspecialchars($offre['willya']) . '</h3>';
                        echo '<div>';
                        foreach ($remises as $remise)echo '<span class="partenaire-reduction">' . htmlspecialchars($remise['reduction']) . '%</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<button><a href="partiener/' . htmlspecialchars($offre['id']) . '">Détails</a></button>';
                        echo '</div>';
                    }
    
                    echo '</div>';
                    
                    echo '</div>';
                } 
            }
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    
        echo '</div>';
    }

    public function display_partenaire_details($id) {
        try {
            $partenaireController = new Partenaire_controller();
            $offersController = new Offers_controller();
    
            $partenaire = $partenaireController->get_Partenaire_by_id_controller($id);
            $remises = $offersController->get_Offres_by_partenaire_controller($id);
    
            echo '<div class="partenaire-details">';
    
            echo '<h1>' . htmlspecialchars($partenaire[0]['nom']) . '</h1>';
    
            if (!empty($partenaire[0]['logo'])) {
                echo '<img src="' . htmlspecialchars(base_url($partenaire[0]['logo'])) . '" alt="Logo de ' . htmlspecialchars($partenaire[0]['nom']) . '" class="partenaire-logo">';
            }
    
            echo '<p><strong>Ville:</strong> ' . htmlspecialchars($partenaire[0]['willya']) . '</p>';
            echo '<p><strong>Adresse:</strong> ' . htmlspecialchars($partenaire[0]['adresse']) . '</p>';
            echo '<p><strong>Catégorie:</strong> ' . htmlspecialchars($partenaire[0]['categorie']) . '</p>';
            echo '<p><strong>Date d\'ajout:</strong> ' . htmlspecialchars($partenaire[0]['date_ajouter']) . '</p>';

            if (!empty($partenaire[0]['description'])) {
                echo '<p><strong>Description:</strong> ' . htmlspecialchars($partenaire[0]['description']) . '</p>';
            } else {
                echo '<p><strong>Description:</strong> Non spécifiée.</p>';
            }
            echo '<h3>Offres disponibles</h3>';
            $offersView = new Offers_controller();
            $offersView->display_offers_table($id); 

        echo '</div>';
    
            echo '</div>';
        } catch (Exception $e) {
            echo '<p>Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }

    public function display_logs_diaporama() {
        echo '<div class="partenaire-logo-container">';
        
        try {
            $partenaireController = new Partenaire_controller();
            $partenaire = $partenaireController->get_Partenaire_controller();
        
            echo '<div class="diaporama_logo">';
            echo '<div class="container-logo">';
        
            for ($i = 0; $i < count($partenaire); $i++) {
                $article = $partenaire[$i];
                echo '<img src="' . htmlspecialchars($article['logo']) . '" alt="Logo Partenaire" title="' . htmlspecialchars($article['nom']) . '" />';
            }
        
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }        
    
    
}



?>