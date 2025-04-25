-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 24 apr 2025 kl 13:09
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `promille`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `tbldrinklog`
--

CREATE TABLE `tbldrinklog` (
  `drinkid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `drinktype` varchar(50) NOT NULL,
  `alcoholpercent` float NOT NULL,
  `volume_ml` float NOT NULL,
  `drinktimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbldrinklog`
--

INSERT INTO `tbldrinklog` (`drinkid`, `userid`, `drinktype`, `alcoholpercent`, `volume_ml`, `drinktimestamp`) VALUES
(1, 1, 'Öl', 10.5, 500, '2025-04-24 08:47:08'),
(2, 1, 'Öl', 55, 200, '2025-04-24 08:56:05'),
(3, 1, 'Öl', 22, 222, '2025-04-24 08:59:17'),
(4, 1, 'Öl', 50, 2000, '2025-04-24 09:09:44'),
(5, 1, 'Öl', 0.9, 1, '2025-04-24 10:49:46'),
(6, 2, 'Jäger', 35, 120, '2025-04-24 11:01:16');

-- --------------------------------------------------------

--
-- Tabellstruktur `tblpromille`
--

CREATE TABLE `tblpromille` (
  `userid` int(11) NOT NULL,
  `promille` float NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tblpromille`
--

INSERT INTO `tblpromille` (`userid`, `promille`, `updated_at`) VALUES
(1, 16.8339, '2025-04-24 12:49:46'),
(2, 0.641215, '2025-04-24 13:01:16');

-- --------------------------------------------------------

--
-- Tabellstruktur `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `namn` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `alkoholvolym` float NOT NULL,
  `userlevel` tinyint(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbluser`
--

INSERT INTO `tbluser` (`id`, `namn`, `password`, `weight`, `height`, `alkoholvolym`, `userlevel`) VALUES
(1, 'Elton Tagner', '$2y$10$3e6SNwG4WVfYswIdr.gV/uWKVBEkdbHQVxphXVu3y5vp.jAAhSI/O', 82, 182, 0, 10),
(2, 'Linus Åkesson', '$2y$10$CbAs4MlyX/urL3NtT4IO/u6BYOjhvqDgc2qciz2JlyfhDiWLvqwUG', 76, 177, 0, 10);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `tbldrinklog`
--
ALTER TABLE `tbldrinklog`
  ADD PRIMARY KEY (`drinkid`);

--
-- Index för tabell `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `tbldrinklog`
--
ALTER TABLE `tbldrinklog`
  MODIFY `drinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
