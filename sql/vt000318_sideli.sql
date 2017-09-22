-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 21, 2017 at 08:07 PM
-- Server version: 5.5.50
-- PHP Version: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vt000318_sideli`
--

-- --------------------------------------------------------

--
-- Table structure for table `agente`
--

CREATE TABLE IF NOT EXISTS `agente` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `agente`
--

INSERT INTO `agente` (`id`, `nombre`, `apellido`, `cuit`, `razon_social`, `domicilio`, `telefono`, `celular`, `email`, `tipo`, `estado`, `created`, `updated`) VALUES
(1, 'nelson', 'cardonato', '30509052661', 'Nelson Cardonato', 'Alla', '451255221', '45521212', 'nelson.cardonato@email.com', 1, 'ac', '2017-07-21 23:11:45', '2017-07-21 20:11:49'),
(2, 'nicolas', 'selva', '20325285411', 'Nicolas selva', 'Aqui', '52154588', '326594', 'nicolas.selva@email.com', 2, 'ac', '2017-07-21 23:12:47', '2017-07-21 20:12:49'),
(5, 'Alberto Orlando', 'Barrera', '23423423423', 'razon 1', 'cvxcvxcvcxv', '4565465464', '22342342342', 'test@email.com', 1, 'ac', '2017-07-25 14:03:06', '2017-07-25 11:03:06'),
(7, 'Colegio', 'Medico', '30518030236', 'Colegio Medico', '123213213', '234234324', '234324', 'test@email.com', 1, 'ac', '2017-07-27 15:02:47', '2017-07-27 12:02:47'),
(8, 'Canteras', 'Diquecito SA', '30520720517', 'Canteras Diquesito SA', 'domicilio', '43434354', '656565656', 'tomador@email.com', 2, 'ac', '2017-07-27 15:07:32', '2017-07-27 12:07:32'),
(9, 'Ruiz Sa', 'De La Torre', '30520763127', 'Re la Torre y Ruiz SA', 'gdgfdgfd', '123213213', '451212', 'emisor1@email.com', 1, 'ac', '2017-07-27 15:10:27', '2017-07-27 12:10:27'),
(10, 'Tenedor', 'editado', '30512345677', 'Tenedor Razon Social', 'domicilio', '234234', '15151515', 'tomador@email.com', 2, 'ac', '2017-07-27 15:12:36', '2017-07-27 12:12:36'),
(11, 'Emisor', 'Agente', '20308529621', 'Emisor Razon Social', 'domicilio', '1234565445', '15565454', 'tenedor@email.com', 1, 'ac', '2017-09-19 19:46:57', '2017-09-19 16:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `banco`
--

CREATE TABLE IF NOT EXISTS `banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(200) NOT NULL,
  `sucursal` varchar(150) NOT NULL,
  `estado` enum('ac','in') DEFAULT 'ac',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `razon_social` (`razon_social`,`sucursal`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `banco`
--

INSERT INTO `banco` (`id`, `razon_social`, `sucursal`, `estado`, `created`) VALUES
(1, 'Banco San Juan', 'San Juan', 'ac', '2017-07-21 22:56:03'),
(2, 'Banco Nación', 'San Juan', 'ac', '2017-09-07 18:07:02'),
(3, 'Banco Boston', 'San Juan', 'ac', '2017-09-07 18:07:37'),
(4, 'Banco Credicop', 'San Juan', 'ac', '2017-09-07 18:07:27'),
(5, 'Banco SUQUIA', 'San Juan', 'ac', '2017-09-07 18:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `cheques`
--

CREATE TABLE IF NOT EXISTS `cheques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `bancoId` int(11) NOT NULL,
  `agenteId` int(11) NOT NULL,
  `importe` decimal(14,2) NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `estado` enum('IN','AC') NOT NULL DEFAULT 'AC',
  `observacion` text,
  `numero` varchar(50) NOT NULL,
  `espropio` bit(1) DEFAULT b'0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bancoId` (`bancoId`,`agenteId`,`numero`) USING BTREE,
  KEY `agenteId` (`agenteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cheques`
--

INSERT INTO `cheques` (`id`, `fecha`, `bancoId`, `agenteId`, `importe`, `vencimiento`, `estado`, `observacion`, `numero`, `espropio`, `created`) VALUES
(1, '2017-08-10', 4, 2, '6000.00', '2017-12-31', 'AC', '', '123455678978', b'0', '2017-08-07 20:15:46'),
(2, '2017-09-22', 4, 11, '50000.00', NULL, 'AC', NULL, '147258369', b'1', '2017-09-21 20:23:30'),
(3, '2017-09-22', 2, 11, '25000.00', NULL, 'AC', NULL, '123654987', b'1', '2017-09-21 20:23:30'),
(7, '2017-09-26', 2, 11, '250000.00', NULL, 'AC', NULL, '987654322', b'1', '2017-09-21 20:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
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
  UNIQUE KEY `docId` (`docId`,`cliDocumento`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`cliId`, `cliNombre`, `cliApellido`, `docId`, `cliDocumento`, `cliDomicilio`, `cliTelefono`, `cliMail`, `cliEstado`, `cliDefault`) VALUES
(1, 'Consumidor Final', '', 1, '', '', '', '', 'AC', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `title1` varchar(15) DEFAULT NULL,
  `title2` varchar(15) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`title1`, `title2`, `version`) VALUES
('Sistema de ', 'Liquidación', '1.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `inversor`
--

CREATE TABLE IF NOT EXISTS `inversor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(250) DEFAULT NULL,
  `cuit` varchar(11) DEFAULT NULL,
  `domicilio` varchar(250) DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Dumping data for table `inversor`
--

INSERT INTO `inversor` (`id`, `razon_social`, `cuit`, `domicilio`, `estado`) VALUES
(1, 'Soluciones Y Finanzas Empresariales SA', '30714503703', 'Jujuy Sur 167, Piso 1, depto C, San Juan, Juan', 1),
(2, 'Vinicava SRL', '11111111111', 'Domicilio', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ivaalicuotas`
--

CREATE TABLE IF NOT EXISTS `ivaalicuotas` (
  `ivaId` int(11) NOT NULL AUTO_INCREMENT,
  `ivaDescripcion` varchar(20) NOT NULL,
  `ivaPorcentaje` decimal(10,2) NOT NULL,
  `ivaEstado` varchar(2) NOT NULL DEFAULT 'AC',
  `ivaPorDefecto` bigint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ivaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ivaalicuotas`
--

INSERT INTO `ivaalicuotas` (`ivaId`, `ivaDescripcion`, `ivaPorcentaje`, `ivaEstado`, `ivaPorDefecto`) VALUES
(1, 'Exen', '0.00', 'AC', 0),
(2, 'No Grav', '0.00', 'AC', 0),
(3, '10,5%', '10.50', 'AC', 0),
(4, '21%', '21.00', 'AC', 1),
(5, '27%', '27.00', 'AC', 0);

-- --------------------------------------------------------

--
-- Table structure for table `operacion`
--

CREATE TABLE IF NOT EXISTS `operacion` (
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
  `observacion` text,
  `estado` int(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=9 ;

--
-- Dumping data for table `operacion`
--

INSERT INTO `operacion` (`id`, `agente_emisor_id`, `agente_tenedor_id`, `banco_id`, `nro_cheque`, `importe`, `fecha_venc`, `nro_dias`, `tasa_mensual`, `interes`, `impuesto_cheque`, `gastos`, `compra`, `comision_valor`, `comision_total`, `subtotal`, `iva`, `sellado`, `neto`, `inversor_id`, `observacion`, `estado`, `created`) VALUES
(4, 10, 11, 1, 123456789, '100000.0000', '2017-10-19', 30, '6.0000', '5917.8100', '21000.0000', '76.0000', '73006.1900', '0.9800', '980.0000', '72026.1900', '1448.5400', '700.0000', '69877.6500', 1, 'comentario', 0, '2017-09-21 05:09:23'),
(8, 10, 11, 4, 123456791, '150000.0000', '2017-10-04', 15, '6.0000', '4438.3600', '31500.0000', '76.0000', '113985.6400', '0.9800', '1470.0000', '112515.6400', '1240.7500', '1050.0000', '110224.8900', 1, '', 0, '2017-09-21 05:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `operacion_detalle`
--

CREATE TABLE IF NOT EXISTS `operacion_detalle` (
  `operacion_id` int(11) DEFAULT NULL,
  `cheque_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `operacion_detalle`
--

INSERT INTO `operacion_detalle` (`operacion_id`, `cheque_id`) VALUES
(1, 2),
(1, 3),
(1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sisactions`
--

CREATE TABLE IF NOT EXISTS `sisactions` (
  `actId` int(11) NOT NULL AUTO_INCREMENT,
  `actDescription` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `actDescriptionSpanish` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`actId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sisactions`
--

INSERT INTO `sisactions` (`actId`, `actDescription`, `actDescriptionSpanish`) VALUES
(1, 'Add', 'Agregar'),
(2, 'Edit', 'Editar'),
(3, 'Del', 'Eliminar'),
(4, 'View', 'Consultar'),
(5, 'Imprimir', 'Imprimir'),
(6, 'Saldo', 'Consultar Saldo'),
(7, 'Close', 'Cerrar'),
(8, 'Box', 'Caja'),
(9, 'Conf', 'Confirmar'),
(10, 'Disc', 'Descartar'),
(11, 'Budget', 'Presupuesto'),
(12, 'Cob', 'Cobrar'),
(13, 'Anu', 'Anular'),
(14, 'AyC', 'Ap. y Cier. de Caja');

-- --------------------------------------------------------

--
-- Table structure for table `sisgroups`
--

CREATE TABLE IF NOT EXISTS `sisgroups` (
  `grpId` int(11) NOT NULL AUTO_INCREMENT,
  `grpName` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`grpId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sisgroups`
--

INSERT INTO `sisgroups` (`grpId`, `grpName`) VALUES
(2, 'Administrador'),
(3, 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `sisgroupsactions`
--

CREATE TABLE IF NOT EXISTS `sisgroupsactions` (
  `grpactId` int(11) NOT NULL AUTO_INCREMENT,
  `grpId` int(11) NOT NULL,
  `menuAccId` int(11) NOT NULL,
  PRIMARY KEY (`grpactId`),
  KEY `grpId` (`grpId`) USING BTREE,
  KEY `menuAccId` (`menuAccId`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=679 ;

--
-- Dumping data for table `sisgroupsactions`
--

INSERT INTO `sisgroupsactions` (`grpactId`, `grpId`, `menuAccId`) VALUES
(615, 3, 1),
(616, 3, 2),
(617, 3, 3),
(618, 3, 4),
(619, 3, 5),
(620, 3, 6),
(621, 3, 7),
(622, 3, 8),
(623, 3, 9),
(624, 3, 10),
(625, 3, 11),
(626, 3, 12),
(627, 3, 29),
(628, 3, 30),
(629, 3, 31),
(630, 3, 32),
(631, 3, 21),
(632, 3, 22),
(633, 3, 23),
(634, 3, 24),
(635, 3, 25),
(636, 3, 26),
(637, 3, 27),
(638, 3, 28),
(639, 3, 35),
(640, 3, 36),
(641, 3, 37),
(642, 3, 38),
(643, 3, 33),
(644, 3, 34),
(645, 2, 1),
(646, 2, 2),
(647, 2, 3),
(648, 2, 4),
(649, 2, 5),
(650, 2, 6),
(651, 2, 7),
(652, 2, 8),
(653, 2, 9),
(654, 2, 10),
(655, 2, 11),
(656, 2, 12),
(657, 2, 29),
(658, 2, 30),
(659, 2, 31),
(660, 2, 32),
(661, 2, 21),
(662, 2, 22),
(663, 2, 23),
(664, 2, 24),
(665, 2, 25),
(666, 2, 26),
(667, 2, 27),
(668, 2, 28),
(669, 2, 35),
(670, 2, 36),
(671, 2, 37),
(672, 2, 38),
(673, 2, 33),
(674, 2, 34),
(675, 2, 39),
(676, 2, 40),
(677, 2, 41),
(678, 2, 42);

-- --------------------------------------------------------

--
-- Table structure for table `sismenu`
--

CREATE TABLE IF NOT EXISTS `sismenu` (
  `menuId` int(11) NOT NULL AUTO_INCREMENT,
  `menuName` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuIcon` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuController` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuView` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `menuFather` int(11) DEFAULT NULL,
  PRIMARY KEY (`menuId`),
  KEY `menuFather` (`menuFather`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `sismenu`
--

INSERT INTO `sismenu` (`menuId`, `menuName`, `menuIcon`, `menuController`, `menuView`, `menuFather`) VALUES
(9, 'Seguridad', 'fa fa-key', '', '', NULL),
(10, 'Usuarios', '', 'user', 'index', 9),
(11, 'Grupos', '', 'group', 'index', 9),
(12, 'Administración', 'fa fa-fw fa-cogs', '', '', NULL),
(13, 'Bancos', '', 'bank', 'index', 12),
(18, 'Agentes', 'fa fa-fw fa-user-secret', 'agent', '', NULL),
(19, 'Emisores', 'fa fa-chevron-right', 'agent', 'emisor_list', 18),
(20, 'Tenedores', 'fa fa-chevron-right', 'agent', 'tenedor_list', 18),
(21, 'Cheques', '', 'check', 'index', 12),
(22, 'Valores', 'fa fa-fw fa-cog', 'valuegral', 'index', NULL),
(23, 'Inversores', 'fa fa-chevron-right', 'investor', 'index', 18),
(25, 'Operaciones', 'fa fa-money', 'operation', 'index', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sismenuactions`
--

CREATE TABLE IF NOT EXISTS `sismenuactions` (
  `menuAccId` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `actId` int(11) DEFAULT NULL,
  PRIMARY KEY (`menuAccId`),
  KEY `menuId` (`menuId`) USING BTREE,
  KEY `actId` (`actId`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `sismenuactions`
--

INSERT INTO `sismenuactions` (`menuAccId`, `menuId`, `actId`) VALUES
(1, 10, 1),
(2, 10, 2),
(3, 10, 3),
(4, 10, 4),
(5, 11, 1),
(6, 11, 2),
(7, 11, 3),
(8, 11, 4),
(9, 13, 1),
(10, 13, 2),
(11, 13, 3),
(12, 13, 4),
(21, 19, 1),
(22, 19, 2),
(23, 19, 3),
(24, 19, 4),
(25, 20, 1),
(26, 20, 2),
(27, 20, 3),
(28, 20, 4),
(29, 21, 1),
(30, 21, 2),
(31, 21, 3),
(32, 21, 4),
(33, 22, 2),
(34, 22, 4),
(35, 23, 1),
(36, 23, 2),
(37, 23, 3),
(38, 23, 4),
(39, 25, 1),
(40, 25, 2),
(41, 25, 3),
(42, 25, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sisusers`
--

CREATE TABLE IF NOT EXISTS `sisusers` (
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
  KEY `grpId` (`grpId`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sisusers`
--

INSERT INTO `sisusers` (`usrId`, `usrNick`, `usrName`, `usrLastName`, `usrComision`, `usrPassword`, `grpId`, `usrLastAcces`, `usrToken`, `usrEsAdmin`) VALUES
(2, 'admin', 'admin', 'admin', 1, 'e10adc3949ba59abbe56e057f20f883e', 2, '2017-09-21 17:33:40', 'sfprgG5JjKQWSShSS3WMIIYYjJPwG7eHKdknibT7wYJ3NZngzXcqyNn6jKpQOp5KM4QUAg8qVKjLel8q8outywTT3bWi3ypPcCccTFU2uaFRgnhLtiQAjftWEo4AS5nktmEogL2h0ntwyFUyRz1odI6mQjDYibT0JVEU3enMxLtC8wKIwqYynvbitds6DvHIYgr8a5iiIjIFiAqtr4jurxP56OqPcoA0axOUYeEkB5jPmaSMrTIeKnH0t1lxK4j', b'1'),
(3, 'acuadros', 'Alejandro', 'Cuadros', 1, 'e10adc3949ba59abbe56e057f20f883e', 3, '2017-09-11 10:41:14', 'm6jx7POQ3QEWAF7OLWTyn6G2RAW14muUPEs2KANr21pO99q43phLA6Ja8kakMNsv1Lp0zupeRxo5WcW0l7KZ7RIq4vTbWZnRmPUjl3YLNwv8G4KCnogttMcLSjslqMt5fgVAiJw1Ths0zfltUP4ja1NqbWpmAKWDP99NkWEcycvSkqgGrIDjO1uzw4gsYOJhjKs8SMCbUKSSkJ9GfjpLb1hvK4ZuGh9NByrb9NT3ko7SWUvvHppTGrpEctvXc1V', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `tipos_documentos`
--

CREATE TABLE IF NOT EXISTS `tipos_documentos` (
  `docId` int(11) NOT NULL AUTO_INCREMENT,
  `docDescripcion` varchar(50) NOT NULL,
  `docTipo` varchar(2) NOT NULL,
  `docEstado` varchar(2) NOT NULL,
  PRIMARY KEY (`docId`),
  UNIQUE KEY `docDescripcion` (`docDescripcion`,`docTipo`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tipos_documentos`
--

INSERT INTO `tipos_documentos` (`docId`, `docDescripcion`, `docTipo`, `docEstado`) VALUES
(1, 'DNI', 'DP', 'AC'),
(2, 'CUIT', 'DP', 'AC'),
(3, 'LC', 'DP', 'AC'),
(4, 'LE', 'DP', 'AC');

-- --------------------------------------------------------

--
-- Table structure for table `valores`
--

CREATE TABLE IF NOT EXISTS `valores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tasa` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) NOT NULL,
  `gastos` decimal(10,2) NOT NULL,
  `comision` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `valores`
--

INSERT INTO `valores` (`id`, `tasa`, `impuestos`, `gastos`, `comision`) VALUES
(1, '6.00', '21.00', '76.00', '0.98');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cheques`
--
ALTER TABLE `cheques`
  ADD CONSTRAINT `cheques_ibfk_1` FOREIGN KEY (`bancoId`) REFERENCES `banco` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cheques_ibfk_2` FOREIGN KEY (`agenteId`) REFERENCES `agente` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`docId`) REFERENCES `tipos_documentos` (`docId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `sisgroupsactions`
--
ALTER TABLE `sisgroupsactions`
  ADD CONSTRAINT `sisgroupsactions_ibfk_1` FOREIGN KEY (`grpId`) REFERENCES `sisgroups` (`grpId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sisgroupsactions_ibfk_2` FOREIGN KEY (`menuAccId`) REFERENCES `sismenuactions` (`menuAccId`) ON UPDATE CASCADE;

--
-- Constraints for table `sismenu`
--
ALTER TABLE `sismenu`
  ADD CONSTRAINT `sismenu_ibfk_1` FOREIGN KEY (`menuFather`) REFERENCES `sismenu` (`menuId`) ON UPDATE CASCADE;

--
-- Constraints for table `sismenuactions`
--
ALTER TABLE `sismenuactions`
  ADD CONSTRAINT `sismenuactions_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `sismenu` (`menuId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sismenuactions_ibfk_2` FOREIGN KEY (`actId`) REFERENCES `sisactions` (`actId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `sisusers`
--
ALTER TABLE `sisusers`
  ADD CONSTRAINT `sisusers_ibfk_1` FOREIGN KEY (`grpId`) REFERENCES `sisgroups` (`grpId`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
