<?php

class ControllerDashboard extends Controller {
    public function __construct($url) {
        parent::__construct($url);
        
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header('Location: /ElevageHome/public/?url=auth/login');
            exit;
        }

        if (isset($url) && count($url) > 1) {
            throw new Exception('Page introuvable');
        }

        $this->dashboard();
    }

    public function dashboard() {
        // Charger les managers
        $bandesManager = new BandesManager();
        $ventesManager = new VentesManager();
        $depensesManager = new DepensesManager();
        $mortaliteManager = new MortaliteManager();

        // Déterminer les dates de filtrage
        $date_debut = $_GET['date_debut'] ?? date('Y-m-01'); // 1er du mois actuel
        $date_fin = $_GET['date_fin'] ?? date('Y-m-d');      // Aujourd'hui
        
        // Validation des dates
        if (!$this->isValidDate($date_debut)) {
            $date_debut = date('Y-m-01');
        }
        if (!$this->isValidDate($date_fin)) {
            $date_fin = date('Y-m-d');
        }
        
        // Assurer que date_debut <= date_fin
        if ($date_debut > $date_fin) {
            $temp = $date_debut;
            $date_debut = $date_fin;
            $date_fin = $temp;
        }

        // Récupérer les données avec filtrage par date
        $bandes = $bandesManager->getAllBandes();
        $depenses = $depensesManager->getDepensesByDateRange($date_debut, $date_fin);
        $ventes = $ventesManager->getVentesByDateRange($date_debut, $date_fin);
        $mortalites = $mortaliteManager->getAllMortalites();

        // Récupérer les statistiques avec filtrage par date
        $totalDepenses = $depensesManager->getTotalDepensesByDateRange($date_debut, $date_fin);
        $totalVentes = $ventesManager->getTotalVentesByDateRange($date_debut, $date_fin);
        $totalMorts = $mortaliteManager->getTotalMorts();
        $totalAnimaux = $bandesManager->getTotalAnimaux();
        $totalVendues = $ventesManager->getTotalQuantiteVenduByProduit('poulet_vif');
        $totalDisponible = max(0, $totalAnimaux - $totalVendues - $totalMorts);

        // Calculer la rentabilité
        $rentabilite = ($totalVentes - $totalDepenses);

        // Préparer les données pour le dashboard
        $data = [
            'bandes' => $bandes,
            'depenses' => $depenses,
            'ventes' => $ventes,
            'mortalites' => $mortalites,
            'totalDepenses' => $totalDepenses,
            'totalVentes' => $totalVentes,
            'totalDisponible' => $totalDisponible,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
        ];

        $this->render('dashboard', $data);
    }
    
    private function isValidDate($date) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
