-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 24 Août 2014 à 21:59
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `openlibrerian`
--

-- --------------------------------------------------------

--
-- Structure de la table `memberchiptags`
--

CREATE TABLE IF NOT EXISTS `memberchiptags` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IDObject` int(11) unsigned NOT NULL,
  `IDTag` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `IDMusic` (`IDObject`),
  KEY `IDLabel` (`IDTag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Structure de la table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(1600) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`name`),
  KEY `description` (`description`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `label` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `tokenapi`
--

CREATE TABLE IF NOT EXISTS `tokenapi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ip` int(11) DEFAULT NULL,
  `token` varchar(254) NOT NULL,
  `DateTime` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `page` varchar(255) NOT NULL,
  `usee` enum('0','1') NOT NULL DEFAULT '0',
  `associatedDatas` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=597 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `memberchiptags`
--
ALTER TABLE `memberchiptags`
  ADD CONSTRAINT `memberchiptags_ibfk_1` FOREIGN KEY (`IDObject`) REFERENCES `objects` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memberchiptags_ibfk_2` FOREIGN KEY (`IDTag`) REFERENCES `tags` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
