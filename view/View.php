<?php

class View {
    private $_file;
    private $_basePath;

    public function __construct($action) {
        $this->_basePath = dirname(dirname(__FILE__));
        $action = strtolower($action);
        
        $searchPaths = [
            $this->_basePath . '/view/pages/' . $action . '.php',
            $this->_basePath . '/view/pages/auth/' . $action . '.php',
            $this->_basePath . '/view/pages/services/' . $action . '.php',
            $this->_basePath . '/view/admin/' . $action . '.php',
        ];

        foreach ($searchPaths as $path) {
            if (file_exists($path)) {
                $this->_file = $path;
                return;
            }
        }

        throw new Exception("La vue '$action' est introuvable.");
    }

    private function generateFile1($file, $data = []) {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        throw new Exception('Fichier ' . $file . ' introuvable.');
    }

    public function generate($data = []) {
        $content = $this->generateFile1($this->_file, $data);
        $templateFile = $this->_basePath . '/view/template.php';
        $view = $this->generateFile1($templateFile, ['content' => $content]);
        echo $view;
    }

    public function generate1($data = []) {
        $content = $this->generateFile1($this->_file, $data);
        echo $content;
    }
}
