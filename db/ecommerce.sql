-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 07 fév. 2025 à 20:08
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
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`utilisateur_id`),
  KEY `fk_commandes` (`commandes_id`),
  KEY `fk_facture` (`facture_id`)
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
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
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
  KEY `fk_commande` (`commandes_id`),
  KEY `fk_factures` (`facture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
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
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `produit_id` (`produit_id`)
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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_produit` varchar(255) NOT NULL,
  `catégorie_produit` varchar(255) NOT NULL,
  `savon_id` int DEFAULT NULL,
  `savon_liquid_id` int DEFAULT NULL,
  `shampoon_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produits_savon` (`savon_id`),
  KEY `fk_produits_savon_liquid` (`savon_liquid_id`),
  KEY `fk_produits_shampoon` (`shampoon_id`)
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
  PRIMARY KEY (`id`),
  KEY `fk_references_produit` (`produit_id`),
  KEY `fk_savonss` (`savon_id`),
  KEY `fk_savon_liquide` (`savon_liquid_id`),
  KEY `fk_shampooin` (`shampoon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `savon`
--

DROP TABLE IF EXISTS `savon`;
CREATE TABLE IF NOT EXISTS `savon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `poids` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `reference_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_savon_reference` (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `savon_liquid`
--

DROP TABLE IF EXISTS `savon_liquid`;
CREATE TABLE IF NOT EXISTS `savon_liquid` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `reference_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_savon_liquid_reference` (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shampoon`
--

DROP TABLE IF EXISTS `shampoon`;
CREATE TABLE IF NOT EXISTS `shampoon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `prix_ttc` decimal(10,2) NOT NULL,
  `reference_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_shampoon_reference` (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`id`),
  KEY `produit_id` (`produit_id`),
  KEY `fk_savon_reference` (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `role`, `role_description`, `mail`, `mdp`) VALUES
(1, 'admin', NULL, 'admin@example.com', 'password_admin'),
(2, 'gestionnaire', NULL, 'gestionnaire@example.com', 'password_gestionnaire'),
(3, 'user', NULL, 'user@example.com', 'password_user');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_commandes` FOREIGN KEY (`commandes_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_facture` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `dashboard`
--
ALTER TABLE `dashboard`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_commande` FOREIGN KEY (`commandes_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_contact` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_factures` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_panier` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_payment` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_produits` FOREIGN KEY (`produits_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_references_articles` FOREIGN KEY (`references_articles_id`) REFERENCES `references_articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_savon` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_savon_liquid` FOREIGN KEY (`savon_liquid_id`) REFERENCES `savon_liquid` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_shampoon` FOREIGN KEY (`shampoon_id`) REFERENCES `shampoon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `references_articles`
--
ALTER TABLE `references_articles`
  ADD CONSTRAINT `fk_savon_liquide` FOREIGN KEY (`savon_liquid_id`) REFERENCES `savon_liquid` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_savons` FOREIGN KEY (`id`) REFERENCES `savon` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_savonss` FOREIGN KEY (`savon_id`) REFERENCES `savon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_shampooin` FOREIGN KEY (`shampoon_id`) REFERENCES `shampoon` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
