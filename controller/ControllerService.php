<?php

class ControllerService extends Controller {
    private $_service;

    public function __construct($url) {
        parent::__construct($url);
        $this->_service = isset($url[0]) ? strtolower($url[0]) : 'service';
        $this->renderService();
    }

    public function renderService() {
        $serviceName = ucfirst($this->_service);
        $this->render('service', ['serviceName' => $serviceName]);
    }
}
