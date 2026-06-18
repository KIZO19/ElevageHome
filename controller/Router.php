<?php

class Router {
    private $_ctrl;
    private $_view;
    private $_basePath;

    public function __construct() {
        $this->_basePath = dirname(dirname(__FILE__));
    }

    public function routeReq() {
        try {
            // AUTOLOAD
            $basePath = $this->_basePath;
            spl_autoload_register(function($class) use ($basePath) {
                $paths = [
                    $basePath . "/controller/{$class}.php",
                    $basePath . "/model/manager/{$class}.php",
                    $basePath . "/model/object/{$class}.php",
                    $basePath . "/view/{$class}.php",
                ];

                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        require_once($path);
                        return;
                    }
                }
            });

            require_once($this->_basePath . '/view/View.php');
            require_once($this->_basePath . '/controller/Controller.php');

            $url = [];

            if (isset($_GET['url'])) {
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
                
                $dashboard_routes = ['dashboard'];
                $services = ['hebergement', 'restaurant', 'salle', 'reception'];
                
                if (in_array(strtolower($url[0]), $dashboard_routes)) {
                    require_once($this->_basePath . "/controller/ControllerDashboard.php");
                    $this->_ctrl = new ControllerDashboard($url);
                } elseif (in_array(strtolower($url[0]), $services)) {
                    require_once($this->_basePath . "/controller/ControllerService.php");
                    $this->_ctrl = new ControllerService($url);
                } else {
                    $controller = ucfirst(strtolower($url[0]));
                    $controllerClass = "Controller" . $controller;
                    $controllerFile = $this->_basePath . "/controller/" . $controllerClass . ".php";

                    if (file_exists($controllerFile)) {
                        require_once($controllerFile);
                        $this->_ctrl = new $controllerClass($url);
                    } else {
                        throw new Exception('Page Introuvable !');
                    }
                }
            } else {
                require_once($this->_basePath . "/controller/ControllerHome.php");
                $this->_ctrl = new ControllerHome($url);
            }

        } catch (Exception $ex) {
            $this->_view = new View("error");
            $this->_view->generate(array("errorMsg" => $ex->getMessage()));
        }
    }
}
