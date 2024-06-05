<?php
    $route = [
        '/cargaison' => 'cargaison',
        '/produit' => 'produit',
    
    ];

    
    // require_once 'main.html.php';
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    

    if (array_key_exists($uri, $route)) {
        require_once 'api.php';
        require_once "template/partial/navbar.html.php";
        require "template/" . $route[$uri] . ".html.php";
            // require 'index.html.php';
    }    
?>
