<?php

class RoleManager extends Model {
    
    public function getAllRoles() {
        return $this->fetchAll("
            SELECT * FROM roles ORDER BY nom_role
        ");
    }
    
    public function getRoleById($id) {
        return $this->fetch("
            SELECT * FROM roles WHERE id_role = ?
        ", [$id]);
    }
    
    public function getRoleByName($name) {
        return $this->fetch("
            SELECT * FROM roles WHERE nom_role = ?
        ", [$name]);
    }
}
