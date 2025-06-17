-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 01:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suelect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `volledige_naam` text NOT NULL,
  `is_actief` tinyint(1) NOT NULL DEFAULT 1,
  `laatste_login` timestamp NULL DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` enum('normal_admin','root_admin') NOT NULL DEFAULT 'normal_admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `wachtwoord`, `email`, `volledige_naam`, `is_actief`, `laatste_login`, `aangemaakt_op`, `bijgewerkt_op`, `type`) VALUES
(1, 'SuElect\\RA-SlijngardC', '$2y$10$GBbjjzIsSRy7ugU7G0s17u0mmroBHUdOpTFoRTvv1c6h/8ZmL7fGu', 'chivar.slijngard@suelect.sr', 'Chivar Carl Freddy Slijngard', 1, '2025-06-11 12:41:34', '2025-03-12 08:23:39', '2025-06-11 13:32:34', 'root_admin'),
(2, 'SuElect\\NA-MeerveldA', '$2y$10$abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567890', 'anouk.meerveld@suelect.sr', 'Anouk Marie Meerveld', 1, '2025-06-10 17:20:15', '2025-03-15 12:15:22', '2025-06-10 17:20:15', 'normal_admin'),
(3, 'SuElect\\NA-KrosenR', '$2y$10$def456ghi789jkl012mno345pqr678stu901vwx234yz567890abc123', 'ricardo.krosen@suelect.sr', 'Ricardo David Krosen', 1, '2025-06-09 19:45:30', '2025-03-18 14:30:45', '2025-06-09 19:45:30', 'normal_admin'),
(4, 'SuElect\\NA-BlankenburgL', '$2y$10$ghi789jkl012mno345pqr678stu901vwx234yz567890abc123def456', 'lucia.blankenburg@suelect.sr', 'Lucia Elisabeth Blankenburg', 0, NULL, '2025-04-02 16:22:10', '2025-04-02 16:22:10', 'normal_admin');

-- --------------------------------------------------------

--
-- Table structure for table `admininlogpogingen`
--

CREATE TABLE `admininlogpogingen` (
  `poging_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `succes` tinyint(1) NOT NULL,
  `poging_datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admininlogpogingen`
--

