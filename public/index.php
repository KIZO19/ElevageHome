<?php

session_start();

define('ROOT_DIR', dirname(dirname(__FILE__)));

// Charger la configuration
require_once ROOT_DIR . '/config/database.php';

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function ($exception) {
    http_response_code(500);
    $message = $exception->getMessage();

    if (file_exists(ROOT_DIR . '/view/View.php')) {
        require_once ROOT_DIR . '/view/View.php';
        try {
            $view = new View('error');
            $view->generate(['errorMsg' => $message]);
            return;
        } catch (Exception $e) {
            // Fallback to simple rendering
        }
    }

    echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Erreur</title></head><body><h1>Erreur Serveur</h1><p>' . htmlspecialchars($message) . '</p></body></html>';
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) {
        http_response_code(500);
        $message = $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'];

        if (file_exists(ROOT_DIR . '/view/View.php')) {
            require_once ROOT_DIR . '/view/View.php';
            try {
                $view = new View('error');
                $view->generate(['errorMsg' => $message]);
                return;
            } catch (Exception $e) {
                // fallback to simple rendering
            }
        }

        echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Erreur</title></head><body><h1>Erreur Serveur</h1><p>' . htmlspecialchars($message) . '</p></body></html>';
    }
});

// Charger le routeur
require_once ROOT_DIR . '/controller/Router.php';

// Démarrer le routeur
$router = new Router();
$router->routeReq();
