<?php
require_once(__DIR__ . '/menu_composant_controller.php');

class Router {
    private $routes = [];

    public function addRoute($url, $file, $method) {
        $urlRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $url);
        $urlRegex = '#^' . $urlRegex . '$#'; 
        $this->routes[$urlRegex] = ['file' => $file, 'method' => $method];
    }

    public function run() {
        $url = str_replace('/TDW', '', $_SERVER['REQUEST_URI']);
        $url = strtok($url, '?'); 
        
    
        foreach ($this->routes as $urlRegex => $route) {
            if (preg_match($urlRegex, $url, $matches)) {
                
                $this->loadPageAndCallMethod($route['file'], $route['method'], $matches);
                return;
            }
        }
    
        echo "Page not found";
    }
    
    private function loadPageAndCallMethod($file, $method, $params) {
        $controllerPath = __DIR__ . "/../Controller/{$file}";
        $className = pathinfo($file, PATHINFO_FILENAME);
    
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
    
            if (class_exists($className)) {
                $controller = new $className();
    
                if (method_exists($controller, $method)) {
                    array_shift($params); 
                    $params = array_values($params); 
                    call_user_func_array([$controller, $method], $params);
                } else {
                    echo "Méthode {$method} introuvable dans la classe {$className}.";
                }
            } else {
                echo "Classe {$className} introuvable.";
            }
        } else {
            echo "Fichier du contrôleur {$file} introuvable.";
        }
    }
    
    
    

    // private function loadPageAndCallMethod($file, $method, $matches) {
    //     $filePath = __DIR__ . '/' . $file;
    
    //     if (file_exists($filePath)) {
    //         require_once $filePath;
    
    //         $className = pathinfo($file, PATHINFO_FILENAME); 
            
    //         if (class_exists($className)) {
    //             $controller = new $className();
    
    //             $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Extraire les paramètres nommés
    //             if (method_exists($controller, $method)) {
    //                 $controller->$method($params);
    //             } else {
    //                 echo "Méthode '$method' non trouvée dans le contrôleur '$className'.<br>";
    //             }
    //         } else {
    //             echo "Classe '$className' introuvable.<br>";
    //         }
    //     } else {
    //         echo "Fichier '$file' introuvable.<br>";
    //     }
    // }

    public function construireRoute() {
        $cf = new menu_composant_controller();
        $qtf = $cf->get_menu_item_controller();
        
        foreach ($qtf as $row) {
            $this->addRoute($row["route"], $row["href"], $row["method"]);
            
            if ($row["sub_item"] == 1) {
                $qf = $cf->get_sous_menu_item_controller($row["id"]);
                foreach ($qf as $sRow) {
                    $this->addRoute($sRow["route"], $sRow["href"], $sRow["method"]);
                }
            }
        }
    }
    
}
?>