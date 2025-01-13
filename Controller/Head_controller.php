<?php
require_once(__DIR__ . '/../View/Head_view.php');


class Head_controller {

    public function display_head_page($pageName, $cssFiles = [], $jsFiles = [], $libraries = []) {
        $headView = new Head_view();
        $headView->display_head($pageName, $cssFiles, $jsFiles, $libraries);
    }
}
?>
