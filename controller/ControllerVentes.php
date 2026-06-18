<?php

class ControllerVentes extends Controller {
    
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
        $ventesManager = new VentesManager();
        $ventes = $ventesManager->getAllVentes();
        
        $this->render('ventes/list', ['ventes' => $ventes]);
    }
    
    public function add() {
        $bandesManager = new BandesManager();
        $clientsManager = new ClientsManager();
        $ventesManager = new VentesManager();
        
        $bandes = $bandesManager->getAllBandes();
        $clients = $clientsManager->getAllClients();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['id_bande']) || empty($data['id_client']) || empty($data['produit_vendu']) || 
                empty($data['quantite_vendue']) || empty($data['prix_unitaire']) || 
                empty($data['date_vente'])) {
                $error = 'Les champs obligatoires doivent être remplis';
                $this->render('ventes/add', [
                    'error' => $error,
                    'bandes' => $bandes,
                    'clients' => $clients
                ]);
                return;
            }
            
            try {
                $ventesManager->addVente($data);
                header('Location: /ElevageHome/public/?url=ventes');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'ajout: ' . $e->getMessage();
                $this->render('ventes/add', [
                    'error' => $error,
                    'bandes' => $bandes,
                    'clients' => $clients
                ]);
            }
        } else {
            $this->render('ventes/add', [
                'bandes' => $bandes,
                'clients' => $clients
            ]);
        }
    }
    
    public function edit($id) {
        $ventesManager = new VentesManager();
        $bandesManager = new BandesManager();
        $clientsManager = new ClientsManager();
        
        $vente = $ventesManager->getVenteById($id);
        if (!$vente) {
            throw new Exception('Vente introuvable');
        }
        
        $bandes = $bandesManager->getAllBandes();
        $clients = $clientsManager->getAllClients();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            if (empty($data['id_client']) || empty($data['quantite_vendue']) || empty($data['prix_unitaire']) || 
                empty($data['date_vente'])) {
                $error = 'Les champs obligatoires doivent être remplis';
                $this->render('ventes/edit', [
                    'vente' => $vente,
                    'bandes' => $bandes,
                    'clients' => $clients,
                    'error' => $error
                ]);
                return;
            }
            
            try {
                $ventesManager->updateVente($id, $data);
                header('Location: /ElevageHome/public/?url=ventes');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur: ' . $e->getMessage();
                $this->render('ventes/edit', [
                    'vente' => $vente,
                    'bandes' => $bandes,
                    'clients' => $clients,
                    'error' => $error
                ]);
            }
        } else {
            $this->render('ventes/edit', [
                'vente' => $vente,
                'bandes' => $bandes,
                'clients' => $clients
            ]);
        }
    }
    
    public function delete($id) {
        $ventesManager = new VentesManager();
        
        $vente = $ventesManager->getVenteById($id);
        if (!$vente) {
            throw new Exception('Vente introuvable');
        }
        
        try {
            $ventesManager->deleteVente($id);
            header('Location: /ElevageHome/public/?url=ventes');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
