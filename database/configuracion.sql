/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : vt000318_sideli

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2017-07-19 13:42:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `title1` varchar(15) DEFAULT NULL,
  `title2` varchar(15) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES ('Sistema de ', 'Liquidación', '1.0.0');
