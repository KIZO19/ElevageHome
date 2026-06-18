<?php

class ControllerClients extends Controller {
    
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
        $clientsManager = new ClientsManager();
        $clients = $clientsManager->getAllClients();
        
        $this->render('clients/list', ['clients' => $clients]);
    }
    
    public function add() {
        $clientsManager = new ClientsManager();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['nom_complet']) || empty($data['telephone'])) {
                $error = 'Le nom et le téléphone sont obligatoires';
                $this->render('clients/add', ['error' => $error]);
                return;
            }
            
            // Vérifier si téléphone existe déjà
            $existant = $clientsManager->getClientByPhone($data['telephone']);
            if ($existant) {
                $error = 'Un client avec ce numéro existe déjà';
                $this->render('clients/add', ['error' => $error]);
                return;
            }
            
            try {
                $clientsManager->addClient($data);
                header('Location: /ElevageHome/public/?url=clients');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'ajout: ' . $e->getMessage();
                $this->render('clients/add', ['error' => $error]);
            }
        } else {
            $this->render('clients/add');
        }
    }
    
    public function edit($id) {
        $clientsManager = new ClientsManager();
        
        $client = $clientsManager->getClientById($id);
        if (!$client) {
            throw new Exception('Client introuvable');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            if (empty($data['nom_complet']) || empty($data['telephone'])) {
                $error = 'Le nom et le téléphone sont obligatoires';
                $this->render('clients/edit', [
                    'client' => $client,
                    'error' => $error
                ]);
                return;
            }
            
            // Vérifier si le téléphone est utilisé par un autre client
            if ($data['telephone'] != $client['telephone']) {
                $existant = $clientsManager->getClientByPhone($data['telephone']);
                if ($existant) {
                    $error = 'Un autre client utilise déjà ce numéro';
                    $this->render('clients/edit', [
                        'client' => $client,
                        'error' => $error
                    ]);
                    return;
                }
            }
            
            try {
                $clientsManager->updateClient($id, $data);
                header('Location: /ElevageHome/public/?url=clients');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur: ' . $e->getMessage();
                $this->render('clients/edit', [
                    'client' => $client,
                    'error' => $error
                ]);
            }
        } else {
            $this->render('clients/edit', ['client' => $client]);
        }
    }
    
    public function delete($id) {
        $clientsManager = new ClientsManager();
        
        $client = $clientsManager->getClientById($id);
        if (!$client) {
            throw new Exception('Client introuvable');
        }
        
        try {
            $clientsManager->deleteClient($id);
            header('Location: /ElevageHome/public/?url=clients');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
