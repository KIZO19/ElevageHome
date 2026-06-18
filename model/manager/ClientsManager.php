<?php

class ClientsManager extends Model {
    
    public function getAllClients() {
        return $this->fetchAll("
            SELECT c.*
            FROM clients c
            ORDER BY c.nom_complet ASC
            LIMIT 1000
        ");
    }
    
    public function getClientById($id) {
        return $this->fetch("
            SELECT c.*
            FROM clients c
            WHERE c.id_client = ?
        ", [$id]);
    }
    
    public function getClientByPhone($phone) {
        return $this->fetch("
            SELECT c.*
            FROM clients c
            WHERE c.telephone = ?
        ", [$phone]);
    }
    
    public function addClient($data) {
        return $this->query("
            INSERT INTO clients (nom_complet, telephone, adresse_goma, type_client)
            VALUES (?, ?, ?, ?)
        ", [
            $data['nom_complet'] ?? '',
            $data['telephone'] ?? '',
            $data['adresse_goma'] ?? null,
            $data['type_client'] ?? 'particulier'
        ]);
    }
    
    public function updateClient($id, $data) {
        return $this->query("
            UPDATE clients 
            SET nom_complet = ?, telephone = ?, adresse_goma = ?, type_client = ?
            WHERE id_client = ?
        ", [
            $data['nom_complet'] ?? '',
            $data['telephone'] ?? '',
            $data['adresse_goma'] ?? null,
            $data['type_client'] ?? 'particulier',
            $id
        ]);
    }
    
    public function deleteClient($id) {
        return $this->query("
            DELETE FROM clients
            WHERE id_client = ?
        ", [$id]);
    }
    
    public function searchClients($query) {
        return $this->fetchAll("
            SELECT c.*
            FROM clients c
            WHERE c.nom_complet LIKE ? OR c.telephone LIKE ?
            ORDER BY c.nom_complet ASC
            LIMIT 50
        ", ['%' . $query . '%', '%' . $query . '%']);
    }
}
