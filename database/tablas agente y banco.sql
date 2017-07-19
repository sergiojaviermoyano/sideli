/*
Navicat MySQL Data Transfer

Source Server         : localhost_root
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : sideli

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2017-07-19 12:21:03
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `agente`
-- ----------------------------
DROP TABLE IF EXISTS `agente`;
CREATE TABLE `agente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `razon_social` varchar(200) DEFAULT NULL,
  `domicilio` varchar(200) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tipo` int(2) DEFAULT NULL,
  `estado` enum('ac','in') DEFAULT 'ac' COMMENT 'ac: activo, in:inactivo',
  `created` timestamp NULL DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of agente
-- ----------------------------

-- ----------------------------
-- Table structure for `banco`
-- ----------------------------
DROP TABLE IF EXISTS `banco`;
CREATE TABLE `banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(200) DEFAULT NULL,
  `sucursal` varchar(150) DEFAULT NULL,
  `estado` enum('ac','in') DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of banco
-- ----------------------------
