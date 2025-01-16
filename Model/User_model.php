<?php
require_once('dataBase.php');
class User_model {


    public function ajouter_model($email, $password, $role) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->bindParam(2, $password, PDO::PARAM_STR); 
        $stmt->bindParam(3, $role, PDO::PARAM_STR); 
        
        $result = $stmt->execute();
        print_r($result);
        $db->deconnexion($c);
        return $result;
    }

    public function get_user_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM users";
        $stmt = $c->prepare($qtf);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_membre_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT *
        FROM membre m
        JOIN users u ON m.id = u.id
        WHERE m.bloque = 0";        
        $stmt = $c->prepare($qtf);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$row) {
            $row['membr'] = $row['membr'] == 1 ? 'oui' : 'non';
        }
        $db->deconnexion($c);
        return $result;
    }

    public function get_membre_block_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT *
        FROM membre m
        JOIN users u ON m.id = u.id
        WHERE m.bloque = 1";        
        $stmt = $c->prepare($qtf);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$row) {
            $row['membr'] = $row['membr'] == 1 ? 'oui' : 'non';
        }
        $db->deconnexion($c);
        return $result;
    }

    public function get_membre_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT *
        FROM membre m
        JOIN users u ON m.id = u.id
        WHERE m.id = ?";        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$row) {
            $row['membr'] = $row['membr'] == 1 ? 'oui' : 'non';
        }
        $db->deconnexion($c);
        return $result;
    }

    public function get_user_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM users WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_user_by_email_model($email) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM users WHERE email = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_users_by_role_model($role) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM users WHERE role = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $role, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }
    public function get_membre_by_ids_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        
        $qtf = "SELECT * FROM membre WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $db->deconnexion($c);
        return $result;
    }
    
    // public function modifier_model($id, $email, $password, $role) {
    //     $db = $this->db;
    //     $c = $db->connexion();
    //     $qtf = "UPDATE users SET email = ?, password = ?, role = ? WHERE id = ?";
        
    //     $stmt = $c->prepare($qtf);
    //     $stmt->bindParam(1, $email, PDO::PARAM_STR);
    //     $stmt->bindParam(2, $password, PDO::PARAM_STR); 
    //     $stmt->bindParam(3, $role, PDO::PARAM_STR);
    //     $stmt->bindParam(4, $id, PDO::PARAM_INT);
        
    //     $result = $stmt->execute();
    //     $db->deconnexion($c);
    //     return $result;
    // }

    public function modifier_model($id, $email, $role, $password = null) {
        $db = new dataBase();
        $c = $db->connexion();
    
    
        try {
            $sql = "UPDATE users SET email = :email, role = :role";
            if (!empty($password)) {
                $sql .= ", password = :password";
            }
            $sql .= " WHERE id = :id";
    
            $stmt = $c->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            if (!empty($password)) {
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            }
    
            $stmt->execute();
            $db->deconnexion($c);
            return true;
        } catch (Exception $e) {
            $db->deconnexion($c);
            return false;
        }
    }
    
    
    public function ajouter_user_model($email, $password, $nom, $prenom, $phone, $photoprofile, $photoIdentiti, $date_ajouter) {
        $db = new dataBase();
        $c = $db->connexion();
    
        try {
            $qtf = "INSERT INTO users (email, password, role) VALUES (?, ?, 'user')";
            $stmt = $c->prepare($qtf);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->bindParam(2, $password, PDO::PARAM_STR);
            $result = $stmt->execute();
            if ($result) {
                $id_user = $c->lastInsertId();
                if ($id_user) {
                    echo "Nouvel utilisateur ajouté avec l'ID : " . $id_user;
                } else {
                    echo "Erreur: Impossible de récupérer l'ID de l'utilisateur ajouté.";
                }
            } else {
                echo "Erreur lors de l'ajout de l'utilisateur.";
            }
            $user = "INSERT INTO membre (id, nom, prenom, phone, photo_personnel, piece_identite, membr , date_ajouter) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $c->prepare($user);
            $stmt->bindParam(1, $id_user, PDO::PARAM_INT);
            $stmt->bindParam(2, $nom, PDO::PARAM_STR);
            $stmt->bindParam(3, $prenom, PDO::PARAM_STR);
            $stmt->bindParam(4, $phone, PDO::PARAM_STR);
            $stmt->bindParam(5, $photoprofile, PDO::PARAM_STR);
            $stmt->bindParam(6, $photoIdentiti, PDO::PARAM_STR);
            $stmt->bindValue(7, 0, PDO::PARAM_INT);
            $stmt->bindParam(8, $date_ajouter, PDO::PARAM_STR);
            $result = $stmt->execute();
    
            echo '<p class="success-message">Partenaire ajouté avec succès.</p>';
    
        } catch (Exception $e) {
            echo '<p class="error-message">Erreur lors de l\'ajout : ' . $e->getMessage() . '</p>';
        } finally {
            $db->deconnexion($c);
        }
        return $id_user;
    }
    
    public function emailExists($email) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $db->deconnexion($c);
        return $stmt->fetchColumn() > 0;
    }
    public function modifier_isConnecte($userId, $token) {
        $db = new dataBase();
        $c = $db->connexion();
    
        $qtf = "UPDATE users SET isConnected = ? WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $token, PDO::PARAM_STR);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT); 
        $result = $stmt->execute();
    
        $db->deconnexion($c); 
        return $result;
    }
    public function get_user_id_by_isConnected($token) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM users WHERE isConnected = ? ";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $token, PDO::PARAM_STR); 
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
    
        return $result ? $result : null;
    }
    
    public function modifier_user_info($id, $email, $nom, $prenom, $phone, $photo_personnel = null, $piece_identite = null) {
        $db = new dataBase();
        $c = $db->connexion();
        try {
            $query_users = "UPDATE users SET email = ? WHERE id = ?";
            $stmt_users = $c->prepare($query_users);
            $stmt_users->bindParam(1, $email);
            $stmt_users->bindParam(2, $id);
            $stmt_users->execute();
    
            $query_membre = "UPDATE membre SET nom = ?, prenom = ?, phone = ?";
            
            if ($photo_personnel && $piece_identite) {
                $query_membre .= ", photo_personnel = ?, piece_identite = ?";
            } elseif ($photo_personnel) {
                $query_membre .= ", photo_personnel = ?";
            } elseif ($piece_identite) {
                $query_membre .= ", piece_identite = ?";
            }
            
            $query_membre .= " WHERE id = ?";
            $stmt_membre = $c->prepare($query_membre);
            
            $stmt_membre->bindParam(1, $nom);
            $stmt_membre->bindParam(2, $prenom);
            $stmt_membre->bindParam(3, $phone);
            
            if ($photo_personnel && $piece_identite) {
                $stmt_membre->bindParam(4, $photo_personnel);
                $stmt_membre->bindParam(5, $piece_identite);
                $stmt_membre->bindParam(6, $id);
            } elseif ($photo_personnel) {
                $stmt_membre->bindParam(4, $photo_personnel);
                $stmt_membre->bindParam(5, $id);
            } elseif ($piece_identite) {
                $stmt_membre->bindParam(4, $piece_identite);
                $stmt_membre->bindParam(5, $id);
            } else {
                $stmt_membre->bindParam(4, $id);
            }
    
            $stmt_membre->execute();
    
            $db->deconnexion($c);
            return true;
        } catch (Exception $e) {
            $db->deconnexion($c);
            return false;
        }
    }

    public function modifier_membre_model($id, $nom, $prenom, $phone, $email, $membr, $bloque, $photo_personnel , $piece_identite ) {
        $db = new dataBase();
        $c = $db->connexion();
        try {
            echo "ID: $id, Nom: $nom, Prenom: $prenom, Phone: $phone, Email: $email, Membre: $membr, Bloque: $bloque, Photo Personnel: $photo_personnel, Piece Identite: $piece_identite";
            $query_users = "UPDATE users SET email = ? WHERE id = ?";
            $stmt_users = $c->prepare($query_users);
            $stmt_users->bindParam(1, $email);
            $stmt_users->bindParam(2, $id);
            $stmt_users->execute();
    
            // Mettre à jour la table `membre` (nom, prenom, phone, membr, bloque, photo_personnel, piece_identite)
            $query_membre = "UPDATE membre SET nom = ?, prenom = ?, phone = ?, membr = ?, bloque = ?";
    
            // Ajouter les champs optionnels (photo_personnel et piece_identite)
            if ($photo_personnel && $piece_identite) {
                $query_membre .= ", photo_personnel = ?, piece_identite = ?";
            } elseif ($photo_personnel) {
                $query_membre .= ", photo_personnel = ?";
            } elseif ($piece_identite) {
                $query_membre .= ", piece_identite = ?";
            }
    
            // Ajouter la condition WHERE
            $query_membre .= " WHERE user_id = ?"; // Assurez-vous que la clé étrangère est correcte
            $stmt_membre = $c->prepare($query_membre);
    
            // Liaison des paramètres obligatoires
            $stmt_membre->bindParam(1, $nom);
            $stmt_membre->bindParam(2, $prenom);
            $stmt_membre->bindParam(3, $phone);
            $stmt_membre->bindParam(4, $membr);
            $stmt_membre->bindParam(5, $bloque);
    
            // Liaison des paramètres optionnels
            if ($photo_personnel && $piece_identite) {
                $stmt_membre->bindParam(6, $photo_personnel);
                $stmt_membre->bindParam(7, $piece_identite);
                $stmt_membre->bindParam(8, $id);
            } elseif ($photo_personnel) {
                $stmt_membre->bindParam(6, $photo_personnel);
                $stmt_membre->bindParam(7, $id);
            } elseif ($piece_identite) {
                $stmt_membre->bindParam(6, $piece_identite);
                $stmt_membre->bindParam(7, $id);
            } else {
                $stmt_membre->bindParam(6, $id);
            }
    
            // Exécution de la requête
            $stmt_membre->execute();
    
            // Déconnexion de la base de données
            $db->deconnexion($c);
            return true;
        } catch (Exception $e) {
            // En cas d'erreur, déconnexion et retour false
            $db->deconnexion($c);
            return false;
        }
    }
    public function block_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE membre SET bloque = 1 WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    public function deblock_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "UPDATE membre SET bloque = 0 WHERE id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function supprimer_user_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        try {
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $c->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $result = $stmt->execute();
    
            $db->deconnexion($c);
    
            return $result; 
        } catch (Exception $e) {
            $db->deconnexion($c);
            return false;
        }
    }
    
    
}
?>
