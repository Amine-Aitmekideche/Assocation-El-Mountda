<?php
require_once __DIR__ . '/../Controller/Dashboard_Componant_controller.php';
require_once __DIR__ . '/../Controller/lien_controller.php';

class Dashboard_Componant_view{
    public function display_Dashbord($data, $fields, $actions,$classSuppName , $functionSuppName) {
        if (count($data) > 0) {
            echo '<div class="dashboard-section">';
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
                            // Affichage d'un texte simple
                            $textValue = $row[$field['attribute']] ?? '';
                            echo '<td>' . htmlspecialchars($textValue) . '</td>';
                            break;
                    }
                }
                
            echo '<td>';
            foreach ($actions as $action) {
                if ($action['url'] === '#') {
                    $data = $action['data']; 
                    $dataAttributes = '';
                    
                    foreach ($data as $key => $value) {
                        $dataAttributes .= ' data-' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
                    }
            
                    $class = htmlspecialchars($action['class']);
                    $id = htmlspecialchars($action['id']);
                    $onclick = htmlspecialchars($action['onclick']);
                    $label = htmlspecialchars($action['label']);

            
                    echo "<button class='{$class}' id='{$id}' onclick=\"{$onclick}\" {$dataAttributes} data-id=\"" . htmlspecialchars($row['id']) . "\">";
                    echo $label;
                    echo '</button>';
                } else {
                    $url = str_replace('{id}', $row['id'], $action['url']);
                    $url = base_url($url); 
                    $label = htmlspecialchars($action['label']);
                    $class = htmlspecialchars($action['class'] ?? '');
                    $onclick = htmlspecialchars($action['onclick'] ?? '');
            
                    echo "<button class='{$class}' onclick=\"{$onclick}\">";
                    echo "<a href=\"{$url}\">{$label}</a>";
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