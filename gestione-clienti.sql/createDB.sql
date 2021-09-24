--
-- Database: `gestione-clienti`
--

CREATE TABLE `cliente` (
  `id_cliente` int(6) NOT NULL AUTO_INCREMENT,
  `denominazione` varchar(255) DEFAULT NULL,
  `Via` varchar(255) DEFAULT NULL,
  `comune` varchar(255) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `Cap` varchar(5) DEFAULT NULL,
  `CF_PIVA` varchar(25) DEFAULT NULL,
  `Tel` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `MarcaCaldaia` varchar(255) DEFAULT NULL,
  `Tipo` varchar(9) DEFAULT NULL,
  `Anno` int(5) DEFAULT NULL,
  `DataInst` varchar(10) DEFAULT NULL,
  `GT` int(1) DEFAULT NULL,
  `Seriale` varchar(50) DEFAULT NULL,
  `Codice_Catasto` varchar(10) DEFAULT NULL,
  `Giorni` int(4) DEFAULT NULL,
  `Attiva` varchar(4) DEFAULT NULL,
  `Note` varchar(10000) DEFAULT NULL,
  `pUtile` varchar(4) DEFAULT NULL,
  `potenzaFocolare` double DEFAULT NULL,
  `Combustibile` varchar(25) DEFAULT NULL,
  `Modello` varchar(255) DEFAULT NULL,
  `Alimentazione` varchar(255) DEFAULT NULL,
  `Sospeso` varchar(5) DEFAULT NULL,
  `Locale` varchar(255) DEFAULT NULL,
  `CampoLibero` varchar(1000) DEFAULT NULL,
  `Via2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2236 DEFAULT CHARSET=utf8;




CREATE TABLE `foto` (
  `idF` int(6) NOT NULL AUTO_INCREMENT,
  `idC` int(6) DEFAULT NULL,
  `Nome` text DEFAULT NULL,
  PRIMARY KEY (`idF`)
) ENGINE=InnoDB AUTO_INCREMENT=1538 DEFAULT CHARSET=utf8;





CREATE TABLE `intervento` (
  `id_intervento` int(6) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(6) DEFAULT NULL,
  `Intervento` varchar(237) DEFAULT NULL,
  `data` varchar(10) DEFAULT NULL,
  `Tecnico` varchar(50) DEFAULT NULL,
  `TipoIntervento` varchar(5) DEFAULT NULL,
  `DataE` varchar(10) DEFAULT NULL,
  `chiamata` varchar(10) DEFAULT NULL,
  `ImportoTotale` varchar(11) DEFAULT NULL,
  `ImportoPagato` varchar(11) DEFAULT NULL,
  `data_pagamento` varchar(10) DEFAULT NULL,
  `eseguito` int(11) DEFAULT NULL,
  `priorita` varchar(1) DEFAULT NULL,
  `map` text DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_intervento`)
) ENGINE=InnoDB AUTO_INCREMENT=4520 DEFAULT CHARSET=utf8;




CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `denominazione` text NOT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


INSERT INTO users VALUES
("1","admin","admin@fake.it","admin","admin","1");


