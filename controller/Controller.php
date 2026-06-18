<?php

class Controller {
    protected $_view;
    protected $_url;
    protected $_basePath;

    public function __construct($url = []) {
        $this->_basePath = dirname(dirname(__FILE__));
        $this->_url = $url;
    }

    protected function render($view, $data = []) {
        $this->_view = new View($view);
        $this->_view->generate($data);
    }

    protected function renderPartial($view, $data = []) {
        $this->_view = new View($view);
        $this->_view->generate1($data);
    }

    protected function url() {
        return $this->_url;
    }
}
