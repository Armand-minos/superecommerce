-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 09 fév. 2025 à 09:52
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) NOT NULL,
  `code_postal` varchar(5) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `commandes_id` int DEFAULT NULL,
  `facture_id` int DEFAULT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`utilisateur_id`),
  KEY `fk_commandes` (`commandes_id`),
  KEY `fk_facture` (`facture_id`),
  KEY `1dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `date_heure` datetime NOT NULL,
  `numero_commandes` varchar(255) NOT NULL,
  `adresse_livraison` varchar(255) NOT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `messages` varchar(255) NOT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `2dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dashboard`
--

DROP TABLE IF EXISTS `dashboard`;
CREATE TABLE IF NOT EXISTS `dashboard` (
  `id` int NOT NULL AUTO_INCREMENT,
  `visites` varchar(255) NOT NULL,
  `gestions_Commandes` varchar(255) NOT NULL,
  `statistiques` varchar(255) NOT NULL,
  `gestion_factures` varchar(255) NOT NULL,
  `compte_client` varchar(255) NOT NULL,
  `contact_client` varchar(255) NOT NULL,
  `produits_gestion` varchar(255) NOT NULL,
  `client_id` int DEFAULT NULL,
  `produits_id` int DEFAULT NULL,
  `references_articles_id` int DEFAULT NULL,
  `savon_id` int DEFAULT NULL,
  `savon_liquid_id` int DEFAULT NULL,
  `shampoon_id` int DEFAULT NULL,
  `stock_id` int DEFAULT NULL,
  `payment_id` int DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  `panier_id` int DEFAULT NULL,
  `facture_id` int DEFAULT NULL,
  `commandes_id` int DEFAULT NULL,
  `id_revenu` int DEFAULT NULL,
  `id_vente` int DEFAULT NULL,
  `id_visite` int DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_client` (`client_id`),
  KEY `fk_produits` (`produits_id`),
  KEY `fk_references_articles` (`references_articles_id`),
  KEY `fk_savon` (`savon_id`),
  KEY `fk_savon_liquid` (`savon_liquid_id`),
  KEY `fk_shampoon` (`shampoon_id`),
  KEY `fk_stock` (`stock_id`),
  KEY `fk_payment` (`payment_id`),
  KEY `fk_contact` (`contact_id`),
  KEY `fk_panier` (`panier_id`),
  KEY `fk_facture` (`facture_id`),
  KEY `fk_commande` (`commandes_id`),
  KEY `fk_revenu` (`id_revenu`),
  KEY `fk_vente` (`id_vente`),
  KEY `fk_visite` (`id_visite`),
  KEY `000utilisateur` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `dashboard`
--

