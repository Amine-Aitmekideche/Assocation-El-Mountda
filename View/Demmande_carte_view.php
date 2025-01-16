<?php
require_once __DIR__ . '/../Controller/Partenaire_controller.php';
require_once __DIR__ . '/../Controller/Carte_controller.php';

class Demmande_carte_view {


    public function affiche_formulaire_demmande() {
        echo '<div class="form-container">';

        session_start();
        if (isset($_SESSION['errorsdemmand'])) {
            echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
            foreach ($_SESSION['errorsdemmand'] as $error) {
                echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . $error . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errorsdemmand']);
        }
        $controleur = new Carte_controller();
        $types = $controleur->get_all_cartes();
        echo '<form method="POST" action="../user/demmande_post" enctype="multipart/form-data">';
        
        echo '<label for="type">Type de Carte :</label>';
        echo '<select id="type" name="type" required>';
        echo '<option value="">-- Sélectionnez un type --</option>';
        foreach ($types as $type) {
            echo '<option value="' . htmlspecialchars($type['type']) . '">' . htmlspecialchars($type['type']) . '</option>';
        }
        echo '</select>';

        echo '<label for="photo">Photo de la Carte :</label>';
        echo '<input type="file" id="photo" name="photo" accept="image/*" required>';
        
        echo '<button type="submit">Soumettre la Demande</button>';
        
        echo '</form>';
        echo '</div>';
    }

}
?>
