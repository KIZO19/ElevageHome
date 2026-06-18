<?php

class MortaliteManager extends Model {
    
    public function getAllMortalites() {
        return $this->fetchAll("
            SELECT p.*, b.code_bande
            FROM pertes_mortalite p
            JOIN bandes b ON p.id_bande = b.id_bande
            ORDER BY p.date_perte DESC
            LIMIT 100
        ");
    }
    
    public function getMortaliteById($id) {
        return $this->fetch("
            SELECT p.*, b.code_bande
            FROM pertes_mortalite p
            JOIN bandes b ON p.id_bande = b.id_bande
            WHERE p.id_perte = ?
        ", [$id]);
    }
    
    public function getPertesByBande($id_bande) {
        return $this->fetchAll("
            SELECT * FROM pertes_mortalite
            WHERE id_bande = ?
            ORDER BY date_perte DESC
        ", [$id_bande]);
    }
    
    public function getTotalMorts() {
        $result = $this->fetch("
            SELECT SUM(nbre_sujets_morts) as total 
            FROM pertes_mortalite
        ");
        return intval($result['total'] ?? 0);
    }
    
    public function getTauxMortalityByBande($id_bande) {
        $result = $this->fetch("
            SELECT 
                SUM(nbre_sujets_morts) as total_morts,
                b.quantite_initiale
            FROM pertes_mortalite p
            JOIN bandes b ON p.id_bande = b.id_bande
            WHERE p.id_bande = ?
            GROUP BY b.quantite_initiale
        ", [$id_bande]);
        
        if ($result && $result['quantite_initiale'] > 0) {
            return ($result['total_morts'] / $result['quantite_initiale']) * 100;
        }
        return 0;
    }
    
    public function getCausesProbables() {
        return $this->fetchAll("
            SELECT cause_probable, COUNT(*) as nombre
            FROM pertes_mortalite
            WHERE cause_probable IS NOT NULL
            GROUP BY cause_probable
            ORDER BY nombre DESC
        ");
    }
    
    public function addMortalite($data) {
        return $this->query("
            INSERT INTO pertes_mortalite (id_bande, date_perte, nbre_sujets_morts, cause_probable)
            VALUES (?, ?, ?, ?)
        ", [
            $data['id_bande'],
            $data['date_perte'],
            $data['nbre_sujets_morts'],
            $data['cause_probable'] ?? null
        ]);
    }
    
    public function updateMortalite($id, $data) {
        return $this->query("
            UPDATE pertes_mortalite 
            SET nbre_sujets_morts = ?, date_perte = ?, cause_probable = ?
            WHERE id_perte = ?
        ", [
            $data['nbre_sujets_morts'],
            $data['date_perte'],
            $data['cause_probable'] ?? null,
            $id
        ]);
    }
    
    public function deleteMortalite($id) {
        return $this->query("
            DELETE FROM pertes_mortalite
            WHERE id_perte = ?
        ", [$id]);
    }
}
