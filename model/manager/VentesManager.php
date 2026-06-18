<?php

class VentesManager extends Model {
    private $hasClientColumn = null;

    public function hasClientColumn(): bool {
        if ($this->hasClientColumn === null) {
            $result = $this->fetchAll("SHOW COLUMNS FROM ventes_recettes LIKE 'id_client'");
            $this->hasClientColumn = !empty($result);
        }
        return $this->hasClientColumn;
    }

    private function getVenteSelectQuery(): string {
        if ($this->hasClientColumn()) {
            return "SELECT v.*, b.code_bande, c.nom_complet AS client_nom
                    FROM ventes_recettes v
                    JOIN bandes b ON v.id_bande = b.id_bande
                    LEFT JOIN clients c ON v.id_client = c.id_client";
        }

        return "SELECT v.*, b.code_bande
                FROM ventes_recettes v
                JOIN bandes b ON v.id_bande = b.id_bande";
    }

    public function getAllVentes() {
        return $this->fetchAll($this->getVenteSelectQuery() . "
            ORDER BY v.date_vente DESC
            LIMIT 100
        ");
    }
    
    public function getVenteById($id) {
        return $this->fetch($this->getVenteSelectQuery() . "
            WHERE v.id_vente = ?
        ", [$id]);
    }
    
    public function getVentesByClient($id_client) {
        if (!$this->hasClientColumn()) {
            return [];
        }

        return $this->fetchAll("SELECT v.*, b.code_bande
            FROM ventes_recettes v
            JOIN bandes b ON v.id_bande = b.id_bande
            WHERE v.id_client = ?
            ORDER BY v.date_vente DESC
        ", [$id_client]);
    }
    
    public function getTotalVentes() {
        $result = $this->fetch("
            SELECT SUM(montant_total_recette) as total 
            FROM ventes_recettes
        ");
        return floatval($result['total'] ?? 0);
    }

    public function getTotalQuantiteVenduByProduit($produit) {
        $result = $this->fetch("
            SELECT SUM(quantite_vendue) as total
            FROM ventes_recettes
            WHERE produit_vendu = ?
        ", [$produit]);
        return floatval($result['total'] ?? 0);
    }
    
    public function getTotalVentesByDateRange($date_debut, $date_fin) {
        $result = $this->fetch("
            SELECT SUM(montant_total_recette) as total 
            FROM ventes_recettes
            WHERE date_vente >= ? AND date_vente <= ?
        ", [$date_debut, $date_fin]);
        return floatval($result['total'] ?? 0);
    }
    
    public function getVentesByDateRange($date_debut, $date_fin) {
        return $this->fetchAll($this->getVenteSelectQuery() . "
            WHERE v.date_vente >= ? AND v.date_vente <= ?
            ORDER BY v.date_vente DESC
            LIMIT 100
        ", [$date_debut, $date_fin]);
    }
    
    public function getTotalVentesByBande($id_bande) {
        $result = $this->fetch("
            SELECT SUM(montant_total_recette) as total 
            FROM ventes_recettes
            WHERE id_bande = ?
        ", [$id_bande]);
        return floatval($result['total'] ?? 0);
    }
    
    public function getVentesByProduit() {
        return $this->fetchAll("
            SELECT produit_vendu,
                   COUNT(*) as nombre,
                   SUM(quantite_vendue) as quantite_totale,
                   SUM(montant_total_recette) as montant_total
            FROM ventes_recettes
            GROUP BY produit_vendu
            ORDER BY montant_total DESC
        ");
    }
    
    public function getRevenueByMonth() {
        return $this->fetchAll("
            SELECT DATE_FORMAT(date_vente, '%Y-%m') as mois,
                   SUM(montant_total_recette) as total
            FROM ventes_recettes
            GROUP BY DATE_FORMAT(date_vente, '%Y-%m')
            ORDER BY mois DESC
            LIMIT 12
        ");
    }
    
    public function addVente($data) {
        if ($this->hasClientColumn()) {
            return $this->query("
                INSERT INTO ventes_recettes (id_bande, id_client, produit_vendu, quantite_vendue, 
                                            prix_unitaire_vente, date_vente, acheteur_ou_marche)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ", [
                $data['id_bande'],
                $data['id_client'] ?? null,
                $data['produit_vendu'] ?? 'poulet_vif',
                $data['quantite_vendue'],
                $data['prix_unitaire'],
                $data['date_vente'],
                $data['acheteur_ou_marche'] ?? null
            ]);
        }

        return $this->query("
            INSERT INTO ventes_recettes (id_bande, produit_vendu, quantite_vendue, 
                                        prix_unitaire_vente, date_vente, acheteur_ou_marche)
            VALUES (?, ?, ?, ?, ?, ?)
        ", [
            $data['id_bande'],
            $data['produit_vendu'] ?? 'poulet_vif',
            $data['quantite_vendue'],
            $data['prix_unitaire'],
            $data['date_vente'],
            $data['acheteur_ou_marche'] ?? null
        ]);
    }
    
    public function updateVente($id, $data) {
        if ($this->hasClientColumn()) {
            return $this->query("
                UPDATE ventes_recettes 
                SET id_client = ?, quantite_vendue = ?, prix_unitaire_vente = ?, 
                    date_vente = ?, acheteur_ou_marche = ?
                WHERE id_vente = ?
            ", [
                $data['id_client'] ?? null,
                $data['quantite_vendue'],
                $data['prix_unitaire'],
                $data['date_vente'],
                $data['acheteur_ou_marche'] ?? null,
                $id
            ]);
        }

        return $this->query("
            UPDATE ventes_recettes 
            SET quantite_vendue = ?, prix_unitaire_vente = ?, 
                date_vente = ?, acheteur_ou_marche = ?
            WHERE id_vente = ?
        ", [
            $data['quantite_vendue'],
            $data['prix_unitaire'],
            $data['date_vente'],
            $data['acheteur_ou_marche'] ?? null,
            $id
        ]);
    }
    
    public function deleteVente($id) {
        return $this->query("
            DELETE FROM ventes_recettes
            WHERE id_vente = ?
        ", [$id]);
    }
}

