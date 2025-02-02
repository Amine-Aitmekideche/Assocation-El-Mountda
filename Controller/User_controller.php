<?php 
require_once(__DIR__ . '/../Model/User_model.php');
require_once(__DIR__ . '/../View/User_view.php');
require_once(__DIR__ . '/../Controller/file_controller.php');
require_once 'menu_composant_controller.php';
require_once 'Footer_controller.php';
require_once 'Head_controller.php';
require_once 'Dashboard_Componant_controller.php';

class User_controller {

    public function ajouter_controller($email, $password, $role) {
        $userModel = new User_model();
        $hashedPassword =hash('sha256', $password);
        $result = $userModel->ajouter_model($email, $hashedPassword, $role);
        
        return $result;
    }
    
    public function get_user_controller() {
        $userModel = new User_model();
        $users = $userModel->get_user_model();
        
        return $users;
    }
    
    public function get_membre_controller() {
        $userModel = new User_model();
        $users = $userModel->get_membre_model();
        
        return $users;
    }

    public function get_membre_block_controller() {
        $userModel = new User_model();
        $users = $userModel->get_membre_block_model();
        
        return $users;
    }
   
    public function get_user_by_id_controller($id) {
        $userModel = new User_model();
        $user = $userModel->get_user_by_id_model($id);
        
        return $user;
    }
    public function get_membre_by_id_controller($id) {
        $userModel = new User_model();
        $user = $userModel->get_membre_by_id_model($id);
        
        return $user;
    }
    public function get_user_by_email_controller($email) {
        $userModel = new User_model();
        $user = $userModel->get_user_by_email_model($email);
        
        return $user;
    }

    public function get_users_by_role_controller($role) {
        $userModel = new User_model();
        $users = $userModel->get_users_by_role_model($role);
        
        return $users;
    }

    public function modifier_controller($id, $email, $role, $password) {
        $userModel = new User_model();
        if ($password) {$hashedPassword =hash('sha256', $password);}
        $result = $userModel->modifier_model($id, $email, $role, $hashedPassword);
        
        return $result;
    }
  
    public function get_user_id_by_isConnected_controller($token) {
        $userModel = new User_model();
        $result = $userModel->get_user_id_by_isConnected($token);
        return $result;
    }
    public function user_info_controller($id) {
        $userModel = new User_view();
        $userModel->user_info_view($id);
    }
    public function display_connexion() {
        $userModel = new User_view();
        $userModel->display_connexion();
    }

    public function display_inscription() {
        $userModel = new User_view();
        $userModel->display_inscription();
    }

    public function modifier_isConnecte_controller($userId, $token) {
        $userModel = new User_model();
        $result = $userModel->modifier_isConnecte($userId, $token);
        return $result;
    }
    public function login_page() {
        if (isset($_COOKIE['auth_token'])) {
            $token = $_COOKIE['auth_token'];
    
            $user = $this->get_user_id_by_isConnected_controller($token);
    
            switch ($user[0]['role']) {
                case 'admin':
                    header('Location: ./admin/dash_news');
                    exit();
                case 'partenaire':
                    header('Location: ./partenaire');
                    exit();
                case 'user':
                    header('Location: ./user');
                    exit();
            }
        } else {
            $pageName = "Connexion";
            $cssFiles = ['public/style/varaibles.css', 'public/style/login.css', 'public/style/menu_user.css', 'public/style/footer.css'];
            $jsFiles = ["js/scrpt.js"];
            $libraries = ['jquery', 'icons'];
    
            require_once 'Controller/Head_controller.php';
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
            require_once 'Controller/menu_composant_controller.php';
            $menuController = new menu_composant_controller();
            $menuController->display_menu_by_role('user');
    
            $this->display_connexion();
    
            echo '</body>';
        }
    }
    
    
    public function affiche_inscription_page() {
        $pageName = "Inscription";
        $cssFiles = [
            'public/style/varaibles.css', 
            'public/style/inscription.css', 
            'public/style/menu_user.css', 
            'public/style/footer.css'
        ];
        $jsFiles = ["js/scrpt.js"];
        $libraries = ['jquery', 'icons'];
    
        require_once 'Controller/Head_controller.php';
        $headController = new Head_controller();
        $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
        require_once 'Controller/menu_composant_controller.php';
        $menuController = new menu_composant_controller();
        $menuController->display_menu_by_role('user');
    
        $this->display_inscription();
    
        echo '</body>';
    }
    public function emailExists_controller($email) {
        $userModel = new User_model();
        $result =$userModel->emailExists($email);
        return $result;
    }
    
