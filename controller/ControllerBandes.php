<?php

class ControllerBandes extends Controller {
    
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
            } elseif ($method === 'view' && isset($url[2])) {
                $this->view($url[2]);
            } else {
                $this->list();
            }
        } else {
            $this->list();
        }
    }
    
    public function list() {
        $bandesManager = new BandesManager();
        $bandes = $bandesManager->getAllBandes();
        
        $this->render('bandes/list', ['bandes' => $bandes]);
    }
    
    public function view($id) {
        $bandesManager = new BandesManager();
        $bande = $bandesManager->getBandeById($id);
        
        if (!$bande) {
            throw new Exception('Bande introuvable');
        }
        
        $depensesManager = new DepensesManager();
        $ventesManager = new VentesManager();
        $mortaliteManager = new MortaliteManager();
        
        $depenses = $depensesManager->getDepensesByBande($id);
        $ventes = $ventesManager->getVentesByBande($id);
        $mortalites = $mortaliteManager->getPertesByBande($id);
        
        $data = [
            'bande' => $bande,
            'depenses' => $depenses,
            'ventes' => $ventes,
            'mortalites' => $mortalites,
            'totalDepenses' => $depensesManager->getTotalDepensesByBande($id),
            'totalVentes' => $ventesManager->getTotalVentesByBande($id),
            'tauxMortalite' => $mortaliteManager->getTauxMortalityByBande($id)
        ];
        
        $this->render('bandes/view', $data);
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['code_bande']) || empty($data['type_production']) || empty($data['quantite_initiale'])) {
                $error = 'Tous les champs obligatoires doivent être remplis';
                $this->render('bandes/add', ['error' => $error]);
                return;
            }
            
            $bandesManager = new BandesManager();
            $data['id_exploitation'] = $_SESSION['id_exploitation'] ?? 1;
            
            try {
                $bandesManager->addBande($data);
                header('Location: /ElevageHome/public/?url=bandes');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'ajout: ' . $e->getMessage();
                $this->render('bandes/add', ['error' => $error]);
            }
        } else {
            $this->render('bandes/add');
        }
    }
    
    public function edit($id) {
        $bandesManager = new BandesManager();
        $bande = $bandesManager->getBandeById($id);
        
        if (!$bande) {
            throw new Exception('Bande introuvable');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['code_bande']) || empty($data['type_production'])) {
                $error = 'Tous les champs obligatoires doivent être remplis';
                $this->render('bandes/edit', ['bande' => $bande, 'error' => $error]);
                return;
            }
            
            try {
                // Mise à jour simple
                $query = "UPDATE bandes SET code_bande = ?, type_production = ?, statut_lot = ? WHERE id_bande = ?";
                $bandesManager->query($query, [
                    $data['code_bande'],
                    $data['type_production'],
                    $data['statut_lot'],
                    $id
                ]);
                
                header('Location: /ElevageHome/public/?url=bandes/view/' . $id);
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de la modification: ' . $e->getMessage();
                $this->render('bandes/edit', ['bande' => $bande, 'error' => $error]);
            }
        } else {
            $this->render('bandes/edit', ['bande' => $bande]);
        }
    }
    
    public function delete($id) {
        $bandesManager = new BandesManager();
        $bande = $bandesManager->getBandeById($id);
        
        if (!$bande) {
            throw new Exception('Bande introuvable');
        }
        
        try {
            // Soft delete: marquer comme clôturée
            $bandesManager->query("UPDATE bandes SET statut_lot = 'cloture' WHERE id_bande = ?", [$id]);
            
            header('Location: /ElevageHome/public/?url=bandes');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
