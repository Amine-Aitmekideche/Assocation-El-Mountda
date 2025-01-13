<?php
    
    require_once('./View/Composant_view.php');
    class Composant_controller{
        public function Button_Routeur(){
            $button= new Composant_view();
            $r=$button->Button_Routeur();
            return $r;
        }


    }
?>