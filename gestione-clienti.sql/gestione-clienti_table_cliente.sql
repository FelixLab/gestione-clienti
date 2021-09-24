
-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(6) NOT NULL AUTO_INCREMENT,
  `denominazione` varchar(37) DEFAULT NULL,
  `Via` varchar(64) DEFAULT NULL,
  `comune` varchar(28) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `Cap` int(5) DEFAULT NULL,
  `CF_PIVA` varchar(17) DEFAULT NULL,
  `Tel` varchar(49) DEFAULT NULL,
  `Fax` varchar(10) DEFAULT NULL,
  `Mail` varchar(39) DEFAULT NULL,
  `MarcaCaldaia` varchar(13) DEFAULT NULL,
  `Tipo` varchar(9) DEFAULT NULL,
  `Anno` int(5) DEFAULT NULL,
  `DataInst` varchar(10) DEFAULT NULL,
  `GT` int(1) DEFAULT NULL,
  `Seriale` varchar(28) DEFAULT NULL,
  `Codice_Catasto` varchar(10) DEFAULT NULL,
  `Giorni` int(3) DEFAULT NULL,
  `Attiva` varchar(4) DEFAULT NULL,
  `Note` varchar(834) DEFAULT NULL,
  `pUtile` varchar(4) DEFAULT NULL,
  `potenzaFocolare` int(2) DEFAULT NULL,
  `Combustibile` varchar(10) DEFAULT NULL,
  `Modello` varchar(28) DEFAULT NULL,
  `Alimentazione` varchar(10) DEFAULT NULL,
  `Sospeso` varchar(5) DEFAULT NULL,
  `Locale` varchar(10) DEFAULT NULL,
  `CampoLibero` varchar(1000) DEFAULT NULL,
  `Via2` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=1337 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cliente`
--

