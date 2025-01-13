<?php
require_once __DIR__ . '/../Model/Partainer_categorie_model.php';

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
}
?>
