<?php
require_once './Controller/Dashboard_Componant_controller.php';
require_once './Controller/file_controller.php';
require_once './Controller/lien_controller.php';
require_once './Controller/Partenaire_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $response = [
        'status' => 'false', 
        'message' => 'Une erreur s\'est produite.', 
    ];

    try {
        $controller = new Dashboard_Componant_controller();

        $parametres = [];
        $i = 0;
        foreach ($_POST as $key => $value) {
            if ($key !== 'action' && $key !== 'nomClass' && $key !== 'functionName' && $key !== 'pathFile') {
                $parametres[$i] = htmlspecialchars($value);
                $i++;
            }
        }

        foreach ($_FILES as $key => $value) {
            $file = $_FILES[$key];
            $path = $_POST['pathFile'] ?? '';
            if (is_array($value) && $file['size'] != 0) {
                $uploadedFileName = file_controller::chargerFile($file, htmlspecialchars($path));
                if ($uploadedFileName) {
                    $parametres[$i] = htmlspecialchars($path . '/' . $uploadedFileName);
                    $i++;
                } else {
                    throw new Exception("Erreur lors du chargement du fichier.");
                }
            }
        }

        $action = $_POST['action'] ?? null;
        $nomClass = $_POST['nomClass'] ?? null;
        $functionName = $_POST['functionName'] ?? null;

        if ($nomClass && $functionName) {
            // require_once $nomClass . '.php';
            $controller = new $nomClass();

            // Appeler la méthode dynamiquement
            $result = $controller->$functionName(...$parametres);

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

    echo json_encode($response);
    exit;
}
?>