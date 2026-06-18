<?php

class BandesManager extends Model {
    
    public function getAllBandes() {
        return $this->fetchAll("
            SELECT b.*, e.nom_responsable 
            FROM bandes b 
            JOIN exploitations e ON b.id_exploitation = e.id_exploitation
            ORDER BY b.date_lancement DESC
        ");
    }
    
    public function getBandeById($id) {
        return $this->fetch("
            SELECT b.*, e.nom_responsable 
            FROM bandes b 
            JOIN exploitations e ON b.id_exploitation = e.id_exploitation
            WHERE b.id_bande = ?
        ", [$id]);
    }
    
    public function getBandesActives() {
        return $this->fetchAll("
            SELECT * FROM bandes 
            WHERE statut_lot = 'en_cours'
            ORDER BY date_lancement DESC
        ");
    }
    
    public function getTotalBandas() {
        $result = $this->fetch("SELECT COUNT(*) as total FROM bandes");
        return $result['total'] ?? 0;
    }
    
    public function getTotalAnimaux() {
        $result = $this->fetch("
            SELECT SUM(quantite_initiale) as total 
            FROM bandes 
            WHERE statut_lot = 'en_cours'
        ");
        return $result['total'] ?? 0;
    }
    
    public function addBande($data) {
        return $this->query("
            INSERT INTO bandes (id_exploitation, code_bande, espece_detaillee, type_production, 
                              quantite_initiale, prix_achat_unitaire_poussin, date_lancement)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ", [
            $data['id_exploitation'],
            $data['code_bande'],
            $data['espece_detaillee'] ?? 'Poulet (Gallus gallus domesticus)',
            $data['type_production'],
            $data['quantite_initiale'],
            $data['prix_achat_unitaire_poussin'],
            $data['date_lancement']
        ]);
    }
}
