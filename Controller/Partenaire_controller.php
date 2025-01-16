<?php
require_once __DIR__ . '/../Model/Partenaire_model.php';
require_once __DIR__ . '/../View/Partainer_view.php';
require_once __DIR__ . '/../Controller/file_controller.php';
require_once __DIR__ . '/../Controller/User_controller.php';

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
        
    }
    
    public function ajouter_partenaire_controller($nom, $willya, $adresse, $categorie, $description, $logo) {
        $partenaire_model = new Partenaire_model();  
        $dateCreation = new DateTime();  
        $dateTimeString = $dateCreation->format('Y-m-d H:i:s');  
        
        $result = $partenaire_model->ajouter_model($nom, $willya, $adresse, $categorie, $logo, $description,  $dateTimeString);
       
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
    public function affiche_partenaires_dashbord_page() {
        $userController = new User_controller();
        $userId = $userController->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Partenaires Dashboard";
            $cssFiles = [
                '../public/style/varaibles.css',
                '../public/style/dashbord_table.css',
                '../public/style/menu_left.css',
                '../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
            echo '<h1>Partenaires Dashboard</h1>';
    
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
    
            $controller = new Dashboard_Componant_controller();
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Logo', 'attribute' => 'logo', 'type' => 'image'],
                ['label' => 'Adresse', 'attribute' => 'adresse', 'type' => 'text'],
                ['label' => 'Catégorie', 'attribute' => 'categorie', 'type' => 'text'],
                ['label' => 'Date Ajoutée', 'attribute' => 'date_ajouter', 'type' => 'date'],
            ];
    
            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_partenaire/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Voir plus',
                    'url' => '../admin/details_partenaire/{id}',
                    'class' => 'btn-view'
                ],
                [
                    'label' => 'Supprimer',
                    'url' => '../admin/supprimePartenaire/{id}',
                    'onclick' => "return confirm('Êtes-vous sûr de vouloir supprimer cette partenaire ?');"
                   
                ],
            ];
    
            $controller->affiche_Dashbord(
                'Partenaire_controller',
                'get_Partenaire_controller',
                $fields,
                [],
                $actions,
                'Partenaire_controller',
                'supprimer_partenaires_controller'
            );
    
            $footer = new Footer_controller();
            $footer->display_footer();
    
            echo '</body>';
        }
    }

    public function affiche_partenaire_details_page($id) {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Détails Partenaire";
            $cssFiles = [
                '../../public/style/varaibles.css',
                '../../public/style/dashbord_details.css',
                '../../public/style/footer.css'
            ];
            $jsFiles = [];
            $libraries = [];
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $fields = [
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Logo', 'attribute' => 'logo', 'type' => 'image'],
                ['label' => 'Adresse', 'attribute' => 'adresse', 'type' => 'text'],
                ['label' => 'Catégorie', 'attribute' => 'categorie', 'type' => 'text'],
                ['label' => 'Date Ajoutée', 'attribute' => 'date_ajouter', 'type' => 'date'],
            ];
        
            $controller = new Dashboard_Componant_controller();
            $controller->display_DetailView(
                'Partenaire_controller',
                'get_Partenaire_by_id_controller',
                $fields,
                [$id],
                'Détails du Partenaire'
            );
        
            $footer = new Footer_controller();
            $footer->display_footer();
        
            echo '</body>';
        }
    }

    public function affiche_partenaire_modifier_page($id) {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Modifier Partenaire";
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
        
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'id'],
                ['label' => 'Logo', 'attribute' => 'logo', 'type' => 'image'],  
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],  
                ['label' => 'Willya', 'attribute' => 'willya', 'type' => 'text'],  
                ['label' => 'Adresse', 'attribute' => 'adresse', 'type' => 'text'],  
                ['label' => 'Catégorie', 'attribute' => 'categorie', 'type' => 'select', 
                    'options' => $controller->construire_Dashboard('Partenaire_categorie_controller', 'get_Partenaire_category_controller', [], []), 
                    'att_option_affiche' => 'categorie', 
                    'att_option_return' => 'categorie'],  
                ['label' => 'Description', 'attribute' => 'description', 'type' => 'textarea'],  
            ];
        
            $controller->display_ModifierForm(
                'Partenaire_controller',
                'get_Partenaire_by_id_controller',
                $fields,
                [$id],
                '../../admin/modifier_partenaire_post',
                'Partenaire_controller',
                'modifier_partenaire_controller',
                'public/images/partenaires',
                '../../admin/dash_partenaires',
                'Modifier Partenaire'
            );

        
            echo '</body>';
        }
    }

    public function affiche_partenaire_ajouter_page() {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Ajouter Partenaire";
            $cssFiles = [
                '../public/style/varaibles.css',
                '../public/style/dashbord_ajouter.css',
                '../public/style/menu_left.css',
                '../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
        
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
        
            $controller = new Dashboard_Componant_controller();
        
            $fields = [
                ['label' => 'Logo', 'attribute' => 'logo', 'type' => 'image'],
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Willaya', 'attribute' => 'willya', 'type' => 'text'],
                ['label' => 'Adresse', 'attribute' => 'adresse', 'type' => 'text'],
                [
                    'label' => 'Categorie', 
                    'attribute' => 'categorie', 
                    'type' => 'select',
                    'options' => $controller->construire_Dashboard('Partenaire_categorie_controller', 'get_Partenaire_category_controller', [], []), 
                    'att_option_affiche' => 'categorie', 
                    'att_option_return' => 'categorie'
                ],
                ['label' => 'Description', 'attribute' => 'description', 'type' => 'textarea'],
            ];
        
            $controller->display_AjouterForm(
                $fields,
                '../admin/ajouter_partenaire_post',
                'Partenaire_controller',
                'ajouter_partenaire_controller',
                'public/images/partenaires',
                '../admin/dash_partenaires',
                'Ajouter Partenaire'
            );
        
        
            echo '</body>';
        }
    }
    public function ajouter_partenaire() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $nom = $_POST['nom'] ?? null;
            $willya = $_POST['willya'] ?? null;
            $adresse = $_POST['adresse'] ?? null;
            $categorie = $_POST['categorie'] ?? 1;
            $description = $_POST['description'] ?? null;
    
            // Handle file upload for the logo
            $logoFile = $_FILES['logo'] ?? null;
            $logoPath = null;
            echo "<h3>Informations du formulaire :</h3>";
            echo "Nom : " . htmlspecialchars($nom) . "<br>";
            echo "Willya : " . htmlspecialchars($willya) . "<br>";
            echo "Adresse : " . htmlspecialchars($adresse) . "<br>";
            echo "Catégorie : " . htmlspecialchars($categorie) . "<br>";
            echo "Description : " . htmlspecialchars($description) . "<br>";
            
            // Afficher les informations du fichier logo
            echo "<h3>Informations du fichier logo :</h3>";
            if ($logoFile) {
                echo "<pre>";
                print_r($logoFile);
                echo "</pre>";
            } else {
                echo "Aucun fichier logo n'a été téléchargé.<br>";
            }
            $uploadDir = 'public/image/partenaires/';
            try {
                if (isset($logoFile) && $logoFile['error'] === UPLOAD_ERR_OK) {
                    $logoPath = file_controller::chargerFile($logoFile, $uploadDir);
                    $logoPath = $uploadDir . $logoPath;
                }
            } catch (Exception $e) {
                $_SESSION['errorsAjout'] = ["Erreur lors du téléchargement du logo : " . $e->getMessage()];
                header('Location: ../admin/ajoute_partanaire');
                exit();
            }
    
            if ($nom && $willya && $adresse && $categorie && $description) {
                $this->ajouter_partenaire_controller($nom, $willya, $adresse, $categorie, $description, $logoPath);
                header('Location: ../admin/dash_partenaires');
                exit();
            } else {
                $_SESSION['errorsAjout'] = ["Tous les champs sont obligatoires."];
                header('Location: ../admin/ajoute_partanaire');
                exit();
            }
        } else {
            $_SESSION['errorsAjout'] = ["Requête invalide."];
            header('Location: ../admin/ajoute_partanaire');
            exit();
        }
    }
    public function modifier_partenaire() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? null;
            $willya = $_POST['willya'] ?? null;
            $adresse = $_POST['adresse'] ?? null;
            $categorie = $_POST['categorie'] ?? null; 
            $description = $_POST['description'] ?? null;
    
            $logoFile = $_FILES['image'] ?? null;
            $logoPath = null;
    
            $uploadDir = 'public/image/partenaires/';
            try {
                if (isset($logoFile) && $logoFile['error'] === UPLOAD_ERR_OK) {
                    $logoPath = file_controller::chargerFile($logoFile, $uploadDir);
                    $logoPath = $uploadDir . $logoPath;
                } else {
                    $existingPartenaire = $this->get_Partenaire_by_id_controller($id);
                    if ($existingPartenaire) {
                        $logoPath = $existingPartenaire['logo']; 
                    }
                }
            } catch (Exception $e) {
                $_SESSION['errorsModifier'] = ["Erreur lors du téléchargement du logo : " . $e->getMessage()];
                header('Location: ./modifier_partenaire/' . $id);
                exit();
            }
            if ($id && $nom && $willya && $adresse && $categorie && $description) {
                $this->modifier_partenaire_controller($id, $nom, $willya, $adresse, $categorie, $description, $logoPath);
                header('Location: ../admin/dash_partenaires');
            } else {
                $_SESSION['errorsModifier'] = ["Tous les champs sont obligatoires."];
                header('Location: ./modifier_partenaire/' . $id);
                exit();
            }
        } else {
            $_SESSION['errorsModifier'] = ["Requête invalide."];
            header('Location: ./modifier_partenaire/' . $id);
            exit();
        }
    }
    public function supprimer_partenaire($id) {
        session_start();
        if ($id) {
            try {
                $partenaire = $this->get_Partenaire_by_id_controller($id);
                if (!$partenaire) {
                    throw new Exception("Partenaire introuvable.");
                }
    
                $logoPath = $partenaire['logo'] ?? null;
                if ($logoPath && file_exists($logoPath)) {
                    if (!unlink($logoPath)) {
                        throw new Exception("Erreur lors de la suppression du logo.");
                    }
                }
    
                $result = $this->supprimer_partenaire_controller($id);
                if ($result) {
                    $_SESSION['successDelite'] = "Le partenaire a été supprimé avec succès.";
                } else {
                    $_SESSION['errorsDelite'] = ["Erreur lors de la suppression du partenaire."];
                }
    
                header('Location: ../dash_partenaires');
                exit();
    
            } catch (Exception $e) {
                $_SESSION['errorsDelite'] = [$e->getMessage()];
                header('Location: ../dash_partenaires');
                exit();
            }
        } else {
            $_SESSION['errorsDelite'] = ["L'ID du partenaire est manquant."];
            header('Location: ../dash_partenaires');
            exit();
        }
    }


    public function affiche_partenaire_compte_page() {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Partenaires et Comptes";
            $cssFiles = [
                '../public/style/varaibles.css',
                '../public/style/dashbord_table.css',
                '../public/style/menu_left.css',
                '../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
        
            $partenaires = $this->get_Partenaire_With_Compte_controller();
        
            echo '<h1>Comptes des Partenaires</h1>';
        
            $controller = new Dashboard_Componant_controller();
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text'],
            ];
        
            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_partenaire_compte/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Supprimer',
                    'url' => '../admin/supprimer_partenaire_compte/{id}',
                    'onclick' => "return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?');"
                ],
            ];
        
            $controller->affiche_Dashbord(
                'Partenaire_controller',
                'get_Partenaire_With_Compte_controller',
                $fields,
                [],
                $actions,
                'Partenaire_controller',
                'supprimer_partenaire_compte_controller'
            );
        
        
        
            echo '</body>';
        }
    }
    public function get_Partenaire_With_Compte_controller() {
        $model = new Partenaire_model();
        $partenaires = $model->getAllPartenairesWithCompte();
        return $partenaires;
    }

    public function affiche_partenaire_compte_ajouter_page() {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Ajouter Partenaire Compte";
            $cssFiles = [
                '../public/style/varaibles.css',
                '../public/style/dashbord_ajouter.css',
                '../public/style/menu_left.css',
                '../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
        
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
        
            $controller = new Dashboard_Componant_controller();
        
            $fields = [
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'select', 
                    'options' => $controller->construire_Dashboard('Partenaire_controller', 'get_Partenaire_controller', [], []), 
                    'att_option_affiche' => 'nom', 
                    'att_option_return' => 'id'
                ],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text'],
                ['label' => 'Mot de passe', 'attribute' => 'password', 'type' => 'password'],
            ];
        
            $controller->display_AjouterForm(
                $fields,
                '../admin/ajouter_partenaire_compte_post_admin',
                'Partenaire_controller',
                'ajouter_partenaire_compte_controller',
                'public/images/partenaires',
                '../admin/partenaire_contact',
                'Ajouter Partenaire et Compte'
            );
        
            echo '</body>';
        }
    }
    public function ajouterPartenaireCompte_controller($nom, $email, $password) {
        $controller = new Partenaire_model();
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  
        $controller->ajouterPartenaireCompte($nom, $email, $hashedPassword);
    }
    public function ajouter_partenaire_compte() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            echo $nom,$email,$password;
            if ($nom && $email && $password) {
    
                $idCompte = $this->ajouterPartenaireCompte_controller($nom,$email, $password);
                echo $idCompte;
                header('Location: ../admin/partenaire_contact');
                    exit();
            } else {
                $_SESSION['errorsAjout'] = ["Tous les champs sont obligatoires."];
                header('Location: ../admin/partenaire_ajouter_compte');
                exit();
            }
        } else {
            $_SESSION['errorsAjout'] = ["Requête invalide."];
            header('Location: ../admin/partenaire_ajouter_compte');
            exit();
        }
    }


    public function affiche_partenaire_compte_modifier_page($id) {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Modifier Partenaire Compte";
            $cssFiles = [
                '../../public/style/varaibles.css',
                '../../public/style/dashbord_modifier.css',
                '../../public/style/menu_left.css',
                '../../public/style/Footer.css'
            ];
            $jsFiles = ['../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
        
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
        
            $controller = new Dashboard_Componant_controller();
        
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'id'],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text', ],
                ['label' => 'Nouveau mot de passe', 'attribute' => 'password', 'type' => 'password'],
            ];
        
            // Affichage du formulaire de modification
            $controller->display_ModifierForm(
                'User_controller',
                'get_user_by_id_controller',
                $fields,
                [$id],
                '../../admin/modifier_partenaire_compte_post',
                'Partenaire_controller',
                'modifier_partenaire_compte_controller',
                'public/images/partenaires',
                '../admin/partenaires_comptes',
                'Modifier Partenaire Compte'
            );
            echo '</body>';
        }
    }

    public function modifier_compte_parte_post() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
    
            // Vérification des champs obligatoires
            if ($email) {
                $controller = new User_controller();
                $result=$controller->modifier_controller($id, $email,'partenaire' , $password);
    
                if ($result) {
                    header('Location: ../admin/partenaire_contact');
                    exit();
                } else {
                    // En cas d'erreur
                    $_SESSION['errorsModifier'] = ["Erreur lors de la modification du partenaire."];
                    header('Location: ../admin/modifier_partenaire_compte/' . $id);
                    exit();
                }
            } else {
                // Si des champs sont manquants
                $_SESSION['errorsModifier'] = ["le champs mail est obligatoires."];
                header('Location: ../admin/modifier_partenaire_compte/' . $id);
                exit();
            }
        } else {
            $_SESSION['errorsModifier'] = ["Requête invalide."];
            header('Location: ../admin/modifier_partenaire_compte/' . $id);
            exit();
        }
    }

    public function supprimer_part_compt_post($id) {
        session_start();
        if ($id) {
            try {
                $userController = new User_controller();
                $result = $userController->supprimer_user_controller($id);
                if ($result) {
                    $_SESSION['successUserDelete'] = "Le compte utilisateur a été supprimé avec succès.";
                } else {
                    $_SESSION['errorsUserDelete'] = ["Erreur lors de la suppression du compte utilisateur."];
                }
    
                header('Location: ../../admin/partenaire_contact');
                exit();
            } catch (Exception $e) {
                $_SESSION['errorsUserDelete'] = [$e->getMessage()];
                header('Location: ../admin/partenaire_contact');
                exit();
            }
        } else {
            $_SESSION['errorsUserDelete'] = ["L'ID de l'utilisateur est manquant."];
            header('Location: ../admin/partenaire_contact');
            exit();
        }
    }

    public function affiche_verifier_id_form() {
        $controller = new User_controller();
        $userId = $controller->verify_cookie('partenaire'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Vérifier Demande";
            $cssFiles = ['./public/style/variables.css', './public/style/menu_user.css', './public/style/footer.css'];
            $jsFiles = ["js/script.js"];
            $libraries = ['jquery', 'icons'];
        
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
            $this->affiche_verifier_id_form_controller();
            $footer = new Footer_controller();
            $footer->display_footer();
            echo '</body>';
        }
    }

    public function affiche_verifier_id_form_controller(){
        $controller = new Partenier_view();
        $controller->affiche_verifier_id_form();
    }
    
    
}
?>
