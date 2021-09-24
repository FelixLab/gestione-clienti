
-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

DROP TABLE IF EXISTS `foto`;
CREATE TABLE IF NOT EXISTS `foto` (
  `idF` int(11) NOT NULL AUTO_INCREMENT,
  `idC` int(6) DEFAULT NULL,
  `Nome` text,
  PRIMARY KEY (`idF`)
) ENGINE=MyISAM AUTO_INCREMENT=687 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `foto`
--
