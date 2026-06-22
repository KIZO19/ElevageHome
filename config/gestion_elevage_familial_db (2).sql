-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 12:50 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `bandes`
--

CREATE TABLE `bandes` (
  `id_bande` int(11) NOT NULL,
  `id_exploitation` int(11) NOT NULL,
  `code_bande` varchar(50) NOT NULL,
  `espece_detaillee` varchar(70) DEFAULT 'Poulet (Gallus gallus domesticus)',
  `type_production` enum('chair','pondeuse','indigene_local') NOT NULL,
  `quantite_initiale` int(11) NOT NULL CHECK (`quantite_initiale` > 0),
  `prix_achat_unitaire_poussin` decimal(10,2) NOT NULL CHECK (`prix_achat_unitaire_poussin` >= 0),
  `date_lancement` date NOT NULL,
  `statut_lot` enum('en_cours','cloture') DEFAULT 'en_cours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bandes`
--

INSERT INTO `bandes` (`id_bande`, `id_exploitation`, `code_bande`, `espece_detaillee`, `type_production`, `quantite_initiale`, `prix_achat_unitaire_poussin`, `date_lancement`, `statut_lot`) VALUES
(1, 1, 'BND-KYES-2026-CHAIR-01', 'Poulet (Gallus gallus domesticus)', 'chair', 500, 1.20, '2026-05-10', 'en_cours'),
(2, 1, 'BDN002', 'Pintade', 'chair', 120, 32000.00, '2026-06-03', 'en_cours'),
(3, 1, 'BDN003', 'Poulet Indigène', 'indigene_local', 19, 24000.00, '2026-06-18', 'en_cours');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom_complet` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse_goma` varchar(255) DEFAULT NULL,
  `type_client` enum('particulier','grossiste','restaurant_hotel') DEFAULT 'particulier',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `nom_complet`, `telephone`, `adresse_goma`, `type_client`, `created_at`) VALUES
