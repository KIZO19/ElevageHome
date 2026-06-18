<?php

class ControllerFactures extends Controller {
    
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
            } elseif ($method === 'addlignes' && isset($url[2])) {
                $this->addlignes($url[2]);
            } elseif ($method === 'deleteligne' && isset($url[2]) && isset($url[3])) {
                $this->deleteligne($url[2], $url[3]);
            } elseif ($method === 'view' && isset($url[2])) {
                $this->view($url[2]);
            } elseif ($method === 'pos' && isset($url[2])) {
                $this->pos($url[2]);
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
        $facturesManager = new FacturesManager();
        $factures = $facturesManager->getAllFactures();
        
        $this->render('factures/list', ['factures' => $factures]);
    }
    
    public function add() {
        $clientsManager = new ClientsManager();
        $facturesManager = new FacturesManager();
        $bandesManager = new BandesManager();
        
        $clients = $clientsManager->getAllClients();
        $bandes = $bandesManager->getAllBandes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Validation
            if (empty($data['id_client']) || empty($data['date_facturation'])) {
                $error = 'Client et date obligatoires';
                $this->render('factures/add', [
                    'error' => $error,
                    'clients' => $clients,
                    'bandes' => $bandes
                ]);
                return;
            }
            
            try {
                // Créer la facture
                $facturesManager->addFacture([
                    'id_client' => $data['id_client'],
                    'date_facturation' => $data['date_facturation'],
                    'statut_paiement' => $data['statut_paiement'] ?? 'non_paye',
                    'mode_paiement' => $data['mode_paiement'] ?? 'cash'
                ]);
                
                // Récupérer l'ID de la facture créée
                $factures = $facturesManager->getFacturesByClient($data['id_client']);
                $last_facture = end($factures);
                
                // Rediriger vers addlignes
                header('Location: /ElevageHome/public/?url=factures/addlignes/' . $last_facture['id_facture']);
                exit;
            } catch (Exception $e) {
                $error = 'Erreur: ' . $e->getMessage();
                $this->render('factures/add', [
                    'error' => $error,
                    'clients' => $clients,
                    'bandes' => $bandes
                ]);
            }
        } else {
            $this->render('factures/add', [
                'clients' => $clients,
                'bandes' => $bandes
            ]);
        }
    }
    
    public function addlignes($id) {
        $facturesManager = new FacturesManager();
        $bandesManager = new BandesManager();
        
        $facture = $facturesManager->getFactureById($id);
        if (!$facture) {
            throw new Exception('Facture introuvable');
        }
        
        $lignes = $facturesManager->getLignesFactureWithCalcul($id);
        $bandes = $bandesManager->getAllBandes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'add_ligne';
            
            if ($action === 'add_ligne') {
                $data = $_POST;
                
                if (empty($data['produit_vendu']) || empty($data['quantite']) || empty($data['prix_unitaire_vente'])) {
                    $error = 'Produit, quantité et prix obligatoires';
                } else {
                    try {
                        $facturesManager->addLigneFacture($id, $data);
                        // Recalculer le total
                        $facturesManager->updateMontantTotal($id);
                        
                        // Recharger pour afficher la nouvelle ligne
                        header('Location: /ElevageHome/public/?url=factures/addlignes/' . $id);
                        exit;
                    } catch (Exception $e) {
                        $error = 'Erreur: ' . $e->getMessage();
                    }
                }
                
                $lignes = $facturesManager->getLignesFactureWithCalcul($id);
                $facture = $facturesManager->getFactureById($id);
                $this->render('factures/addlignes', [
                    'facture' => $facture,
                    'lignes' => $lignes,
                    'bandes' => $bandes,
                    'error' => $error ?? null
                ]);
            } elseif ($action === 'finish') {
                header('Location: /ElevageHome/public/?url=factures/view/' . $id);
                exit;
            }
        } else {
            $this->render('factures/addlignes', [
                'facture' => $facture,
                'lignes' => $lignes,
                'bandes' => $bandes
            ]);
        }
    }
    
    public function deleteligne($id_ligne, $id_facture) {
        $facturesManager = new FacturesManager();
        
        try {
            $facturesManager->deleteLigneFacture($id_ligne);
            // Recalculer le total
            $facturesManager->updateMontantTotal($id_facture);
            
            header('Location: /ElevageHome/public/?url=factures/addlignes/' . $id_facture);
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur: ' . $e->getMessage());
        }
    }
    
    public function view($id) {
        $facturesManager = new FacturesManager();
        
        $facture = $facturesManager->getFactureById($id);
        if (!$facture) {
            throw new Exception('Facture introuvable');
        }
        
        $lignes = $facturesManager->getLignesFactureWithCalcul($id);
        
        $this->render('factures/view', [
            'facture' => $facture,
            'lignes' => $lignes
        ]);
    }
    
    public function pos($id) {
        $facturesManager = new FacturesManager();
        
        $facture = $facturesManager->getFactureById($id);
        if (!$facture) {
            throw new Exception('Facture introuvable');
        }
        
        $lignes = $facturesManager->getLignesFactureWithCalcul($id);
        
        $this->renderPartial('factures/pos', [
            'facture' => $facture,
            'lignes' => $lignes
        ]);
    }
    
    public function edit($id) {
        $facturesManager = new FacturesManager();
        
        $facture = $facturesManager->getFactureById($id);
        if (!$facture) {
            throw new Exception('Facture introuvable');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            try {
                $facturesManager->updateStatutPaiement($id, $data['statut_paiement'], $data['mode_paiement'] ?? null);
                header('Location: /ElevageHome/public/?url=factures/view/' . $id);
                exit;
            } catch (Exception $e) {
                $error = 'Erreur: ' . $e->getMessage();
                $this->render('factures/edit', [
                    'facture' => $facture,
                    'error' => $error
                ]);
            }
        } else {
            $this->render('factures/edit', ['facture' => $facture]);
        }
    }
    
    public function delete($id) {
        $facturesManager = new FacturesManager();
        
        $facture = $facturesManager->getFactureById($id);
        if (!$facture) {
            throw new Exception('Facture introuvable');
        }
        
        try {
            $facturesManager->deleteFacture($id);
            header('Location: /ElevageHome/public/?url=factures');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur: ' . $e->getMessage());
        }
    }
}
