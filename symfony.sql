-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 18 Janvier 2015 à 22:41
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cp` int(11) NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `siret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci,
  `dateadd` datetime NOT NULL,
  `datemodif` datetime DEFAULT NULL,
  `nbprojets` smallint(6) DEFAULT NULL,
  `useradd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usermodif` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C0E801635E237E06` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `name`, `adresse`, `cp`, `ville`, `pays`, `tel`, `fax`, `email`, `contact`, `code`, `siret`, `notes`, `dateadd`, `datemodif`, `nbprojets`, `useradd`, `usermodif`, `slug`) VALUES
(26, 'Client 1', 'adresse Client 1', 31800, 'Ville Client 1', 'France', 'Téléphone Client 1', 'Fax Client 1', 'emailclient1@gmail.com', 'Contact Client 1', NULL, NULL, NULL, '2014-12-19 14:50:46', '2015-01-16 14:53:54', 2, '', NULL, ''),
(27, 'Client 2', 'adresse Client 2', 31800, 'Ville Client 2', 'France', 'Téléphone Client 2', 'Fax Client 2', 'Email Client 2', 'Contact Client 2', NULL, NULL, NULL, '2014-12-19 14:50:46', NULL, 0, '', NULL, ''),
(28, 'Client 3', 'adresse Client 3', 31800, 'Ville Client 3', 'France', 'Téléphone Client 3', 'Fax Client 3', 'Email Client 3', 'Contact Client 3', NULL, NULL, NULL, '2014-12-19 14:50:46', NULL, 0, '', NULL, ''),
(29, 'Client 4', 'adresse Client 4', 31800, 'Ville Client 4', 'France', 'Téléphone Client 4', 'Fax Client 4', 'Email Client 4', 'Contact Client 4', NULL, NULL, NULL, '2014-12-19 14:50:46', NULL, 0, '', NULL, ''),
(30, 'Client 5', 'adresse Client 5', 31800, 'Ville Client 5', 'France', 'Téléphone Client 5', 'Fax Client 5', 'Email Client 5', 'Contact Client 5', NULL, NULL, NULL, '2014-12-19 14:50:46', NULL, 0, '', NULL, ''),
(31, 'Technograv', 'boulevard maréchal joffre', 31800, 'Saint Gaudens', 'France', 'ND', 'ND', 'info@technograv.fr', 'Nicole Pique', 'TG31', 'ND', 'Aucune info particulière', '2014-12-19 17:21:53', NULL, 0, '', NULL, ''),
(32, 'Reproduction', 'pour', 0, 'test', 'France', 'on', 'met', 'rien@rien.fr', 'Reproduction', 'dans', 'contact', 'point.', '2014-12-19 18:29:32', NULL, 0, '', NULL, ''),
(33, 'deuxieme', 'test', 31800, 'voir', 'France', 'si', 'ca', 'fonctionne@bien.fr', 'troisièeme', 'c''est', 'partie', 'point.', '2014-12-19 19:39:02', '2014-12-19 19:41:08', 0, '', NULL, ''),
(34, 'Marine Perard', '53 rue Gambetta', 92800, 'PUTEAUX', 'France', '0619666119', '0619666120', 'maildemarine@gmail.com', 'Marine Perard', 'MP18', '5465420454513', 'Pas de note', '2014-12-20 10:21:19', '2015-01-13 10:40:59', 1, '', NULL, ''),
(35, 'On', 'un', 6, 'd', 'France', 'a', 'f', 'i@i.com', 'c', 'h', 'a', 'fait', '2014-12-20 10:34:43', NULL, 0, '', NULL, ''),
(36, 'lol', 'un', 6, 'd', 'France', 'a', 'f', 'i@i.com', 'lol', 'h', 'a', 'fait', '2014-12-20 10:35:52', NULL, 0, '', NULL, ''),
(37, 'Nicolas Michel', '53 rue Gambetta', 88, 'PUTEAUX', 'France', 'ND', 'ND', 'nicolas.michel2008@gmail.com', 'Nicolas Michel', 'poiu', 'poiu', NULL, '2014-12-20 11:37:48', NULL, 0, '', NULL, ''),
(38, 'quatrieme', 'test', 39, 'voir', 'France', '0619666116', 'ND', 'fonctionne@bien.fr', 'quatrieme', NULL, NULL, NULL, '2014-12-20 12:01:19', NULL, 0, '', NULL, ''),
(39, 'cinquieme', 'adresse', 4, 'voir', 'France', 'ND', 'ND', 'fonctionne@bien.fr', 'Moi meme', NULL, NULL, NULL, '2014-12-20 12:02:48', '2015-01-15 19:21:59', 6, '', NULL, ''),
(43, 'Pascal Pérard', 'adresse', 12, 'ED', 'France', 'Tel', NULL, 'email@email.com', 'Pascal Pérard', NULL, NULL, 'note', '2014-12-21 21:35:14', NULL, 0, '', NULL, ''),
(44, 'Client test pour Marine', 'Adresse assez longue', 10000, 'Mortain', 'France', '0265497846', '4678945478', 'monnouvelemai@gmail.com', 'Marine', 'MA01', NULL, 'Notes', '2015-01-11 19:54:24', '2015-01-11 19:57:20', 0, '', NULL, ''),
(54, 'test id_client non null', 'adresse id_client assez longue', 45698, 'ville id_client', 'France', '0123654789', '9658741236', 'emailid_client@gmail.com', 'contact id_client', 'ND', 'ND', 'aucune notes', '2015-01-17 22:16:22', NULL, 0, '', NULL, ''),
(56, 'test INSERT INTO', 'INSERT INTO assez long', 45678, 'INSERT INTO ville', 'France', '0123467895', '4567821345', 'emailINSERTINTO@gmail.com', 'INSERT INTO', 'II', 'ND', 'notes INSERT INTO', '2015-01-17 22:20:20', '2015-01-17 23:32:51', 3, '', NULL, ''),
(57, 'test 10 min', 'test 10 min assez long', 2157, 'test 10 min ville', 'France', '9876543219', '9876542219', 'test10min@gmail.com', '10 min', 'TDM', 'ND', 'notes test 10 min', '2015-01-17 22:40:47', NULL, 0, '', NULL, ''),
(58, 'test useradd', 'test useradd adresse assez longue', 54879, 'test useradd ville', 'France', '0234987615', '5478945124', 'testuseraddnew@gmail.com', 'test useradd contact', 'aucun', 'aucun', 'notes test useradd', '2015-01-18 01:09:47', '2015-01-18 01:14:33', 0, 'user2', 'user1', ''),
(59, 'test sans oldfile', 'test sans oldfile adresse', 45789, 'test sans oldfile ville', 'France', '1247985621', '1346985247', 'testsansoldfile@gmail.com', 'test sans oldfile contact', 'aucun', 'aucun', 'notes test sans oldfile', '2015-01-18 01:37:18', NULL, 0, 'user2', NULL, ''),
(64, 'test slug 1 !', 'test slug 1 ! adresse', 45789, 'test slug 1 ! ville', 'France', '4545454545', '7878787878', 'testslug1@gmail.com', 'test slug 1 ! contact', 'aucun', 'aucun', 'test slug 1 ! notes', '2015-01-18 20:18:20', NULL, 0, 'user2', NULL, 'test-slug-1-test-slug-1-ville'),
(65, 'Renault', '46 rue de la renault', 31800, 'Saint Gaudens', 'France', '4565467897', '3254154678', 'renaultstgaudens@gmail.com', 'Madame Renault', 'aucun', 'aucun', 'aucune note', '2015-01-18 20:22:15', NULL, 0, 'user2', NULL, 'renault-saint-gaudens'),
(66, 'Peugeot', 'adresse Peugeot assez longue', 31870, 'Saint gaudens', 'France', '4545121264', '1231649785', 'Peugeot1@gmail.com', 'contact Peugeot', 'aucun', 'aucun', 'aucune notes', '2015-01-18 20:29:04', NULL, 0, 'user2', NULL, 'peugeot'),
(67, 'Karaka', 'Karaka adresse', 31800, 'Saint Gaudens', 'France', '4569874578', '5123658745', 'Karaka@gmail.com', 'Karaka contact', 'Karaka', 'Karaka', 'Karaka notes', '2015-01-18 22:03:28', NULL, 0, 'user2', NULL, 'karaka');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projet_id` int(11) NOT NULL,
  `auteur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E16CE76BC18272` (`projet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `projet_id`, `auteur`, `contenu`, `date`, `titre`) VALUES
(1, 13, NULL, 'contenu qui fonctionne', '2015-01-16 15:55:45', 'Mon premier com !'),
(2, 13, NULL, 'test nbcomment', '2015-01-16 15:57:29', 'deuxième comment');

-- --------------------------------------------------------

--
-- Structure de la table `crea`
--

CREATE TABLE IF NOT EXISTS `crea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `infos` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `prixHT` int(11) NOT NULL,
  `tva` int(11) NOT NULL,
  `prixttc` int(11) NOT NULL,
  `acompte` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `infos` longtext COLLATE utf8_unicode_ci NOT NULL,
  `projet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4AE6EA2FC18272` (`projet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `devis`
--

INSERT INTO `devis` (`id`, `numero`, `prixHT`, `tva`, `prixttc`, `acompte`, `url`, `alt`, `infos`, `projet_id`) VALUES
(1, 6, 11, 16, 18, 20, 'txt', 'readme.txt', 'infos ajouter un nouveau devis', 17);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `montantHT` int(11) NOT NULL,
  `tva` int(11) NOT NULL,
  `netapayer` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `infos` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `logo`
--

CREATE TABLE IF NOT EXISTS `logo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extention` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `infos` longtext COLLATE utf8_unicode_ci,
  `client_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_44BC352D19EB6921` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Contenu de la table `logo`
--

INSERT INTO `logo` (`id`, `extention`, `alt`, `infos`, `client_id`, `date`) VALUES
(2, 'jpeg', 'croustade.jpg', 'marre de id_client', 54, '2015-01-17 22:16:22'),
(3, 'jpeg', 'croustade.jpg', 'INSERT INTO infos', 56, '2015-01-17 22:20:20'),
(4, 'jpeg', 'croustade.jpg', 'infos test 10 min', 57, '2015-01-17 22:40:47'),
(5, 'jpeg', 'croustade.jpg', 'test useradd', 58, '2015-01-18 01:09:47'),
(6, 'jpeg', 'croustade.jpg', 'test sans oldfile infos', 59, '2015-01-18 01:37:18'),
(11, 'jpeg', 'croustade.jpg', 'test slug 1 ! infos', 64, '2015-01-18 20:18:20'),
(12, 'jpeg', 'croustade.jpg', 'Renault', 65, '2015-01-18 20:22:15'),
(13, 'jpeg', 'croustade.jpg', 'infos Peugeot', 66, '2015-01-18 20:29:04'),
(14, 'jpeg', 'croustade.jpg', 'Karaka infos', 67, '2015-01-18 22:03:29');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auteur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contenu` longtext COLLATE utf8_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL,
  `delai` time DEFAULT NULL,
  `assign` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etape` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateadd` datetime NOT NULL,
  `datemodif` datetime DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `maj` datetime NOT NULL,
  `nbcommentaires` smallint(6) DEFAULT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_57B9999F19EB6921` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id`, `titre`, `auteur`, `contenu`, `published`, `delai`, `assign`, `type`, `etape`, `dateadd`, `datemodif`, `client_id`, `maj`, `nbcommentaires`, `slug`) VALUES
(1, 'Test upload', NULL, 'aucune consigne', 1, NULL, 0, 'gra', 'com', '2015-01-05 14:45:24', NULL, 39, '0000-00-00 00:00:00', 0, ''),
(2, 'Test upload 2', NULL, 'Toujours aucune', 1, NULL, 0, 'gra', 'com', '2015-01-05 14:53:32', NULL, 39, '0000-00-00 00:00:00', 0, ''),
(3, 'Projet 1', NULL, 'aucune', 1, NULL, 0, 'gra', 'com', '2015-01-05 15:00:52', NULL, 39, '0000-00-00 00:00:00', 0, ''),
(4, 'Projet 2', NULL, 'lol', 1, NULL, 0, 'hab', 'com', '2015-01-05 15:03:20', NULL, 26, '0000-00-00 00:00:00', 0, ''),
(5, 'Projet 3', NULL, 'test avec param!=null', 1, NULL, 0, 'gra', 'com', '2015-01-05 16:10:29', NULL, 39, '0000-00-00 00:00:00', 0, ''),
(6, 'Projet 3', NULL, 'test avec param!=null', 1, NULL, 0, 'gra', 'com', '2015-01-05 16:11:24', NULL, 39, '0000-00-00 00:00:00', 0, ''),
(7, 'Projet 3', NULL, 'test avec param!=null', 1, NULL, 0, 'gra', 'com', '2015-01-05 16:27:34', NULL, 39, '0000-00-00 00:00:00', 0, ''),
(12, 'test upload 2344', NULL, 'consignes', 1, NULL, 0, 'gra', 'com', '2015-01-13 10:40:58', NULL, 34, '2015-01-13 10:40:58', 0, ''),
(13, 'Test des evenements', NULL, 'aucune', 1, NULL, 0, 'gra', 'com', '2015-01-16 14:53:54', '2015-01-16 15:57:29', 26, '2015-01-16 15:57:29', 1, ''),
(15, 'Projet Devix(s)', NULL, 'Projet Devix(s) est a faire !', 1, '09:10:00', 0, 'gra', 'com', '2015-01-17 22:38:05', NULL, 56, '2015-01-17 22:38:05', 0, ''),
(17, 'ajouter un nouveau devis', NULL, 'ajouter un nouveau devis consignes', 1, NULL, 0, 'gra', 'com', '2015-01-17 23:32:50', NULL, 56, '2015-01-17 23:32:50', 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `projet_crea`
--

CREATE TABLE IF NOT EXISTS `projet_crea` (
  `projet_id` int(11) NOT NULL,
  `crea_id` int(11) NOT NULL,
  PRIMARY KEY (`projet_id`,`crea_id`),
  KEY `IDX_A4F1ACCC18272` (`projet_id`),
  KEY `IDX_A4F1ACC2A9051B5` (`crea_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet_facture`
--

CREATE TABLE IF NOT EXISTS `projet_facture` (
  `projet_id` int(11) NOT NULL,
  `facture_id` int(11) NOT NULL,
  PRIMARY KEY (`projet_id`,`facture_id`),
  KEY `IDX_7CAC3961C18272` (`projet_id`),
  KEY `IDX_7CAC39617F2DEE08` (`facture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA1797792FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_2DA17977A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 'user1', 'user1', 'email@gmail.com', 'email@gmail.com', 1, 'd3lcrm3mftsgwcgk04wows0gg0wgc0g', '376Z6T2Og67YeRUWR7UFh6NGSx9lGNiVYNmnP9P/1Eh+lgYo7aJY5MqnKNBJVWAqQIQkLBGOux4F3sMvGcDJCg==', '2015-01-18 01:13:56', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(2, 'user2', 'user2', 'emailuser2@gmail.com', 'emailuser2@gmail.com', 1, '99vwy3ujixgcc004cs0o8kwcww8gcsg', 'sIVRb9Kt5rFKw+/GFIaQRaYFO3jWpiz0J3roWUtM/izwaerxHldp8tLjSl/RRS9AIna5pXPCBmK96lXfJfqRXQ==', '2015-01-18 01:37:01', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL),
(3, 'user3', 'user3', 'nouvelemail@gmail.com', 'nouvelemail@gmail.com', 1, 'sb8korpc37kwgsog4cckk4k8skk4wg4', '1lkeJc6efoToMMimng6lafStzZFNZ2pa+nKooQrf7Hxb4ASmSy9eDQv3rMGHhD8ssi2kJXoBbwTHFXsyPEPE+w==', '2015-01-11 20:21:20', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_E16CE76BC18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`);

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `FK_4AE6EA2FC18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`);

--
-- Contraintes pour la table `logo`
--
ALTER TABLE `logo`
  ADD CONSTRAINT `FK_44BC352D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_57B9999F19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `projet_crea`
--
ALTER TABLE `projet_crea`
  ADD CONSTRAINT `FK_A4F1ACC2A9051B5` FOREIGN KEY (`crea_id`) REFERENCES `crea` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A4F1ACCC18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projet_facture`
--
ALTER TABLE `projet_facture`
  ADD CONSTRAINT `FK_7CAC39617F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7CAC3961C18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