(1, 'Restaurant Le Volcan', '+243810000002', 'Quartier Volcan, Goma', 'restaurant_hotel', '2026-06-13 08:39:55'),
(2, 'JOSUE MAKUTANO', '+243823941089', 'Goma', 'grossiste', '2026-06-16 06:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `depenses`
--

CREATE TABLE `depenses` (
  `id_depense` int(11) NOT NULL,
  `id_bande` int(11) NOT NULL,
  `id_type_charge` int(11) NOT NULL,
  `libelle_depense` varchar(255) NOT NULL,
  `quantite` decimal(10,2) NOT NULL DEFAULT 1.00 CHECK (`quantite` > 0),
  `unite_mesure` varchar(50) DEFAULT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL CHECK (`prix_unitaire` >= 0),
  `montant_total_charge` decimal(12,2) GENERATED ALWAYS AS (`quantite` * `prix_unitaire`) STORED,
  `date_depense` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depenses`
--

INSERT INTO `depenses` (`id_depense`, `id_bande`, `id_type_charge`, `libelle_depense`, `quantite`, `unite_mesure`, `prix_unitaire`, `date_depense`) VALUES
(1, 1, 1, 'Achat Sac Concentré Démarrage (Provende)', 4.00, 'kg', 9000.00, '2026-05-11'),
(2, 1, 2, 'Vaccin Gumboro et Newcastle', 2.00, 'Flacon', 12.50, '2026-05-12'),
(3, 1, 4, 'Transport moto des aliments depuis Katindo', 1.00, 'Course', 5.00, '2026-05-11'),
(4, 1, 5, 'Achat Braises pour le chauffage du poulailler', 2.00, 'Sac', 15.00, '2026-05-10'),
(6, 2, 3, 'ALIMENTS ', 12.00, 'kg', 1000.00, '2026-06-16'),
(7, 1, 3, 'Achat Sac Concentré Démarrage (Provende)', 150.00, 'sac', 1000.00, '2026-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `exploitations`
--

CREATE TABLE `exploitations` (
  `id_exploitation` int(11) NOT NULL,
  `nom_responsable` varchar(150) NOT NULL,
  `quartier_goma` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exploitations`
--

INSERT INTO `exploitations` (`id_exploitation`, `nom_responsable`, `quartier_goma`, `telephone`, `date_creation`) VALUES
(1, 'Ménage Kizombo', 'Kyeshero', '+243990000001', '2026-06-13 08:39:55');

-- --------------------------------------------------------

--
-- Table structure for table `factures`
--

CREATE TABLE `factures` (
  `id_facture` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `numero_facture` varchar(50) NOT NULL,
  `date_facturation` date NOT NULL,
  `statut_paiement` enum('non_paye','avance','paye') DEFAULT 'non_paye',
  `mode_paiement` enum('cash','mobile_money','credit') DEFAULT 'cash',
  `montant_total_facture` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `factures`
--

INSERT INTO `factures` (`id_facture`, `id_client`, `numero_facture`, `date_facturation`, `statut_paiement`, `mode_paiement`, `montant_total_facture`) VALUES
(1, 1, 'FAC-2026-06-001', '2026-06-13', 'paye', 'mobile_money', 10000.00),
(3, 1, 'FAC-2026-00007', '2026-06-16', 'paye', 'cash', 0.00),
(4, 2, 'FAC-2026-00008', '2026-06-19', 'paye', 'cash', 27500.00);

-- --------------------------------------------------------

--
-- Table structure for table `lignes_facture`
--

CREATE TABLE `lignes_facture` (
  `id_ligne` int(11) NOT NULL,
  `id_facture` int(11) NOT NULL,
  `id_bande` int(11) DEFAULT NULL,
  `produit_vendu` enum('poulet_vif','oeuf_alveole','fiente_engrais') NOT NULL,
  `quantite` decimal(10,2) NOT NULL CHECK (`quantite` > 0),
  `prix_unitaire_vente` decimal(10,2) NOT NULL CHECK (`prix_unitaire_vente` >= 0),
  `montant_ligne` decimal(12,2) GENERATED ALWAYS AS (`quantite` * `prix_unitaire_vente`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lignes_facture`
--

INSERT INTO `lignes_facture` (`id_ligne`, `id_facture`, `id_bande`, `produit_vendu`, `quantite`, `prix_unitaire_vente`) VALUES
(1, 1, 1, 'poulet_vif', 50.00, 7.50),
(2, 1, 1, 'fiente_engrais', 2.00, 3.00),
(3, 4, 3, 'fiente_engrais', 11.00, 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `pertes_mortalite`
--

CREATE TABLE `pertes_mortalite` (
  `id_perte` int(11) NOT NULL,
  `id_bande` int(11) NOT NULL,
  `date_perte` date NOT NULL,
  `nbre_sujets_morts` int(11) NOT NULL CHECK (`nbre_sujets_morts` > 0),
  `cause_probable` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pertes_mortalite`
--

INSERT INTO `pertes_mortalite` (`id_perte`, `id_bande`, `date_perte`, `nbre_sujets_morts`, `cause_probable`) VALUES
(1, 1, '2026-05-15', 3, 'Choc thermique / Froid'),
(2, 1, '2026-05-20', 2, 'Suspicion Newcastle'),
(3, 2, '2026-06-16', 1, 'age'),
(4, 3, '2026-06-19', 47, 'cannibalisme');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`, `description`) VALUES
(1, 'Manager', 'Accès total, gestion des utilisateurs, statistiques globales sur Goma'),
(2, 'eleveur_chef', 'Propriétaire du ménage. Accès aux coûts, rentabilité, factures et suivi technique'),
(3, 'ouvrier_terrain', 'Encodage uniquement : saisie des pertes, de la collecte des œufs et de la consommation d\'aliments');

-- --------------------------------------------------------

--
-- Table structure for table `types_charge`
--

CREATE TABLE `types_charge` (
  `id_type_charge` int(11) NOT NULL,
  `nom_categorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types_charge`
--

INSERT INTO `types_charge` (`id_type_charge`, `nom_categorie`) VALUES
(1, 'Alimentation (Provende/Maïs)'),
(5, 'Infrastructure & Énergie (Chauffage/Braises)'),
(3, 'Main-d’œuvre (Aide/Ouvrier)'),
(2, 'Santé & Médicaments (Vaccins)'),
(4, 'Transport & Logistique');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_exploitation` int(11) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `statut_compte` enum('actif','suspendu') DEFAULT 'actif',
  `email_confirmed` tinyint(1) DEFAULT 1,
  `confirmation_token` varchar(255) DEFAULT NULL,
  `confirmation_token_expires` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `profile_completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `id_role`, `id_exploitation`, `nom`, `prenom`, `email`, `mot_de_passe`, `statut_compte`, `email_confirmed`, `confirmation_token`, `confirmation_token_expires`, `reset_token`, `reset_token_expires`, `profile_completed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Kamino', 'Jean', 'jean.kamino@coop.cd', '$2y$10$UnHachageBcryptIci...', 'actif', 1, NULL, NULL, NULL, NULL, 0, '2026-06-13 08:46:00', '2026-06-18 22:11:05'),
(2, 2, 1, 'Kizombo', 'Joseph', 'joseph.kizo@gmail.com', '$2y$10$UnAutreHachageBcrypt...', 'suspendu', 1, NULL, NULL, NULL, NULL, 0, '2026-06-13 08:46:00', '2026-06-19 18:06:25'),
(3, 1, 1, 'Balume', 'Marc', 'marc.balume@outlook.com', '$2y$10$5NjxXggmRsn6MFBoSAvTMeCt.2Ul95QApt6i4FXBBzuKumFfH4EHC', 'actif', 0, NULL, NULL, NULL, NULL, 0, '2026-06-13 08:46:00', '2026-06-19 18:08:01'),
(4, 2, NULL, 'KIZOMBO', 'Joseph', 'pdg_admin@elevage.cd', '$2y$10$IYQytXzh3YJ4Or.3Kbq76Oa.uUiwEuxh8.lPPFsNZZgBJn9HFLD9m', 'actif', 0, NULL, NULL, NULL, NULL, 0, '2026-06-15 21:56:42', '2026-06-16 17:07:47'),
(5, 2, NULL, 'KIZOMBO', 'Joseph', 'pdg@elevage.cd', '$2y$10$WM7vKCWBAhk7PRQ460JGQ.CcVeYOFjJH59O28bP3vMCUvEzGx5Lfa', 'actif', 0, NULL, NULL, NULL, NULL, 0, '2026-06-15 22:35:31', '2026-06-16 17:07:47'),
(6, 2, NULL, 'KIZOMBO', 'Joseph', 'johkizo19@gmail.com', '$2y$10$cqAtyeadatej/f13Ky.FeOjAGpH93OF1MZV1WTHNkPya8/Bp6g6ei', 'actif', 1, NULL, NULL, 'cd474852188de4531e0d353dbddb4be14a13e6a6cb5f8a3a6cfad34a1233ff7e', '2026-06-18 16:46:44', 0, '2026-06-16 16:20:53', '2026-06-18 21:45:39'),
(7, 2, NULL, 'KASEREKA', 'AMANI', 'jules@gmail.com', 'KIZO120', 'actif', 0, '2778565d720f149c99156aec1f7a43bdd24427ba344d429f7ad97d707aef9be3', '2026-06-19 15:49:24', NULL, NULL, 0, '2026-06-18 13:49:24', '2026-06-18 13:51:06'),
(8, 2, NULL, 'Emma', 'Sec', 'kizo@elevqge.cd', '$2y$10$G3Slsv/SfPOWROzgBJNDxOeUo9EmZSjzkXpW6FaxLQM1cw4fDVjoi', 'actif', 1, 'cafa4bc01ecbfbfff0f9765c1b7046e2be345722f8118fc4164f1da5a44b6ec7', '2026-06-19 23:28:18', NULL, NULL, 0, '2026-06-18 21:28:18', '2026-06-18 21:31:46'),
(9, 1, NULL, 'Dupon', 'Jean', 'jeandupon@gmail.com', '$2y$10$T/GpUYWwN89dLTwWT1VuauoksUwb6BWlr154pUKhzPPo5JpOkvSdS', 'suspendu', 1, 'c7425eeef0c745cf3e5f0135c622599f22e722d02d07035e0519d1af4c9a04af', '2026-06-19 23:35:28', NULL, NULL, 0, '2026-06-18 21:35:28', '2026-06-19 18:25:08'),
(10, 2, NULL, 'Kizombo', 'KIZOMBO', 'admin@phpzag.com', '$2y$10$n7xjZwbibTaDIIj.WMy5XeorwgjSLtXq9YlJlSDffPAUFHhMWsRta', 'suspendu', 1, '6803bc31add33ae7537d258c20ac131c50bd6a801eb356cba94068139ace7c5f', '2026-06-20 12:38:42', NULL, NULL, 0, '2026-06-19 10:38:42', '2026-06-19 18:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `ventes_recettes`
--

CREATE TABLE `ventes_recettes` (
  `id_vente` int(11) NOT NULL,
  `id_bande` int(11) NOT NULL,
  `produit_vendu` enum('poulet_vif','oeuf_alveole','fiente_engrais') NOT NULL,
  `quantite_vendue` decimal(10,2) NOT NULL CHECK (`quantite_vendue` > 0),
  `prix_unitaire_vente` decimal(10,2) NOT NULL CHECK (`prix_unitaire_vente` >= 0),
  `montant_total_recette` decimal(12,2) GENERATED ALWAYS AS (`quantite_vendue` * `prix_unitaire_vente`) STORED,
  `date_vente` date NOT NULL,
  `acheteur_ou_marche` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ventes_recettes`
--

INSERT INTO `ventes_recettes` (`id_vente`, `id_bande`, `produit_vendu`, `quantite_vendue`, `prix_unitaire_vente`, `date_vente`, `acheteur_ou_marche`) VALUES
(1, 2, 'poulet_vif', 12.00, 33000.00, '2026-06-12', 'Resto'),
(2, 1, 'poulet_vif', 12.00, 23000.00, '2026-06-09', 'Resto'),
(3, 1, 'oeuf_alveole', 50.00, 1000.00, '2026-06-16', 'Resto'),
(4, 3, 'poulet_vif', 12.00, 20000.00, '2026-06-19', 'Resto'),
(5, 1, 'fiente_engrais', 100.00, 2500.00, '2026-06-19', 'Resto'),
(6, 3, 'fiente_engrais', 11.00, 2500.00, '2026-06-19', 'Eleveur ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bandes`
--
ALTER TABLE `bandes`
  ADD PRIMARY KEY (`id_bande`),
  ADD UNIQUE KEY `code_bande` (`code_bande`),
  ADD KEY `fk_bandes_exploitation` (`id_exploitation`),
  ADD KEY `statut_lot` (`statut_lot`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- Indexes for table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id_depense`),
  ADD KEY `fk_depenses_bande` (`id_bande`),
  ADD KEY `fk_depenses_type` (`id_type_charge`),
  ADD KEY `date_depense` (`date_depense`);

--
-- Indexes for table `exploitations`
--
ALTER TABLE `exploitations`
  ADD PRIMARY KEY (`id_exploitation`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- Indexes for table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id_facture`),
  ADD UNIQUE KEY `numero_facture` (`numero_facture`),
  ADD KEY `fk_factures_client` (`id_client`),
  ADD KEY `statut_paiement` (`statut_paiement`),
  ADD KEY `date_facturation` (`date_facturation`);

--
-- Indexes for table `lignes_facture`
--
ALTER TABLE `lignes_facture`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `fk_lignes_facture` (`id_facture`),
  ADD KEY `fk_lignes_bande` (`id_bande`);

--
-- Indexes for table `pertes_mortalite`
--
ALTER TABLE `pertes_mortalite`
  ADD PRIMARY KEY (`id_perte`),
  ADD KEY `fk_pertes_bande` (`id_bande`),
  ADD KEY `date_perte` (`date_perte`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nom_role` (`nom_role`);

--
-- Indexes for table `types_charge`
--
ALTER TABLE `types_charge`
  ADD PRIMARY KEY (`id_type_charge`),
  ADD UNIQUE KEY `nom_categorie` (`nom_categorie`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `confirmation_token` (`confirmation_token`),
  ADD UNIQUE KEY `reset_token` (`reset_token`),
  ADD KEY `fk_utilisateurs_role` (`id_role`),
  ADD KEY `fk_utilisateurs_exploitation` (`id_exploitation`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `ventes_recettes`
--
ALTER TABLE `ventes_recettes`
  ADD PRIMARY KEY (`id_vente`),
  ADD KEY `fk_ventes_bande` (`id_bande`),
  ADD KEY `date_vente` (`date_vente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bandes`
--
ALTER TABLE `bandes`
  MODIFY `id_bande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id_depense` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exploitations`
--
ALTER TABLE `exploitations`
  MODIFY `id_exploitation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `factures`
--
ALTER TABLE `factures`
  MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lignes_facture`
--
ALTER TABLE `lignes_facture`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pertes_mortalite`
--
ALTER TABLE `pertes_mortalite`
  MODIFY `id_perte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `types_charge`
--
ALTER TABLE `types_charge`
  MODIFY `id_type_charge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ventes_recettes`
--
ALTER TABLE `ventes_recettes`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bandes`
--
ALTER TABLE `bandes`
  ADD CONSTRAINT `fk_bandes_exploitation` FOREIGN KEY (`id_exploitation`) REFERENCES `exploitations` (`id_exploitation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `depenses`
--
ALTER TABLE `depenses`
  ADD CONSTRAINT `fk_depenses_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_depenses_type` FOREIGN KEY (`id_type_charge`) REFERENCES `types_charge` (`id_type_charge`) ON UPDATE CASCADE;

--
-- Constraints for table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `fk_factures_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON UPDATE CASCADE;

--
-- Constraints for table `lignes_facture`
--
ALTER TABLE `lignes_facture`
  ADD CONSTRAINT `fk_lignes_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lignes_facture` FOREIGN KEY (`id_facture`) REFERENCES `factures` (`id_facture`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pertes_mortalite`
--
ALTER TABLE `pertes_mortalite`
  ADD CONSTRAINT `fk_pertes_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `fk_utilisateurs_exploitation` FOREIGN KEY (`id_exploitation`) REFERENCES `exploitations` (`id_exploitation`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateurs_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON UPDATE CASCADE;

--
-- Constraints for table `ventes_recettes`
--
ALTER TABLE `ventes_recettes`
  ADD CONSTRAINT `fk_ventes_bande` FOREIGN KEY (`id_bande`) REFERENCES `bandes` (`id_bande`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
