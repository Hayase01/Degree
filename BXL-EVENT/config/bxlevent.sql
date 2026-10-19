-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 30 mars 2026 à 08:23
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
-- Base de données : `bxlevent`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `couleur`) VALUES
(1, 'Musique', 'Bleu'),
(2, 'Exposition', 'Vert'),
(3, 'Théâtre', 'Rouge'),
(4, 'Festival', 'Orange'),
(11, 'Athletisme', 'Brun');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `lieux` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) DEFAULT '0.00',
  `place_dispo` int NOT NULL,
  `organisateur_nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisateur_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `titre`, `description`, `date`, `heure`, `lieux`, `adresse`, `prix`, `place_dispo`, `organisateur_nom`, `organisateur_email`, `image`, `category_id`, `user_id`, `created_at`) VALUES
(1, 'Concert Jazz', 'Soirée jazz exceptionnelle', '2026-04-05', '20:00:00', 'Salle de Concert', '10 Rue de la Musique, Bruxelles', 15.00, 100, 'Jean Dupont', 'jean@example.com', 'concert.jpg', 1, 1, '2026-03-26 04:49:23'),
(2, 'Exposition Peinture', 'Œuvres contemporaines', '2026-04-10', '10:00:00', 'Galerie Art', '5 Avenue des Arts, Bruxelles', 0.00, 50, 'Marie Curie', 'marie@example.com', 'exposition.jpg', 2, 1, '2026-03-26 04:49:23'),
(3, 'Festival BD', 'Festival de bande dessinée', '2026-05-01', '12:00:00', 'Parc Central', '1 Parc Street, Bruxelles', 5.00, 200, 'Paul Martin', 'paul@example.com', 'festival.jpg', 4, 1, '2026-03-26 04:49:23'),
(4, 'Concert Classique 2025', 'Concert de l’année dernière', '2025-12-15', '19:00:00', 'Salle Historique', '12 Rue du Passé, Bruxelles', 10.00, 100, 'Jean Dupont', 'jean@example.com', 'classique.jpg', 1, 1, '2026-03-26 04:49:23'),
(5, 'Concert Electro', 'Soirée électro DJ', '2026-04-10', '22:00:00', 'Club Night', '12 Rue de la Nuit, Bruxelles', 18.00, 120, 'DJ Max', 'max@test.com', '1774849502_depositphotos_57551863-stock-photo-rock-concert.jpg', 1, 1, '2026-03-29 09:40:57'),
(6, 'Expo Moderne', 'Art contemporain', '2026-04-12', '11:00:00', 'Galerie Art', '8 Avenue des Arts, Bruxelles', 5.00, 60, 'Anna Lee', 'anna@test.com', '1774849572_depositphotos_44788455-stock-photo-colorful-modern-art-gallery.jpg', 2, 1, '2026-03-29 09:40:57'),
(7, 'Stand-up Comedy', 'Soirée humour', '2026-04-15', '20:30:00', 'Comedy Club', '3 Rue du Rire, Bruxelles', 12.00, 90, 'Tom Smile', 'tom@test.com', '1774850435_depositphotos_147714111-stock-illustration-stand-up-show-concept.jpg', 3, 1, '2026-03-29 09:40:57'),
(8, 'Festival Food', 'Street food festival', '2026-04-18', '12:00:00', 'Place Centrale', 'Grand Place, Bruxelles', 3.00, 300, 'Chef Alex', 'alex@test.com', '1774850510_depositphotos_101784422-stock-illustration-food-truck-street-food-festival.jpg', 4, 1, '2026-03-29 09:40:57'),
(9, 'Concert Pop', 'Concert pop live', '2026-04-20', '19:00:00', 'Salle Music', '15 Rue Musique, Bruxelles', 22.00, 150, 'Lina Pop', 'lina@test.com', '1774850578_vue-arriere-personnes-excitees-bras-leves-s-amusant-tout-regardant-feux-artifice-confettis-devant-scene-au-festival-musique-espace-copie_637285-568.jpg', 1, 1, '2026-03-29 09:40:57'),
(10, 'Expo Sculpture', 'Sculptures modernes', '2026-04-22', '10:00:00', 'Musée Art', '2 Rue Musée, Bruxelles', 7.00, 70, 'Paul Stone', 'paul@test.com', '1774850622_free-photo-of-rencontre-avec-une-statue-dans-le-parc.png', 2, 1, '2026-03-29 09:40:57'),
(11, 'Impro Théâtre', 'Improvisation théâtre', '2026-04-25', '19:30:00', 'Théâtre Libre', '9 Rue Libre, Bruxelles', 10.00, 80, 'Clara Scene', 'clara@test.com', '1774850722_femme-mime-choquee-couvrant-bouche-du-mime-masculin-debout-devant-rideau_23-2147891627.jpg', 3, 1, '2026-03-29 09:40:57'),
(12, 'Festival Jazz', 'Festival jazz annuel', '2026-04-28', '18:00:00', 'Parc Jazz', '7 Avenue Jazz, Bruxelles', 15.00, 200, 'Jazz Band', 'jazz@test.com', '1774850772_homme-joue-du-saxophone_1304-5306.jpg', 4, 1, '2026-03-29 09:40:57'),
(13, 'Concert Indie', 'Groupe indie live', '2026-05-02', '20:00:00', 'Club Indie', '6 Rue Indie, Bruxelles', 14.00, 100, 'Indie Band', 'indie@test.com', '1774850871_depositphotos_655528196-stock-photo-weezer-concert-webster-hall-new.jpg', 1, 1, '2026-03-29 09:40:57'),
(14, 'Expo Design', 'Design contemporain', '2026-05-05', '10:00:00', 'Centre Design', '4 Rue Design, Bruxelles', 6.00, 60, 'Design Pro', 'design@test.com', '1774850914_moderne-maquette-stand-exposition-publicitaire-chaises-etageres-drapeaux-eclairage-illustration-vectorielle-realiste_1284-84515.jpg', 2, 1, '2026-03-29 09:40:57'),
(15, 'Théâtre Moderne', 'Pièce moderne', '2026-05-08', '19:00:00', 'Théâtre Urbain', '11 Rue Urbaine, Bruxelles', 20.00, 120, 'Urban Team', 'urban@test.com', '1774850975_scene-theatre-rideau-rouge-sieges-projecteur_259139-478.jpg', 3, 1, '2026-03-29 09:40:57'),
(16, 'Festival Jeux de société', 'Festival en l\'honneur des jeux de société', '2026-05-12', '14:00:00', 'Parc Festival', '13 Avenue Festival, Bruxelles', 0.00, 400, 'Event Team', 'event@test.com', '1774851659_218011629-ludoerno-le-festival-des-jeux-de-societe-1-1600x900.jpg', 4, 1, '2026-03-29 09:40:57'),
(17, 'Concert Rock 2025', 'Concert rock énergique', '2025-11-10', '20:00:00', 'Ancienne Salle', '10 Rue du Passé, Bruxelles', 20.00, 80, 'Paul Durand', 'paul@test.com', '1774849453_depositphotos_6058460-stock-photo-music-illustration.jpg', 1, 1, '2026-03-29 09:45:48'),
(18, 'Expo Photo Vintage', 'Exposition de photos anciennes', '2025-10-05', '14:00:00', 'Galerie Retro', '5 Rue Vintage, Bruxelles', 0.00, 50, 'Marie Dupont', 'marie@test.com', '1774849424_pexels-photo-1674049.jpg', 2, 1, '2026-03-29 09:46:51'),
(19, 'Théâtre Classique', 'Pièce de théâtre classique', '2025-09-20', '19:30:00', 'Théâtre Royal', '20 Place Royale, Bruxelles', 25.00, 100, 'Jean Martin', 'jean@test.com', '1774849247_depositphotos_729400460-stock-photo-lope-vega-theater-hall-seville.jpg', 3, 1, '2026-03-29 09:46:51'),
(20, 'Festival Été 2025', 'Festival en plein air', '2025-08-15', '12:00:00', 'Parc Central', '1 Avenue du Parc, Bruxelles', 5.00, 200, 'Luc Bernard', 'luc@test.com', '1774850370_depositphotos_101938218-stock-photo-teenagers-summer-music-festival-sitting.jpg', 4, 1, '2026-03-29 09:46:51');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `création` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `création`) VALUES
(1, 'admin@bxlevents.be', '$2y$10$58wD8h81oQCoyTr2FK7ZC.HFiB9/TaTs.QrGpxGQgTR/fyl1v3Fha', '2026-03-26 04:25:49');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
