<?php

session_start();

define('ROOT_DIR', dirname(dirname(__FILE__)));

// Charger la configuration
require_once ROOT_DIR . '/config/database.php';

// Charger le routeur
require_once ROOT_DIR . '/controller/Router.php';

// Démarrer le routeur
$router = new Router();
$router->routeReq();
