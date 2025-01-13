<?php
require_once('Controller/menu_composant_controller.php');
include_once('Controller/lien_controller.php');
class menu_composant_view{
    public function display_menu(){
       echo  '<div id="nav-container"></div>';
        echo '<nav>';
        echo '<img src="public/image/a.png" alt="logo" class="logo" onerror="alert("Image non trouvée")">';

        // echo '<img src="' . base_url('public/image/logo.png') . '" alt="logo" class="logo">';
        echo '<ul>';
        try{
            $cf = new menu_composant_controller();
            $qtf = $cf->get_menu_item_controller();
            foreach($qtf as $row){
                
                if($row["afficher"] == 1){
                    if($row["sub_item"]== 1 && $row["route"] == NULL ){
                        echo"<li><h4>".$row["item"]."<h4></li>";
                    }else{
                        echo"<li><a href=". base_url($row["route"]).">".$row["item"]."</a></li>";
                    }
                    
                }
                if($row["sub_item"]== 1){
                $qf = $cf->get_sous_menu_item_controller($row["id"]);
                echo '<ul>';
                foreach($qf as $rowS){
                    if($rowS["affichier"] == 1){
                        echo"<li><a href=". base_url($rowS["route"]).">".$rowS["item"]."</a></li>";
                    }
                }
                echo '</ul>';
                }
                echo '</li>';
    
            }
        }
        catch(Exception $e){
            echo 'err:'.$e->getMessage();
        }
    }
    
        public function display_menu_by_role($role){
            echo  '<div id="nav-container"></div>';
            echo '<nav><ul>';
            try{
                $cf = new menu_composant_controller();
                $qtf = $cf->get_menu_item_by_role_controller($role);
                foreach($qtf as $row){
                    if($row["afficher"] == 1){
                        if($row["sub_item"]== 1 && $row["route"] == NULL ){
                            echo"<li><h4>".$row["item"]."<h4></li>";
                        }else{
                            echo"<li><a href=". base_url($row["route"]).">".$row["item"]."</a></li>";
                        }
                        
                    }
                    if($row["sub_item"]== 1){
                        $qf = $cf->get_sous_menu_item_controller($row["id"]);
                        echo '<ul>';
                        foreach($qf as $rowS){
                            if($rowS["affichier"] == 1){
                                echo"<li><a href=".base_url($rowS["route"]).">".$rowS["item"]."</a></li>";
                            }
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
        
                }
            }
            catch(Exception $e){
                echo 'err:'.$e->getMessage();
            }
        
        echo '</ul></nav>';
    }
}



?>