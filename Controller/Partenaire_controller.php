<?php
require_once __DIR__ . '/../Model/Partenaire_model.php';
require_once __DIR__ . '/../View/Partainer_view.php';
require_once __DIR__ . '/../Controller/file_controller.php';

class Partenaire_controller {

    public function get_Partenaire_controller() {
        $model = new Partenaire_model();
        $partenaires = $model->get_Partenaire_model();
        return $partenaires;
    }

    public function get_Partenaires_by_category_controller($category) {
        $model = new Partenaire_model();
        $partenaires = $model->get_Partenaires_by_category_model($category);
        return $partenaires;
    }

    public function  get_Partenaire_by_id_controller($id) {
        $model = new Partenaire_model();
        $partenaire = $model-> get_Partenaires_by_id_model($id);
        return $partenaire;
    }
    
    public function display_logs_diaporama(){
        $v= new Partenier_view();
        $r=$v->display_logs_diaporama();
    }
    public function affiche_partainers(){
        $v= new Partenier_view();
        $r=$v->display_partenaires();
    }
    public function filter_partainers(){
        $v= new Partenier_view();
        $r=$v->filter_partainers();
    }
    public function tri_partainers($id, $text){
        $v= new Partenier_view();
        $r=$v->tri_partainers($id, $text);
    }
    public function display_partenaire_details($id){
        $v= new Partenier_view();
        $r=$v->display_partenaire_details($id);
    }

    public function supprimer_partenaire_controller($id) {
        $news_model = new Partenaire_model();
        $result = $news_model->supprimer_model($id);
    
        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Supprision partenaire réussi !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de la Supprision  de partenaire.',
            ];
        }
    }

    public function modifier_partenaire_controller($id, $nom, $willya, $adresse, $categorie,  $description , $logo = null) {
        $partenaire_model = new Partenaire_model();  
        $result = $partenaire_model->modifier_model($id, $nom, $willya, $adresse, $categorie, $logo, $description);
        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Modifier partenaire réussi !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de la modification  de partenaire.',
            ];
        }
    }
    
    // public function ajouter_partenaire_controller($nom, $willya, $adresse, $categorie, $description, $logo) {
    //     $partenaire_model = new Partenaire_model();  
    //     $dateCreation = new DateTime();  
    //     $dateTimeString = $dateCreation->format('Y-m-d H:i:s');  
        
    //     $result = $partenaire_model->ajouter_model($nom, $willya, $adresse, $categorie, $logo, $description,  $dateTimeString);
        
    //     if ($result) {
    //         return [
    //             'status' => 'true',
    //             'message' => $result,
    //         ];
    //     } else {
    //         return [
    //             'status' => 'false',
    //             'message' => $result,
    //         ];
    //     }
    // }
    public function ajouter_partenaire_controller($postData, $fileData) {
        $logFile = __DIR__ . '/log.txt';
        error_log("je suis dans ajouter partenaire controller", 3, $logFile);

        $response = [
            'status' => 'false',
            'message' => 'Une erreur s\'est produite.',
        ];
    
        try {
            error_log("Données POST : " . print_r($_POST, true), 3, $logFile);
            error_log("Données FILES : " . print_r($_FILES, true), 3, $logFile);
    
            // Récupérer et valider les champs
            $nom = htmlspecialchars($postData['nom'] ?? '');
            $willya = htmlspecialchars($postData['willya'] ?? '');
            $adresse = htmlspecialchars($postData['adresse'] ?? '');
            $categorie = htmlspecialchars($postData['categorie'] ?? '');
            $description = htmlspecialchars($postData['description'] ?? '');
            $pathFile = htmlspecialchars($postData['pathFile'] ?? '');
            echo $pathFile;
            // Gérer le fichier uploadé
            $logo = null;

            if (isset($fileData['logo']) && $fileData['logo']['size'] > 0) {
                $file = $fileData['logo'];  // Récupérer le fichier logo
                $path = $pathFile;  // Le répertoire de destination

                // Appel à la méthode chargerFile pour traiter l'upload
                try {
                    $uploadedFileName = file_controller::chargerFile($file, htmlspecialchars($path));

                    // Si le fichier a été téléchargé avec succès, générer son chemin complet
                    if ($uploadedFileName) {
                        $logo = htmlspecialchars($path . '/' . $uploadedFileName);
                    }
                } catch (Exception $e) {
                    // Si une erreur survient pendant le téléchargement
                    throw new Exception("Erreur lors du chargement du fichier : " . $e->getMessage());
                }
            }

    
            // Appeler le modèle pour ajouter le partenaire
            $partenaire_model = new Partenaire_model();
            $dateCreation = new DateTime();
            $dateTimeString = $dateCreation->format('Y-m-d H:i:s');
            $result = $partenaire_model->ajouter_model($nom, $willya, $adresse, $categorie, $logo, $description, $dateTimeString);
    
            if ($result) {
                $response['status'] = 'true';
                $response['message'] = 'Partenaire ajouté avec succès.';
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        // header('Content-Type: application/json; charset=UTF-8');
        // echo json_encode($response, JSON_UNESCAPED_UNICODE);
        return $response;
    }
    
    
    public function affiche_parteners_page() {
        $pageName = "ElMountada | Partenaires";
        $cssFiles = ['./public/style/varaibles.css', './public/style/menu_user.css', './public/style/parteners.css', './public/style/footer.css'];
        $jsFiles = ["js/scrpt.js"];
        $libraries = ['jquery', 'icons'];
    
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('user');
    
        echo '<h1 class="page-title">Liste des offres par catégorie</h1>';
        echo '<div class="triFilter">';
            $this->filter_partainers();
    
            echo '<div>';
                $this->tri_partainers('triPartenerCategorie', 'Tri par Catégorie');
                $this->tri_partainers('triPartenerWillaya', 'Tri par Ville');
            echo '</div>';
        echo '</div>';
    
        $this->affiche_partainers();
    
        $menu = new Footer_controller();
        $menu->display_footer();
        echo '</body>';
    }
    
    public function display_partenaire_details_page($id) {
        $pageName = "ElMountada | Détails Partenaire";
        $cssFiles = ['../public/style/varaibles.css', '../public/style/menu_user.css', '../public/style/partenaire_details.css','../public/style/offer.css' ,'../public/style/footer.css'];
        $jsFiles = [];
        $libraries = ['icons']; 
    
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('user');
    
        
        $this->display_partenaire_details($id);
    
        $menu = new Footer_controller();
        $menu->display_footer();
        echo '</body>';
    }
    
}
?>
