-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Lun 03 Décembre 2018 à 14:32
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
(6, 'KYU FEMMES', 1950, 2000, 'F', 1, 10, 0),
(7, 'EXCELLENCES FEMMES', 1950, 2000, 'F', 11, 18, 0),
(9, 'KYU HOMMES', 1950, 1998, 'M', 1, 10, 0),
(10, 'HONNEURS', 1950, 1998, 'M', 11, 12, 0),
(11, 'EXELLENCES HOMMES', 1950, 1998, 'M', 13, 18, 0),
(13, 'SAMOURAI', 2008, 2009, 'X', 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
