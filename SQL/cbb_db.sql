-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 02:57 AM
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
-- Database: `cbb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cbb_burger`
--

CREATE TABLE `cbb_burger` (
  `burger_id` bigint(20) UNSIGNED NOT NULL,
  `id_nummer` varchar(255) NOT NULL COMMENT 'Nationale ID/BSN',
  `voornaam` text NOT NULL,
  `achternaam` text NOT NULL,
  `geboorte_datum` date NOT NULL,
  `adres` text NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `woonplaats` text NOT NULL,
  `nationaliteit` varchar(100) NOT NULL DEFAULT 'Surinaams',
  `status` enum('ACTIEF','OVERLEDEN','GEËMIGREERD','GESCHORST') NOT NULL DEFAULT 'ACTIEF',
  `laatste_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cbb_burger`
--

INSERT INTO `cbb_burger` (`burger_id`, `id_nummer`, `voornaam`, `achternaam`, `geboorte_datum`, `adres`, `postcode`, `woonplaats`, `nationaliteit`, `status`, `laatste_update`) VALUES
(1, '8XGH78ZA3', 'Tushar', 'Gena', '2006-02-16', 'Bistrolaan no33', '0000', 'Lelydorp', 'Surinaams', 'ACTIEF', '2025-03-11 23:58:06'),
(2, '12345678', 'Johan', 'Lammers', '1980-05-15', 'Kernkampweg 10', '12345', 'Paramaribo', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(3, '23456789', 'Maria', 'Pinas', '1975-08-23', 'Tourtonnelaan 45', '23456', 'Paramaribo', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(4, '34567890', 'Ricardo', 'Brokmeier', '1990-11-07', 'Jaggernath Lachmonstraat 20', '34567', 'Wanica', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(5, '45678901', 'Fatima', 'Abaas', '1988-02-12', 'Kwattaweg 120', '45678', 'Paramaribo', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(6, '56789012', 'David', 'Leter', '1965-04-30', 'Indira Gandhiweg 200', '56789', 'Wanica', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(7, '67890123', 'Sophie', 'Narain', '1972-09-18', 'Leysweg 35', '67890', 'Paramaribo', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(8, '78901234', 'Michael', 'Blokland', '1983-12-05', 'Gompertstraat 12', '78901', 'Paramaribo', 'Surinaams', 'OVERLEDEN', '2025-03-12 00:51:39'),
(9, '89012345', 'Jennifer', 'Madretsma', '1995-07-22', 'Frederik Derbystraat 8', '89012', 'Paramaribo', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39'),
(10, '90123456', 'Carlos', 'Amoida', '1968-03-14', 'Mahonylaan 67', '90123', 'Nickerie', 'Surinaams', 'GEËMIGREERD', '2025-03-12 00:51:39'),
(11, '01234567', 'Anita', 'Soekhai', '1992-10-26', 'Anton Dragtenweg 103', '01234', 'Commewijne', 'Surinaams', 'ACTIEF', '2025-03-12 00:51:39');

-- --------------------------------------------------------

--
-- Table structure for table `cbb_stemrecht`
--

CREATE TABLE `cbb_stemrecht` (
  `stemrecht_id` bigint(20) UNSIGNED NOT NULL,
  `burger_id` bigint(20) UNSIGNED NOT NULL,
  `heeft_stemrecht` tinyint(1) NOT NULL DEFAULT 1,
  `reden_geen_stemrecht` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cbb_stemrecht`
--

INSERT INTO `cbb_stemrecht` (`stemrecht_id`, `burger_id`, `heeft_stemrecht`, `reden_geen_stemrecht`) VALUES
(1, 1, 1, NULL),
(2, 2, 1, NULL),
(3, 3, 0, NULL),
(4, 4, 1, NULL),
(5, 5, 1, NULL),
(6, 6, 0, NULL),
(7, 7, 1, NULL),
(8, 8, 1, NULL),
(9, 9, 0, NULL),
(10, 10, 1, NULL),
(11, 11, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cbb_burger`
--
ALTER TABLE `cbb_burger`
  ADD PRIMARY KEY (`burger_id`),
  ADD UNIQUE KEY `id_nummer` (`id_nummer`),
  ADD KEY `idx_id_nummer` (`id_nummer`);

--
-- Indexes for table `cbb_stemrecht`
--
ALTER TABLE `cbb_stemrecht`
  ADD PRIMARY KEY (`stemrecht_id`),
  ADD KEY `idx_burger_stemrecht` (`burger_id`,`heeft_stemrecht`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cbb_burger`
--
ALTER TABLE `cbb_burger`
  MODIFY `burger_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cbb_stemrecht`
--
ALTER TABLE `cbb_stemrecht`
  MODIFY `stemrecht_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cbb_stemrecht`
--
ALTER TABLE `cbb_stemrecht`
  ADD CONSTRAINT `cbb_stemrecht_burger_id_foreign` FOREIGN KEY (`burger_id`) REFERENCES `cbb_burger` (`burger_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
