<?php
require_once __DIR__ . '/../Controller/Carte_controller.php';

class Carte_view {
    public function affiche_page_cartes() {
        echo '<div class="cartes-container">';
        
        try {
            $cartesController = new Carte_controller(); 
            $cartes = $cartesController->get_all_cartes(); 
    
            if (count($cartes) > 0) {
                foreach ($cartes as $carte) {
                    echo '<div class="carte-item">';
                    echo '<h3 class="carte-type">' . htmlspecialchars($carte['type']) . '</h3>';
                    echo '<p class="carte-description">' . htmlspecialchars($carte['description']) . '</p>';
                    echo '<p class="carte-prix">Prix : ' . htmlspecialchars($carte['prix']) . ' DA</p>';
                    echo '<button class="details-button"><a href="carte/' . htmlspecialchars($carte['type']) . '">Détails</a></button>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-cartes-message">Aucune carte disponible pour le moment.</p>';
            }
    
            // Ajouter un bouton "Obtenir l'offre" après toutes les cartes
            echo '<div class="offer-button-container">';
            echo '<button class="offer-button"><a href="./user/membre_transform">Demmande un offre</a></button>';
            echo '</div>';
    
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    
        echo '</div>';
    }
    
    
}
?>