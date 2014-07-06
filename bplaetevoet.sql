-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 06 jul 2014 om 21:37
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `bplaetevoet`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `omschrijving` longtext COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `afbeelding` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `projects`
--

INSERT INTO `projects` (`id`, `naam`, `omschrijving`, `url`, `afbeelding`, `datecreated`) VALUES
(1, 'Dewofire brandbeveiliging', 'Opdracht : Voor een nieuwe speler op de markt van brandbeveiliging een passende website opmaken met oog voor de eigen huisstijl en gebruiksgemak.\r\nInclusief shopping-systeem om offertes aan te vragen.\r\n', 'http:\\\\www.dewofire.be', 'dewofire-1.jpg', '2014-07-05 11:57:17'),
(2, 'VDAB Pizzashop', 'Deze site werd gemaakt als eindopdracht in de cursus PHP ', 'http://www.bplaetevoet.be/pizzashop', 'pizzashop-1.jpg', '2014-07-05 15:14:13');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `omschrijving` longtext COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Gegevens worden geëxporteerd voor tabel `skills`
--

INSERT INTO `skills` (`id`, `naam`, `omschrijving`, `level`) VALUES
(1, 'HTML5', '', 8),
(2, 'CSS3', '', 8),
(3, 'PHP 5.4', '', 8),
(4, 'Doctrine', '', 7),
(5, 'SQL', '', 7),
(6, 'symfony2', '', 5),
(7, 'Responsive design', '', 7),
(8, 'Bootstrap', '', 8);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `skill_project`
--

CREATE TABLE IF NOT EXISTS `skill_project` (
  `skill_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`skill_id`,`project_id`),
  KEY `IDX_35464EC75585C142` (`skill_id`),
  KEY `IDX_35464EC7166D1F9C` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `skill_project`
--
ALTER TABLE `skill_project`
  ADD CONSTRAINT `FK_35464EC7166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_35464EC75585C142` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
