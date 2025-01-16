<?php
    require_once(__DIR__ . '/../View/Footer_view.php');

    class Footer_controller {

        public function display_footer() {
            $footerView = new Footer_view();
            $footerView->display_footer();  
        }
    }
?>