    public function ajouter_user_controller($email, $password, $nom, $prenom, $phone, $photoprofile, $photoIdentiti) {
    
        $date_ajouter = date('Y-m-d H:i:s'); 
        $userModel = new User_model();
        $result = $userModel->ajouter_user_model($email, $password, $nom, $prenom, $phone, $photoprofile, $photoIdentiti, $date_ajouter);
        return $result;
    }
    
    public function inscription_controller() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['last_name'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['first_name'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $password = trim($_POST['password'] ?? '');
            $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    
    
           
            if ($this->emailExists_controller($email)) {
                $errors[] = "L'adresse e-mail existe déjà.";
            }
    
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $profilePhotoType = mime_content_type($_FILES['profile_photo']['tmp_name']);
                if (!in_array($profilePhotoType, $allowedMimeTypes)) {
                    $errors[] = "La photo de profil doit être une image au format JPG ou PNG.";
                }
            }
    
            if (isset($_FILES['id_photo']) && $_FILES['id_photo']['error'] === UPLOAD_ERR_OK) {
                $idPhotoType = mime_content_type($_FILES['id_photo']['tmp_name']);
                if (!in_array($idPhotoType, $allowedMimeTypes)) {
                    $errors[] = "La carte d'identité doit être une image au format JPG ou PNG.";
                }
            }
    
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ./inscription');

                exit();
            }
    
            $uploadDir = __DIR__ . '/../public/image/users/';
            $photoProfile = null;
            $photoIdentit = null;
    
