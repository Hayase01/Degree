-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 juin 2026 à 10:10
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nova`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_category`, `nom`) VALUES
(1, 'Produit'),
(2, 'Shaker');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `montant_total` decimal(10,2) DEFAULT '0.00',
  `statut` enum('En attente','Payee','Expediee','Livree') COLLATE utf8mb4_unicode_ci DEFAULT 'En attente',
  `nom_client` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_client` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_user`, `date_commande`, `montant_total`, `statut`, `nom_client`, `prenom_client`, `email_client`, `adresse`, `ville`, `code_postal`, `pays`, `telephone`) VALUES
(1, NULL, '2026-06-18 08:19:16', 0.00, 'Livree', 'Hayase', 'Anthony', 'anthony9731@outlook.fr', 'Quai de la Dérivation', 'Liège', '4020', 'Belgique', ''),
(2, NULL, '2026-06-18 08:21:56', 0.00, 'Livree', 'Hayase', 'Anthony', 'anthony9731@outlook.fr', 'Quai de la Dérivation', 'Liège', '4020', 'Belgique', ''),
(3, NULL, '2026-06-18 08:37:11', 0.00, 'Livree', 'Hayase', 'Anthony', 'anthony9731@outlook.fr', 'Quai de la Dérivation', 'Liège', '4020', 'Belgique', ''),
(4, 1, '2026-06-18 08:47:53', 29.99, 'En attente', 'Hayase', 'Anthony', 'anthony9731@outlook.fr', 'Quai de la Dérivation', 'Liège', '4020', 'Belgique', '');

-- --------------------------------------------------------

--
-- Structure de la table `detail_commande`
--

DROP TABLE IF EXISTS `detail_commande`;
CREATE TABLE IF NOT EXISTS `detail_commande` (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_commande` int NOT NULL,
  `id_produit_format` int NOT NULL,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_commande` (`id_commande`),
  KEY `id_produit_format` (`id_produit_format`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `detail_commande`
--

INSERT INTO `detail_commande` (`id_detail`, `id_commande`, `id_produit_format`, `quantite`, `prix_unitaire`) VALUES
(1, 4, 1, 1, 29.99);

-- --------------------------------------------------------

--
-- Structure de la table `formats`
--

DROP TABLE IF EXISTS `formats`;
CREATE TABLE IF NOT EXISTS `formats` (
  `id_format` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_format`),
  UNIQUE KEY `libelle` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formats`
--

INSERT INTO `formats` (`id_format`, `libelle`) VALUES
(5, '1000 ml'),
(1, '30 portions'),
(2, '50 portions'),
(3, '500 ml'),
(4, '750 ml');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_banniere` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_category` int NOT NULL,
  `id_type` int DEFAULT NULL,
  PRIMARY KEY (`id_produit`),
  UNIQUE KEY `nom` (`nom`),
  UNIQUE KEY `slug` (`slug`),
  KEY `id_category` (`id_category`),
  KEY `id_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom`, `slug`, `description`, `image`, `image_banniere`, `id_category`, `id_type`) VALUES
(1, 'Null Star', 'null-star', 'Condense the infinite.', 'Null.Star 1_preview_rev_1.png', '1781721169_ban_Null.Star 1.png', 1, 1),
(2, 'Molecular Prime', 'molecular-prime', 'Perfect matter engineered beyond physics.', 'molecular-prime-banner_preview_rev_6.png', '1781740863_ban_molecular-prime-banner.png', 1, 4),
(3, 'Antimatter Drop', 'antimatter-drop', 'Harness forbidden instability.', 'antimatter-drop-banner_preview_rev_3.png', '1781740870_ban_antimatter-drop-banner.png', 1, 2),
(4, 'Wormhole', 'wormhole', 'Open a breach through reality.', 'wormhole-banner_preview_rev_4.png', '1781740876_ban_wormhole-banner.png', 1, 3),
(9, 'Event Horizon', 'event-horizon', 'Designed beyond the edge of perception.', '1781775602_img_shaker-void (2).png', '1781775602_ban_shaker-ban-void.png', 2, 1),
(10, 'Genesis Vessel', 'genesis-vessel', 'A perfect container for engineered excellence.', '1781775740_img_shaker-molecul (2).png', '1781775740_ban_shaker-ban-molecul.png', 2, 4),
(11, 'Chaos Reactor', 'chaos-reactor', 'Unstable. Aggressive. Unpredictable.', '1781775828_img_shaker-anti (2).png', '1781775828_ban_shaker-ban-anti.png', 2, 2),
(12, 'Quantum Gateway', 'quantum-gateway', 'Engineered to accelerate every journey.', '1781775943_img_shaker-wormhole (2).png', '1781775943_ban_shaker-ban-wormhole.png', 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `produit_format`
--

DROP TABLE IF EXISTS `produit_format`;
CREATE TABLE IF NOT EXISTS `produit_format` (
  `id_produit_format` int NOT NULL AUTO_INCREMENT,
  `id_produit` int NOT NULL,
  `id_format` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_produit_format`),
  UNIQUE KEY `id_produit` (`id_produit`,`id_format`),
  KEY `id_format` (`id_format`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_format`
--

INSERT INTO `produit_format` (`id_produit_format`, `id_produit`, `id_format`, `prix`, `stock`) VALUES
(1, 1, 1, 29.99, 100),
(2, 1, 2, 49.99, 100),
(13, 2, 1, 29.99, 100),
(14, 2, 2, 49.99, 100),
(15, 3, 1, 29.99, 100),
(16, 3, 2, 49.99, 100),
(17, 4, 1, 29.99, 100),
(18, 4, 2, 49.99, 100),
(22, 9, 3, 19.99, 100),
(23, 9, 4, 24.99, 100),
(24, 9, 5, 29.99, 100),
(25, 10, 3, 19.99, 100),
(26, 10, 4, 24.99, 100),
(27, 10, 5, 29.99, 100),
(28, 11, 3, 19.99, 100),
(29, 11, 4, 24.99, 100),
(30, 11, 5, 29.99, 100),
(31, 12, 3, 19.99, 100),
(32, 12, 4, 24.99, 100),
(33, 12, 5, 29.99, 100);

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_type`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id_type`, `nom`, `couleur`) VALUES
(1, 'Void', '#1A1A1A'),
(2, 'Distortion', '#F113BE'),
(3, 'Amplifier', '#00BBF9'),
(4, 'Signature', '#FFD166');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','client') COLLATE utf8mb4_unicode_ci DEFAULT 'client',
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `date_creation`) VALUES
(1, 'Admin', 'Anthony', 'admin.anthony@workshop.be', 'Admin2026_workshop!', 'admin', '2026-06-10 12:42:16');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Contraintes pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  ADD CONSTRAINT `detail_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_commande_ibfk_2` FOREIGN KEY (`id_produit_format`) REFERENCES `produit_format` (`id_produit_format`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`),
  ADD CONSTRAINT `produits_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `types` (`id_type`);

--
-- Contraintes pour la table `produit_format`
--
ALTER TABLE `produit_format`
  ADD CONSTRAINT `produit_format_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE,
  ADD CONSTRAINT `produit_format_ibfk_2` FOREIGN KEY (`id_format`) REFERENCES `formats` (`id_format`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
