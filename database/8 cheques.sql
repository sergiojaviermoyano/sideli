/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : vt000318_sideli

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2017-07-26 17:24:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cheques
-- ----------------------------
DROP TABLE IF EXISTS `cheques`;
CREATE TABLE `cheques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `bancoId` int(11) NOT NULL,
  `agenteId` int(11) NOT NULL,
  `importe` decimal(14,2) NOT NULL,
  `vencimiento` date NOT NULL,
  `estado` enum('IN','AC') NOT NULL DEFAULT 'AC',
  `observacion` text,
  `numero` varchar(50) NOT NULL,
  `espropio` bit(1) DEFAULT b'0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bancoId` (`bancoId`,`agenteId`,`numero`) USING BTREE,
  KEY `agenteId` (`agenteId`),
  CONSTRAINT `cheques_ibfk_2` FOREIGN KEY (`agenteId`) REFERENCES `agente` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `cheques_ibfk_1` FOREIGN KEY (`bancoId`) REFERENCES `banco` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
