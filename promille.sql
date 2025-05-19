-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 19 maj 2025 kl 13:15
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
(47, 15, 'Cider', 5, 330, '2025-05-19 10:50:26'),
(48, 15, 'Öl', 5.4, 330, '2025-05-19 10:51:57'),
(49, 16, 'Shot', 40, 60, '2025-05-19 10:55:00'),
(50, 16, 'Shot', 35, 60, '2025-05-19 10:55:45'),
(51, 16, 'Cider', 1, 100, '2025-05-19 10:58:28');

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
(15, 0.423584, '2025-05-19 13:15:15'),
(16, 0.651658, '2025-05-19 13:15:15');

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
  `userlevel` tinyint(11) NOT NULL DEFAULT 10,
  `team` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `tbluser`
--

INSERT INTO `tbluser` (`id`, `namn`, `password`, `weight`, `height`, `alkoholvolym`, `userlevel`, `team`) VALUES
(15, 'Elton Tagner', '$2y$10$1zU3AknuMyfhNq4VT5beDO4LJIbAlSioO8mXU9bgyNjTtQJyn3bFS', 82, 183, 0, 10, 'Magaluf'),
(16, 'Linus Åkesson', '$2y$10$oz3QEZSKcXw/z3S3xoR5OOoceK8FT8HfwI5ZQovAWMpqhOHlJfYba', 76, 178, 0, 10, 'Aiya Napa');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `tbldrinklog`
--
ALTER TABLE `tbldrinklog`
  ADD PRIMARY KEY (`drinkid`);

--
-- Index för tabell `tblpromille`
--
ALTER TABLE `tblpromille`
  ADD UNIQUE KEY `userid` (`userid`);

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
  MODIFY `drinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT för tabell `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
