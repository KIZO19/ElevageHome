<?php

class ControllerDepenses extends Controller {
    
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
        $depensesManager = new DepensesManager();
        $depenses = $depensesManager->getAllDepenses();
        
        $this->render('depenses/list', ['depenses' => $depenses]);
    }
    
    public function add() {
        $bandesManager = new BandesManager();
        $depensesManager = new DepensesManager();
        
        $bandes = $bandesManager->getAllBandes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['id_bande']) || empty($data['id_type_charge']) || empty($data['libelle_depense']) || 
                empty($data['quantite']) || empty($data['unite_mesure']) ||
                empty($data['prix_unitaire']) || empty($data['date_depense'])) {
                $error = 'Tous les champs obligatoires doivent être remplis';
                $this->render('depenses/add', [
                    'error' => $error,
                    'bandes' => $bandes
                ]);
                return;
            }
            
            try {
                $depensesManager->addDepense($data);
                header('Location: /ElevageHome/public/?url=depenses');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'ajout: ' . $e->getMessage();
                $this->render('depenses/add', [
                    'error' => $error,
                    'bandes' => $bandes
                ]);
            }
        } else {
            $this->render('depenses/add', ['bandes' => $bandes]);
        }
    }
    
    public function edit($id) {
        $depensesManager = new DepensesManager();
        $bandesManager = new BandesManager();
        
        $depense = $depensesManager->getDepenseById($id);
        if (!$depense) {
            throw new Exception('Dépense introuvable');
        }
        
        $bandes = $bandesManager->getAllBandes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            if (empty($data['id_type_charge']) || empty($data['quantite']) || empty($data['unite_mesure']) || 
                empty($data['prix_unitaire']) || empty($data['date_depense']) ||
                empty($data['libelle_depense'])) {
                $error = 'Les champs obligatoires doivent être remplis';
                $this->render('depenses/edit', [
                    'depense' => $depense,
                    'bandes' => $bandes,
                    'error' => $error
                ]);
                return;
            }
            
            try {
                $depensesManager->updateDepense($id, $data);
                header('Location: /ElevageHome/public/?url=depenses');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur: ' . $e->getMessage();
                $this->render('depenses/edit', [
                    'depense' => $depense,
                    'bandes' => $bandes,
                    'error' => $error
                ]);
            }
        } else {
            $this->render('depenses/edit', [
                'depense' => $depense,
                'bandes' => $bandes
            ]);
        }
    }
    
    public function delete($id) {
        $depensesManager = new DepensesManager();
        
        $depense = $depensesManager->getDepenseById($id);
        if (!$depense) {
            throw new Exception('Dépense introuvable');
        }
        
        try {
            $depensesManager->deleteDepense($id);
            header('Location: /ElevageHome/public/?url=depenses');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
