-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 15 maj 2025 kl 10:24
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
(6, 2, 'Jäger', 35, 120, '2025-04-24 11:01:16'),
(7, 1, '1', 1, 1, '2025-04-25 10:53:17'),
(8, 1, 'Öl', 10.5, 500, '2025-04-25 10:56:51'),
(9, 1, 'Öl', 40, 100, '2025-04-25 10:59:42'),
(10, 1, 'Öl', 11, 4000, '2025-04-25 11:02:38'),
(11, 2, 'Öl', 19.9, 200, '2025-04-25 11:07:35'),
(12, 2, 'Öl', 22, 100, '2025-04-25 11:08:31'),
(13, 2, 'Öl', 10, 400, '2025-04-25 11:09:32'),
(14, 2, 'Öl', 10, 1, '2025-04-25 11:13:02'),
(15, 2, '1', 1, 1, '2025-04-25 11:13:33'),
(16, 2, 'Öl', 70, 5000, '2025-04-25 11:15:14'),
(17, 3, 'Öl', 11, 10000, '2025-04-25 11:25:16'),
(18, 1, 'Öl', 33, 100, '2025-04-28 11:59:04'),
(19, 1, '100', 100, 100, '2025-04-28 12:01:17'),
(20, 4, 'ölööl', 50, 1000, '2025-04-28 12:05:10'),
(21, 5, 'Öl', 100, 1000, '2025-04-28 12:06:05'),
(22, 5, 'Öl', 1, 1000, '2025-04-28 12:07:37'),
(23, 4, 'Öl', 20, 200, '2025-04-28 12:38:35'),
(24, 4, 'Öl', 100, 1000, '2025-04-28 12:38:58'),
(25, 4, 'Öl', 10, 700, '2025-05-08 07:25:09'),
(26, 6, 'Cider (Smirnoff ice)', 4.5, 330, '2025-05-08 07:26:46'),
(27, 6, 'Ren Alkohol', 100, 900, '2025-05-08 07:32:28'),
(28, 4, 'Öl', 10, 1000, '2025-05-08 08:56:44'),
(29, 4, 'Ren Alkohol', 100, 1000, '2025-05-09 07:52:43'),
(30, 4, 'Annat', 10, 10000, '2025-05-09 08:01:34'),
(31, 7, 'Cider', 10, 200, '2025-05-09 08:56:34'),
(32, 7, 'Cider', 5.3, 500, '2025-05-09 10:23:13'),
(33, 7, 'Cider', 5.2, 100, '2025-05-09 10:23:23'),
(34, 11, 'Shot', 40, 60, '2025-05-09 10:40:09'),
(35, 12, 'Shot', 40, 60, '2025-05-09 11:05:02'),
(36, 12, 'Annat', 100, 100000, '2025-05-09 11:05:25'),
(37, 4, 'Cider', 5.4, 330, '2025-05-12 08:42:50'),
(38, 4, 'Cider', 5.4, 330, '2025-05-12 08:44:17'),
(39, 11, 'Cider', 5.5, 330, '2025-05-12 08:50:24'),
(40, 11, 'Cider', 5.5, 330, '2025-05-12 08:50:34'),
(41, 11, 'Cider', 5.5, 330, '2025-05-12 08:50:56');

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
(4, 0.29672, '2025-05-12 12:05:52'),
(5, 0, '2025-05-12 12:05:52'),
(6, 0, '2025-05-12 12:05:52'),
(7, 0, '2025-05-12 12:05:52'),
(8, 0, '2025-05-12 12:05:52'),
(9, 0, '2025-05-12 12:05:52'),
(10, 0, '2025-05-12 12:05:52'),
(11, 15.6058, '2025-05-12 12:05:52'),
(12, 0, '2025-05-12 12:05:52'),
(13, 0, '2025-05-12 12:05:52');

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
(4, 'Elton Tagner', '$2y$10$7FqQdGB5Boesydf8/hhWXOVh/3zk6f1Ca4zJPumoPoW3LL4jYA1OG', 82, 182, 0, 10, ''),
(5, 'Melker Knickedik', '$2y$10$tz5AazbTq/0Ggp6qa4yaGu2B79I5WhGKDOYtexs555jUcFHctNkvy', 37, 191, 0, 10, ''),
(6, 'Vendel Seiver', '$2y$10$eGEQjze78ftASJi1ZKi.peiD7KKHbaHB/RNm/KDxdmKBESszVMT7u', 75, 180, 0, 10, ''),
(7, 'Mio Gullybrand', '$2y$10$y29M1TPcwpTdnj3sKMu9me3TjX1P6XuBk5QykJxO2v/0MHtEctYES', 98, 185, 0, 10, ''),
(8, 'Melwin', '$2y$10$QnFNRu3BqTK4Yxc8SGgB1u/yDzbxg0YYBNaYnLf/p/uFtwp1AwMc2', 70, 210, 0, 10, ''),
(9, 'Melwin Ataturk', '$2y$10$4308mrWYkrhht4wFuntPNuXpm8CtD88/OKexyRuthFha5xuizKnjC', 120, 240, 0, 10, ''),
(10, 'Melwin Özdemir Aydin Yilmaz Ataturk', '$2y$10$8NH3/g.Q7/34Ld7m5oEDvugfBpOdMGiKsabryFe4pyZO3UMZq1PtC', 320, 240, 0, 10, 'magaluf'),
(11, 'Hubert Yilmaz', '$2y$10$bu14c0ZsMc3kPK8DNJX8.uo.41hL9CbZPT7n1xN6vlfa/NlRQ4Uxi', 4, 30, 0, 10, 'Aiya Napa'),
(12, 'Gigantimus', '$2y$10$.bEkKtDwqsw6gfKFnJjcgOX6qVpmKaIjWn7KvYKQpgsCPCoflVTv6', 9000, 2400, 0, 10, 'Magaluf'),
(13, 'Gigantimus', '$2y$10$A57v84ogiZwxMfJi4W7qxeU4mH5JwqRt.dszYWH92Likw2VDYwo8K', 9000, 2400, 0, 10, 'Magaluf');

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
  MODIFY `drinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT för tabell `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
