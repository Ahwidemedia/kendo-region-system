-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Sam 01 Décembre 2018 à 16:10
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jkcf`
--

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `annee_debut`, `annee_fin`, `sexe`, `grade_debut`, `grade_fin`, `mineur`) VALUES
(1, 'BENJAMIN', 2006, 2007, 'X', 0, 0, 1),
(2, 'MINIME', 2004, 2005, 'X', 0, 0, 1),
(3, 'ESPOIR', 2001, 2003, 'F', 0, 0, 1),
(4, 'CADET', 2002, 2003, 'M', 0, 0, 1),
(5, 'JUNIORS', 1999, 2001, 'M', 0, 0, 1),
(6, 'KYU FEMMES', 1950, 1999, 'F', 1, 10, 0),
(7, 'EXCELLENCES FEMMES', 1950, 1999, 'F', 11, 18, 0),
(9, 'KYU HOMMES', 1950, 1999, 'M', 1, 10, 0),
(10, 'HONNEURS', 1950, 1998, 'M', 11, 12, 0),
(11, 'EXELLENCES HOMMES', 1950, 1999, 'M', 13, 18, 0),
(13, 'SAMOURAI', 2009, 2009, 'X', 0, 0, 1);

--
-- Contenu de la table `clubs`
--

INSERT INTO `clubs` (`id`, `name`, `region_id`) VALUES
(1, 'JKCF', 6),
(2, 'KETSUGO ANGERS', 6),
(3, 'ANGERS KENDO IAIDO', 6),
(4, 'ESVN', 6),
(5, 'CPB KENSHIKAI RENNES', 5),
(6, 'KCSB', 5),
(7, 'KENDO CLUB POITIERS', 7),
(8, 'DOJO NANTAIS', 6),
(9, 'CEJC QUIMPER', 5),
(10, 'AME AGARU CAEN', 4),
(11, 'KENDO CLUB BRESTOIS', 5),
(12, 'LE POINÇONNET', 7),
(13, 'LE MANS', 6),
(14, 'USO KENDO IAIDO', 7),
(15, 'PATRONAGE LAÏQUE DE LORIENT', 5),
(16, 'JCN', 5),
(17, 'KENDO CLUB DE BRIONNE', 7),
(18, 'KENDO CLUB CONDEEN', 7),
(19, 'WAKOKAI', 5),
(20, 'ADAKI', 7),
(21, 'SHODOKAN', 6),
(22, 'CBB KENDO', 7),
(23, 'YUSHINKAN CHANTEPIE', 5),
(24, 'SUISHINKAI', 6),
(25, 'NITEN', 13),
(26, 'SHODOKAN Vendée', 6),
(28, 'JUDO CLUB DE VERTOU - KENDO', 6),
(29, 'JUDO CLUB NAZAIRIEN', 6),
(30, 'KEN SHIN KAN PLOERMEL', 5),
(31, 'CERCLE PAUL BERT GINGUENE', 5),
(32, 'ASSOCIATION SPORTIVE CHANTEPIE KENDO', 5);

--
-- Contenu de la table `competitions`
--

INSERT INTO `competitions` (`id`, `name`, `description`, `equipe`, `document`, `discipline_id`, `created`, `modified`, `evenement_id`) VALUES
(1, '', '<p>ezrz</p>', 2, NULL, 2, '2018-11-29 11:40:38', '2018-11-29 11:40:38', 0),
(2, '', '<p>lalala</p>', 3, NULL, 1, '2018-11-29 11:42:54', '2018-11-29 11:42:54', 6),
(3, '', '<p>Trop cool la compète</p>', 3, '3-.rtf', 1, '2018-11-29 11:58:26', '2018-11-29 11:58:26', 9);

--
-- Contenu de la table `disciplines`
--

INSERT INTO `disciplines` (`id`, `name`) VALUES
(2, 'IAIDO'),
(5, 'JODO'),
(1, 'KENDO'),
(4, 'NAGINATA'),
(3, 'SPORT CHAMBARA');

--
-- Contenu de la table `equipes`
--

INSERT INTO `equipes` (`id`, `name`, `competition_id`, `created`, `modified`) VALUES
(14, 'Equipe 1', 3, '2018-11-30 20:10:07', '2018-12-01 13:39:46'),
(15, 'Equipe 2', 3, '2018-11-30 23:46:25', '2018-12-01 13:39:46'),
(65, 'Equipe 3', 3, '2018-12-01 13:05:53', '2018-12-01 13:39:46'),
(72, 'Equipe 4', 3, '2018-12-01 13:25:41', '2018-12-01 13:25:41'),
(81, 'Equipe 5', 3, '2018-12-01 13:37:30', '2018-12-01 13:37:30'),
(82, 'Equipe 6', 3, '2018-12-01 13:39:46', '2018-12-01 13:39:46');

--
-- Contenu de la table `evenements`
--

INSERT INTO `evenements` (`id`, `name`, `description`, `lieux`, `image`, `date_debut`, `date_fin`, `date_desactivation`, `created`, `modified`, `slug`, `user_id`) VALUES
(9, 'Ma première compétition', '<p>C''est une belle compète</p>', 'Fontenay', '9-ma-premiere-competition.jpg', '2018-11-29', '2018-11-30', '2018-11-29', '2018-11-29', '2018-11-29', 'ma-premiere-competition', 2);

--
-- Contenu de la table `grades`
--

INSERT INTO `grades` (`id`, `name`) VALUES
(1, '10ème Kyu'),
(11, '1er Dan'),
(10, '1er Kyu'),
(12, '2ème Dan'),
(9, '2ème Kyu'),
(13, '3ème Dan'),
(8, '3ème Kyu'),
(14, '4ème Dan'),
(7, '4ème Kyu'),
(15, '5ème Dan'),
(6, '5ème Kyu'),
(16, '6ème Dan'),
(5, '6ème Kyu'),
(17, '7ème Dan'),
(4, '7ème Kyu'),
(18, '8ème Dan'),
(3, '8ème Kyu'),
(2, '9ème Kyu');

--
-- Contenu de la table `profils`
--

INSERT INTO `profils` (`id`, `name`) VALUES
(1, 'Administrateur'),
(2, 'Gestionnaire'),
(3, 'Utilisateur');

--
-- Contenu de la table `regions`
--

INSERT INTO `regions` (`id`, `name`) VALUES
(14, 'DOM TOM'),
(13, 'ILE DE FRANCE'),
(3, 'NORD EST - Bourgogne Franche Comté'),
(2, 'NORD EST - Grand Est'),
(1, 'NORD EST - Hauts de France'),
(5, 'NORD OUEST - Bretagne'),
(7, 'NORD OUEST - Centre Val de Loire'),
(4, 'NORD OUEST - Normandie'),
(6, 'NORD OUEST - Pays de la Loire'),
(8, 'SUD EST - Auvergne Rhone Alpes'),
(10, 'SUD EST - Corse'),
(9, 'SUD EST - PACA'),
(11, 'SUD OUEST - Nouvelle Aquitaine'),
(12, 'SUD OUEST - Occitanie');

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nom`, `prenom`, `email`, `fonction`, `active`, `token`, `lastlogin`, `profil_id`, `club_id`, `created`, `modified`) VALUES
(1, 'Unknown', '$2y$10$Vo2TkM5JWIrIvJ3OQVMGDeB6ywTbqYacvz7HqPQe6amU1kDx79C9G', 'Unknown', 'Unknown', 'Unknown@Unknown.fr', 'Unknown', 1, '', '2018-11-29 00:00:00', 1, 1, '2018-11-29 00:00:00', '2018-11-29 00:00:00'),
(2, 'AmandineHilt', '$2y$10$Vo2TkM5JWIrIvJ3OQVMGDeB6ywTbqYacvz7HqPQe6amU1kDx79C9G', 'Hilt', 'Amandine', 'amandine.hilt@hotmail.fr', 'Bénévole', 1, '', NULL, 0, 1, '2018-11-30 20:39:40', '2018-11-30 20:39:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
