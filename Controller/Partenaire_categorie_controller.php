<?php
require_once __DIR__ . '/../Model/Partainer_categorie_model.php';
require_once 'menu_composant_controller.php';
require_once 'Footer_controller.php';
require_once 'Head_controller.php';
require_once 'Dashboard_Componant_controller.php';

class Partenaire_categorie_controller {
    
    public function get_Partenaire_category_controller() {
        $model = new Partenier_categorie_model();
        $categories = $model->get_Partenaire_category_model();
        return $categories;
    }
    public function get_categorie_by_id_controller($id) {
        $model = new Partenier_categorie_model();
        $categories = $model->get_categorie_by_id_model($id);
        return $categories;
    }
    public function ajouter_categorie_controller($categorie, $description) {
        $categorie_model = new Partenier_categorie_model();
        $result = $categorie_model->ajouter_categorie($categorie, $description);

        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Ajout categorie réussi !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de l\'ajout de categorie.',
            ];
        }
    }

    public function modifier_categorie_controller($id, $categorie, $description) {
        $categorie_model = new Partenier_categorie_model();
        $result = $categorie_model->modifier_categorie($id, $categorie, $description);

        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Modifier categorie réussi !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de la modification  de categorie.',
            ];
        }
    }

    public function supprimer_categorie_controller($id) {
        $categorie_model = new Partenier_categorie_model();
        $result = $categorie_model->supprimer_categorie($id);

        if ($result) {
            return [
                'status' => 'true',
                'message' => 'Supprision categorie réussi !',
            ];
        } else {
            return [
                'status' => 'false',
                'message' => 'Erreur lors de la Supprision  de categorie.',
            ];
        }
    }

    public function affiche_partenaire_categories() {
        $view = new Partenaire_categorie_view();
        $view->display_categories();
    }

    public function affiche_partenaire_categorie_dashbord_page() {
        // $userController = new User_controller();
            // $userId = $userController->verify_cookie('admin'); 
            // if ($userId !== null) {
                $pageName = "ElMountada | News Dashboard";
                $cssFiles = [
                    '../public/style/varaibles.css',
                    '../public/style/dashbord_table.css',
                    '../public/style/menu_left.css',
                    '../public/style/Footer.css'
                ];
                $jsFiles = ['../js/scrpt.js'];
                $libraries = ['jquery','icons']; 
                $headController = new Head_controller();
                $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
            echo '<h1>Partenaire Categorie Dashboard</h1>';
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');

            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Categorie', 'attribute' => 'categorie', 'type' => 'text'],
                ['label' => 'Description', 'attribute' => 'description', 'type' => 'text'],
            ];

            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_categorie_partenaire/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Supprimer',
                    'url' => '../admin/supprimerCategoriePartenaire/{id}',
                    'onclick' => "return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie partenaire ?');"
                ],
            ];

            $controller = new Dashboard_Componant_controller();
            $controller->affiche_Dashbord(
                'Partenaire_categorie_controller', 
                'get_Partenaire_category_controller', 
                $fields, 
                [], 
                $actions, 
                'Partenaire_categorie_controller', 
                'supprimer_categorie_controller'
            );
        // }
    }
    public function affiche_partenaire_categorie_ajout_page() {
        $pageName = "ElMountada | Ajouter Categorie Partenaire";
        $cssFiles = [
            '../public/style/varaibles.css',
            '../public/style/dashbord_ajouter.css',
            '../public/style/menu_left.css'
        ];
        $jsFiles = ['../js/scrpt.js'];
        $libraries = ['jquery'];
        
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $menu = new menu_composant_controller();
        $menu->display_menu_by_role('admin');
        $controller = new Dashboard_Componant_controller();
    
        $fields = [
            ['label' => 'Categorie', 'attribute' => 'categorie', 'type' => 'text'],
            ['label' => 'Description', 'attribute' => 'description', 'type' => 'textarea'],
        ];
    
        // Appel de la fonction qui affiche le formulaire d'ajout
        $controller->display_AjouterForm(
            $fields, 
            '../admin/ajouter_categorie_post', 
            'Partenaire_categorie_controller', 
            'ajouter_categorie_controller',
            ' ',
            '../admin/dash_categorie_partenaire',
            'Ajouter Categorie Partenaire'
        );
    
        echo '</body>';
    }
    
    public function ajouter_categorie_partenaire() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorie = $_POST['categorie'] ?? null;
            $description = $_POST['description'] ?? null;
    
            if ($categorie && $description) {
                $this->ajouter_categorie_controller($categorie,$description);
                header('Location: ../admin/dash_categorie_partenaire');
            } else {
                $_SESSION['errorsAjout'] = ["Tous les champs sont obligatoires."];
                header('Location: ./ajouter_categorie_partenaire');
                exit();
            }
        } else {
            $_SESSION['errorsAjout'] = ["Requête invalide."];
            header('Location: ./ajouter_categorie_partenaire');
            exit();
        }
    }

    public function supprimer_categorie_partenaire($id) {
        session_start();
        if ($id) {
            try {
                $categorie = $this->get_categorie_by_id_controller($id);
                if (!$categorie) {
                    throw new Exception("Catégorie introuvable.");
                }
    
                $result = $this->supprimer_categorie_controller($id);
                if ($result) {
                    $_SESSION['successDelite'] = "La catégorie a été supprimée avec succès.";
                } else {
                    $_SESSION['errorsDelite'] = ["Erreur lors de la suppression de la catégorie."];
                }
    
                header('Location: ../../admin/dash_categorie_partenaire');
                exit();
    
            } catch (Exception $e) {
                $_SESSION['errorsDelite'] = [$e->getMessage()];
                header('Location: ../../admin/dash_categorie_partenaire');
                exit();
            }
        } else {
            $_SESSION['errorsDelite'] = ["L'ID de la catégorie est manquant."];
            header('Location: ../../admin/dash_categorie_partenaire');
            exit();
        }
    }

    public function affiche_partenaire_categorie_modifier_page($id) {
        $pageName = "ElMountada | Modifier Categorie Partenaire";
        $cssFiles = [
            '../../public/style/varaibles.css',
            '../../public/style/dashbord_modifier.css',
            '../../public/style/footer.css'
        ];
        $jsFiles = ['../../js/scrpt.js'];
        $libraries = ['jquery', 'icons'];
    
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        $controller = new Dashboard_Componant_controller();
    
        // Définir les champs du formulaire
        $fields = [
            ['label' => 'ID', 'attribute' => 'id', 'type' => 'id'],
            ['label' => 'Categorie', 'attribute' => 'categorie', 'type' => 'text'],
            ['label' => 'Description', 'attribute' => 'description', 'type' => 'textarea'],
        ];
    
        // Appel de la fonction pour afficher le formulaire de modification
        $controller->display_ModifierForm(
            'Partenaire_categorie_controller', 
            'get_categorie_by_id_controller', 
            $fields, 
            [$id], 
            '../../admin/modifier_categorie_post', 
            'Partenaire_categorie_controller', 
            'modifier_categorie_controller', 
            ' ', 
            '../../admin/dash_categorie_partenaire', 
            'Modifier Categorie Partenaire'
        );
    
       
        echo '</body>';
    }
    
    public function modifier_categorie_partenaire() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $categorie = $_POST['categorie'] ?? null;
            $description = $_POST['description'] ?? null;
    
            if ($id && $categorie && $description) {
                $this->modifier_categorie_controller($id, $categorie, $description);
    
                header('Location: ./dash_categorie_partenaire');
            } else {
                $_SESSION['errorsModifier'] = ["Tous les champs sont obligatoires."];
                header('Location: ./modifier_categorie_partenaire?id=' . $id);
                exit();
            }
        } else {
            $_SESSION['errorsModifier'] = ["Requête invalide."];
            header('Location: ./modifier_categorie_partenaire?id=' . $id);
            exit();
        }
    }
    
    
    
}
?>
