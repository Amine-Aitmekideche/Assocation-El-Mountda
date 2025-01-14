<?php
class Detail_Dashbord_view {
    public function display_DetailView($data, $fields, $titrePage) {
        if (!empty($data)) { 
            echo '<div class="detail-section">';
            echo '<h2>'.$titrePage.'</h2>';
            
           
            foreach ($fields as $field) {
                echo '<div class="form-group">';
                echo '<label for="' . htmlspecialchars($field['attribute'] ?? '') . '">' . htmlspecialchars($field['label'] ?? '') . ':</label>';
                
                $attribute = $field['attribute'] ?? '';
                $type = $field['type'] ?? 'text'; 
                $value = $data[0][$attribute] ?? ''; 
            
                if ($type === 'image') {
                    if (!empty($value)) {
                        echo '<div><img src="' . htmlspecialchars(base_url($value)) . '" alt="' . htmlspecialchars($field['label']) . '" class="preview-image" id="imagePreview"/></div>';
                    } else {
                        echo '<p>Aucune image disponible.</p>';
                    }
                } elseif ($type === 'file') {
                    if (!empty($value)) {
                        echo '<div><a href="' . htmlspecialchars(base_url($value)) . '" target="_blank" class="file-link">Télécharger le fichier</a></div>';
                    } else {
                        echo '<p>Aucun fichier disponible.</p>';
                    }
                } else {
                    echo '<p>' . htmlspecialchars_decode($value) . '</p>';
                }
                
                echo '</div>';
            }
            
            echo '<div class="form-actions">';
            echo '<button type="button" onclick="window.history.back()">Retour</button>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<p>Aucune donnée à afficher.</p>';
        }
    }
    
}
?>
