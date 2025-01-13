<?php
class Ajouter_Dashbord_view {
    public function display_AjouterForm($fields, $action, $nomClass, $functionName,$pathFile,$rederection,$titrePage) {
        echo '<div class="modifier-section">';
        echo '<h2>'.$titrePage.'</h2>';
        echo '<form action="process_ajout.php" method="POST" enctype="multipart/form-data">';
        
        foreach ($fields as $field) {
            echo '<div class="form-group">';
            echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
            
            switch ($field['type']) {
                case 'image': 
                    echo '<img id="preview-' . htmlspecialchars($field['attribute']) . '" src="" alt="Prévisualisation de l\'image" style="display: none; margin-top: 10px; max-width: 100%; border: 1px solid #ddd; border-radius: 8px;">';
                    echo '<input type="file" name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" accept="image/*" onchange="previewImage(event, \'' . htmlspecialchars($field['attribute']) . '\')" required>';
                    echo '<button type="button" class="upload-button" onclick="document.getElementById(\'' . htmlspecialchars($field['attribute']) . '\').click()">Choisir une image</button>';
                    break;
                
                case 'file':
                    echo '<input type="file" name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" onchange="showFileName(event, \'' . htmlspecialchars($field['attribute']) . '\')" required>';
                    echo '<span id="file-name-' . htmlspecialchars($field['attribute']) . '" style="margin-left: 10px; font-style: italic; color: #555;"></span>';
                    break;
                
                case 'select':
                   
                    echo '<select name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" required>';
                    if (isset($field['options'])) {
                        foreach ($field['options'] as $option) {
                            $optionValue = htmlspecialchars($option[$field['att_option_return']] ?? '');
                            $optionLabel = htmlspecialchars($option[$field['att_option_affiche']] ?? '');
                    
                            echo '<option value="' . $optionValue . '">' . $optionLabel . '</option>';                        }
                    }
                    echo '</select>';
                    break;
                
                case 'textarea':
                    echo '<textarea name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" rows="4" required></textarea>';
                    break;

                case 'datetime-local':
                    echo '<input type="datetime-local" name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" value="' . htmlspecialchars($field['value'] ?? '') . '" required>';
                    break;

                default:
                    echo '<input type="' . htmlspecialchars($field['type'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" name="' . htmlspecialchars($field['attribute'] ?? '') . '" value="' . htmlspecialchars($field['value'] ?? '') . '" required>';
                    break;
            }
            echo '</div>';
        }
        
        echo '<div class="form-actions">';
        echo '<button type="button" id="action_button" 
                data-action="' . htmlspecialchars($action) . '" 
                data-nomclass="' . htmlspecialchars($nomClass) . '" 
                data-functionname="' . htmlspecialchars($functionName) . '"
                data-pathfile="' . htmlspecialchars($pathFile) . '">Enregistrer</button>';
        echo '<button type="button" onclick="window.location.href=\'' . $rederection . '\';">Annuler</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
    }
}
?>
