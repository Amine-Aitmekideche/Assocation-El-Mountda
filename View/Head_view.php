<?php

class Head_view {

    public function display_head($pageName, $cssFiles = [], $jsFiles = [], $libraries = []) {
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>' . htmlspecialchars($pageName) . '</title>';

        foreach ($cssFiles as $cssFile) {
            echo '<link rel="stylesheet" href="' . htmlspecialchars($cssFile) . '">';
        }

        foreach ($libraries as $lib) {
            if ($lib == 'jquery') {
                echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
            } elseif ($lib == 'bootstrap') {
                echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
                echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
            }elseif ($lib == 'icons') {
                echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">';
            }
        }

        foreach ($jsFiles as $jsFile) {
            echo '<script defer src="' . htmlspecialchars($jsFile) . '"></script>';
        }

        echo '</head>
        <body>';
    }
}
?>
