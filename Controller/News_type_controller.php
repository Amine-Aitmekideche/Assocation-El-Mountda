<?php
    require_once(__DIR__ . '/../Model/News_type_model.php');
    require_once(__DIR__ . '/../View/News_view.php');

    class News_type_controller{
        public function get_News_type_controller(){
            $mtf= new News_type_model();
            $r=$mtf->get_News_type_model();
            return $r;
        }

        public function get_News_type_id_controller($id){
            $mtf= new News_type_model();
            $r=$mtf->get_News_type_id_model($id);
            return $r;
        }
        public function ajouter_type_controller($type, $description) {
            $type_model = new News_type_model();
            $result = $type_model->ajouter_type($type, $description);
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Ajout type News réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de l\'ajout de type news.',
                ];
            }
        }
    
        public function modifier_type_controller($id, $type, $description) {
            $type_model = new News_type_model();
            $result = $type_model->modifier_type($id, $type, $description);
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Modification type News réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de la modification de type news.',
                ];
            }
        }
    
        public function supprimer_type_controller($id) {
            $type_model = new News_type_model();
            $result = $type_model->supprimer_type($id);
            if ($result) {
                return [
                    'status' => 'true',
                    'message' => 'Supprision type news réussi !',
                ];
            } else {
                return [
                    'status' => 'false',
                    'message' => 'Erreur lors de la Supprision  de type news.',
                ];
            }
        }
        public function affiche_type_news(){
            $v= new News_view();
            $r=$v->display_news();
        }
    }
?>