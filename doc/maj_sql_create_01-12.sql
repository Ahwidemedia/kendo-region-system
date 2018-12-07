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

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `annee_debut` year(4) NOT NULL,
  `annee_fin` year(4) NOT NULL,
  `sexe` varchar(1) COLLATE utf8_bin NOT NULL,
  `grade_debut` tinyint(2) NOT NULL,
  `grade_fin` int(11) NOT NULL,
  `mineur` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categories_competitions`
--

CREATE TABLE `categories_competitions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `region_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `competitions`
--

CREATE TABLE `competitions` (
  `id` int(11) NOT NULL,
  `name` varchar(800) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `equipe` int(1) NOT NULL DEFAULT '0',
  `document` text COLLATE utf8_bin,
  `discipline_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `evenement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE `equipes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `competition_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `lieux` varchar(500) COLLATE utf8_bin NOT NULL,
  `image` varchar(500) COLLATE utf8_bin NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `date_desactivation` date NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `slug` varchar(500) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `inscription_administratifs`
--

CREATE TABLE `inscription_administratifs` (
  `id` int(11) NOT NULL,
  `arbitre` int(1) NOT NULL DEFAULT '0',
  `commissaire` int(1) NOT NULL DEFAULT '0',
  `jury` int(1) NOT NULL,
  `presence` tinyint(3) NOT NULL,
  `licencie_id` int(11) DEFAULT NULL,
  `competition_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `inscription_competitions`
--

CREATE TABLE `inscription_competitions` (
  `id` int(11) NOT NULL,
  `commentaire` text COLLATE utf8_bin,
  `surclassement_age` tinyint(1) NOT NULL DEFAULT '0',
  `surclassement_grade` tinyint(1) NOT NULL,
  `autorisation` int(1) NOT NULL DEFAULT '0',
  `certificat` year(4) NOT NULL,
  `certificat_qs` tinyint(1) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `licencie_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL,
  `participation_indiv` tinyint(1) NOT NULL,
  `participation_equipe` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='	';

-- --------------------------------------------------------

--
-- Structure de la table `inscription_passages`
--

CREATE TABLE `inscription_passages` (
  `id` int(11) NOT NULL,
  `commentaire` text COLLATE utf8_bin,
  `passage_id` int(11) NOT NULL,
  `licencie_id` int(11) NOT NULL,
  `grade_presente_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `licencies`
--

CREATE TABLE `licencies` (
  `id` int(11) NOT NULL,
  `nom` varchar(45) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(45) COLLATE utf8_bin NOT NULL,
  `ddn` year(4) NOT NULL,
  `sexe` varchar(1) COLLATE utf8_bin NOT NULL,
  `numero_licence` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `grade_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `passages`
--

CREATE TABLE `passages` (
  `id` int(11) NOT NULL,
  `name` varchar(800) COLLATE utf8_bin NOT NULL,
  `date_passage` date NOT NULL,
  `lieux` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `archive` int(1) NOT NULL DEFAULT '1',
  `date_desactivation` date DEFAULT NULL,
  `document` text COLLATE utf8_bin,
  `discipline_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `evenement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

CREATE TABLE `profils` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `nom` varchar(100) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `fonction` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) NOT NULL,
  `token` varchar(500) COLLATE utf8_bin NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `profil_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories_competitions`
--
ALTER TABLE `categories_competitions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `regio_club_fk_idx` (`region_id`);

--
-- Index pour la table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Index pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_historique_fk_idx` (`user_id`);

--
-- Index pour la table `inscription_administratifs`
--
ALTER TABLE `inscription_administratifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `licencie_adm_inscription_idx` (`licencie_id`),
  ADD KEY `user_adm_inscription_idx` (`user_id`);

--
-- Index pour la table `inscription_competitions`
--
ALTER TABLE `inscription_competitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_inscription_fk_idx` (`competition_id`),
  ADD KEY `user_cpt_inscription_fk_idx` (`user_id`),
  ADD KEY `licencie_cpt_inscription_idx` (`licencie_id`);

--
-- Index pour la table `inscription_passages`
--
ALTER TABLE `inscription_passages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passage_inscripyion_fk_idx` (`passage_id`),
  ADD KEY `licencie_inscription_fk_idx` (`licencie_id`),
  ADD KEY `grade_inscription_fk_idx` (`grade_presente_id`),
  ADD KEY `club_inscription_fk_idx` (`club_id`),
  ADD KEY `user_inscription_fk_idx` (`user_id`);

--
-- Index pour la table `licencies`
--
ALTER TABLE `licencies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Index pour la table `passages`
--
ALTER TABLE `passages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discipline_passage_fk_idx` (`discipline_id`);

--
-- Index pour la table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Index pour la table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`,`prenom`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `profil_user_fk_idx` (`profil_id`),
  ADD KEY `club_user_fk_idx` (`club_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories_competitions`
--
ALTER TABLE `categories_competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `inscription_administratifs`
--
ALTER TABLE `inscription_administratifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `inscription_competitions`
--
ALTER TABLE `inscription_competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `licencies`
--
ALTER TABLE `licencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `clubs`
--
ALTER TABLE `clubs`
  ADD CONSTRAINT `region_club_fk` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD CONSTRAINT `user_historique_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `licencies` 
ADD UNIQUE INDEX `licencie_uk` (`nom` ASC, `prenom` ASC, `ddn` ASC, `sexe` ASC);

ALTER TABLE `passages` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT; 

ALTER TABLE `inscription_passages` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `inscription_passages` 
ADD UNIQUE INDEX `inscription_passage_unique` (`passage_id` ASC, `licencie_id` ASC);

ALTER TABLE `licencies` 
ADD COLUMN `date_naissance` DATE NULL AFTER `ddn`,
ADD COLUMN `lieu_naissance` VARCHAR(100) NULL AFTER `date_naissance`,
ADD COLUMN `adresse` VARCHAR(800) NULL AFTER `lieu_naissance`;
ADD COLUMN `nationalite` VARCHAR(100) NULL AFTER `numero_licence`,
ADD COLUMN `telephone` VARCHAR(45) NULL AFTER `nationalite`,
ADD COLUMN `fax` VARCHAR(45) NULL AFTER `telephone`,
ADD COLUMN `email` VARCHAR(45) NULL AFTER `fax`,
ADD COLUMN `grade_actuel_lieu` VARCHAR(100) NULL AFTER `grade_actuel_id`,
ADD COLUMN `grade_actuel_organisation` VARCHAR(100) NULL AFTER `grade_actuel_lieu`,
ADD COLUMN `grade_actuel_date` DATE NULL AFTER `grade_actuel_organisation`,
CHANGE COLUMN `grade_id` `grade_actuel_id` INT(11) NOT NULL ;

ALTER TABLE `licencies` 
CHANGE COLUMN `date_naissance` `date_naissance` DATE NOT NULL ,
CHANGE COLUMN `numero_licence` `numero_licence` VARCHAR(45) NULL ,
CHANGE COLUMN `email` `email` VARCHAR(45) NOT NULL ,
CHANGE COLUMN `grade_id` `grade_actuel_id` INT(11) NOT NULL ;

ALTER TABLE `licencies` 
CHANGE COLUMN `date_naissance` `date_naissance` DATE NOT NULL;

ALTER TABLE `inscription_passages` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
