<?php

class UtilisateursManager extends Model {
    
    public function getUserByEmail($email) {
        return $this->fetch("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            WHERE u.email = ?
        ", [$email]);
    }
    
    public function getUserById($id) {
        return $this->fetch("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            WHERE u.id_utilisateur = ?
        ", [$id]);
    }
    
    public function getAllUtilisateurs() {
        return $this->fetchAll("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            ORDER BY u.created_at DESC
        ");
    }
    
    public function getPendingUsers() {
        return $this->fetchAll("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            WHERE u.email_confirmed = FALSE
            ORDER BY u.created_at DESC
        ");
    }
    
    public function getConfirmedUsers() {
        return $this->fetchAll("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            WHERE u.email_confirmed = TRUE
            ORDER BY u.created_at DESC
        ");
    }
    
    public function getUserByConfirmationToken($token) {
        return $this->fetch("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            WHERE u.confirmation_token = ? 
            AND u.confirmation_token_expires > NOW()
        ", [$token]);
    }
    
    public function getUserByResetToken($token) {
        return $this->fetch("
            SELECT u.*, r.nom_role, e.nom_responsable
            FROM utilisateurs u
            JOIN roles r ON u.id_role = r.id_role
            LEFT JOIN exploitations e ON u.id_exploitation = e.id_exploitation
            WHERE u.reset_token = ? 
            AND u.reset_token_expires > NOW()
        ", [$token]);
    }
    
    public function verifyPassword($email, $password) {
        $user = $this->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        
        return false;
    }
    
    public function addUtilisateur($data) {
        if (empty($data['mot_de_passe'])) {
            throw new Exception('Le mot de passe est obligatoire');
        }
        
        try {
            // Try with email_confirmed column (after migration)
            return $this->query("
                INSERT INTO utilisateurs (id_role, id_exploitation, nom, prenom, email, mot_de_passe, email_confirmed)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ", [
                $data['id_role'],
                $data['id_exploitation'] ?? null,
                $data['nom'],
                $data['prenom'],
                $data['email'],
                password_hash($data['mot_de_passe'], PASSWORD_BCRYPT),
                $data['email_confirmed'] ?? FALSE
            ]);
        } catch (Exception $e) {
            // If column doesn't exist, use old query without email_confirmed
            if (strpos($e->getMessage(), 'email_confirmed') !== false) {
                return $this->query("
                    INSERT INTO utilisateurs (id_role, id_exploitation, nom, prenom, email, mot_de_passe)
                    VALUES (?, ?, ?, ?, ?, ?)
                ", [
                    $data['id_role'],
                    $data['id_exploitation'] ?? null,
                    $data['nom'],
                    $data['prenom'],
                    $data['email'],
                    password_hash($data['mot_de_passe'], PASSWORD_BCRYPT)
                ]);
            }
            throw $e;
        }
    }
    
    public function updateUtilisateur($id, $data) {
        $query = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, id_role = ?, id_exploitation = ?, statut_compte = ?";
        $params = [
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['id_role'],
            $data['id_exploitation'] ?? null,
            $data['statut_compte'] ?? 'actif'
        ];

        if (!empty($data['mot_de_passe'])) {
            $query .= ", mot_de_passe = ?";
            $params[] = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);
        }

        $query .= " WHERE id_utilisateur = ?";
        $params[] = $id;

        return $this->query($query, $params);
    }
    
    public function setConfirmationToken($id, $token, $expiresAt) {
        return $this->query("
            UPDATE utilisateurs 
            SET confirmation_token = ?, confirmation_token_expires = ?
            WHERE id_utilisateur = ?
        ", [$token, $expiresAt, $id]);
    }
    
    public function confirmEmail($id) {
        return $this->query("
            UPDATE utilisateurs 
            SET email_confirmed = TRUE, confirmation_token = NULL, confirmation_token_expires = NULL
            WHERE id_utilisateur = ?
        ", [$id]);
    }
    
    public function setResetToken($id, $token, $expiresAt) {
        return $this->query("
            UPDATE utilisateurs 
            SET reset_token = ?, reset_token_expires = ?
            WHERE id_utilisateur = ?
        ", [$token, $expiresAt, $id]);
    }
    
    public function resetPassword($id, $newPassword) {
        return $this->query("
            UPDATE utilisateurs 
            SET mot_de_passe = ?, reset_token = NULL, reset_token_expires = NULL
            WHERE id_utilisateur = ?
        ", [password_hash($newPassword, PASSWORD_BCRYPT), $id]);
    }
    
    public function updateProfile($id, $data) {
        return $this->query("
            UPDATE utilisateurs 
            SET nom = ?, prenom = ?, profile_completed = TRUE
            WHERE id_utilisateur = ?
        ", [
            $data['nom'],
            $data['prenom'],
            $id
        ]);
    }
    
    public function changePassword($id, $newPassword) {
        return $this->query("
            UPDATE utilisateurs 
            SET mot_de_passe = ?
            WHERE id_utilisateur = ?
        ", [password_hash($newPassword, PASSWORD_BCRYPT), $id]);
    }
    
    public function suspendUser($id) {
        return $this->query("
            UPDATE utilisateurs SET statut_compte = 'suspendu' WHERE id_utilisateur = ?
        ", [$id]);
    }
    
    public function activateUser($id) {
        return $this->query("
            UPDATE utilisateurs SET statut_compte = 'actif' WHERE id_utilisateur = ?
        ", [$id]);
    }
    
    public function updateUserRole($id, $roleId) {
        return $this->query("
            UPDATE utilisateurs SET id_role = ? WHERE id_utilisateur = ?
        ", [$roleId, $id]);
    }
    
    public function deleteUtilisateur($id) {
        return $this->query("
            UPDATE utilisateurs SET statut_compte = 'suspendu' WHERE id_utilisateur = ?
        ", [$id]);
    }
}