INSERT INTO `admininlogpogingen` (`poging_id`, `admin_id`, `username`, `succes`, `poging_datum`) VALUES
(1, 1, 'SuElect\\RA-SlijngardC', 0, '2025-03-12 08:47:57'),
(2, 1, 'SuElect\\RA-SlijngardC', 0, '2025-03-12 08:48:16'),
(3, 1, 'SuElect\\RA-SlijngardC', 1, '2025-03-12 08:49:35'),
(4, 1, 'SuElect\\RA-SlijngardC', 1, '2025-03-12 10:22:57'),
(5, 1, 'SuElect\\RA-SlijngardC', 1, '2025-03-12 11:55:11'),
(6, 1, 'SuElect\\RA-SlijngardC', 1, '2025-03-20 03:01:32'),
(7, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-14 14:18:05'),
(8, 1, 'SuElect\\RA-SlijngardC', 0, '2025-05-21 12:07:44'),
(9, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-21 12:07:58'),
(10, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-21 12:20:22'),
(11, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-21 12:32:52'),
(12, 1, 'SuElect\\RA-SlijngardC', 0, '2025-05-21 15:10:15'),
(13, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-21 15:10:22'),
(14, 1, 'SuElect\\RA-SlijngardC', 0, '2025-05-28 10:15:04'),
(15, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-28 10:15:20'),
(16, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-28 11:10:59'),
(17, 1, 'SuElect\\RA-SlijngardC', 1, '2025-05-28 12:02:40'),
(18, 1, 'SuElect\\RA-SlijngardC', 1, '2025-06-11 01:15:49'),
(19, 1, 'SuElect\\RA-SlijngardC', 1, '2025-06-11 02:46:31'),
(20, 1, 'SuElect\\RA-SlijngardC', 0, '2025-06-11 12:41:21'),
(21, 1, 'SuElect\\RA-SlijngardC', 1, '2025-06-11 12:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `distrikt`
--

CREATE TABLE `distrikt` (
  `distrikt_id` bigint(20) UNSIGNED NOT NULL,
  `naam` text NOT NULL,
  `aantal_zetels` int(11) NOT NULL DEFAULT 1,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distrikt`
--

INSERT INTO `distrikt` (`distrikt_id`, `naam`, `aantal_zetels`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Paramaribo', 12, '2025-01-15 13:00:00', '2025-01-15 13:00:00'),
(2, 'Wanica', 8, '2025-01-15 13:05:00', '2025-01-15 13:05:00'),
(3, 'Nickerie', 6, '2025-01-15 13:10:00', '2025-01-15 13:10:00'),
(4, 'Commewijne', 4, '2025-01-15 13:15:00', '2025-01-15 13:15:00'),
(5, 'Saramacca', 3, '2025-01-15 13:20:00', '2025-01-15 13:20:00'),
(6, 'Para', 2, '2025-01-15 13:25:00', '2025-01-15 13:25:00'),
(7, 'Marowijne', 2, '2025-01-15 13:30:00', '2025-01-15 13:30:00'),
(8, 'Brokopondo', 1, '2025-01-15 13:35:00', '2025-01-15 13:35:00'),
(9, 'Coronie', 1, '2025-01-15 13:40:00', '2025-01-15 13:40:00'),
(10, 'Sipaliwini', 1, '2025-01-15 13:45:00', '2025-01-15 13:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker`
--

CREATE TABLE `gebruiker` (
  `gebruiker_id` bigint(20) UNSIGNED NOT NULL,
  `voornaam` text NOT NULL,
  `achternaam` text NOT NULL,
  `id_nummer` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `geboorte_datum` date NOT NULL,
  `geslacht` enum('M','V','Anders') NOT NULL,
  `gestemd` tinyint(1) NOT NULL DEFAULT 0,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `laatste_login` timestamp NULL DEFAULT NULL,
  `distrikt_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gebruiker`
--

INSERT INTO `gebruiker` (`gebruiker_id`, `voornaam`, `achternaam`, `id_nummer`, `wachtwoord`, `email`, `geboorte_datum`, `geslacht`, `gestemd`, `aangemaakt_op`, `bijgewerkt_op`, `laatste_login`, `distrikt_id`) VALUES
(1, 'Tushar', 'Gena', '8XGH78ZA3', '$2y$10$0yzxpEanJbaMfGWAR9AsNO5LNWbwsx3HVwMOkdCN5eUA9.Q1/GI0.', 'tushar.gena@gmail.com', '2006-02-16', 'M', 0, '2025-03-20 03:12:01', '2025-06-12 01:13:00', '2025-06-10 17:19:22', 4),
(2, 'Mighaisa', 'Gau Gau', '8XGH78ZA6\r\n', '$2y$10$nGF.l4zSbXJQbOD3eq/GaOzFKub4x3L43eyQ5MhjVGdikIvW1ahK2', 'mighaisa.gaugau@gmail.com', '2005-04-07', 'V', 0, '2025-06-11 12:35:59', '2025-06-12 01:13:09', '2025-06-11 12:38:18', 1),
(3, 'Marcus', 'de Vries', '9YHI89ZB4', '$2y$10$pqr678stu901vwx234yz567890abc123def456ghi789jkl012mno345', 'marcus.devries@email.sr', '1985-07-12', 'M', 1, '2025-02-01 11:30:00', '2025-06-12 01:13:24', '2025-06-01 13:15:30', 7),
(4, 'Priya', 'Ramnarain', '7WGF67YC2', '$2y$10$stu901vwx234yz567890abc123def456ghi789jkl012mno345pqr678', 'priya.ramnarain@email.sr', '1992-11-23', 'V', 1, '2025-02-05 17:20:00', '2025-05-28 19:45:20', '2025-05-28 19:45:20', NULL),
(5, 'Erik', 'van der Berg', '6VFE56XD1', '$2y$10$vwx234yz567890abc123def456ghi789jkl012mno345pqr678stu901', 'erik.vandenberg@email.sr', '1978-03-15', 'M', 0, '2025-02-10 14:45:00', '2025-06-05 12:30:15', '2025-06-05 12:30:15', NULL),
(6, 'Anita', 'Soekhlal', '5UED45WE9', '$2y$10$yz567890abc123def456ghi789jkl012mno345pqr678stu901vwx234', 'anita.soekhlal@email.sr', '1990-09-08', 'V', 1, '2025-02-15 19:10:00', '2025-05-30 17:20:45', '2025-05-30 17:20:45', NULL),
(7, 'Roberto', 'Fernandez', '4TDC34VF8', '$2y$10$890abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567', 'roberto.fernandez@email.sr', '1987-12-03', 'M', 0, '2025-02-20 15:30:00', '2025-06-08 14:15:30', '2025-06-08 14:15:30', NULL),
(8, 'Kamala', 'Bisessar', '3SCB23UG7', '$2y$10$abc123def456ghi789jkl012mno345pqr678stu901vwx234yz567890', 'kamala.bisessar@email.sr', '1995-05-20', 'V', 1, '2025-02-25 12:15:00', '2025-06-02 18:30:20', '2025-06-02 18:30:20', NULL),
(9, 'Devon', 'Toussaint', '2RBA12TH6', '$2y$10$def456ghi789jkl012mno345pqr678stu901vwx234yz567890abc123', 'devon.toussaint@email.sr', '1982-08-14', 'M', 0, '2025-03-01 16:40:00', '2025-06-07 15:45:15', '2025-06-07 15:45:15', NULL),
(10, 'Kavita', 'Mahadew', '1QAZ01SI5', '$2y$10$ghi789jkl012mno345pqr678stu901vwx234yz567890abc123def456', 'kavita.mahadew@email.sr', '1993-01-27', 'V', 1, '2025-03-05 13:20:00', '2025-06-03 16:20:40', '2025-06-03 16:20:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inlogpogingen`
--

CREATE TABLE `inlogpogingen` (
  `poging_id` bigint(20) UNSIGNED NOT NULL,
  `gebruiker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `succes` tinyint(1) NOT NULL,
  `poging_datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inlogpogingen`
--

INSERT INTO `inlogpogingen` (`poging_id`, `gebruiker_id`, `succes`, `poging_datum`) VALUES
(1, 2, 0, '2025-03-12 00:39:48'),
(2, 2, 1, '2025-03-12 00:39:58'),
(3, 2, 0, '2025-03-12 00:40:03'),
(4, 2, 1, '2025-03-12 00:45:29'),
(5, 2, 0, '2025-03-12 03:29:08'),
(6, 2, 1, '2025-03-12 03:29:28'),
(7, 2, 1, '2025-03-12 04:35:42'),
(8, 2, 1, '2025-03-12 04:39:15'),
(9, 2, 1, '2025-03-12 05:13:28'),
(10, 2, 1, '2025-03-12 08:18:32'),
(11, 2, 1, '2025-03-12 08:18:59'),
(12, 2, 1, '2025-03-12 10:22:36'),
(13, NULL, 0, '2025-03-12 10:29:43'),
(14, NULL, 0, '2025-03-12 10:30:02'),
(15, 3, 1, '2025-03-12 10:30:10'),
(16, 1, 1, '2025-03-12 11:13:56'),
(17, 1, 1, '2025-03-12 11:54:57'),
(18, 1, 1, '2025-03-12 12:20:13'),
(19, NULL, 0, '2025-03-20 02:58:53'),
(20, NULL, 0, '2025-03-20 02:59:07'),
(21, NULL, 0, '2025-03-20 02:59:09'),
(22, 1, 0, '2025-03-20 03:00:54'),
(23, 1, 1, '2025-03-20 03:01:15'),
(24, NULL, 0, '2025-03-20 03:03:26'),
(25, NULL, 0, '2025-03-20 03:03:26'),
(26, NULL, 0, '2025-03-20 03:04:02'),
(27, NULL, 0, '2025-03-20 03:04:42'),
(28, NULL, 0, '2025-03-20 03:04:42'),
(29, 1, 1, '2025-03-20 03:19:37'),
(30, 1, 0, '2025-05-21 12:07:31'),
(31, 1, 0, '2025-06-10 17:13:51'),
(32, 1, 0, '2025-06-10 17:14:03'),
(33, 1, 0, '2025-06-10 17:14:16'),
(34, 1, 0, '2025-06-10 17:14:27'),
(35, 1, 0, '2025-06-10 17:14:37'),
(36, 1, 1, '2025-06-10 17:15:00'),
(37, 1, 0, '2025-06-10 17:19:04'),
(38, 1, 1, '2025-06-10 17:19:22'),
(39, NULL, 0, '2025-06-11 02:46:13'),
(40, 2, 0, '2025-06-11 12:37:07'),
(41, 2, 1, '2025-06-11 12:37:56'),
(42, 2, 1, '2025-06-11 12:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `kandidaat`
--

CREATE TABLE `kandidaat` (
  `kandidaat_id` bigint(20) UNSIGNED NOT NULL,
  `naam` text NOT NULL,
  `partij_id` bigint(20) UNSIGNED NOT NULL,
  `distrikt_id` bigint(20) UNSIGNED NOT NULL,
  `aantal_stemmen` bigint(20) NOT NULL DEFAULT 0,
  `type` bigint(20) NOT NULL,
  `bio` text DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kandidaat`
--

INSERT INTO `kandidaat` (`kandidaat_id`, `naam`, `partij_id`, `distrikt_id`, `aantal_stemmen`, `type`, `bio`, `foto_url`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Dr. Alexander Hendriks', 1, 1, 2, 1, 'Ervaren advocaat en voormalig rechter met een sterke focus op rechtvaardigheid en transparantie in de politiek.', '/assets/photos/hendriks.jpg', '2025-01-25 13:00:00', '2025-06-12 00:42:44'),
(2, 'Isabella Kramer-Vos', 1, 1, 1832, 1, 'Voormalig minister van Onderwijs en advocate met jarenlange ervaring in sociale rechtvaardigheid.', '/assets/photos/kramer_vos.jpg', '2025-01-25 13:15:00', '2025-06-11 19:00:00'),
(3, 'Rafael Boekhoudt', 1, 2, 1, 1, 'Ondernemer en gemeenschapsleider met focus op economische ontwikkeling en innovatie.', '/assets/photos/boekhoudt.jpg', '2025-01-25 13:30:00', '2025-06-12 00:42:44'),
(4, 'Maya Sewdien', 1, 2, 1423, 1, 'Onderwijskundige en voormalig schooldirecteur, gespecialiseerd in onderwijs en jeugdbeleid.', '/assets/photos/sewdien.jpg', '2025-01-25 13:45:00', '2025-06-11 19:00:00'),
(5, 'Victor Bergman', 2, 1, 1, 1, 'Voormalig minister van Buitenlandse Zaken met decennia ervaring in internationale betrekkingen.', '/assets/photos/bergman.jpg', '2025-01-25 14:00:00', '2025-06-12 00:42:44'),
(6, 'Carmen Valdez', 2, 1, 1765, 1, 'Econoom en voormalig minister van Financiën met expertise in economische planning.', '/assets/photos/valdez.jpg', '2025-01-25 14:15:00', '2025-06-11 19:00:00'),
(7, 'Diana Oosterhoff', 2, 3, 1, 1, 'Advocate en politica uit Nickerie, bekend om haar werk in de agrarische sector.', '/assets/photos/oosterhoff.jpg', '2025-01-25 14:30:00', '2025-06-12 00:42:44'),
(8, 'Fernando Delgado', 2, 3, 1289, 1, 'Ingenieur en projectmanager met focus op infrastructuur en regionale ontwikkeling.', '/assets/photos/delgado.jpg', '2025-01-25 14:45:00', '2025-06-11 19:00:00'),
(9, 'Samuel Rodrigues', 3, 4, 987, 1, 'Zakenman en gemeenschapsleider, bekend om zijn werk in lokale ontwikkelingsprojecten.', '/assets/photos/rodrigues.jpg', '2025-01-25 15:00:00', '2025-06-11 19:00:00'),
(10, 'Patricia Mackenzie', 3, 4, 834, 1, 'Advocate en mensenrechtenactivist uit Commewijne met focus op sociale rechtvaardigheid.', '/assets/photos/mackenzie.jpg', '2025-01-25 15:15:00', '2025-06-11 19:00:00'),
(11, 'Roberto Gonzalez', 3, 5, 756, 1, 'Gemeenschapsleider en ondernemer uit Saramacca met focus op duurzame ontwikkeling.', '/assets/photos/gonzalez.jpg', '2025-01-25 15:30:00', '2025-06-11 19:00:00'),
(12, 'Thomas van Leeuwen', 4, 5, 623, 1, 'Voormalig vakbondsleider en ervaren politicus uit Saramacca.', '/assets/photos/vanleeuwen.jpg', '2025-01-25 15:45:00', '2025-06-11 19:00:00'),
(13, 'Natasha Poeran', 4, 6, 543, 1, 'Onderwijzeres en gemeenschapsleider uit Para met focus op sociale voorzieningen.', '/assets/photos/poeran.jpg', '2025-01-25 16:00:00', '2025-06-11 19:00:00'),
(14, 'Miguel Santos', 4, 6, 487, 1, 'Voormalig minister van Sociale Zaken en ervaren beleidsmaker.', '/assets/photos/santos.jpg', '2025-01-25 16:15:00', '2025-06-11 19:00:00'),
(15, 'Charlotte Vermeulen', 5, 7, 412, 1, 'Advocate en politica uit Marowijne met focus op modernisering van het rechtssysteem.', '/assets/photos/vermeulen.jpg', '2025-01-25 16:30:00', '2025-06-11 19:00:00'),
(16, 'Andre Morrison', 5, 7, 365, 1, 'Ondernemer en gemeenschapsleider met expertise in internationale handel.', '/assets/photos/morrison.jpg', '2025-01-25 16:45:00', '2025-06-11 19:00:00'),
(17, 'Elena Vasquez', 5, 8, 298, 1, 'Ingenieur en projectmanager uit Brokopondo met focus op technologische innovatie.', '/assets/photos/vasquez.jpg', '2025-01-25 17:00:00', '2025-06-11 19:00:00'),
(18, 'Gregory Fernandez', 6, 9, 234, 1, 'Vakbondsleider en arbeidsrechten activist uit Coronie.', '/assets/photos/g_fernandez.jpg', '2025-01-25 17:15:00', '2025-06-11 19:00:00'),
(19, 'Indira Ramlal', 6, 10, 187, 1, 'Onderwijzeres en gemeenschapsleider uit Sipaliwini met focus op sociale rechtvaardigheid.', '/assets/photos/ramlal.jpg', '2025-01-25 17:30:00', '2025-06-11 19:00:00'),
(20, 'Marcus Liem', 6, 1, 1654, 1, 'Econoom en beleidsadviseur uit Paramaribo met expertise in arbeidsrecht.', '/assets/photos/liem.jpg', '2025-01-25 17:45:00', '2025-06-11 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `partij`
--

CREATE TABLE `partij` (
  `partij_id` bigint(20) UNSIGNED NOT NULL,
  `naam` text NOT NULL,
  `afkorting` varchar(10) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `beschrijving` text DEFAULT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partij`
--

INSERT INTO `partij` (`partij_id`, `naam`, `afkorting`, `logo_url`, `beschrijving`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Progressieve Volkspartij (PVP)', 'PVP', '/assets/logos/pvp.png', 'Een politieke partij gericht op vooruitgang en sociale rechtvaardigheid voor alle burgers.', '2025-01-20 12:00:00', '2025-06-12 01:25:29'),
(2, 'Nieuwe Democratische Beweging (NDB)', 'NDB', '/assets/logos/ndb.png', 'De Nieuwe Democratische Beweging streeft naar een moderne democratie en economische groei.', '2025-01-20 12:15:00', '2025-06-12 01:25:29'),
(3, 'Eenheidspartij voor Ontwikkeling (EPO)', 'EPO', '/assets/logos/epo.png', 'EPO werkt aan de eenheid en duurzame ontwikkeling van alle gemeenschappen.', '2025-01-20 12:30:00', '2025-06-12 01:25:29'),
(4, 'Sociaal Democratische Unie (SDU)', 'SDU', '/assets/logos/sdu.png', 'SDU bevordert sociale democratie en gelijkheid tussen alle bevolkingsgroepen.', '2025-01-20 12:45:00', '2025-06-12 01:25:29'),
(5, 'Liberale Hervormingspartij (LHP)', 'LHP', '/assets/logos/lhp.png', 'Een liberale partij voor een modern en hervormd politiek systeem.', '2025-01-20 13:00:00', '2025-06-12 01:25:29'),
(6, 'Arbeiderspartij voor Rechtvaardigheid (APR)', 'APR', '/assets/logos/apr.png', 'APR vertegenwoordigt de belangen van werknemers en bevordert sociale rechtvaardigheid.', '2025-01-20 13:15:00', '2025-06-12 01:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `stem`
--

CREATE TABLE `stem` (
  `stem_id` bigint(20) UNSIGNED NOT NULL,
  `gebruiker_id` bigint(20) UNSIGNED NOT NULL,
  `kandidaat_id` bigint(20) UNSIGNED NOT NULL,
  `gestemd_op` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stem`
--

INSERT INTO `stem` (`stem_id`, `gebruiker_id`, `kandidaat_id`, `gestemd_op`) VALUES
(1, 3, 1, '2025-05-15 12:30:00'),
(2, 4, 1, '2025-05-15 13:45:00'),
(3, 6, 5, '2025-05-15 14:20:00'),
(4, 8, 3, '2025-05-15 17:15:00'),
(5, 10, 7, '2025-05-15 18:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admininlogpogingen`
--
ALTER TABLE `admininlogpogingen`
  ADD PRIMARY KEY (`poging_id`),
  ADD KEY `admin_inlogpogingen_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `distrikt`
--
ALTER TABLE `distrikt`
  ADD PRIMARY KEY (`distrikt_id`);

--
-- Indexes for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`gebruiker_id`),
  ADD UNIQUE KEY `id_nummer` (`id_nummer`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_gebruiker_distrikt` (`distrikt_id`);

--
-- Indexes for table `inlogpogingen`
--
ALTER TABLE `inlogpogingen`
  ADD PRIMARY KEY (`poging_id`),
  ADD KEY `inlogpogingen_gebruiker_id_foreign` (`gebruiker_id`);

--
-- Indexes for table `kandidaat`
--
ALTER TABLE `kandidaat`
  ADD PRIMARY KEY (`kandidaat_id`),
  ADD KEY `kandidaat_distrikt_id_foreign` (`distrikt_id`),
  ADD KEY `kandidaat_partij_id_foreign` (`partij_id`);

--
-- Indexes for table `partij`
--
ALTER TABLE `partij`
  ADD PRIMARY KEY (`partij_id`);

--
-- Indexes for table `stem`
--
ALTER TABLE `stem`
  ADD PRIMARY KEY (`stem_id`),
  ADD KEY `stem_kandidaat_id_foreign` (`kandidaat_id`),
  ADD KEY `stem_gebruiker_id_foreign` (`gebruiker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admininlogpogingen`
--
ALTER TABLE `admininlogpogingen`
  MODIFY `poging_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `distrikt`
--
ALTER TABLE `distrikt`
  MODIFY `distrikt_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `gebruiker_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inlogpogingen`
--
ALTER TABLE `inlogpogingen`
  MODIFY `poging_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `kandidaat`
--
ALTER TABLE `kandidaat`
  MODIFY `kandidaat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `partij`
--
ALTER TABLE `partij`
  MODIFY `partij_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stem`
--
ALTER TABLE `stem`
  MODIFY `stem_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admininlogpogingen`
--
ALTER TABLE `admininlogpogingen`
  ADD CONSTRAINT `admin_inlogpogingen_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD CONSTRAINT `fk_gebruiker_distrikt` FOREIGN KEY (`distrikt_id`) REFERENCES `distrikt` (`distrikt_id`);

--
-- Constraints for table `inlogpogingen`
--
ALTER TABLE `inlogpogingen`
  ADD CONSTRAINT `inlogpogingen_gebruiker_id_foreign` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`gebruiker_id`);

--
-- Constraints for table `kandidaat`
--
ALTER TABLE `kandidaat`
  ADD CONSTRAINT `kandidaat_distrikt_id_foreign` FOREIGN KEY (`distrikt_id`) REFERENCES `distrikt` (`distrikt_id`),
  ADD CONSTRAINT `kandidaat_partij_id_foreign` FOREIGN KEY (`partij_id`) REFERENCES `partij` (`partij_id`);

--
-- Constraints for table `stem`
--
ALTER TABLE `stem`
  ADD CONSTRAINT `stem_gebruiker_id_foreign` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`gebruiker_id`),
  ADD CONSTRAINT `stem_kandidaat_id_foreign` FOREIGN KEY (`kandidaat_id`) REFERENCES `kandidaat` (`kandidaat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