INSERT INTO `dashboard` (`id`, `visites`, `gestions_Commandes`, `statistiques`, `gestion_factures`, `compte_client`, `contact_client`, `produits_gestion`, `client_id`, `produits_id`, `references_articles_id`, `savon_id`, `savon_liquid_id`, `shampoon_id`, `stock_id`, `payment_id`, `contact_id`, `panier_id`, `facture_id`, `commandes_id`, `id_revenu`, `id_vente`, `id_visite`, `utilisateur_id`) VALUES
(1, '0', '0', '0', '0', '0', '0', '0', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `email_confirmations`
--

DROP TABLE IF EXISTS `email_confirmations`;
CREATE TABLE IF NOT EXISTS `email_confirmations` (
  `id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiresAt` timestamp NOT NULL,
  `confirmation_code` varchar(255) NOT NULL,
  `dashboard_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`utilisateur_id`),
  KEY `3dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `email_confirmations`
--

INSERT INTO `email_confirmations` (`id`, `utilisateur_id`, `token`, `expiresAt`, `confirmation_code`, `dashboard_id`) VALUES
(0, 8, '7d7858010fa815e71f5bd7aa604e2ad7', '2025-02-09 19:29:16', '5b6d868239b68b2b', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `numero_facture` varchar(255) NOT NULL,
  `adresse_entrepise` varchar(255) NOT NULL,
  `adresse_client` varchar(255) NOT NULL,
  `montant_ht` decimal(10,2) NOT NULL,
  `tva` decimal(10,2) NOT NULL DEFAULT '20.00',
  `montant_ttc` decimal(10,2) GENERATED ALWAYS AS ((`montant_ht` + ((`montant_ht` * `tva`) / 100))) STORED,
  `pdf` longblob,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `4dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `tva` decimal(15,2) NOT NULL,
  `frais_livraison` decimal(10,2) NOT NULL,
  `total_ttc` decimal(10,2) NOT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `produit_id` (`produit_id`),
  KEY `5dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `montant_payemnt` decimal(10,2) NOT NULL,
  `euro` varchar(3) NOT NULL,
  `stripe_payment_id` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_heure_transaction` datetime NOT NULL,
  `date_heure_maj` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `method_payment` varchar(50) NOT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `6dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `catégorie_produit` varchar(255) NOT NULL,
  `references_articles_id` int NOT NULL,
  `savon_id` int DEFAULT NULL,
  `savon_liquid_id` int DEFAULT NULL,
  `shampoon_id` int DEFAULT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produits_savon` (`savon_id`),
  KEY `fk_produits_savon_liquid` (`savon_liquid_id`),
  KEY `fk_produits_shampoon` (`shampoon_id`),
  KEY `fk_references_article` (`references_articles_id`),
  KEY `7dashboard` (`dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `catégorie_produit`, `references_articles_id`, `savon_id`, `savon_liquid_id`, `shampoon_id`, `dashboard_id`) VALUES
(1, 'Savon', 12, 1, NULL, NULL, 1),
(3, 'Savon liquide', 19, NULL, 2, NULL, 1),
(4, 'Shampooing', 20, NULL, NULL, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit_consulte`
--

DROP TABLE IF EXISTS `produit_consulte`;
CREATE TABLE IF NOT EXISTS `produit_consulte` (
  `id_consultation` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `produits_id` int NOT NULL,
  `date_consultation` datetime DEFAULT CURRENT_TIMESTAMP,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id_consultation`),
  KEY `fk_utilisateur` (`utilisateur_id`),
  KEY `fk_produits` (`produits_id`),
  KEY `8dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id_promotion` int NOT NULL AUTO_INCREMENT,
  `produits_id` int NOT NULL,
  `type_promo` enum('remise','pourcentage','offre spéciale') DEFAULT NULL,
  `valeur` decimal(10,2) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id_promotion`),
  KEY `9dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `references_articles`
--

DROP TABLE IF EXISTS `references_articles`;
CREATE TABLE IF NOT EXISTS `references_articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `type_article` text NOT NULL,
  `produit_id` int NOT NULL,
  `savon_id` int DEFAULT NULL,
  `savon_liquid_id` int DEFAULT NULL,
  `shampoon_id` int DEFAULT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_references_produit` (`produit_id`),
  KEY `fk_savonss` (`savon_id`),
  KEY `fk_savon_liquide` (`savon_liquid_id`),
  KEY `fk_shampooin` (`shampoon_id`),
  KEY `01dashboard` (`dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `references_articles`
--

INSERT INTO `references_articles` (`id`, `reference`, `date_creation`, `type_article`, `produit_id`, `savon_id`, `savon_liquid_id`, `shampoon_id`, `dashboard_id`) VALUES
(12, 'SA2025020001', '2025-02-09 09:21:17', 'savon', 123, 1, NULL, NULL, 1),
(18, 'SA2025020002', '2025-02-09 09:58:02', 'savon', 123, NULL, NULL, NULL, 1),
(19, 'SAL2025020001', '2025-02-09 09:58:43', 'savon_liquide', 124, NULL, NULL, NULL, 1),
(20, 'SHA2025020001', '2025-02-09 09:59:12', 'shampoon', 125, NULL, NULL, NULL, 1),
(21, 'SAL2025020002', '2025-02-09 10:00:55', 'savon_liquide', 124, NULL, 2, NULL, 1),
(22, 'SHA2025020002', '2025-02-09 10:01:58', 'shampoon', 125, NULL, NULL, 2, 1),
(23, 'SHA2025020003', '2025-02-09 10:08:00', 'shampoon', 125, NULL, NULL, 3, 1);

--
-- Déclencheurs `references_articles`
--
DROP TRIGGER IF EXISTS `before_insert_references_articles`;
DELIMITER $$
CREATE TRIGGER `before_insert_references_articles` BEFORE INSERT ON `references_articles` FOR EACH ROW BEGIN
    DECLARE prefix VARCHAR(3);
    DECLARE new_reference VARCHAR(255);
    DECLARE compteur INT;

    -- Déterminer le préfixe en fonction du type d'article
    IF NEW.type_article = 'savon' THEN
        SET prefix = 'SA';
    ELSEIF NEW.type_article = 'savon_liquide' THEN
        SET prefix = 'SAL';
    ELSEIF NEW.type_article = 'shampoon' THEN
        SET prefix = 'SHA';
    ELSE
        SET prefix = 'REF';  -- Par défaut si le type n'est pas reconnu
    END IF;

    -- Trouver le compteur pour le mois en cours
    SELECT COUNT(*) + 1 INTO compteur
    FROM references_articles
    WHERE reference LIKE CONCAT(prefix, DATE_FORMAT(NOW(), '%Y%m'), '%')
    AND date_creation >= DATE_FORMAT(NOW(), '%Y-%m-01');

    -- Générer la référence avec le format PREFIX + AnnéeMois + Compteur (4 chiffres)
    SET new_reference = CONCAT(prefix, DATE_FORMAT(NOW(), '%Y%m'), LPAD(compteur, 4, '0'));

    -- Assigner la nouvelle référence avant l'insertion
    SET NEW.reference = new_reference;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `revenu`
--

DROP TABLE IF EXISTS `revenu`;
CREATE TABLE IF NOT EXISTS `revenu` (
  `id_revenu` int NOT NULL AUTO_INCREMENT,
  `id_vente` int NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_revenu` datetime DEFAULT CURRENT_TIMESTAMP,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id_revenu`),
  KEY `id_vente` (`id_vente`),
  KEY `02dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `savon`
--

DROP TABLE IF EXISTS `savon`;
CREATE TABLE IF NOT EXISTS `savon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `poids` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `reference_id` int DEFAULT NULL,
  `dashboard_id` int NOT NULL,
  `stock_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_savon_reference` (`reference_id`),
  KEY `03dashboard` (`dashboard_id`),
  KEY `fk_stockc` (`stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `savon`
--

INSERT INTO `savon` (`id`, `produit_id`, `image`, `nom`, `poids`, `description`, `ingredients`, `prix_ttc`, `reference_id`, `dashboard_id`, `stock_id`) VALUES
(1, 123, 'savon.jpg', 'Savon naturel', '100g', 'Savon bio fait main', 'Huile d\'olive, Beurre de karité', 5.99, 12, 1, 1),
(3, 123, 'savon.jpg', 'Savon naturel', '100g', 'Savon bio fait main', 'Huile d\'olive, Beurre de karité', 5.99, 12, 1, 1);

--
-- Déclencheurs `savon`
--
DROP TRIGGER IF EXISTS `before_savon_insert`;
DELIMITER $$
CREATE TRIGGER `before_savon_insert` BEFORE INSERT ON `savon` FOR EACH ROW BEGIN
    DECLARE new_reference VARCHAR(255);
    DECLARE new_reference_id INT;

    -- Génération de la référence savon (format SA2025020001)
    SET new_reference = CONCAT(
        'SA',
        DATE_FORMAT(NOW(), '%Y%m'),
        LPAD((SELECT COUNT(*) + 1 FROM references_articles WHERE reference LIKE CONCAT('SA', DATE_FORMAT(NOW(), '%Y%m'), '%')), 3, '0')
    );

    -- Insérer la référence dans references_articles
    INSERT INTO references_articles (reference, date_creation, type_article, produit_id, savon_id, dashboard_id)
    VALUES (new_reference, NOW(), 'savon', NEW.produit_id, NULL, NEW.dashboard_id);

    -- Récupérer l'ID de la référence nouvellement insérée
    SET new_reference_id = LAST_INSERT_ID();

    -- Associer cet ID au savon avant insertion
    SET NEW.reference_id = new_reference_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `savon_liquid`
--

DROP TABLE IF EXISTS `savon_liquid`;
CREATE TABLE IF NOT EXISTS `savon_liquid` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `reference_id` int NOT NULL,
  `dashboard_id` int NOT NULL,
  `stock_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_savon_liquid_reference` (`reference_id`),
  KEY `04dashboard` (`dashboard_id`),
  KEY `fk_stockck` (`stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `savon_liquid`
--

INSERT INTO `savon_liquid` (`id`, `produit_id`, `image`, `nom`, `volume`, `description`, `ingredients`, `prix_ttc`, `reference_id`, `dashboard_id`, `stock_id`) VALUES
(2, 124, 'savon_liquide.jpg', 'Savon liquide bio', '500ml', 'Savon liquide nourrissant', 'Aloe Vera, Huile de coco', 7.99, 21, 1, 2);

--
-- Déclencheurs `savon_liquid`
--
DROP TRIGGER IF EXISTS `before_savon_liquid_insert`;
DELIMITER $$
CREATE TRIGGER `before_savon_liquid_insert` BEFORE INSERT ON `savon_liquid` FOR EACH ROW BEGIN
    DECLARE new_reference VARCHAR(255);
    DECLARE new_reference_id INT;

    -- Génération de la référence savon liquide (format SAL2025020001)
    SET new_reference = CONCAT(
        'SAL',
        DATE_FORMAT(NOW(), '%Y%m'),
        LPAD((SELECT COUNT(*) + 1 FROM references_articles WHERE reference LIKE CONCAT('SAL', DATE_FORMAT(NOW(), '%Y%m'), '%')), 3, '0')
    );

    -- Insérer la référence dans references_articles
    INSERT INTO references_articles (reference, date_creation, type_article, produit_id, savon_liquid_id, dashboard_id)
    VALUES (new_reference, NOW(), 'savon_liquide', NEW.produit_id, NULL, NEW.dashboard_id);

    -- Récupérer l'ID de la référence nouvellement insérée
    SET new_reference_id = LAST_INSERT_ID();

    -- Associer cet ID au savon liquide avant insertion
    SET NEW.reference_id = new_reference_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `shampoon`
--

DROP TABLE IF EXISTS `shampoon`;
CREATE TABLE IF NOT EXISTS `shampoon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `reference_id` int NOT NULL,
  `dashboard_id` int NOT NULL,
  `stock_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_shampoon_reference` (`reference_id`),
  KEY `05dashboard` (`dashboard_id`),
  KEY `fk_stockcko` (`stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `shampoon`
--

INSERT INTO `shampoon` (`id`, `produit_id`, `image`, `nom`, `volume`, `description`, `ingredients`, `prix_ttc`, `reference_id`, `dashboard_id`, `stock_id`) VALUES
(2, 125, 'shampoo.jpg', 'Shampooing revitalisant', '250ml', 'Shampooing pour cheveux secs', 'Huile d\'argan, Kératine', 9.99, 22, 1, 3),
(3, 125, 'shampoo.jpg', 'Shampooing revitalisant', '250ml', 'Shampooing pour cheveux secs', 'Huile d\'argan, Kératine', 9.99, 23, 1, 3);

--
-- Déclencheurs `shampoon`
--
DROP TRIGGER IF EXISTS `before_shampoon_insert`;
DELIMITER $$
CREATE TRIGGER `before_shampoon_insert` BEFORE INSERT ON `shampoon` FOR EACH ROW BEGIN
    DECLARE new_reference VARCHAR(255);
    DECLARE new_reference_id INT;

    -- Génération de la référence shampoon (format SHA2025020001)
    SET new_reference = CONCAT(
        'SHA',
        DATE_FORMAT(NOW(), '%Y%m'),
        LPAD((SELECT COUNT(*) + 1 FROM references_articles WHERE reference LIKE CONCAT('SHA', DATE_FORMAT(NOW(), '%Y%m'), '%')), 3, '0')
    );

    -- Insérer la référence dans references_articles
    INSERT INTO references_articles (reference, date_creation, type_article, produit_id, shampoon_id, dashboard_id)
    VALUES (new_reference, NOW(), 'shampoon', NEW.produit_id, NULL, NEW.dashboard_id);

    -- Récupérer l'ID de la référence nouvellement insérée
    SET new_reference_id = LAST_INSERT_ID();

    -- Associer cet ID au shampoon avant insertion
    SET NEW.reference_id = new_reference_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `quantite_disponible` int NOT NULL,
  `seuil_alerte` int NOT NULL,
  `date_derniere_maj` datetime NOT NULL,
  `reference_id` int NOT NULL,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_savon_reference` (`reference_id`),
  KEY `06dashboard` (`dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `produit_id`, `quantite_disponible`, `seuil_alerte`, `date_derniere_maj`, `reference_id`, `dashboard_id`) VALUES
(1, 2, 200, 30, '2025-02-09 10:49:12', 12, 1),
(2, 2, 200, 30, '2025-02-09 10:49:12', 21, 1),
(3, 2, 200, 30, '2025-02-09 10:49:12', 22, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` enum('admin','user','gestionnaire') NOT NULL,
  `role_description` varchar(255) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email_confirmations_id` int DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  `dashboard_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_email_confirmations` (`email_confirmations_id`),
  KEY `client` (`client_id`),
  KEY `0dashboard` (`dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `role`, `role_description`, `mail`, `mdp`, `email_confirmations_id`, `client_id`, `dashboard_id`) VALUES
(1, 'admin', 'Administrateur du système', 'admin@example.com', 'password_admin', NULL, NULL, NULL),
(2, '', 'Gestionnaire Administratif', 'gestionnaire@example.com', 'password_gestionnaire', NULL, NULL, NULL),
(3, '', 'Client Utilisateur', 'client@example.com', 'password_client', NULL, NULL, NULL),
(4, 'user', NULL, 'armand.moisan08@gmail.com', '$2y$10$Q8S221x71uypPnyq9KexNee8Dze2X6jP2EiI9k4GEJGrIh12IOR.m', NULL, NULL, NULL),
(8, 'user', NULL, 'armand.moiffsan08@gmail.com', '$2y$10$emYtQWuyR01M9s2.LHz8vOaq9Tf1/I40/UzBFGO.fduixN5XLoJp2', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

DROP TABLE IF EXISTS `vente`;
CREATE TABLE IF NOT EXISTS `vente` (
  `id_vente` int NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `montant_total` decimal(10,2) DEFAULT NULL,
  `date_vente` datetime DEFAULT CURRENT_TIMESTAMP,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id_vente`),
  KEY `fk_clients` (`client_id`),
  KEY `09dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `visite`
--

DROP TABLE IF EXISTS `visite`;
CREATE TABLE IF NOT EXISTS `visite` (
  `id_visite` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `date_visite` datetime DEFAULT CURRENT_TIMESTAMP,
  `dashboard_id` int NOT NULL,
  PRIMARY KEY (`id_visite`),
  KEY `fk_utilisateur` (`utilisateur_id`),
  KEY `00dashboard` (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `1dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_commandes` FOREIGN KEY (`commandes_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_facture` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `2dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `dashboard`
--
ALTER TABLE `dashboard`
  ADD CONSTRAINT `000utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commande` FOREIGN KEY (`commandes_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contact` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factures` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_panier` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payment` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produits` FOREIGN KEY (`produits_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_references_articles` FOREIGN KEY (`references_articles_id`) REFERENCES `references_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_revenu` FOREIGN KEY (`id_revenu`) REFERENCES `revenu` (`id_revenu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savon` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savon_liquid` FOREIGN KEY (`savon_liquid_id`) REFERENCES `savon_liquid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_shampoon` FOREIGN KEY (`shampoon_id`) REFERENCES `shampoon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stock` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vente` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ventesd` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viste` FOREIGN KEY (`id_visite`) REFERENCES `visite` (`id_visite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `email_confirmations`
--
ALTER TABLE `email_confirmations`
  ADD CONSTRAINT `3dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `4dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `5dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `6dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `7dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_references_article` FOREIGN KEY (`references_articles_id`) REFERENCES `references_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savonliq` FOREIGN KEY (`savon_liquid_id`) REFERENCES `savon_liquid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_shampoonn` FOREIGN KEY (`shampoon_id`) REFERENCES `shampoon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ssssavon` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit_consulte`
--
ALTER TABLE `produit_consulte`
  ADD CONSTRAINT `8dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `9dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `references_articles`
--
ALTER TABLE `references_articles`
  ADD CONSTRAINT `01dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fsavon_id` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savon_id` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savon_liquide` FOREIGN KEY (`savon_liquid_id`) REFERENCES `savon_liquid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savonss` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_shampooin` FOREIGN KEY (`shampoon_id`) REFERENCES `shampoon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `revenu`
--
ALTER TABLE `revenu`
  ADD CONSTRAINT `02dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `savon`
--
ALTER TABLE `savon`
  ADD CONSTRAINT `03dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savon_reference` FOREIGN KEY (`reference_id`) REFERENCES `references_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stockc` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `savon_liquid`
--
ALTER TABLE `savon_liquid`
  ADD CONSTRAINT `04dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_savonli_reference` FOREIGN KEY (`reference_id`) REFERENCES `references_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stockck` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `shampoon`
--
ALTER TABLE `shampoon`
  ADD CONSTRAINT `05dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_shampoon_reference` FOREIGN KEY (`reference_id`) REFERENCES `references_articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stockcko` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `06dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `0dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_email_confirmations` FOREIGN KEY (`email_confirmations_id`) REFERENCES `email_confirmations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `09dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_clients` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `visite`
--
ALTER TABLE `visite`
  ADD CONSTRAINT `00dashboard` FOREIGN KEY (`dashboard_id`) REFERENCES `dashboard` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
