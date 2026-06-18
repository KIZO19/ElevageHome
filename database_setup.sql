-- Installation script for ElevageHome
-- Run this SQL to set up the database

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2026 at 11:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_elevage_familial_db`
--

CREATE DATABASE IF NOT EXISTS `gestion_elevage_familial_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `gestion_elevage_familial_db`;

-- ========================================
-- Créer les tables
-- ========================================

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL UNIQUE,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exploitations` (
  `id_exploitation` int(11) NOT NULL AUTO_INCREMENT,
  `nom_responsable` varchar(150) NOT NULL,
  `quartier_goma` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL UNIQUE,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_exploitation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_exploitation` int(11) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL UNIQUE,
  `mot_de_passe` varchar(255) NOT NULL,
  `statut_compte` enum('actif','suspendu') DEFAULT 'actif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_utilisateur`),
  KEY `fk_utilisateurs_role` (`id_role`),
  KEY `fk_utilisateurs_exploitation` (`id_exploitation`),
  CONSTRAINT `fk_utilisateurs_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON UPDATE CASCADE,
  CONSTRAINT `fk_utilisateurs_exploitation` FOREIGN KEY (`id_exploitation`) REFERENCES `exploitations` (`id_exploitation`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `bandes` (
  `id_bande` int(11) NOT NULL AUTO_INCREMENT,
  `id_exploitation` int(11) NOT NULL,
  `code_bande` varchar(50) NOT NULL UNIQUE,
  `espece_detaillee` varchar(70) DEFAULT 'Poulet (Gallus gallus domesticus)',
  `type_production` enum('chair','pondeuse','indigene_local') NOT NULL,
  `quantite_initiale` int(11) NOT NULL CHECK (`quantite_initiale` > 0),
  `prix_achat_unitaire_poussin` decimal(10,2) NOT NULL CHECK (`prix_achat_unitaire_poussin` >= 0),
  `date_lancement` date NOT NULL,
  `statut_lot` enum('en_cours','cloture') DEFAULT 'en_cours',
  PRIMARY KEY (`id_bande`),
  UNIQUE KEY `code_bande` (`code_bande`),
  KEY `fk_bandes_exploitation` (`id_exploitation`),
  KEY `statut_lot` (`statut_lot`),
  CONSTRAINT `fk_bandes_exploitation` FOREIGN KEY (`id_exploitation`) REFERENCES `exploitations` (`id_exploitation`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `types_charge` (
  `id_type_charge` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id_type_charge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `depenses` (
  `id_depense` int(11) NOT NULL AUTO_INCREMENT,
  `id_bande` int(11) NOT NULL,
  `id_type_charge` int(11) NOT NULL,
  `libelle_depense` varchar(255) NOT NULL,
  `quantite` decimal(10,2) NOT NULL DEFAULT 1.00 CHECK (`quantite` > 0),
  `unite_mesure` varchar(50) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL CHECK (`prix_unitaire` >= 0),
  `montant_total_charge` decimal(12,2) GENERATED ALWAYS AS (`quantite` * `prix_unitaire`) STORED,
  `date_depense` date NOT NULL,
  PRIMARY KEY (`id_depense`),
  KEY `fk_depenses_bande` (`id_bande`),
  KEY `fk_depenses_type` (`id_type_charge`),
  KEY `date_depense` (`date_depense`),
  CONSTRAINT `fk_depenses_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_depenses_type` FOREIGN KEY (`id_type_charge`) REFERENCES `types_charge` (`id_type_charge`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pertes_mortalite` (
  `id_perte` int(11) NOT NULL AUTO_INCREMENT,
  `id_bande` int(11) NOT NULL,
  `date_perte` date NOT NULL,
  `nbre_sujets_morts` int(11) NOT NULL CHECK (`nbre_sujets_morts` > 0),
  `cause_probable` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_perte`),
  KEY `fk_pertes_bande` (`id_bande`),
  KEY `date_perte` (`date_perte`),
  CONSTRAINT `fk_pertes_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ventes_recettes` (
  `id_vente` int(11) NOT NULL AUTO_INCREMENT,
  `id_bande` int(11) NOT NULL,
  `produit_vendu` enum('poulet_vif','oeuf_alveole','fiente_engrais') NOT NULL,
  `quantite_vendue` decimal(10,2) NOT NULL CHECK (`quantite_vendue` > 0),
  `prix_unitaire_vente` decimal(10,2) NOT NULL CHECK (`prix_unitaire_vente` >= 0),
  `montant_total_recette` decimal(12,2) GENERATED ALWAYS AS (`quantite_vendue` * `prix_unitaire_vente`) STORED,
  `date_vente` date NOT NULL,
  `acheteur_ou_marche` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_vente`),
  KEY `fk_ventes_bande` (`id_bande`),
  KEY `date_vente` (`date_vente`),
  CONSTRAINT `fk_ventes_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom_complet` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL UNIQUE,
  `adresse_goma` varchar(255) DEFAULT NULL,
  `type_client` enum('particulier','grossiste','restaurant_hotel') DEFAULT 'particulier',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `factures` (
  `id_facture` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `numero_facture` varchar(50) NOT NULL UNIQUE,
  `date_facturation` date NOT NULL,
  `statut_paiement` enum('non_paye','avance','paye') DEFAULT 'non_paye',
  `mode_paiement` enum('cash','mobile_money','credit') DEFAULT 'cash',
  `montant_total_facture` decimal(12,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id_facture`),
  UNIQUE KEY `numero_facture` (`numero_facture`),
  KEY `fk_factures_client` (`id_client`),
  KEY `statut_paiement` (`statut_paiement`),
  KEY `date_facturation` (`date_facturation`),
  CONSTRAINT `fk_factures_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `lignes_facture` (
  `id_ligne` int(11) NOT NULL AUTO_INCREMENT,
  `id_facture` int(11) NOT NULL,
  `id_bande` int(11) DEFAULT NULL,
  `produit_vendu` enum('poulet_vif','oeuf_alveole','fiente_engrais') NOT NULL,
  `quantite` decimal(10,2) NOT NULL CHECK (`quantite` > 0),
  `prix_unitaire_vente` decimal(10,2) NOT NULL CHECK (`prix_unitaire_vente` >= 0),
  `montant_ligne` decimal(12,2) GENERATED ALWAYS AS (`quantite` * `prix_unitaire_vente`) STORED,
  PRIMARY KEY (`id_ligne`),
  KEY `fk_lignes_facture` (`id_facture`),
  KEY `fk_lignes_bande` (`id_bande`),
  CONSTRAINT `fk_lignes_facture` FOREIGN KEY (`id_facture`) REFERENCES `factures` (`id_facture`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lignes_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Insérer les données de base
-- ========================================

INSERT INTO `roles` (`nom_role`, `description`) VALUES
(1, 'admin_cooperative', 'Accès total, gestion des utilisateurs, statistiques globales sur Goma'),
(2, 'eleveur_chef', 'Propriétaire du ménage. Accès aux coûts, rentabilité, factures et suivi technique'),
(3, 'ouvrier_terrain', 'Encodage uniquement : saisie des pertes, de la collecte des œufs et de la consommation d\'aliments');

INSERT INTO `types_charge` (`nom_categorie`) VALUES
('Alimentation (Provende/Maïs)'),
('Santé & Médicaments (Vaccins)'),
('Main-d\'œuvre (Aide/Ouvrier)'),
('Transport & Logistique'),
('Infrastructure & Énergie (Chauffage/Braises)');

INSERT INTO `exploitations` (`nom_responsable`, `quartier_goma`, `telephone`) VALUES
('Ménage Kizombo', 'Kyeshero', '+243990000001');

-- Utilisateur admin avec password: admin123
INSERT INTO `utilisateurs` (`id_role`, `id_exploitation`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(1, NULL, 'Admin', 'ElevageHome', 'admin@elevage.cd', '$2y$10$GrPWCVc5HWXvPQc5U5.fJ.s.OXLYX.8XTMHGFfLMV7aYg0AQxr4Bm');

-- Utilisateur éleveur avec password: eleveur123
INSERT INTO `utilisateurs` (`id_role`, `id_exploitation`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(2, 1, 'Kizombo', 'Joseph', 'joseph@kizo.cd', '$2y$10$V6.nGcWkW5V8ZsGCX7pP6.P1zD2MwQxK5L4P2Q8R9S0T1U2V3W4Xy');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
