<?php

class DepensesManager extends Model {
    
    public function getAllDepenses() {
        return $this->fetchAll("
            SELECT d.*, b.code_bande, tc.nom_categorie
            FROM depenses d
            JOIN bandes b ON d.id_bande = b.id_bande
            JOIN types_charge tc ON d.id_type_charge = tc.id_type_charge
            ORDER BY d.date_depense DESC
            LIMIT 100
        ");
    }
    
    public function getDepenseById($id) {
        return $this->fetch("
            SELECT d.*, b.code_bande, tc.nom_categorie
            FROM depenses d
            JOIN bandes b ON d.id_bande = b.id_bande
            JOIN types_charge tc ON d.id_type_charge = tc.id_type_charge
            WHERE d.id_depense = ?
        ", [$id]);
    }
    
    public function getDepensesByBande($id_bande) {
        return $this->fetchAll("
            SELECT d.*
            FROM depenses d
            WHERE d.id_bande = ?
            ORDER BY d.date_depense DESC
        ", [$id_bande]);
    }
    
    public function getTotalDepenses() {
        $result = $this->fetch("
            SELECT SUM(montant_total_charge) as total 
            FROM depenses
        ");
        return floatval($result['total'] ?? 0);
    }
    
    public function getTotalDepensesByDateRange($date_debut, $date_fin) {
        $result = $this->fetch("
            SELECT SUM(montant_total_charge) as total 
            FROM depenses
            WHERE date_depense >= ? AND date_depense <= ?
        ", [$date_debut, $date_fin]);
        return floatval($result['total'] ?? 0);
    }
    
    public function getDepensesByDateRange($date_debut, $date_fin) {
        return $this->fetchAll("
            SELECT d.*, b.code_bande, tc.nom_categorie
            FROM depenses d
            JOIN bandes b ON d.id_bande = b.id_bande
            JOIN types_charge tc ON d.id_type_charge = tc.id_type_charge
            WHERE d.date_depense >= ? AND d.date_depense <= ?
            ORDER BY d.date_depense DESC
            LIMIT 100
        ", [$date_debut, $date_fin]);
    }
    
    public function getTotalDepensesByBande($id_bande) {
        $result = $this->fetch("
            SELECT SUM(montant_total_charge) as total 
            FROM depenses
            WHERE id_bande = ?
        ", [$id_bande]);
        return floatval($result['total'] ?? 0);
    }
    
    public function getTypesCharge() {
        return $this->fetchAll("
            SELECT id_type_charge, nom_categorie
            FROM types_charge
            ORDER BY nom_categorie ASC
        ");
    }
    
    public function addDepense($data) {
        return $this->query("
            INSERT INTO depenses (id_bande, id_type_charge, libelle_depense, quantite, 
                                 unite_mesure, prix_unitaire, date_depense)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ", [
            $data['id_bande'],
            $data['id_type_charge'],
            $data['libelle_depense'] ?? 'Dépense',
            $data['quantite'] ?? 1,
            $data['unite_mesure'] ?? null,
            $data['prix_unitaire'] ?? 0,
            $data['date_depense'] ?? date('Y-m-d')
        ]);
    }
    
    public function updateDepense($id, $data) {
        return $this->query("
            UPDATE depenses 
            SET id_type_charge = ?, libelle_depense = ?, quantite = ?, unite_mesure = ?, prix_unitaire = ?, date_depense = ?
            WHERE id_depense = ?
        ", [
            $data['id_type_charge'],
            $data['libelle_depense'] ?? 'Dépense',
            $data['quantite'] ?? 1,
            $data['unite_mesure'] ?? null,
            $data['prix_unitaire'] ?? 0,
            $data['date_depense'] ?? date('Y-m-d'),
            $id
        ]);
    }
    
    public function deleteDepense($id) {
        return $this->query("
            DELETE FROM depenses
            WHERE id_depense = ?
        ", [$id]);
    }
}

