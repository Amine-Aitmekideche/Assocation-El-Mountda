<?php
require_once('Controller/User_controller.php');
include_once('Controller/lien_controller.php');

class User_view {
    public function display_connexion() {
        
        echo '<div class="containe_center">';
        echo '<div class="login-container">
                <h1>Connexion</h1>';

        session_start();
        if (isset($_SESSION['errors'])) {
            echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . $error . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errors']);
        }
        
        echo '<form method="POST" action="./connxionInsert">
        
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <span class="show-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i> 
                    </span>
                </div>
                

                <a href="./inscription">Créer un compte</a>
                <button type="submit">Se connecter</button>
            </form>
        </div>';
        echo '</div>';
    }

    public function display_inscription() {
        echo '<div class="signup-container">
                <h1>Créer un compte</h1>';
    
        
        session_start();
        if (isset($_SESSION['errors'])) {
            echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . $error . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errors']);
        }
    
        echo '<form method="POST" action="./inscriptionInsert" enctype="multipart/form-data">
                <label for="first_name">Prénom</label>
                <input type="text" id="first_name" name="first_name" required>
    
                <label for="last_name">Nom</label>
                <input type="text" id="last_name" name="last_name" required>
    
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
    
                <label for="phone">Numéro de téléphone</label>
                <input type="text" id="phone" name="phone" pattern="[0-9]{10}" required>
    
                <label for="password">Mot de passe</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <span class="show-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i> 
                    </span>
                </div>
    
                <label for="profile_photo">Photo de profil</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" >
    
                <label for="id_photo">Photo de la carte d\'identité</label>
                <input type="file" id="id_photo" name="id_photo" accept="image/*" >
    
                <button type="submit">Créer un compte</button>
            </form>
        </div>';
    }
    public function user_info_view($id) {
        echo '<div class="user-info-container">';
        
        try {
            $userController = new User_controller();
            
            $user = $userController->get_user_by_id_controller($id);
            $membre = $userController->get_membre_by_id_controller($id);
            
            if ($user && $membre) {
                echo '<div class="user-details">';
                
                if (!empty($membre[0]['photo_personnel'])) {
                    echo '<div class="user-photo">';
                    echo '<img src="' . htmlspecialchars(base_url($membre[0]['photo_personnel'])) . '" alt="Photo de l\'utilisateur">';
                    echo '</div>';
                }
                
                echo '<h2>Informations Personnelles</h2>';
                echo '<p><strong>Email :</strong> ' . htmlspecialchars($user[0]['email']) . '</p>';
                echo '<p><strong>Nom :</strong> ' . htmlspecialchars($membre[0]['nom']) . '</p>';
                echo '<p><strong>Prénom :</strong> ' . htmlspecialchars($membre[0]['prenom']) . '</p>';
                echo '<p><strong>Téléphone :</strong> ' . htmlspecialchars($membre[0]['phone']) . '</p>';
                
                if (!empty($membre[0]['piece_identite'])) {
                    echo '<div class="user-identity">';
                    echo '<h2>Pièce d\'Identité</h2>';
                    echo '<img src="' . htmlspecialchars(base_url($membre[0]['piece_identite'])) . '" alt="Pièce d\'identité">';
                    echo '</div>';
                }
                
                echo '</div>';
            } else {
                echo '<p class="error-message">Les informations de l\'utilisateur sont introuvables.</p>';
            }
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        
        echo '</div>';
    }
    public function display_user_modifier_form($id) {
        $userController = new User_controller();
        $user = $userController->get_user_by_id_controller($id);
        $membre = $userController->get_membre_by_id_controller($id);
    
        echo '<form method="POST" enctype="multipart/form-data">';
        session_start();
        if (isset($_SESSION['errors'])) {
            echo '<div style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p style="margin: 0; font-size: 14px; font-family: Arial, sans-serif;">&#9888; ' . $error . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errors']);
        }
        echo '<label for="email">Email:</label>';
        echo '<input type="email" name="email" value="' . htmlspecialchars($user[0]['email']) . '"require><br>';
    
        echo '<label for="nom">Nom:</label>';
        echo '<input type="text" name="nom" value="' . htmlspecialchars($membre[0]['nom']) . '"require><br>';
    
        echo '<label for="prenom">Prénom:</label>';
        echo '<input type="text" name="prenom" value="' . htmlspecialchars($membre[0]['prenom']) . '"require><br>';
    
        echo '<label for="prenom">phone:</label>';
        echo '<input type="text" name="phone" value="' . htmlspecialchars($membre[0]['phone']) . '" 
      pattern="^\d{10}$" 
      title="Veuillez entrer un numéro de téléphone valide composé de 10 chiffres (ex : 0123456789)." 
      required><br>';

    
        echo '<label for="photo">Photo de profil:</label>';
        if (!empty($membre[0]['photo_personnel'])) {
            echo '<div class="user-photo">';
            echo '<img src="' . htmlspecialchars(base_url($membre[0]['photo_personnel'])) . '" alt="Photo de l\'utilisateur" style="max-width: 150px;"><br>';
            echo 'Nouvelle photo (la photo existante sera remplacée) :<br>';
        }
        echo '<input type="file" name="photo"><br>';
    
        echo '<label for="piece_identite">Pièce d\'identité:</label>';
        if (!empty($membre[0]['piece_identite'])) {
            echo '<div class="user-identity">';
            echo '<img src="' . htmlspecialchars(base_url($membre[0]['piece_identite'])) . '" alt="Pièce d\'identité" style="max-width: 150px;"><br>';
            echo 'Nouvelle pièce d\'identité (la pièce existante sera remplacée) :<br>';
        }
        echo '<input type="file" name="piece_identite"><br>';
        echo '</div>';
        echo '<button type="submit" name="submit">Modifier</button>';
        echo '</form>';
        echo '</div>';

    }
    
    
}
?>
