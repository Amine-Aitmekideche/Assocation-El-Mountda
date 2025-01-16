<?php
require_once __DIR__ . '/../Controller/Dashboard_Componant_controller.php';
require_once __DIR__ . '/../Controller/lien_controller.php';

class Dashboard_Componant_view{
    public function display_Dashbord($data, $fields, $actions,$classSuppName , $functionSuppName) {
        if (count($data) > 0) {
            // var_dump($data);
            echo '<div class="dashboard-section">';
            session_start();
            if (isset($_SESSION['errorsDelite']) && !empty($_SESSION['errorsDelite'])) {
                echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
                foreach ($_SESSION['errorsDelite'] as $error) {
                    echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . $error . '</p>';
                }
                echo '</div>';
                
                unset($_SESSION['errorsDelite']);
            }
            echo '<div class="dashboard">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            
            foreach ($fields as $field) {
                echo '<th>' . htmlspecialchars($field['label']) . '</th>';
            }
            
            echo '<th>Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            foreach ($data as $row) {
                foreach ($fields as $field) {
                    switch ($field['type']) {
                        case 'image':
                            if (!empty($row[$field['attribute']])) {
                                echo '<td><img src="' . htmlspecialchars(base_url($row[$field['attribute']])) . '" alt="Image" style="max-width: 100px; max-height: 100px;"/></td>';
                            } else {
                                echo '<td>Aucune image disponible</td>';
                            }
                            break;
    
                        case 'cle':
                            $className = $field['class'];
                            $methodName = $field['methode'];
                            $argValue = $row[$field['attribute']] ?? null;
                            if (!empty($className) && !empty($methodName)) {
                                $controller = new $className(); 
                                $result = $controller->$methodName($argValue);      
                                $displayValue = $result[0][$field['att_option_affiche']];
                                // echo  $result[0][$field['att_option_affiche']];
                                echo '<td>' . htmlspecialchars($displayValue) . '</td>';
                            } 
                            break;
    
                        default:
                            $textValue = $row[$field['attribute']] ?? '/';
                            echo '<td>' . htmlspecialchars($textValue) . '</td>';
                            break;
                    }
                }
                
            echo '<td>';
            foreach ($actions as $action) {
                if ($action['url'] === '#') { 
                    $data = $action['data'] ?? [];
                    $dataAttributes = '';
                    
                    foreach ($data as $key => $value) {
                        $dataAttributes .= ' data-' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
                    }
                    
                    $class = htmlspecialchars($action['class'] ?? '');
                    $id = htmlspecialchars($action['id'] ?? '');
                    $onclick = htmlspecialchars($action['onclick'] ?? '');
                    $label = htmlspecialchars($action['label'] ?? '');
                    
                    echo "<button class='{$class}' id='{$id}' onclick=\"{$onclick}\" {$dataAttributes} data-id=\"" . htmlspecialchars($row['id']) . "\">";
                    echo $label;
                    echo '</button>';
                } else {
                    // Actions avec URL dynamique
                    $url = str_replace('{id}', $row['id'], $action['url']); // Remplacement dynamique
                    $url = htmlspecialchars($url); // Sécuriser l'URL
                    $label = htmlspecialchars($action['label'] ?? '');
                    $class = htmlspecialchars($action['class'] ?? '');
                    $onclick = htmlspecialchars($action['onclick'] ?? '');
                    
                    // Bouton avec lien intégré
                    echo "<button class='{$class}' onclick=\"{$onclick}\">";
                    echo "<a href=\"{$url}\" style=\"color: inherit; text-decoration: none;\">{$label}</a>";
                    echo '</button>';
                }
            }
            
            
            
            
            echo '</td>';
            
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>Aucune donnée disponible pour ce tableau.</p>';
    }
}
}
?>