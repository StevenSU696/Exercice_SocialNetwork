-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 30 oct. 2024 à 10:22
-- Version du serveur : 5.7.31
-- Version de PHP : 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `donkey_fb`
--

-- --------------------------------------------------------

--
-- Structure de la table `aime`
--

DROP TABLE IF EXISTS `aime`;
CREATE TABLE IF NOT EXISTS `aime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `date_like` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `amitie`
--

DROP TABLE IF EXISTS `amitie`;
CREATE TABLE IF NOT EXISTS `amitie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id_1` int(11) DEFAULT NULL,
  `utilisateur_id_2` int(11) DEFAULT NULL,
  `date_amitie` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id_1` (`utilisateur_id_1`),
  KEY `utilisateur_id_2` (`utilisateur_id_2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `contenu` text NOT NULL,
  `date_publication` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `utilisateur_id`, `contenu`, `date_publication`) VALUES
(1, 2, 'Bonjour de Cézanne', '2024-10-24'),
(2, 9, 'Bonjour de Verdi', '2024-10-24'),
(3, 2, 'Les pommes de Cézanne', '2024-10-24'),
(7, 7, 'Les neiges d\'antan', '2024-10-24'),
(5, 2, 'Peindre sur le motif - Cézanne', '2024-10-24'),
(6, 9, 'Nabucco de Verdi', '2024-10-24'),
(8, 25, 'message de aaa', '2024-10-29'),
(9, 25, 'ceci est un message de aaa', '2024-10-29'),
(10, 25, 'ceci est un message de boss', '2024-10-29'),
(11, 25, 'MESSAGE DE LL', '2024-10-29'),
(12, 27, 'message de boss', '2024-10-29'),
(13, 27, 'Message de BOSS', '2024-10-29'),
(14, 27, 'zzzzzzzzzzzzzzzzzzzz', '2024-10-29'),
(15, 27, 'new new new', '2024-10-29'),
(16, 27, 'message new', '2024-10-29'),
(17, 27, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-10-29'),
(18, 27, 'nouveau message', '2024-10-29'),
(19, 28, 'message de LL', '2024-10-29'),
(20, 27, 'message avec vérifications', '2024-10-30'),
(21, 27, 'post du matin', '2024-10-30'),
(22, 27, '8.57', '2024-10-30'),
(23, 27, 'post 9.47', '2024-10-30'),
(24, 27, 'post = 9.53', '2024-10-30'),
(25, 27, 'post 9.54', '2024-10-30'),
(26, NULL, 'post 10.00', '2024-10-30'),
(27, NULL, 'zzz', '2024-10-30'),
(28, 27, 'post 10.00', '2024-10-30'),
(29, 27, 'post 10.08', '2024-10-30'),
(30, 27, 'post 10.10', '2024-10-30'),
(31, 27, 'post 10.12', '2024-10-30'),
(32, 27, 'post 10.16', '2024-10-30'),
(33, 27, 'aaa 10.18', '2024-10-30'),
(34, 27, '*** 10.18', '2024-10-30'),
(35, 27, 'yyyy', '2024-10-30'),
(36, 27, 'post 11.02', '2024-10-30'),
(37, 27, 'POST !', '2024-10-30'),
(38, 27, 'new message', '2024-10-30'),
(39, 27, 'new content', '2024-10-30');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `mot_de_passe`) VALUES
(26, 'admin', '$2y$10$xXQI.mfknR2NPUQvZVo.TOb5OHoVHVk7374ImF5UOimawBJVAQSM6'),
(2, 'Paul Cézanne', 'peinture'),
(9, 'Giuseppe Verdi', 'opéra'),
(8, 'Henri Beyle', 'écrivain'),
(14, 'François', '$2y$10$uDGK9/BLeLar/pvSzV485ORrXD6BgYId2XqRp9QabI4la/Ne16GlO'),
(11, 'Clark Kent alias Superman', 'superman'),
(28, 'LL', '$2y$10$.MQ4JZKyMYEOW/lmPZWaqekotZiKfXWSWC1ALCBAJZrS2ibkP65R2'),
(27, 'boss', '$2y$10$KcuByTsirNd3ABfUogr5oeOfDoVcQhgC3uXWvLHL6.PA3alWiczGK'),
(25, 'aaa', '$2y$10$ESjOb54dOlq8LKjPiSPfcuu3UaBUrQdvynwqUNq2JMNVS2Xx7mQW6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
