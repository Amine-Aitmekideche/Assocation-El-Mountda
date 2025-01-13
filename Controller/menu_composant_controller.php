<?php
    require_once('Model/menu_composant_model.php');
    require_once('View/menu_composant_view.php');
    class menu_composant_controller{
        public function get_menu_item_controller(){
            $mtf= new menu_composant_model();
            $r=$mtf->get_menu_item_model();
            return $r;
        }

        public function get_menu_item_by_role_controller($role){
            $mtf= new menu_composant_model();
            $r=$mtf->get_menu_item_by_role_model($role);
            return $r;
        }

        public function get_sous_menu_item_controller($v){
            $mtf= new menu_composant_model();
            $r=$mtf->get_sous_menu_item_model($v);
            return $r;
        }

        public function display_menu(){
            $v= new menu_composant_view();
            $r=$v->display_menu();
        }

        public function display_menu_by_role($role){
            $v= new menu_composant_view();
            $r=$v->display_menu_by_role($role);
        }
    }
?>