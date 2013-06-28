-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 28. Jun 2013 um 14:47
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `auftrag`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aenderung_track`
--

CREATE TABLE IF NOT EXISTS `aenderung_track` (
  `user` varchar(255) NOT NULL,
  `projekt` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `versionsnummer` int(11) NOT NULL,
  `groesse` int(11) NOT NULL,
  PRIMARY KEY (`projekt`,`versionsnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `aenderung_track`
--

INSERT INTO `aenderung_track` (`user`, `projekt`, `datetime`, `user_name`, `versionsnummer`, `groesse`) VALUES
('1', '1', '2013-06-17 13:42:42', '', 1, 331468),
('1', '1', '2013-06-17 13:47:05', '', 2, 331477),
('1', '16', '2013-06-26 10:03:26', '', 1, 333112),
('1', '3', '2013-06-18 09:46:54', '', 2, 327436),
('1', '3', '2013-06-18 09:46:56', '', 3, 327436),
('1', '3', '2013-06-18 09:46:59', '', 4, 327436),
('1', '3', '2013-06-18 09:47:10', '', 5, 327436),
('1', '7', '2013-06-17 13:54:25', '', 7, 331535),
('1', '7', '2013-06-18 09:26:44', '', 8, 327416),
('1', '7', '2013-06-18 09:27:05', '', 9, 327417),
('1', '7', '2013-06-18 09:55:22', '', 10, 327436);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_daten`
--

CREATE TABLE IF NOT EXISTS `login_daten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `benutzername` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `e_mail_adresse` varchar(255) NOT NULL,
  `rolle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Daten für Tabelle `login_daten`
--

INSERT INTO `login_daten` (`id`, `benutzername`, `passwort`, `vorname`, `nachname`, `e_mail_adresse`, `rolle`) VALUES
(1, 'Goulao', '12345', 'Jan', 'Elsner', 'computerwurm_jan@web.de', 'admin'),
(2, 'kathi', '12345678', 'kathrin', 'mÃ¼ller', 'kathi.mÃ¼llers', 'member'),
(5, 'gouth 2', '1234567', 'Sarah ', 'hallo', 'sarah@aol.de', 'member'),
(15, 'moine', '321', 'angelina', 'abend', 'angelina@web.de', 'locked'),
(17, 'morgen2', '765', 'marlin', 'hi', 'marlin@web.de', 'locked'),
(21, 'fsadfsadf', '123', 'fasdf', 'fasdfsadf', 'fasdfsadf', 'locked'),
(22, 'basketballer', '4321', 'Fabi', 'sportler', 'fabi@aol.com', 'member'),
(29, 'morning3', '98765', 'maurices', 'brakedancers', 'maurices@web.de', 'member'),
(30, 'Ängie', '12345', 'Angelina', 'bald', 'dasfassad', 'member'),
(39, 'janina', 'sasadsad', 'DASDASDAD', 'fasdadad', 'sdfhsaffdg', 'locked');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projekte`
--

CREATE TABLE IF NOT EXISTS `projekte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `benutzer_Id` int(11) NOT NULL,
  `erstellung` date NOT NULL,
  `status` varchar(255) NOT NULL COMMENT 'closed/open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `projekte`
--

INSERT INTO `projekte` (`id`, `name`, `benutzer_Id`, `erstellung`, `status`) VALUES
(1, 'spass', 1, '2022-04-20', 'closed'),
(2, 'spassw', 1, '0000-00-00', 'open'),
(3, 'Juli', 5, '2013-04-22', 'open'),
(7, 'dasdasd', 1, '2013-06-17', 'open'),
(8, 'Ängie', 1, '2013-06-25', 'open'),
(9, 'julis', 1, '2013-06-25', 'open'),
(10, 'asdasd', 1, '2013-06-25', 'open'),
(11, 'Julisa', 1, '2013-06-25', 'open'),
(12, 'angelina', 1, '2013-06-25', 'open'),
(14, 'Sarah', 1, '2013-06-26', 'open'),
(16, 'hsa', 1, '2013-06-26', 'open');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
