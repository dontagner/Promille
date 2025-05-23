-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Värd: ck1ffa1s8.mysql.service.one.com:3306
-- Tid vid skapande: 23 maj 2025 kl 11:14
-- Serverversion: 10.6.20-MariaDB-ubu2204
-- PHP-version: 8.1.2-1ubuntu2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `ck1ffa1s8_promille`
--
CREATE DATABASE IF NOT EXISTS `ck1ffa1s8_promille` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ck1ffa1s8_promille`;

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
(99, 21, 'Drink', 60, 100, '2025-05-22 08:14:49'),
(101, 15, 'Öl', 5.4, 330, '2025-05-22 08:24:54'),
(104, 28, 'Öl', 10, 500, '2025-05-23 07:48:55'),
(106, 21, 'Shot', 45, 100, '2025-05-23 08:23:26');

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
(15, 0, '2025-05-23 11:13:06'),
(16, 0, '2025-05-23 11:13:06'),
(17, 0.869846, '2025-05-21 15:15:54'),
(18, 0, '2025-05-23 11:13:06'),
(19, 0, '2025-05-23 11:13:06'),
(20, 0, '2025-05-23 11:13:06'),
(21, 0.291083, '2025-05-23 11:13:06'),
(22, 0, '2025-05-23 11:13:06'),
(23, 0, '2025-05-23 11:13:06'),
(24, 0, '2025-05-23 11:13:06'),
(25, 0, '2025-05-23 11:13:06'),
(26, 0, '2025-05-23 11:13:06'),
(27, 0, '2025-05-23 11:13:06'),
(28, 0.100223, '2025-05-23 11:13:06'),
(29, 0, '2025-05-23 11:13:06'),
(30, 0, '2025-05-23 11:13:06');

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
(16, 'Linus Åkesson', '$2y$10$oz3QEZSKcXw/z3S3xoR5OOoceK8FT8HfwI5ZQovAWMpqhOHlJfYba', 76, 178, 0, 10, 'Ayia Napa'),
(18, 'Mio Gullbrand', '$2y$10$2/i0omGBz2rbKxZfOWurg.s.f62EBe36sHK4tV2JYkJWqNITlj1/q', 98, 185, 0, 10, 'Ayia Napa'),
(19, 'Emil Svedberg', '$2y$10$9afNI6jcs4tWH2ihsPSUru36pXt/PpGFkztVWu8F1OnUwivny9uau', 82, 184, 0, 10, 'Magaluf'),
(20, 'Maximus Duljaj', '$2y$10$K7gZSb4NWort5HiY6kBnL.icHwmkVssKV3MIDSOFVXrlWKGyaMZMu', 98, 190, 0, 10, 'Magaluf'),
(21, 'Oskar Fagerström', '$2y$10$MV6xgAaHkMDVEmb1J7IInuC3Va3.OTWtqLjLJAz2TY60Q7QISHC6.', 73, 180, 0, 10, 'Magaluf'),
(22, 'Carl Stolphage', '$2y$10$WbuDOvRUpE4A95Y5ZtpZ1.XrSwJ2hY83ni29OAqdLBNeJt3sEccYy', 60, 180, 0, 10, 'Ayia Napa'),
(23, 'August Ranås', '$2y$10$6o/E093YJa9yig.5q.bfE.t2yagvJ000jOL24dx4FywY5oel6oRv2', 57, 172, 0, 10, 'Ayia Napa'),
(24, 'Alexander Nord', '$2y$10$ZtEehqH.BvGep9P2.80QGOCZerpK9X3Rtr2s6vyIEW2bYNQUCXnve', 80, 176, 0, 10, 'Magaluf'),
(25, 'Martin Tran', '$2y$10$C1eiEfVaXjXQDWzaYsxPNOszpq487zijJl6Dblf6P6iDtkK3wUHZW', 52.5, 162, 0, 10, 'Ayia Napa'),
(26, 'Kevin Carlstedt', '$2y$10$gzH.ZjDhzUzqcL4fYk71BuoyTXKuCfTzr0rlYCocH/dZj7VUu4bqq', 90, 175, 0, 10, 'Ayia Napa'),
(27, 'Vendel Seiver', '$2y$10$I4br5ovnElr4CwV92bjvpuj7bcsnhPsinONVWdnkv/V4kFqYpfCM6', 75, 180, 0, 10, 'Ayia Napa'),
(28, 'Nico Ek', '$2y$10$PmRYQ6GaGjiiE/L8kCj7.uC82p//7XjZCzTKob7Rj23tyGrGv5XKy', 95, 178, 0, 10, 'Magaluf'),
(29, 'Samuel Lundberg', '$2y$10$/5Ku4IZS8RZdwidaKYdouOyiRxwWwcD.jBqPNlwDW9tUOsXiMb88a', 62, 194, 0, 10, 'Ayia Napa'),
(30, 'Johan Chienh', '$2y$10$KpWNOo5oVmikwYDviqKaCendGFGMssxOrt5HY/rXyRzSV0.keWvbm', 69, 171, 0, 10, 'Magaluf');

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
  MODIFY `drinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT för tabell `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
