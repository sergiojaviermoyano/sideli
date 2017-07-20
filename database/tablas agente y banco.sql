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
  `razon_social` varchar(200) NOT NULL,
  `sucursal` varchar(150) NOT NULL,
  `estado` enum('ac','in') DEFAULT 'ac',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `razon_social` (`razon_social`,`sucursal`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of banco
-- ----------------------------
INSERT INTO `banco` VALUES ('1', 'Nación', 'Caucete', 'ac', '2017-07-20 16:51:03');

-- ----------------------------
-- Records of banco
-- ----------------------------
