/*
Navicat MySQL Data Transfer

Source Server         : WampLocalHost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : sideli

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-09-21 20:11:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for agente
-- ----------------------------
DROP TABLE IF EXISTS `agente`;
CREATE TABLE `agente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `cuit` varchar(30) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of agente
-- ----------------------------
INSERT INTO `agente` VALUES ('1', 'nelson', 'cardonato', '30509052661', 'Nelson Cardonato', 'Alla', '451255221', '45521212', 'nelson.cardonato@email.com', '1', 'ac', '2017-07-21 20:11:45', '2017-07-21 20:11:49');
INSERT INTO `agente` VALUES ('2', 'nicolas', 'selva', '20325285411', 'Nicolas selva', 'Aqui', '52154588', '326594', 'nicolas.selva@email.com', '2', 'ac', '2017-07-21 20:12:47', '2017-07-21 20:12:49');
INSERT INTO `agente` VALUES ('5', 'Alberto Orlando', 'Barrera', '23423423423', 'razon 1', 'cvxcvxcvcxv', '4565465464', '22342342342', 'test@email.com', '1', 'ac', '2017-07-25 11:03:06', '2017-07-25 11:03:06');
INSERT INTO `agente` VALUES ('7', 'Colegio', 'Medico', '30518030236', 'Colegio Medico', '123213213', '234234324', '234324', 'test@email.com', '1', 'ac', '2017-07-27 12:02:47', '2017-07-27 12:02:47');
INSERT INTO `agente` VALUES ('8', 'Canteras', 'Diquecito SA', '30520720517', 'Canteras Diquesito SA', 'domicilio', '43434354', '656565656', 'tomador@email.com', '2', 'ac', '2017-07-27 12:07:32', '2017-07-27 12:07:32');
INSERT INTO `agente` VALUES ('9', 'Ruiz Sa', 'De La Torre', '30520763127', 'Re la Torre y Ruiz SA', 'gdgfdgfd', '123213213', '451212', 'emisor1@email.com', '1', 'ac', '2017-07-27 12:10:27', '2017-07-27 12:10:27');
INSERT INTO `agente` VALUES ('10', 'Tenedor', 'editado', '434343434', 'rasdds', 'domicilio', '234234', '15151515', 'emisor2@email.com', '2', 'ac', '2017-07-27 12:12:36', '2017-07-27 12:12:36');

-- ----------------------------
-- Table structure for banco
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of banco
-- ----------------------------
INSERT INTO `banco` VALUES ('1', 'Banco San Juan', 'San Juan', 'ac', '2017-07-21 19:56:03');
INSERT INTO `banco` VALUES ('2', 'Banco Nación', 'San Juan', 'ac', '2017-09-07 15:07:02');
INSERT INTO `banco` VALUES ('3', 'Banco Boston', 'San Juan', 'ac', '2017-09-07 15:07:37');
INSERT INTO `banco` VALUES ('4', 'Banco Credicop', 'San Juan', 'ac', '2017-09-07 15:07:27');
INSERT INTO `banco` VALUES ('5', 'Banco SUQUIA', 'San Juan', 'ac', '2017-09-07 15:07:52');

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
  CONSTRAINT `cheques_ibfk_1` FOREIGN KEY (`bancoId`) REFERENCES `banco` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `cheques_ibfk_2` FOREIGN KEY (`agenteId`) REFERENCES `agente` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cheques
-- ----------------------------

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `cliId` int(11) NOT NULL AUTO_INCREMENT,
  `cliNombre` varchar(100) NOT NULL,
  `cliApellido` varchar(100) NOT NULL,
  `docId` int(11) DEFAULT NULL,
  `cliDocumento` varchar(14) DEFAULT NULL,
  `cliDomicilio` varchar(255) DEFAULT NULL,
  `cliTelefono` varchar(255) DEFAULT NULL,
  `cliMail` varchar(100) DEFAULT NULL,
  `cliEstado` varchar(2) DEFAULT NULL,
  `cliDefault` bit(1) DEFAULT b'0',
  PRIMARY KEY (`cliId`),
  UNIQUE KEY `docId` (`docId`,`cliDocumento`) USING BTREE,
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`docId`) REFERENCES `tipos_documentos` (`docId`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES ('1', 'Consumidor Final', '', '1', '', '', '', '', 'AC', '');

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `validezpresupuesto` int(11) DEFAULT NULL,
  `utilizaordendecompra` bit(1) DEFAULT b'0',
  `title1` varchar(15) DEFAULT NULL,
  `title2` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES ('3', '', 'Sistema de ', 'Liquidación');
INSERT INTO `configuracion` VALUES ('3', '', 'Sistema de ', 'Liquidación');

-- ----------------------------
-- Table structure for inversor
-- ----------------------------
DROP TABLE IF EXISTS `inversor`;
CREATE TABLE `inversor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(250) DEFAULT NULL,
  `cuit` varchar(11) DEFAULT NULL,
  `domicilio` varchar(250) DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of inversor
-- ----------------------------
INSERT INTO `inversor` VALUES ('1', 'Soluciones y Finanzas Empresariales SA', '30714503703', 'Jujuy Sur 167, Piso 1, Depto C, San Juan, San Juan', '1');
INSERT INTO `inversor` VALUES ('2', 'Vinicava SRL', '11111111111', 'Mendoza 123 Sur', '1');

-- ----------------------------
-- Table structure for ivaalicuotas
-- ----------------------------
DROP TABLE IF EXISTS `ivaalicuotas`;
CREATE TABLE `ivaalicuotas` (
  `ivaId` int(11) NOT NULL AUTO_INCREMENT,
  `ivaDescripcion` varchar(20) NOT NULL,
  `ivaPorcentaje` decimal(10,2) NOT NULL,
  `ivaEstado` varchar(2) NOT NULL DEFAULT 'AC',
  `ivaPorDefecto` bigint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ivaId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ivaalicuotas
-- ----------------------------
INSERT INTO `ivaalicuotas` VALUES ('1', 'Exen', '0.00', 'AC', '0');
INSERT INTO `ivaalicuotas` VALUES ('2', 'No Grav', '0.00', 'AC', '0');
INSERT INTO `ivaalicuotas` VALUES ('3', '10,5%', '10.50', 'AC', '0');
INSERT INTO `ivaalicuotas` VALUES ('4', '21%', '21.00', 'AC', '1');
INSERT INTO `ivaalicuotas` VALUES ('5', '27%', '27.00', 'AC', '0');

-- ----------------------------
-- Table structure for operacion
-- ----------------------------
DROP TABLE IF EXISTS `operacion`;
CREATE TABLE `operacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agente_emisor_id` int(11) NOT NULL,
  `agente_tenedor_id` int(11) NOT NULL,
  `banco_id` int(11) NOT NULL,
  `nro_cheque` int(15) NOT NULL,
  `importe` decimal(15,4) NOT NULL,
  `fecha_venc` date DEFAULT NULL,
  `nro_dias` int(5) DEFAULT NULL,
  `tasa_mensual` decimal(5,4) DEFAULT NULL,
  `interes` decimal(15,4) DEFAULT NULL,
  `impuesto_cheque` decimal(15,4) DEFAULT NULL,
  `gastos` decimal(15,4) DEFAULT NULL,
  `compra` decimal(15,4) DEFAULT NULL,
  `comision_valor` decimal(15,4) DEFAULT NULL,
  `comision_total` decimal(15,4) DEFAULT NULL,
  `subtotal` decimal(15,4) DEFAULT NULL COMMENT 'Total Sin descuentos',
  `iva` decimal(15,4) DEFAULT NULL,
  `sellado` decimal(15,4) DEFAULT NULL,
  `neto` decimal(15,4) DEFAULT NULL,
  `inversor_id` int(11) NOT NULL,
  `obveservacion` text,
  `estado` int(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of operacion
-- ----------------------------

-- ----------------------------
-- Table structure for sisactions
-- ----------------------------
DROP TABLE IF EXISTS `sisactions`;
CREATE TABLE `sisactions` (
  `actId` int(11) NOT NULL AUTO_INCREMENT,
  `actDescription` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `actDescriptionSpanish` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`actId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sisactions
-- ----------------------------
INSERT INTO `sisactions` VALUES ('1', 'Add', 'Agregar');
INSERT INTO `sisactions` VALUES ('2', 'Edit', 'Editar');
INSERT INTO `sisactions` VALUES ('3', 'Del', 'Eliminar');
INSERT INTO `sisactions` VALUES ('4', 'View', 'Consultar');
INSERT INTO `sisactions` VALUES ('5', 'Imprimir', 'Imprimir');
INSERT INTO `sisactions` VALUES ('6', 'Saldo', 'Consultar Saldo');
INSERT INTO `sisactions` VALUES ('7', 'Close', 'Cerrar');
INSERT INTO `sisactions` VALUES ('8', 'Box', 'Caja');
INSERT INTO `sisactions` VALUES ('9', 'Conf', 'Confirmar');
INSERT INTO `sisactions` VALUES ('10', 'Disc', 'Descartar');
INSERT INTO `sisactions` VALUES ('11', 'Budget', 'Presupuesto');
INSERT INTO `sisactions` VALUES ('12', 'Cob', 'Cobrar');
INSERT INTO `sisactions` VALUES ('13', 'Anu', 'Anular');
INSERT INTO `sisactions` VALUES ('14', 'AyC', 'Ap. y Cier. de Caja');

-- ----------------------------
-- Table structure for sisgroups
-- ----------------------------
DROP TABLE IF EXISTS `sisgroups`;
CREATE TABLE `sisgroups` (
  `grpId` int(11) NOT NULL AUTO_INCREMENT,
  `grpName` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`grpId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sisgroups
-- ----------------------------
INSERT INTO `sisgroups` VALUES ('2', 'Administrador');

-- ----------------------------
-- Table structure for sisgroupsactions
-- ----------------------------
DROP TABLE IF EXISTS `sisgroupsactions`;
CREATE TABLE `sisgroupsactions` (
  `grpactId` int(11) NOT NULL AUTO_INCREMENT,
  `grpId` int(11) NOT NULL,
  `menuAccId` int(11) NOT NULL,
  PRIMARY KEY (`grpactId`),
  KEY `grpId` (`grpId`) USING BTREE,
  KEY `menuAccId` (`menuAccId`) USING BTREE,
  CONSTRAINT `sisgroupsactions_ibfk_1` FOREIGN KEY (`grpId`) REFERENCES `sisgroups` (`grpId`) ON UPDATE CASCADE,
  CONSTRAINT `sisgroupsactions_ibfk_2` FOREIGN KEY (`menuAccId`) REFERENCES `sismenuactions` (`menuAccId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=563 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sisgroupsactions
-- ----------------------------
INSERT INTO `sisgroupsactions` VALUES ('531', '2', '1');
INSERT INTO `sisgroupsactions` VALUES ('532', '2', '2');
INSERT INTO `sisgroupsactions` VALUES ('533', '2', '3');
INSERT INTO `sisgroupsactions` VALUES ('534', '2', '4');
INSERT INTO `sisgroupsactions` VALUES ('535', '2', '5');
INSERT INTO `sisgroupsactions` VALUES ('536', '2', '6');
INSERT INTO `sisgroupsactions` VALUES ('537', '2', '7');
INSERT INTO `sisgroupsactions` VALUES ('538', '2', '8');
INSERT INTO `sisgroupsactions` VALUES ('539', '2', '29');
INSERT INTO `sisgroupsactions` VALUES ('540', '2', '30');
INSERT INTO `sisgroupsactions` VALUES ('541', '2', '31');
INSERT INTO `sisgroupsactions` VALUES ('542', '2', '32');
INSERT INTO `sisgroupsactions` VALUES ('543', '2', '33');
INSERT INTO `sisgroupsactions` VALUES ('544', '2', '34');
INSERT INTO `sisgroupsactions` VALUES ('545', '2', '35');
INSERT INTO `sisgroupsactions` VALUES ('546', '2', '36');
INSERT INTO `sisgroupsactions` VALUES ('547', '2', '21');
INSERT INTO `sisgroupsactions` VALUES ('548', '2', '22');
INSERT INTO `sisgroupsactions` VALUES ('549', '2', '23');
INSERT INTO `sisgroupsactions` VALUES ('550', '2', '24');
INSERT INTO `sisgroupsactions` VALUES ('551', '2', '25');
INSERT INTO `sisgroupsactions` VALUES ('552', '2', '26');
INSERT INTO `sisgroupsactions` VALUES ('553', '2', '27');
INSERT INTO `sisgroupsactions` VALUES ('554', '2', '28');
INSERT INTO `sisgroupsactions` VALUES ('555', '2', '37');
INSERT INTO `sisgroupsactions` VALUES ('556', '2', '38');
INSERT INTO `sisgroupsactions` VALUES ('557', '2', '39');
INSERT INTO `sisgroupsactions` VALUES ('558', '2', '40');
INSERT INTO `sisgroupsactions` VALUES ('559', '2', '41');
INSERT INTO `sisgroupsactions` VALUES ('560', '2', '42');
INSERT INTO `sisgroupsactions` VALUES ('561', '2', '43');
INSERT INTO `sisgroupsactions` VALUES ('562', '2', '44');

-- ----------------------------
-- Table structure for sismenu
-- ----------------------------
DROP TABLE IF EXISTS `sismenu`;
CREATE TABLE `sismenu` (
  `menuId` int(11) NOT NULL AUTO_INCREMENT,
  `menuName` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuIcon` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuController` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuView` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuFather` int(11) DEFAULT NULL,
  PRIMARY KEY (`menuId`),
  KEY `menuFather` (`menuFather`) USING BTREE,
  CONSTRAINT `sismenu_ibfk_1` FOREIGN KEY (`menuFather`) REFERENCES `sismenu` (`menuId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sismenu
-- ----------------------------
INSERT INTO `sismenu` VALUES ('9', 'Seguridad', 'fa fa-key', '', '', null);
INSERT INTO `sismenu` VALUES ('10', 'Usuarios', '', 'user', 'index', '9');
INSERT INTO `sismenu` VALUES ('11', 'Grupos', '', 'group', 'index', '9');
INSERT INTO `sismenu` VALUES ('12', 'Administración', 'fa fa-fw fa-cogs', '', '', null);
INSERT INTO `sismenu` VALUES ('15', 'Agentes', 'fa fa-user-secret', 'agent', '', null);
INSERT INTO `sismenu` VALUES ('16', 'Emisores', 'fa fa-chevron-right', 'agent', 'emisor_list', '15');
INSERT INTO `sismenu` VALUES ('17', 'Tenedores', 'fa fa-chevron-right', 'agent', 'tenedor_list', '15');
INSERT INTO `sismenu` VALUES ('19', 'Bancos', '', 'bank', 'index', '12');
INSERT INTO `sismenu` VALUES ('20', 'Cheques', '', 'check', 'index', '12');
INSERT INTO `sismenu` VALUES ('21', 'Inversores', 'fa fa-chevron-right', 'investor', 'index', '15');
INSERT INTO `sismenu` VALUES ('22', 'Operaciones', 'fa fa-money', 'operation', 'index', null);

-- ----------------------------
-- Table structure for sismenuactions
-- ----------------------------
DROP TABLE IF EXISTS `sismenuactions`;
CREATE TABLE `sismenuactions` (
  `menuAccId` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `actId` int(11) DEFAULT NULL,
  PRIMARY KEY (`menuAccId`),
  KEY `menuId` (`menuId`) USING BTREE,
  KEY `actId` (`actId`) USING BTREE,
  CONSTRAINT `sismenuactions_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `sismenu` (`menuId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `sismenuactions_ibfk_2` FOREIGN KEY (`actId`) REFERENCES `sisactions` (`actId`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sismenuactions
-- ----------------------------
INSERT INTO `sismenuactions` VALUES ('1', '10', '1');
INSERT INTO `sismenuactions` VALUES ('2', '10', '2');
INSERT INTO `sismenuactions` VALUES ('3', '10', '3');
INSERT INTO `sismenuactions` VALUES ('4', '10', '4');
INSERT INTO `sismenuactions` VALUES ('5', '11', '1');
INSERT INTO `sismenuactions` VALUES ('6', '11', '2');
INSERT INTO `sismenuactions` VALUES ('7', '11', '3');
INSERT INTO `sismenuactions` VALUES ('8', '11', '4');
INSERT INTO `sismenuactions` VALUES ('21', '16', '1');
INSERT INTO `sismenuactions` VALUES ('22', '16', '2');
INSERT INTO `sismenuactions` VALUES ('23', '16', '3');
INSERT INTO `sismenuactions` VALUES ('24', '16', '4');
INSERT INTO `sismenuactions` VALUES ('25', '17', '1');
INSERT INTO `sismenuactions` VALUES ('26', '17', '2');
INSERT INTO `sismenuactions` VALUES ('27', '17', '3');
INSERT INTO `sismenuactions` VALUES ('28', '17', '4');
INSERT INTO `sismenuactions` VALUES ('29', '19', '1');
INSERT INTO `sismenuactions` VALUES ('30', '19', '2');
INSERT INTO `sismenuactions` VALUES ('31', '19', '3');
INSERT INTO `sismenuactions` VALUES ('32', '19', '4');
INSERT INTO `sismenuactions` VALUES ('33', '20', '1');
INSERT INTO `sismenuactions` VALUES ('34', '20', '2');
INSERT INTO `sismenuactions` VALUES ('35', '20', '3');
INSERT INTO `sismenuactions` VALUES ('36', '20', '4');
INSERT INTO `sismenuactions` VALUES ('37', '21', '1');
INSERT INTO `sismenuactions` VALUES ('38', '21', '2');
INSERT INTO `sismenuactions` VALUES ('39', '21', '3');
INSERT INTO `sismenuactions` VALUES ('40', '21', '4');
INSERT INTO `sismenuactions` VALUES ('41', '22', '1');
INSERT INTO `sismenuactions` VALUES ('42', '22', '2');
INSERT INTO `sismenuactions` VALUES ('43', '22', '3');
INSERT INTO `sismenuactions` VALUES ('44', '22', '4');

-- ----------------------------
-- Table structure for sisusers
-- ----------------------------
DROP TABLE IF EXISTS `sisusers`;
CREATE TABLE `sisusers` (
  `usrId` int(11) NOT NULL AUTO_INCREMENT,
  `usrNick` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `usrName` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usrLastName` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usrComision` int(11) NOT NULL,
  `usrPassword` varchar(5000) COLLATE utf8_spanish_ci NOT NULL,
  `grpId` int(11) NOT NULL,
  `usrLastAcces` datetime DEFAULT NULL,
  `usrToken` text COLLATE utf8_spanish_ci,
  `usrEsAdmin` bit(1) DEFAULT b'0',
  PRIMARY KEY (`usrId`),
  KEY `grpId` (`grpId`) USING BTREE,
  CONSTRAINT `sisusers_ibfk_1` FOREIGN KEY (`grpId`) REFERENCES `sisgroups` (`grpId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of sisusers
-- ----------------------------
INSERT INTO `sisusers` VALUES ('2', 'admin', 'admin', 'admin', '1', 'e10adc3949ba59abbe56e057f20f883e', '2', '2017-09-20 20:44:12', 'nz3ZHwSsVdDej8n7AuO8OQus3Najmk7jUtuuSFLUxnBHiynJYnrwkKmCfyXzEkugRFyWzqnTf7kVDvBUs0mVHFjva6elVynDCn8xpdcoeksV34vQpZZVkgcPb8KSzFPSLYRa62agKZCLEgUlt2laPFGBypN19pfzvpMmlSqlbdkoNZIXou5JZdECvbOLMnshidn7Pfblv5LcRtfFexcmSUmDF2My6o6ey33n00AkbuZx9dIVQQenMhfCs3qiS2o', '');

-- ----------------------------
-- Table structure for tipos_documentos
-- ----------------------------
DROP TABLE IF EXISTS `tipos_documentos`;
CREATE TABLE `tipos_documentos` (
  `docId` int(11) NOT NULL AUTO_INCREMENT,
  `docDescripcion` varchar(50) NOT NULL,
  `docTipo` varchar(2) NOT NULL,
  `docEstado` varchar(2) NOT NULL,
  PRIMARY KEY (`docId`),
  UNIQUE KEY `docDescripcion` (`docDescripcion`,`docTipo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipos_documentos
-- ----------------------------
INSERT INTO `tipos_documentos` VALUES ('1', 'DNI', 'DP', 'AC');
INSERT INTO `tipos_documentos` VALUES ('2', 'CUIT', 'DP', 'AC');
INSERT INTO `tipos_documentos` VALUES ('3', 'LC', 'DP', 'AC');
INSERT INTO `tipos_documentos` VALUES ('4', 'LE', 'DP', 'AC');

-- ----------------------------
-- Table structure for valores
-- ----------------------------
DROP TABLE IF EXISTS `valores`;
CREATE TABLE `valores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tasa` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) NOT NULL,
  `gastos` decimal(10,2) NOT NULL,
  `comision` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of valores
-- ----------------------------
INSERT INTO `valores` VALUES ('1', '6.00', '1.20', '0.00', '0.98');
SET FOREIGN_KEY_CHECKS=1;
