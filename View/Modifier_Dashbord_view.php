<?php
require_once(__DIR__ . '/../Controller/lien_controller.php');

class Modifier_Dashbord_view {
    public function display_ModifierForm($data, $fields, $action, $nomClass, $functionName,$pathFile, $rederection, $titrePage) {
        
        if (!empty($data)) {
            echo '<div class="modifier-section">';
            echo '<h2>'.$titrePage.'</h2>';
            session_start();
            if (isset($_SESSION['errorsModifier']) && !empty($_SESSION['errorsModifier'])) {
                echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
                foreach ($_SESSION['errorsModifier'] as $error) {
                    echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';

                unset($_SESSION['errorsModifier']);
            }

            echo '<form action="' . htmlspecialchars($action) . '" method="POST" enctype="multipart/form-data">';
            
            foreach ($fields as $field) {
                echo '<div class="form-group">';
                
                switch ($field['type']) {
                    case 'id':
                        echo '<input type="hidden" name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" value="' . htmlspecialchars($data[0][$field['attribute']] ?? '') . '">';
                        break;

                    case 'image':
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        if (!empty($data[0][$field['attribute']])) {
                            echo '<div><img  src="' . htmlspecialchars(base_url($data[0][$field['attribute']]) ?? '') . '" 
                                 alt="Image actuelle" class="preview-image" id="preview-' . htmlspecialchars($field['attribute']) . '" 
                                 style="max-width: 100%; border: 1px solid #ddd; border-radius: 8px; margin-top: 10px;"></div>';
                        } else {
                            echo '<div><img id="preview-' . htmlspecialchars($field['attribute']) . '" 
                                 alt="Prévisualisation de l\'image" style="display: none; max-width: 100%; border: 1px solid #ddd; border-radius: 8px; margin-top: 10px;"></div>';
                        }
                    
                        echo '<input type="file" name="image" 
                              id="' . htmlspecialchars($field['attribute']) . '" accept="image/*" 
                              onchange="previewImage(event, \'' . htmlspecialchars($field['attribute']) . '\')">';
                    
                        echo '<button type="button" class="upload-button" 
                              onclick="document.getElementById(\'' . htmlspecialchars($field['attribute']) . '\').click()">Choisir une image</button>';
                        break;
                    
                    case 'file':
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        echo '<input type="file" name="' . htmlspecialchars($field['attribute'] ?? '') . '" 
                              id="' . htmlspecialchars($field['attribute']) . '" 
                              onchange="showFileName(event, \'' . htmlspecialchars($field['attribute']) . '\')">';
                        
                        echo '<span id="file-name-' . htmlspecialchars($field['attribute']) . '" 
                              style="margin-left: 10px; font-style: italic; color: #555;">Aucun fichier sélectionné</span>';
                        break;
                    

                    case 'textarea':
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        echo '<textarea name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" rows="4" >' . htmlspecialchars($data[0][$field['attribute']] ?? '') . '</textarea>';
                        break;

                    case 'date':
                    case 'datetime-local':
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        echo '<input type="' . htmlspecialchars($field['type'] ?? '') . '" name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" value="' . htmlspecialchars($data[0][$field['attribute']] ?? '') . '" >';
                        break;

                    case 'select':
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        echo '<select name="' . htmlspecialchars($field['attribute'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" >';
                        
                        if (isset($field['options'])) {
                            $optionDisplay = $field['att_option_affiche'] ?? null;
                            $optionValue = $field['att_option_return'] ?? null;
                            foreach ($field['options'] as $option) {
                                if (isset($option[$optionDisplay]) && isset($option[$optionValue])) {
                                    $selected = ($data[0][$field['attribute']] == $option[$optionValue]) ? ' selected' : '';
                                    echo '<option value="' . htmlspecialchars($option[$optionValue]) . '"' . $selected . '>';
                                    echo htmlspecialchars($option[$optionDisplay]);
                                    echo '</option>';
                                } 
                            }
                            echo '</select>';
                        } else {
                            echo '<!-- Erreur : Aucune option disponible -->';
                        }
                    break;

                    case 'password':
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        echo '<input type="' . htmlspecialchars($field['type'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" name="' . htmlspecialchars($field['attribute'] ?? '') . '" >';
                     break;

                    default:
                        echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                        echo '<input type="' . htmlspecialchars($field['type'] ?? '') . '" id="' . htmlspecialchars($field['attribute'] ?? '') . '" name="' . htmlspecialchars($field['attribute'] ?? '') . '" value="' . htmlspecialchars($data[0][$field['attribute']] ?? '') . '" >';
                        break;
                }
                
                echo '</div>';
            }
            
            echo '<div class="form-actions">';
            echo '<button type="submit">Enregistrer</button>';

            echo '<button type="button" onclick="window.location.href=\'' . $rederection . '\';">Annuler</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<p>Erreur : aucune donnée à modifier.</p>';
        }
    }
}
?>

