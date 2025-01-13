<?php
// Activer l'affichage des erreurs pour déboguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier du routeur
require_once __DIR__ . "/Controller/Router.php";
// Créer une instance du routeur
$router = new Router();
$router->construireRoute();
// Ajouter des routes qui appellent des pages spécifiques
// $router->addRoute('/offers', 'Offers_controller.php', 'display_offers_page');
// $router->addRoute('/news', 'News_controller.php', 'affiche_news_page');

// $router->addRoute('/partiener', 'Routes/Partiener_page.php' );         // Route vers about.php
// $router->addRoute('/dash', 'Routes/dashbord.php');         // Route vers about.php
// $router->addRoute('/edit', 'Routes/modifier_page.php');         // Route vers about.php
// $router->addRoute('/partiener/:id', 'Routes/Partiener_Details_page.php');         // Route vers about.php
// $router->addRoute('/dash/:id', 'Routes/Detail_page.php');         // Route vers about.php
// $router->addRoute('/ajoute/:id', 'Routes/Ajouter_page.php');         // Route vers about.php

// Lancer le routeur
$router->run();

?>


