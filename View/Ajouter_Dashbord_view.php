<?php
class Ajouter_Dashbord_view {
    public function display_AjouterForm($fields, $action, $nomClass, $functionName, $pathFile, $rederection, $titrePage) {
        echo '<div class="modifier-section">';
        echo '<h2>'.$titrePage.'</h2>';
        echo '<form action="' . htmlspecialchars($action) . '" method="POST" enctype="multipart/form-data">';
        session_start();
        // Vérification si des erreurs sont présentes dans la session et affichage
        if (isset($_SESSION['errorsAjout']) && !empty($_SESSION['errorsAjout'])) {
            echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
            foreach ($_SESSION['errorsAjout'] as $error) {
                echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . $error . '</p>';
            }
            echo '</div>';
            
            // Une fois les erreurs affichées, les retirer de la session pour éviter les répétitions
            unset($_SESSION['errorsAjout']);
        }
    
        // Boucle pour générer les champs du formulaire
        foreach ($fields as $field) {
            echo '<div class="form-group">';
            echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
    
            switch ($field['type']) {
                case 'image': 
                    echo '<img id="preview-' . htmlspecialchars($field['attribute']) . '" src="" alt="Prévisualisation de l\'image" style="display: none; margin-top: 10px; max-width: 100%; border: 1px solid #ddd; border-radius: 8px;">';
                    echo '<input type="file" name="' . htmlspecialchars($field['attribute']) . '" id="' . htmlspecialchars($field['attribute']) . '" accept="image/*" onchange="previewImage(event, \'' . htmlspecialchars($field['attribute']) . '\')" >';
                    echo '<button type="button" class="upload-button" onclick="document.getElementById(\'' . htmlspecialchars($field['attribute']) . '\').click()">Choisir une image</button>';
                    break;
                
                case 'select':
                    echo '<select name="' . htmlspecialchars($field['attribute']) . '" id="' . htmlspecialchars($field['attribute']) . '" >';
                    if (isset($field['options'])) {
                        foreach ($field['options'] as $option) {
                            $optionValue = htmlspecialchars($option[$field['att_option_return']] ?? '');
                            $optionLabel = htmlspecialchars($option[$field['att_option_affiche']] ?? '');
                            echo '<option value="' . $optionValue . '">' . $optionLabel . '</option>';
                        }
                    }
                    echo '</select>';
                    break;
                
                case 'textarea':
                    echo '<textarea name="' . htmlspecialchars($field['attribute']) . '" id="' . htmlspecialchars($field['attribute']) . '" rows="4" ></textarea>';
                    break;
    
                case 'datetime-local':
                    echo '<input type="datetime-local" name="' . htmlspecialchars($field['attribute']) . '" id="' . htmlspecialchars($field['attribute']) . '" value="' . htmlspecialchars($field['value'] ?? '') . '" >';
                    break;
    
                default:
                    echo '<input type="' . htmlspecialchars($field['type']) . '" id="' . htmlspecialchars($field['attribute']) . '" name="' . htmlspecialchars($field['attribute']) . '" value="' . htmlspecialchars($field['value'] ?? '') . '" >';
                    break;
            }
            echo '</div>';
        }
    
        // Boutons du formulaire
        echo '<div class="form-actions">';
        echo '<button type="submit">Ajouter</button>';
        echo '<button type="button" onclick="window.location.href=\'' . $rederection . '\';">Annuler</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
        
    }
}
?>
