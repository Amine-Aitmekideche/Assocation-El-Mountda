<?php
require_once('dataBase.php');
require_once('./Controller/User_controller.php');

class Partenaire_model {

    public function get_Partenaire_model() {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Partenaires";
        $stmt = $c->prepare($qtf);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_Partenaires_by_category_model($category) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Partenaires Where categorie = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $category ,PDO::PARAM_STR);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function get_Partenaires_by_id_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "SELECT * FROM Partenaires Where id = ?";
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $id ,PDO::PARAM_INT);
        $db->execute($stmt);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db->deconnexion($c);
        return $result;
    }

    public function supprimer_model($id) {
        $db = new dataBase();
        $c = $db->connexion();
        $query = "DELETE FROM Partenaires WHERE id = ?";
        $stmt = $c->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function modifier_model($id, $nom, $willya, $adresse, $categorie, $logo, $description) {
        $db = new dataBase();
        $c = $db->connexion();
        
        if ($logo) {
            $qtf = "UPDATE Partenaires SET nom = ?, willya = ?, adresse = ?, categorie = ?, logo = ?, description = ? WHERE id = ?";
        } else {
            $qtf = "UPDATE Partenaires SET nom = ?, willya = ?, adresse = ?, categorie = ?, description = ? WHERE id = ?";
        }
        
        $stmt = $c->prepare($qtf);
        
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $willya, PDO::PARAM_STR);
        $stmt->bindParam(3, $adresse, PDO::PARAM_STR);
        $stmt->bindParam(4, $categorie, PDO::PARAM_STR);
        if ($logo) {
            $stmt->bindParam(5, $logo, PDO::PARAM_STR);
            $stmt->bindParam(6, $description, PDO::PARAM_STR);
            $stmt->bindParam(7, $id, PDO::PARAM_INT);
        } else {
            $stmt->bindParam(5, $description, PDO::PARAM_STR);
            $stmt->bindParam(6, $id, PDO::PARAM_INT);
        }
        
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }

    public function ajouter_model($nom, $willya, $adresse, $categorie, $logo, $description, $date_ajouter) {
        $db = new dataBase();
        $c = $db->connexion();
        $qtf = "INSERT INTO Partenaires (nom, willya, adresse, categorie, logo, description, date_ajouter) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $c->prepare($qtf);
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $willya, PDO::PARAM_STR);
        $stmt->bindParam(3, $adresse, PDO::PARAM_STR);
        $stmt->bindParam(4, $categorie, PDO::PARAM_STR);
        $stmt->bindParam(5, $logo, PDO::PARAM_STR);
        $stmt->bindParam(6, $description, PDO::PARAM_STR);
        $stmt->bindParam(7, $date_ajouter, PDO::PARAM_STR);
        $result = $stmt->execute();
        $db->deconnexion($c);
        return $result;
    }
    

    public function getAllPartenairesWithCompte() {
        $db = new dataBase();
        $c = $db->connexion();
    
        // Requête SQL pour récupérer les partenaires avec leurs comptes
        $qtf = "SELECT c.id, p.nom, c.email
                FROM Partenaires p
                JOIN users c ON p.id_compte = c.id
                WHERE c.role = 'partenaire'";
    
        // Préparation et exécution de la requête
        
        $stmt = $c->prepare($qtf);
        $db->execute($stmt);
        // Récupération des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Déconnexion de la base de données
        $db->deconnexion($c);
    
        return $result;
    }

    public function ajouterPartenaireCompte($nom, $email, $password) {
        $db = new dataBase();
        $c = $db->connexion();
    
        if (!$c) {
            die("Erreur de connexion à la base de données.");
        }
    
        try {
            $user = new User_controller();
            $result = $user->ajouter_controller($email, $password, 'partenaire');
    
            if (!$result) {
                echo "Erreur lors de l'insertion dans la table users.";
                return false;
            }
            $sql = "SELECT id FROM users WHERE email = ? ORDER BY id DESC LIMIT 1";
            $stmt = $c->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCompte = $row['id'] ?? null;
    
            if (!$idCompte) {
                echo "Erreur: Impossible de récupérer l'ID du partenaire ajouté.";
                return false;
            }
    
            echo "Nouveau partenaire ajouté avec l'ID : " . $idCompte;
    
            // Mettre à jour la table `Partenaires`
            $sqlPartenaire = "UPDATE Partenaires SET id_compte = ? WHERE id = ?";
            $stmtPartenaire = $c->prepare($sqlPartenaire);
            $stmtPartenaire->bindParam(1, $idCompte, PDO::PARAM_INT);
            $stmtPartenaire->bindParam(2, $nom, PDO::PARAM_STR); // Utiliser PDO::PARAM_STR pour le nom
            $stmtPartenaire->execute();
    
            $db->deconnexion($c);
    
            return $idCompte;
        } catch (Exception $e) {
            $db->deconnexion($c);
            echo "Erreur SQL : " . $e->getMessage();
            return false;
        }
    }
}
?>
