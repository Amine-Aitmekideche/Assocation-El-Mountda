<?php
function base_url($path = '') {
    // Remplacer avec la base de votre projet
    $base = 'http://localhost:8888/TDW/';
    return $base . ltrim($path, '/');
}

function recupere_arg($param) {
    $value = null;
    if (isset($_GET[$param])) {
        // Vérification si la valeur de $_GET[$param] est un entier valide
        $value = intval($_GET[$param]);
        // Si l'ID est égal à zéro mais que ce n'était pas une valeur prévue, on retourne null
        
    }
    return $value;
}
?>