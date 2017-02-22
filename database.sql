-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 03. Mai 2016 um 19:33
-- Server Version: 5.6.16
-- PHP-Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `schichtplaner`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `ID` int(11) DEFAULT NULL,
  `Bezeichnung` varchar(120) DEFAULT NULL,
  `Dateiname` varchar(80) DEFAULT NULL,
  `ServerPfadname` varchar(80) DEFAULT NULL,
  `newsletter_typ` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schichten`
--

CREATE TABLE IF NOT EXISTS `schichten` (
  `terminnr` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `von` datetime DEFAULT NULL,
  `bis` datetime DEFAULT NULL,
  `Schichtnr` int(11) DEFAULT NULL,
  `Teilnehmer_1` int(11) DEFAULT NULL,
  `Teilnehmer_2` int(11) DEFAULT NULL,
  `Teilnehmer_3` int(11) DEFAULT NULL,
  `status_1` int(11) DEFAULT NULL,
  `status_2` int(11) DEFAULT NULL,
  `status_3` int(11) DEFAULT NULL,
  `sendedmail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schichten_teilnehmer`
--

CREATE TABLE IF NOT EXISTS `schichten_teilnehmer` (
  `terminnr` int(11) DEFAULT NULL,
  `schichtnr` int(11) DEFAULT NULL,
  `teilnehmernr` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `isschichtleiter` int(11) DEFAULT NULL,
  `sendedmail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `FilterTerminTage` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `settings`
--

INSERT INTO `settings` (`FilterTerminTage`) VALUES
(0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teilnehmer`
--

CREATE TABLE IF NOT EXISTS `teilnehmer` (
  `teilnehmernr` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `vorname` varchar(80) DEFAULT NULL,
  `nachname` varchar(80) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `pwd` varchar(120) DEFAULT NULL,
  `infostand` int(11) DEFAULT NULL,
  `trolley` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `Telefonnr` varchar(120) DEFAULT NULL,
  `Handy` varchar(120) DEFAULT NULL,
  `versammlung` varchar(70) DEFAULT NULL,
  `sprache` varchar(70) DEFAULT NULL,
  `Bemerkung` text,
  `LastLoginTime` datetime DEFAULT NULL,
  `MaxSchichten` varchar(30) DEFAULT NULL,
  `TeilnehmerBemerkung` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `termine`
--

CREATE TABLE IF NOT EXISTS `termine` (
  `terminnr` int(11) DEFAULT NULL,
  `art` int(11) DEFAULT NULL,
  `ort` varchar(120) DEFAULT NULL,
  `termin_von` datetime DEFAULT NULL,
  `termin_bis` datetime DEFAULT NULL,
  `sendedmail` int(11) DEFAULT NULL,
  `sonderschicht` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
