-- phpMyAdmin SQL Dump
-- version 4.6.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mar 20, 2017 alle 17:12
-- Versione del server: 5.5.53-MariaDB
-- Versione PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appuntamento`
--
CREATE DATABASE IF NOT EXISTS `appuntamento` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `appuntamento`;

-- --------------------------------------------------------

--
-- Struttura della tabella `app`
--

CREATE TABLE `app` (
  `idapp` int(11) NOT NULL,
  `data` date NOT NULL,
  `fkorario` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `app`
--

INSERT INTO `app` (`idapp`, `data`, `fkorario`, `nome`, `note`) VALUES
(2, '2017-03-15', 103, 'Pippo', ''),
(3, '2017-03-15', 105, 'Pluto', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `compiti`
--

CREATE TABLE `compiti` (
  `idcompito` int(11) NOT NULL,
  `data` date NOT NULL,
  `compito` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `compiti`
--

INSERT INTO `compiti` (`idcompito`, `data`, `compito`) VALUES
(5, '2017-03-20', 'Ricetta Jack'),
(6, '2017-03-20', 'Dire a pluto di pippo');

-- --------------------------------------------------------

--
-- Struttura della tabella `orario`
--

CREATE TABLE `orario` (
  `idorario` int(11) NOT NULL,
  `giornosettimana` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ora` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `attivo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `orario`
--

INSERT INTO `orario` (`idorario`, `giornosettimana`, `ora`, `attivo`) VALUES
(1, 'lun', '8:00 - 8:15', 0),
(2, 'lun', '8:15 - 8:30', 0),
(3, 'lun', '8:30 - 8:45', 0),
(4, 'lun', '8:45 - 9:00', 0),
(5, 'lun', '9:00 - 9:15', 0),
(6, 'lun', '9:15 - 9:30', 0),
(7, 'lun', '9:30 - 9:45', 0),
(8, 'lun', '9:45 - 10:00', 0),
(9, 'lun', '10:00 - 10:15', 0),
(10, 'lun', '10:15 - 10:30', 0),
(11, 'lun', '10:30 - 10:45', 0),
(12, 'lun', '10:45 - 11:00', 0),
(13, 'lun', '11:00 - 11:15', 0),
(14, 'lun', '11:15 - 11:30', 0),
(15, 'lun', '11:30 - 11:45', 0),
(16, 'lun', '11:45 - 12:00', 0),
(17, 'lun', '12:00 - 12:15', 0),
(18, 'lun', '12:15 - 12:30', 0),
(19, 'lun', '12:30 - 12:45', 0),
(20, 'lun', '12:45 - 13:00', 0),
(21, 'lun', '13:00 - 13:15', 0),
(22, 'lun', '13:15 - 13:30', 0),
(23, 'lun', '13:30 - 13:45', 0),
(24, 'lun', '13:45 - 14:00', 0),
(25, 'lun', '14:00 - 14:15', 1),
(26, 'lun', '14:15 - 14:30', 1),
(27, 'lun', '14:30 - 14:45', 1),
(28, 'lun', '14:45 - 15:00', 1),
(29, 'lun', '15:00 - 15:15', 1),
(30, 'lun', '15:15 - 15:30', 1),
(31, 'lun', '15:30 - 15:45', 1),
(32, 'lun', '15:45 - 16:00', 1),
(33, 'lun', '16:00 - 16:15', 0),
(34, 'lun', '16:15 - 16:30', 0),
(35, 'lun', '16:30 - 16:45', 0),
(36, 'lun', '16:45 - 17:00', 0),
(37, 'lun', '17:00 - 17:15', 0),
(38, 'lun', '17:15 - 17:30', 0),
(39, 'lun', '17:30 - 17:45', 0),
(40, 'lun', '17:45 - 18:00', 0),
(41, 'lun', '18:00 - 18:15', 0),
(42, 'lun', '18:15 - 18:30', 0),
(43, 'lun', '18:30 - 18:45', 0),
(44, 'lun', '18:45 - 19:00', 0),
(45, 'lun', '20:00 - 20:15', 0),
(46, 'lun', '20:15 - 20:30', 0),
(47, 'lun', '20:30 - 20:45', 0),
(48, 'lun', '20:45 - 21:00', 0),
(49, 'mar', '8:00 - 8:15', 0),
(50, 'mar', '8:15 - 8:30', 0),
(51, 'mar', '8:30 - 8:45', 1),
(52, 'mar', '8:45 - 9:00', 1),
(53, 'mar', '9:00 - 9:15', 1),
(54, 'mar', '9:15 - 9:30', 1),
(55, 'mar', '9:30 - 9:45', 1),
(56, 'mar', '9:45 - 10:00', 1),
(57, 'mar', '10:00 - 10:15', 1),
(58, 'mar', '10:15 - 10:30', 1),
(59, 'mar', '10:30 - 10:45', 1),
(60, 'mar', '10:45 - 11:00', 1),
(61, 'mar', '11:00 - 11:15', 1),
(62, 'mar', '11:15 - 11:30', 1),
(63, 'mar', '11:30 - 11:45', 0),
(64, 'mar', '11:45 - 12:00', 0),
(65, 'mar', '12:00 - 12:15', 0),
(66, 'mar', '12:15 - 12:30', 0),
(67, 'mar', '12:30 - 12:45', 0),
(68, 'mar', '12:45 - 13:00', 0),
(69, 'mar', '13:00 - 13:15', 0),
(70, 'mar', '13:15 - 13:30', 0),
(71, 'mar', '13:30 - 13:45', 0),
(72, 'mar', '13:45 - 14:00', 0),
(73, 'mar', '14:00 - 14:15', 0),
(74, 'mar', '14:15 - 14:30', 0),
(75, 'mar', '14:30 - 14:45', 0),
(76, 'mar', '14:45 - 15:00', 0),
(77, 'mar', '15:00 - 15:15', 0),
(78, 'mar', '15:15 - 15:30', 0),
(79, 'mar', '15:30 - 15:45', 0),
(80, 'mar', '15:45 - 16:00', 0),
(81, 'mar', '16:00 - 16:15', 0),
(82, 'mar', '16:15 - 16:30', 0),
(83, 'mar', '16:30 - 16:45', 0),
(84, 'mar', '16:45 - 17:00', 0),
(85, 'mar', '17:00 - 17:15', 0),
(86, 'mar', '17:15 - 17:30', 0),
(87, 'mar', '17:30 - 17:45', 0),
(88, 'mar', '17:45 - 18:00', 0),
(89, 'mar', '18:00 - 18:15', 0),
(90, 'mar', '18:15 - 18:30', 0),
(91, 'mar', '18:30 - 18:45', 0),
(92, 'mar', '18:45 - 19:00', 0),
(93, 'mar', '20:00 - 20:15', 0),
(94, 'mar', '20:15 - 20:30', 0),
(95, 'mar', '20:30 - 20:45', 0),
(96, 'mar', '20:45 - 21:00', 0),
(97, 'mer', '8:00 - 8:15', 0),
(98, 'mer', '8:15 - 8:30', 0),
(99, 'mer', '8:30 - 8:45', 1),
(100, 'mer', '8:45 - 9:00', 1),
(101, 'mer', '9:00 - 9:15', 1),
(102, 'mer', '9:15 - 9:30', 1),
(103, 'mer', '9:30 - 9:45', 1),
(104, 'mer', '9:45 - 10:00', 1),
(105, 'mer', '10:00 - 10:15', 1),
(106, 'mer', '10:15 - 10:30', 1),
(107, 'mer', '10:30 - 10:45', 1),
(108, 'mer', '10:45 - 11:00', 1),
(109, 'mer', '11:00 - 11:15', 1),
(110, 'mer', '11:15 - 11:30', 1),
(111, 'mer', '11:30 - 11:45', 1),
(112, 'mer', '11:45 - 12:00', 1),
(113, 'mer', '12:00 - 12:15', 0),
(114, 'mer', '12:15 - 12:30', 0),
(115, 'mer', '12:30 - 12:45', 0),
(116, 'mer', '12:45 - 13:00', 0),
(117, 'mer', '13:00 - 13:15', 0),
(118, 'mer', '13:15 - 13:30', 0),
(119, 'mer', '13:30 - 13:45', 0),
(120, 'mer', '13:45 - 14:00', 0),
(121, 'mer', '14:00 - 14:15', 0),
(122, 'mer', '14:15 - 14:30', 0),
(123, 'mer', '14:30 - 14:45', 0),
(124, 'mer', '14:45 - 15:00', 0),
(125, 'mer', '15:00 - 15:15', 0),
(126, 'mer', '15:15 - 15:30', 0),
(127, 'mer', '15:30 - 15:45', 0),
(128, 'mer', '15:45 - 16:00', 0),
(129, 'mer', '16:00 - 16:15', 0),
(130, 'mer', '16:15 - 16:30', 0),
(131, 'mer', '16:30 - 16:45', 0),
(132, 'mer', '16:45 - 17:00', 0),
(133, 'mer', '17:00 - 17:15', 0),
(134, 'mer', '17:15 - 17:30', 0),
(135, 'mer', '17:30 - 17:45', 0),
(136, 'mer', '17:45 - 18:00', 0),
(137, 'mer', '18:00 - 18:15', 0),
(138, 'mer', '18:15 - 18:30', 0),
(139, 'mer', '18:30 - 18:45', 0),
(140, 'mer', '18:45 - 19:00', 0),
(141, 'mer', '20:00 - 20:15', 0),
(142, 'mer', '20:15 - 20:30', 0),
(143, 'mer', '20:30 - 20:45', 0),
(144, 'mer', '20:45 - 21:00', 0),
(145, 'gio', '8:00 - 8:15', 0),
(146, 'gio', '8:15 - 8:30', 0),
(147, 'gio', '8:30 - 8:45', 1),
(148, 'gio', '8:45 - 9:00', 1),
(149, 'gio', '9:00 - 9:15', 1),
(150, 'gio', '9:15 - 9:30', 1),
(151, 'gio', '9:30 - 9:45', 1),
(152, 'gio', '9:45 - 10:00', 1),
(153, 'gio', '10:00 - 10:15', 1),
(154, 'gio', '10:15 - 10:30', 1),
(155, 'gio', '10:30 - 10:45', 1),
(156, 'gio', '10:45 - 11:00', 1),
(157, 'gio', '11:00 - 11:15', 1),
(158, 'gio', '11:15 - 11:30', 1),
(159, 'gio', '11:30 - 11:45', 1),
(160, 'gio', '11:45 - 12:00', 1),
(161, 'gio', '12:00 - 12:15', 1),
(162, 'gio', '12:15 - 12:30', 1),
(163, 'gio', '12:30 - 12:45', 1),
(164, 'gio', '12:45 - 13:00', 1),
(165, 'gio', '13:00 - 13:15', 0),
(166, 'gio', '13:15 - 13:30', 0),
(167, 'gio', '13:30 - 13:45', 0),
(168, 'gio', '13:45 - 14:00', 0),
(169, 'gio', '14:00 - 14:15', 0),
(170, 'gio', '14:15 - 14:30', 0),
(171, 'gio', '14:30 - 14:45', 0),
(172, 'gio', '14:45 - 15:00', 0),
(173, 'gio', '15:00 - 15:15', 0),
(174, 'gio', '15:15 - 15:30', 0),
(175, 'gio', '15:30 - 15:45', 0),
(176, 'gio', '15:45 - 16:00', 0),
(177, 'gio', '16:00 - 16:15', 0),
(178, 'gio', '16:15 - 16:30', 0),
(179, 'gio', '16:30 - 16:45', 0),
(180, 'gio', '16:45 - 17:00', 0),
(181, 'gio', '17:00 - 17:15', 0),
(182, 'gio', '17:15 - 17:30', 0),
(183, 'gio', '17:30 - 17:45', 0),
(184, 'gio', '17:45 - 18:00', 0),
(185, 'gio', '18:00 - 18:15', 0),
(186, 'gio', '18:15 - 18:30', 0),
(187, 'gio', '18:30 - 18:45', 0),
(188, 'gio', '18:45 - 19:00', 0),
(189, 'gio', '20:00 - 20:15', 0),
(190, 'gio', '20:15 - 20:30', 0),
(191, 'gio', '20:30 - 20:45', 0),
(192, 'gio', '20:45 - 21:00', 0),
(193, 'ven', '8:00 - 8:15', 0),
(194, 'ven', '8:15 - 8:30', 0),
(195, 'ven', '8:30 - 8:45', 0),
(196, 'ven', '8:45 - 9:00', 0),
(197, 'ven', '9:00 - 9:15', 0),
(198, 'ven', '9:15 - 9:30', 0),
(199, 'ven', '9:30 - 9:45', 0),
(200, 'ven', '9:45 - 10:00', 0),
(201, 'ven', '10:00 - 10:15', 0),
(202, 'ven', '10:15 - 10:30', 0),
(203, 'ven', '10:30 - 10:45', 0),
(204, 'ven', '10:45 - 11:00', 0),
(205, 'ven', '11:00 - 11:15', 0),
(206, 'ven', '11:15 - 11:30', 0),
(207, 'ven', '11:30 - 11:45', 0),
(208, 'ven', '11:45 - 12:00', 0),
(209, 'ven', '12:00 - 12:15', 0),
(210, 'ven', '12:15 - 12:30', 0),
(211, 'ven', '12:30 - 12:45', 0),
(212, 'ven', '12:45 - 13:00', 0),
(213, 'ven', '13:00 - 13:15', 0),
(214, 'ven', '13:15 - 13:30', 0),
(215, 'ven', '13:30 - 13:45', 0),
(216, 'ven', '13:45 - 14:00', 0),
(217, 'ven', '14:00 - 14:15', 1),
(218, 'ven', '14:15 - 14:30', 1),
(219, 'ven', '14:30 - 14:45', 1),
(220, 'ven', '14:45 - 15:00', 1),
(221, 'ven', '15:00 - 15:15', 1),
(222, 'ven', '15:15 - 15:30', 1),
(223, 'ven', '15:30 - 15:45', 1),
(224, 'ven', '15:45 - 16:00', 1),
(225, 'ven', '16:00 - 16:15', 0),
(226, 'ven', '16:15 - 16:30', 0),
(227, 'ven', '16:30 - 16:45', 0),
(228, 'ven', '16:45 - 17:00', 0),
(229, 'ven', '17:00 - 17:15', 0),
(230, 'ven', '17:15 - 17:30', 0),
(231, 'ven', '17:30 - 17:45', 0),
(232, 'ven', '17:45 - 18:00', 0),
(233, 'ven', '18:00 - 18:15', 0),
(234, 'ven', '18:15 - 18:30', 0),
(235, 'ven', '18:30 - 18:45', 0),
(236, 'ven', '18:45 - 19:00', 0),
(237, 'ven', '20:00 - 20:15', 0),
(238, 'ven', '20:15 - 20:30', 0),
(239, 'ven', '20:30 - 20:45', 0),
(240, 'ven', '20:45 - 21:00', 0),
(241, 'sab', '8:00 - 8:15', 0),
(242, 'sab', '8:15 - 8:30', 0),
(243, 'sab', '8:30 - 8:45', 0),
(244, 'sab', '8:45 - 9:00', 0),
(245, 'sab', '9:00 - 9:15', 0),
(246, 'sab', '9:15 - 9:30', 0),
(247, 'sab', '9:30 - 9:45', 0),
(248, 'sab', '9:45 - 10:00', 0),
(249, 'sab', '10:00 - 10:15', 0),
(250, 'sab', '10:15 - 10:30', 0),
(251, 'sab', '10:30 - 10:45', 0),
(252, 'sab', '10:45 - 11:00', 0),
(253, 'sab', '11:00 - 11:15', 0),
(254, 'sab', '11:15 - 11:30', 0),
(255, 'sab', '11:30 - 11:45', 0),
(256, 'sab', '11:45 - 12:00', 0),
(257, 'sab', '12:00 - 12:15', 0),
(258, 'sab', '12:15 - 12:30', 0),
(259, 'sab', '12:30 - 12:45', 0),
(260, 'sab', '12:45 - 13:00', 0),
(261, 'sab', '13:00 - 13:15', 0),
(262, 'sab', '13:15 - 13:30', 0),
(263, 'sab', '13:30 - 13:45', 0),
(264, 'sab', '13:45 - 14:00', 0),
(265, 'sab', '14:00 - 14:15', 0),
(266, 'sab', '14:15 - 14:30', 0),
(267, 'sab', '14:30 - 14:45', 0),
(268, 'sab', '14:45 - 15:00', 0),
(269, 'sab', '15:00 - 15:15', 0),
(270, 'sab', '15:15 - 15:30', 0),
(271, 'sab', '15:30 - 15:45', 0),
(272, 'sab', '15:45 - 16:00', 0),
(273, 'sab', '16:00 - 16:15', 0),
(274, 'sab', '16:15 - 16:30', 0),
(275, 'sab', '16:30 - 16:45', 0),
(276, 'sab', '16:45 - 17:00', 0),
(277, 'sab', '17:00 - 17:15', 0),
(278, 'sab', '17:15 - 17:30', 0),
(279, 'sab', '17:30 - 17:45', 0),
(280, 'sab', '17:45 - 18:00', 0),
(281, 'sab', '18:00 - 18:15', 0),
(282, 'sab', '18:15 - 18:30', 0),
(283, 'sab', '18:30 - 18:45', 0),
(284, 'sab', '18:45 - 19:00', 0),
(285, 'sab', '20:00 - 20:15', 0),
(286, 'sab', '20:15 - 20:30', 0),
(287, 'sab', '20:30 - 20:45', 0),
(288, 'sab', '20:45 - 21:00', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `app`
--
ALTER TABLE `app`
  ADD PRIMARY KEY (`idapp`);

--
-- Indici per le tabelle `compiti`
--
ALTER TABLE `compiti`
  ADD PRIMARY KEY (`idcompito`);

--
-- Indici per le tabelle `orario`
--
ALTER TABLE `orario`
  ADD PRIMARY KEY (`idorario`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `app`
--
ALTER TABLE `app`
  MODIFY `idapp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT per la tabella `compiti`
--
ALTER TABLE `compiti`
  MODIFY `idcompito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT per la tabella `orario`
--
ALTER TABLE `orario`
  MODIFY `idorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;