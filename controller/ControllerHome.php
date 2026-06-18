<?php

class ControllerHome extends Controller {
    public function __construct($url) {
        parent::__construct($url);

        if (isset($url) && count($url) > 1) {
            throw new Exception('Page introuvable');
        }

        $this->home();
    }

    public function home() {
        $this->render('home');
    }
}
