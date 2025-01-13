<?php
require_once __DIR__ . '/Dashboard_Componant_controller.php';
require_once __DIR__.'/file_controller.php';
require_once __DIR__.'/lien_controller.php';
require_once __DIR__ . '/Partenaire_controller.php';

$logFile = __DIR__ . '/log.txt';

if (!file_exists($logFile)) {
    touch($logFile); // Créer le fichier s'il n'existe pas
}

error_log("je suis dans le fichier action dashbord\n", 3, $logFile);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Données POST : " . print_r($_POST, true), 3, $logFile);
    error_log("Données FILES : " . print_r($_FILES, true), 3, $logFile);
    
    $response = [
        'status' => 'false',
        'message' => 'Une erreur s\'est produite.',
    ];

    try {
        $action = $_POST['action'] ?? null;
        $nomClass = $_POST['nomClass'] ?? null;
        $functionName = $_POST['functionName'] ?? null;
        error_log("Action: " . $action, 3, $logFile);
        error_log("Nom de la classe: " . $nomClass, 3, $logFile);
        error_log("Nom de la fonction: " . $functionName, 3, $logFile);

        if ($nomClass && $functionName) {
            // require_once '../'.$nomClass . '.php';
            error_log("\n class fonct bien1", 3, $logFile );

            error_log("\n class fonct bien2", 3, $logFile );
            $controller = new $nomClass();

            $result = $controller->$functionName($_POST, $_FILES);

            if ($result) {
                $response['status'] = $result['status'];
                $response['message'] = $result['message'];
            }
        } else {
            throw new Exception('Classe ou méthode manquante.');
        }
        
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
    // echo '<pre>';
    // var_dump($response);  // Afficher le contenu de la réponse
    // echo '</pre>';

    error_log("\nRéponse dash action: " . print_r(json_encode($response, JSON_UNESCAPED_UNICODE), true), 3, $logFile);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
?>