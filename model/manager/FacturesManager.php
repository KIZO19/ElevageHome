<?php

class FacturesManager extends Model {
    
    public function getAllFactures() {
        return $this->fetchAll("
            SELECT f.*, c.nom_complet, c.telephone
            FROM factures f
            JOIN clients c ON f.id_client = c.id_client
            ORDER BY f.date_facturation DESC
            LIMIT 1000
        ");
    }
    
    public function getFactureById($id) {
        return $this->fetch("
            SELECT f.*, c.nom_complet, c.telephone, c.adresse_goma
            FROM factures f
            JOIN clients c ON f.id_client = c.id_client
            WHERE f.id_facture = ?
        ", [$id]);
    }
    
    public function getFacturesByClient($id_client) {
        return $this->fetchAll("
            SELECT f.*
            FROM factures f
            WHERE f.id_client = ?
            ORDER BY f.date_facturation DESC
        ", [$id_client]);
    }
    
    public function getLignesFacture($id_facture) {
        return $this->fetchAll("
            SELECT lf.*, b.code_bande
            FROM lignes_facture lf
            LEFT JOIN bandes b ON lf.id_bande = b.id_bande
            WHERE lf.id_facture = ?
            ORDER BY lf.id_ligne ASC
        ", [$id_facture]);
    }
    
    public function generateNumeroFacture() {
        $result = $this->fetch("
            SELECT MAX(CAST(SUBSTRING(numero_facture, -5) AS UNSIGNED)) as max_num
            FROM factures
            WHERE numero_facture LIKE 'FAC-%'
        ");
        
        $nextNum = ($result['max_num'] ?? 0) + 1;
        return 'FAC-' . date('Y') . '-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
    }
    
    public function addFacture($data) {
        $numero = $this->generateNumeroFacture();
        
        return $this->query("
            INSERT INTO factures (id_client, numero_facture, date_facturation, 
                                 statut_paiement, mode_paiement, montant_total_facture)
            VALUES (?, ?, ?, ?, ?, ?)
        ", [
            $data['id_client'],
            $numero,
            $data['date_facturation'] ?? date('Y-m-d'),
            $data['statut_paiement'] ?? 'non_paye',
            $data['mode_paiement'] ?? 'cash',
            $data['montant_total_facture'] ?? 0
        ]);
    }
    
    public function addLigneFacture($id_facture, $data) {
        return $this->query("
            INSERT INTO lignes_facture (id_facture, id_bande, produit_vendu, quantite, prix_unitaire_vente)
            VALUES (?, ?, ?, ?, ?)
        ", [
            $id_facture,
            $data['id_bande'] ?? null,
            $data['produit_vendu'],
            $data['quantite'] ?? 0,
            $data['prix_unitaire_vente'] ?? 0
        ]);
    }
    
    public function updateStatutPaiement($id, $statut, $mode = null) {
        $query = "UPDATE factures SET statut_paiement = ? WHERE id_facture = ?";
        $params = [$statut, $id];
        
        if ($mode) {
            $query = "UPDATE factures SET statut_paiement = ?, mode_paiement = ? WHERE id_facture = ?";
            $params = [$statut, $mode, $id];
        }
        
        return $this->query($query, $params);
    }
    
    public function updateMontantTotal($id_facture) {
        $result = $this->fetch("
            SELECT ROUND(SUM(ROUND(quantite * prix_unitaire_vente, 2)), 2) as total
            FROM lignes_facture
            WHERE id_facture = ?
        ", [$id_facture]);
        
        $total = floatval($result['total'] ?? 0);
        
        return $this->query("
            UPDATE factures
            SET montant_total_facture = ROUND(?, 2)
            WHERE id_facture = ?
        ", [$total, $id_facture]);
    }
    
    public function getMontantLignesFacture($id_facture) {
        $result = $this->fetch("
            SELECT ROUND(SUM(ROUND(quantite * prix_unitaire_vente, 2)), 2) as total
            FROM lignes_facture
            WHERE id_facture = ?
        ", [$id_facture]);
        
        return floatval($result['total'] ?? 0);
    }
    
    public function getLignesFactureWithCalcul($id_facture) {
        return $this->fetchAll("
            SELECT 
                lf.*,
                b.code_bande,
                ROUND(lf.quantite * lf.prix_unitaire_vente, 2) as montant_ligne
            FROM lignes_facture lf
            LEFT JOIN bandes b ON lf.id_bande = b.id_bande
            WHERE lf.id_facture = ?
            ORDER BY lf.id_ligne ASC
        ", [$id_facture]);
    }
    
    public function deleteLigneFacture($id_ligne) {
        return $this->query("
            DELETE FROM lignes_facture
            WHERE id_ligne = ?
        ", [$id_ligne]);
    }
    
    public function deleteFacture($id) {
        return $this->query("
            DELETE FROM factures
            WHERE id_facture = ?
        ", [$id]);
    }
    
    public function getTotalVentes() {
        $result = $this->fetch("
            SELECT SUM(montant_total_facture) as total 
            FROM factures
            WHERE statut_paiement = 'paye'
        ");
        return floatval($result['total'] ?? 0);
    }
    
    public function getTotalVentesNonPayees() {
        $result = $this->fetch("
            SELECT SUM(montant_total_facture) as total 
            FROM factures
            WHERE statut_paiement IN ('non_paye', 'avance')
        ");
        return floatval($result['total'] ?? 0);
    }
}
