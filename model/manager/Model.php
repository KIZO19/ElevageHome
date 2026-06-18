<?php

abstract class Model {
    private $_db;

    final protected function setBdd() {
        try {
            $this->_db = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
                DB_USER,
                DB_PASS,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (Exception $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    final protected function getBdd() {
        if ($this->_db === null) {
            $this->setBdd();
        }
        return $this->_db;
    }

    final protected function query($query, $data = null) {
        $req = $this->getBdd()->prepare($query);
        
        if ($data) {
            return $req->execute($data);
        } else {
            return $req->execute();
        }
    }

    final protected function fetch($query, $data = null) {
        $req = $this->getBdd()->prepare($query);
        
        if ($data) {
            $req->execute($data);
        } else {
            $req->execute();
        }
        
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    final protected function fetchAll($query, $data = null) {
        $req = $this->getBdd()->prepare($query);
        
        if ($data) {
            $req->execute($data);
        } else {
            $req->execute();
        }
        
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
