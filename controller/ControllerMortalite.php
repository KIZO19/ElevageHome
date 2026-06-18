<?php

class ControllerMortalite extends Controller {
    
    public function __construct($url) {
        parent::__construct($url);
        
        // Vérifier l'authentification
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ElevageHome/public/?url=auth/login');
            exit;
        }
        
        if (isset($url[1])) {
            $method = strtolower($url[1]);
            
            if ($method === 'add') {
                $this->add();
            } elseif ($method === 'edit' && isset($url[2])) {
                $this->edit($url[2]);
            } elseif ($method === 'delete' && isset($url[2])) {
                $this->delete($url[2]);
            } else {
                $this->list();
            }
        } else {
            $this->list();
        }
    }
    
    public function list() {
        $mortaliteManager = new MortaliteManager();
        $mortalites = $mortaliteManager->getAllMortalites();
        
        $this->render('mortalite/list', ['mortalites' => $mortalites]);
    }
    
    public function add() {
        $bandesManager = new BandesManager();
        $mortaliteManager = new MortaliteManager();
        
        $bandes = $bandesManager->getAllBandes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['id_bande']) || empty($data['nbre_sujets_morts']) || 
                empty($data['date_perte'])) {
                $error = 'Les champs obligatoires doivent être remplis';
                $this->render('mortalite/add', [
                    'error' => $error,
                    'bandes' => $bandes
                ]);
                return;
            }
            
            try {
                $mortaliteManager->addMortalite($data);
                header('Location: /ElevageHome/public/?url=mortalite');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'ajout: ' . $e->getMessage();
                $this->render('mortalite/add', [
                    'error' => $error,
                    'bandes' => $bandes
                ]);
            }
        } else {
            $this->render('mortalite/add', ['bandes' => $bandes]);
        }
    }
    
    public function edit($id) {
        $mortaliteManager = new MortaliteManager();
        $bandesManager = new BandesManager();
        
        $mortalite = $mortaliteManager->getMortaliteById($id);
        if (!$mortalite) {
            throw new Exception('Mortalité introuvable');
        }
        
        $bandes = $bandesManager->getAllBandes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            if (empty($data['nombre_morts']) || empty($data['date_perte'])) {
                $error = 'Les champs obligatoires doivent être remplis';
                $this->render('mortalite/edit', [
                    'mortalite' => $mortalite,
                    'bandes' => $bandes,
                    'error' => $error
                ]);
                return;
            }
            
            try {
                $mortaliteManager->updateMortalite($id, $data);
                header('Location: /ElevageHome/public/?url=mortalite');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur: ' . $e->getMessage();
                $this->render('mortalite/edit', [
                    'mortalite' => $mortalite,
                    'bandes' => $bandes,
                    'error' => $error
                ]);
            }
        } else {
            $this->render('mortalite/edit', [
                'mortalite' => $mortalite,
                'bandes' => $bandes
            ]);
        }
    }
    
    public function delete($id) {
        $mortaliteManager = new MortaliteManager();
        
        $mortalite = $mortaliteManager->getMortaliteById($id);
        if (!$mortalite) {
            throw new Exception('Mortalité introuvable');
        }
        
        try {
            $mortaliteManager->deleteMortalite($id);
            header('Location: /ElevageHome/public/?url=mortalite');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