            try {
                if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                    $photoProfile = file_controller::chargerFile($_FILES['profile_photo'], $uploadDir);
                    $photoProfile = 'public/image/users/'.$photoProfile;
                }
                if (isset($_FILES['id_photo']) && $_FILES['id_photo']['error'] === UPLOAD_ERR_OK) {
                    $photoIdentit = file_controller::chargerFile($_FILES['id_photo'], $uploadDir);
                    $photoIdentit = 'public/image/users/'.$photoIdentit;

                }
            } catch (Exception $e) {
                $_SESSION['errors'] = ["Erreur lors du téléchargement des fichiers : " . $e->getMessage()];
                header('Location: ./inscription');
                exit();
            }
    
            $hashedPassword =hash('sha256', $password);
    
            try {
                $id =$this->ajouter_user_controller($email, $hashedPassword, $nom, $prenom, $phone, $photoProfile, $photoIdentit);
                if ($id) {
                    $this->set_cookies($id);
                    header('Location: ./user');
                    exit();
                } 
                
            } catch (Exception $e) {
                session_start();
                $_SESSION['errors'] = ["Erreur lors de l'inscription : " . $e->getMessage()];
                header('Location: ./inscription');
                exit();
            }
        } else {
            session_start();
            $_SESSION['errors'] = ["Requête non valide."];
            header('Location: ./inscription');
            exit();
        }
    }

    public function connecter_controller() {

        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $password = trim($_POST['password'] ?? '');
    
            $errors = [];
            
            try {
                $user = $this->get_user_by_email_controller($email);
                
                if ($user) {
                    if (hash('sha256', $password) === $user[0]['password']) {
                        
    
                        $this->set_cookies($user[0]['id']);
                        $this->envoyer_role($user[0]['role']);
                        
                        exit();
                    } else {
                        $_SESSION['errors'] = ["Mot de passe incorrect."];
                        header('Location: ./connexion');
                        exit();
                    }
                } else {
                    $_SESSION['errors'] = ["Le compte n'existe pas ou l'adresse e-mail est incorrecte."];
                    header('Location: ./connexion');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['errors'] = ["Erreur lors de la connexion : " . $e->getMessage()];
                header('Location: ./connexion');
                exit();
            }
        } else {
            $_SESSION['errors'] = ["Requête non valide."];
            header('Location: ./connexion');
            exit();
        }
    }
    
    public function set_cookies($userId) {
        $token = bin2hex(random_bytes(32));
        $result = $this->modifier_isConnecte_controller($userId, $token);
        if ($result) {
            setcookie('auth_token', $token,time() + 30 * 24 * 60 * 60, "/"); 
        }
    }
    
    public function verify_cookie($role) {
        if (isset($_COOKIE['auth_token'])) {
            $token = $_COOKIE['auth_token'];
    
            $user = $this->get_user_id_by_isConnected_controller($token);
            
    
            if ($user) {
                if ($user[0]['role'] === $role) {
                    return $user[0]['id'];
                } else {
                    header('Location: ./connexion');
                    exit();
                }
            } else {
                header('Location: ./connexion');
                exit();
            }
        }else {
            header('Location: ./connexion');
            exit();
        }
        return null; 
    }

    public function envoyer_role($role) {
        switch ($role) {
            case 'admin':
                header('Location: ./admin/dash_news');
                exit();
            case 'partenaire':
                header('Location: ./partenaire');
                exit();
            case 'user':
                header('Location: ./user');
                exit();
            default:
                header('Location: ./connexion');
                exit();
        }
    }
  
    
    public function affiche_inf_user_page() {
        $userId = $this->verify_cookie("user"); 
        if ($userId !== null) {
            $pageName = "Informations Utilisateur";
            $cssFiles = [
                'public/style/variables.css',
                'public/style/user_info.css', 
                'public/style/menu_user.css',
                'public/style/footer.css'
            ];
            $jsFiles = [];
            $libraries = ['icons'];
    
            require_once 'Controller/Head_controller.php';
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
            require_once 'Controller/menu_composant_controller.php';
            $menuController = new menu_composant_controller();
            $menuController->display_menu_by_role('membre');
    
            $this->user_info_controller($userId);
    
            require_once 'Controller/Footer_controller.php';
            $footerController = new Footer_controller();
            $footerController->display_footer();
    
            echo '</body>';
        }
    }
    public function display_user_modifier_form_controller($id){
        $userModel = new User_view();
        $userModel->display_user_modifier_form($id);
    }

    public function display_user_modifier_form_page() {
        $userId = $this->verify_cookie("user"); 
        if ($userId !== null) {
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $email = $_POST['email'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $phone = $_POST['phone'];
                $photo = $_FILES['photo'];
                $piece_identite = $_FILES['piece_identite'];
                $this->modifier_user_information_controller($userId, $email, $nom, $prenom, $phone, $photo, $piece_identite);
            }
    
            $pageName = "Modifier Informations";
            $cssFiles = [
                'public/style/variables.css',
                'public/style/user_modifier.css', 
                'public/style/menu_user.css',
                'public/style/footer.css'
            ];
            $jsFiles = [];
            $libraries = ['icons'];
    
            require_once 'Controller/Head_controller.php';
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
    
            require_once 'Controller/menu_composant_controller.php';
            $menuController = new menu_composant_controller();
            $menuController->display_menu_by_role('membre');
    
            $this->display_user_modifier_form_controller($userId);
    
            require_once 'Controller/Footer_controller.php';
            $footerController = new Footer_controller();
            $footerController->display_footer();
    
            echo '</body>';
          }
    }
            
    public function modifier_user_information_controller($id, $email, $nom, $prenom, $phone, $photo, $piece_identite) {
        $photo_personnel = null;
        $piece_identite_path = null;
        $uploadDir = 'public/image/users/';
    
        try {
            if (isset($photo) && $photo['error'] === UPLOAD_ERR_OK) {
                $photo_personnel = file_controller::chargerFile($photo, $uploadDir);
                $photo_personnel = $uploadDir . $photo_personnel; // Chemin complet
            }
    
            if (isset($piece_identite) && $piece_identite['error'] === UPLOAD_ERR_OK) {
                $piece_identite_path = file_controller::chargerFile($piece_identite, $uploadDir);
                $piece_identite_path = $uploadDir . $piece_identite_path; // Chemin complet
            }
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Erreur lors du téléchargement des fichiers : " . $e->getMessage()];
            header('Location: ./modifier_user'); 
            exit();
        }
        $result = $this->modifier_user_info_controller($id, $email, $nom, $prenom, $phone, $photo_personnel, $piece_identite_path);
       
        header('Location: ./user');
        exit();
       
    }
    
    public function modifier_user_info_controller($id, $email, $nom, $prenom, $phone, $photo_personnel, $piece_identite ) {
        $modifier = new User_model();
        $modifier ->modifier_user_info($id, $email, $nom, $prenom, $phone, $photo_personnel, $piece_identite );
    }
        
    public function deconnecter() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_COOKIE['auth_token'])) {
            setcookie('auth_token', '', time() - 3600, '/'); 
        }
        header('Location: ./home');
        exit();
    }


    public function affiche_dashbord_user_page() {
        $userId = $this->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Utilisateurs Dashboard";
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
    
            echo '<h1>Utilisateurs Dashboard</h1>';
    
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
    
            $controller = new Dashboard_Componant_controller();
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Photo', 'attribute' => 'photo_personnel', 'type' => 'image'],
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Prénom', 'attribute' => 'prenom', 'type' => 'text'],
                ['label' => 'Téléphone', 'attribute' => 'phone', 'type' => 'text'],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text'],
                ['label' => 'Membre', 'attribute' => 'membr', 'type' => 'text'],
                ['label' => 'Date d\'ajout', 'attribute' => 'date_ajouter', 'type' => 'date'],
            ];
    
            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_membre/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Voir plus',
                    'url' => '../admin/details_user/{id}',
                    'class' => 'btn-view'
                ],
                [
                    'label' => 'block',
                    'url' => '../admin/block_user_post/{id}',
                    'onclick' => "return confirm('Êtes-vous sûr de vouloir blocker cet utilisateur ?');"
                ],
            ];
    
            $controller->affiche_Dashbord(
                'User_controller',
                'get_membre_controller',
                $fields,
                [],
                $actions,
                'User_controller',
                'supprimer_user_controller'
            );
    
            $footer = new Footer_controller();
            $footer->display_footer();
    
            echo '</body>';
         }
    }

    public function affiche_user_block_page() {
        $userId = $this->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Utilisateurs Dashboard";
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
    
            echo '<h1>Utilisateurs Dashboard</h1>';
    
            $menu = new menu_composant_controller();
            $menu->display_menu_by_role('admin');
    
            $controller = new Dashboard_Componant_controller();
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'text'],
                ['label' => 'Photo', 'attribute' => 'photo_personnel', 'type' => 'image'],
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Prénom', 'attribute' => 'prenom', 'type' => 'text'],
                ['label' => 'Téléphone', 'attribute' => 'phone', 'type' => 'text'],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text'],
                ['label' => 'Membre', 'attribute' => 'membr', 'type' => 'text'],
                ['label' => 'Date d\'ajout', 'attribute' => 'date_ajouter', 'type' => 'date'],
            ];
    
            $actions = [
                [
                    'label' => 'Modifier',
                    'url' => '../admin/modifier_membre/{id}',
                    'class' => 'btn-edit'
                ],
                [
                    'label' => 'Voir plus',
                    'url' => '../admin/details_user/{id}',
                    'class' => 'btn-view'
                ],
                [
                    'label' => 'deblock',
                    'url' => '../admin/deblock_user_post/{id}',
                    'onclick' => "return confirm('Êtes-vous sûr de vouloir deblocker cet utilisateur ?');"
                ],
            ];
    
            $controller->affiche_Dashbord(
                'User_controller',
                'get_membre_block_controller',
                $fields,
                [],
                $actions,
                'User_controller',
                'supprimer_user_controller'
            );
    
            $footer = new Footer_controller();
            $footer->display_footer();
    
            echo '</body>';
         }
    }

    public function affiche_details_user_page($id) {
        $userId = $this->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Détails Utilisateur";
            $cssFiles = [
                '../../public/style/varaibles.css',
                '../../public/style/dashbord_details.css',
                '../../public/style/footer.css'
            ];
            $jsFiles = [];
            $libraries = [];
        
            // Affichage de l'en-tête de la page
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $fields = [
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Prénom', 'attribute' => 'prenom', 'type' => 'text'],
                ['label' => 'Téléphone', 'attribute' => 'phone', 'type' => 'text'],
                ['label' => 'Photo personnelle', 'attribute' => 'photo_personnel', 'type' => 'image'],
                ['label' => 'Membre', 'attribute' => 'membr', 'type' => 'text'], 
                ['label' => 'Date d\'ajout', 'attribute' => 'date_ajouter', 'type' => 'date'],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text'],
                ['label' => 'Pièce d\'identité', 'attribute' => 'piece_identite', 'type' => 'image'],

            ];
        
            $controller = new Dashboard_Componant_controller();
            $controller->display_DetailView(
                'User_controller', 
                'get_membre_by_id_controller', 
                $fields,
                [$id],
                'Détails de l\'Utilisateur'
            );
        
            $footer = new Footer_controller();
            $footer->display_footer();
        
            echo '</body>';
        }
    }


    public function affiche_modifier_membre_page($id) {
        $userId = $this->verify_cookie('admin'); 
        if ($userId !== null) {
            $pageName = "ElMountada | Modifier Utilisateur";
            $cssFiles = [
                '../../public/style/varaibles.css',
                '../../public/style/dashbord_modifier.css',
                '../../public/style/footer.css'
            ];
            $jsFiles = ['../../js/scrpt.js'];
            $libraries = ['jquery', 'icons'];
            $headController = new Head_controller();
            $headController->display_head_page($pageName, $cssFiles, $jsFiles, $libraries);
        
            $fields = [
                ['label' => 'ID', 'attribute' => 'id', 'type' => 'id'],
                ['label' => 'Nom', 'attribute' => 'nom', 'type' => 'text'],
                ['label' => 'Prénom', 'attribute' => 'prenom', 'type' => 'text'],
                ['label' => 'Téléphone', 'attribute' => 'phone', 'type' => 'text'],
                ['label' => 'Photo personnelle', 'attribute' => 'photo_personnel', 'type' => 'image'],
                ['label' => 'Pièce d\'identité', 'attribute' => 'piece_identite', 'type' => 'image'],
                ['label' => 'Membre', 'attribute' => 'membr', 'type' => 'select', 
                    'options' => [
                        ['value' => 0, 'label' => 'Non'],
                        ['value' => 1, 'label' => 'Oui']
                    ],
                    'att_option_affiche' => 'label', 
                    'att_option_return' => 'value'
                ],
                ['label' => 'Bloqué', 'attribute' => 'bloque', 'type' => 'select', 
                    'options' => [
                        ['value' => 1, 'label' => 'Oui'],
                        ['value' => 0, 'label' => 'Non']
                    ],
                    'att_option_affiche' => 'label', 
                    'att_option_return' => 'value'
                ],
                ['label' => 'Email', 'attribute' => 'email', 'type' => 'text'],
                
            ];
        
            $controller = new Dashboard_Componant_controller();
            $controller->display_ModifierForm(
                'User_controller', 
                'get_membre_by_id_controller', 
                $fields,
                [$id],
                '../../admin/modifier_membre_post', 
                'User_controller',
                'modifier_user_controller', 
                'public/images/users', 
                '../../admin/dash_users', 
                'Modifier Utilisateur' 
            );
        
            echo '</body>';
        }
    }

    public function modifier_membre_controller($id, $nom, $prenom, $phone, $photo_personnel, $piece_identite, $membr, $bloque, $email) {
        $controller =new User_model();
        $controller->modifier_membre_model($id, $nom, $prenom, $phone, $email, $membr, $bloque, $photo_personnel, $piece_identite);
    }

    public function make_block($id) {
        $controller =new User_model();
        $controller->block_model($id);
        header('Location: ../../admin/users');
        exit();
    }
    public function make_deblock($id) {
        $controller =new User_model();
        $controller->deblock_model($id);
        header('Location: ../../admin/users_block');
        exit();
    }

    public function modifier_membre() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $membr = $_POST['membr'] ?? null;
            $bloque = $_POST['bloque'] ?? null;
            $email = $_POST['email'] ?? null;
    
            // Gestion des fichiers uploadés
            $photo_personnel = null;
            $piece_identite = null;
            $uploadDir = 'public/images/users/';
    
            try {
                foreach ($_FILES as $key => $value) {
                    echo $key . ': ';
                    print_r($value);
                    echo '<br>';
                }
                if (isset($_FILES['photo_personnel']) && $_FILES['photo_personnel']['error'] === UPLOAD_ERR_OK) {
                    $photo_personnel = file_controller::chargerFile($_FILES['photo_personnel'], $uploadDir);
                    $photo_personnel = $uploadDir . $photo_personnel;
                } 
    
                if (isset($_FILES['piece_identite']) && $_FILES['piece_identite']['error'] === UPLOAD_ERR_OK) {
                    $piece_identite = file_controller::chargerFile($_FILES['piece_identite'], $uploadDir);
                    $piece_identite = $uploadDir . $piece_identite;
                } 
            } catch (Exception $e) {
                $_SESSION['errorsModifier'] = ["Erreur lors du téléchargement des fichiers : " . $e->getMessage()];
                header('Location: ./modifier_user/' . $id);
                exit();
            }
    
            if ($id && $nom && $prenom && $phone && $email) {
                $this->modifier_membre_controller($id, $nom, $prenom, $phone, $photo_personnel, $piece_identite, $membr, $bloque, $email);
                //  header('Location: ../admin/users');
                exit();
            } else {
                $_SESSION['errorsModifier'] = ["Tous les champs sont obligatoires."];
                header('Location: ./modifier_user/' . $id);
                exit();
            }
        } else {
            $_SESSION['errorsModifier'] = ["Requête invalide."];
            header('Location: ./modifier_user/' . $id);
            exit();
        }
    }

    public function supprimer_user_controller($id){
        $controller = new User_Model();
        $controller->supprimer_user_model($id);
    }
}

?>

    