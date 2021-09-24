
-- --------------------------------------------------------

--
-- Table structure for table `intervento`
--

DROP TABLE IF EXISTS `intervento`;
CREATE TABLE IF NOT EXISTS `intervento` (
  `id_intervento` int(4) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(4) DEFAULT NULL,
  `Intervento` varchar(237) DEFAULT NULL,
  `data` varchar(10) DEFAULT NULL,
  `Tecnico` varchar(10) DEFAULT NULL,
  `TipoIntervento` varchar(5) DEFAULT NULL,
  `DataE` varchar(10) DEFAULT NULL,
  `chiamata` varchar(10) DEFAULT NULL,
  `ImportoTotale` varchar(11) DEFAULT NULL,
  `ImportoPagato` varchar(11) DEFAULT NULL,
  `data_pagamento` varchar(10) DEFAULT NULL,
  `eseguito` int(11) DEFAULT NULL,
  `priorita` varchar(1) DEFAULT NULL,
  `map` text,
  PRIMARY KEY (`id_intervento`)
) ENGINE=MyISAM AUTO_INCREMENT=2351 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `intervento`
--
