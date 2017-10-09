    -- phpMyAdmin SQL Dump
    -- version 4.7.4
    -- https://www.phpmyadmin.net/
    --
    -- Host: 127.0.0.1:3306
    -- Generation Time: Oct 09, 2017 at 12:09 PM
    -- Server version: 5.7.19
    -- PHP Version: 5.6.31

    SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
    SET AUTOCOMMIT = 0;
    START TRANSACTION;
    SET time_zone = "+00:00";

    --
    -- Database: `sideli`
    --

    -- --------------------------------------------------------

    --
    -- Table structure for table `cheques`
    --

    DROP TABLE IF EXISTS `cheques`;
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
    `tipo` int(3) NOT NULL DEFAULT '0' COMMENT '0: default, 1: Cheque Recibido, 2: Cheque Pagado',
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `bancoId` (`bancoId`,`agenteId`,`numero`) USING BTREE,
    KEY `agenteId` (`agenteId`)
    ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

    --
    -- Dumping data for table `cheques`
    --

    INSERT INTO `cheques` (`id`, `fecha`, `bancoId`, `agenteId`, `importe`, `vencimiento`, `estado`, `observacion`, `numero`, `espropio`, `tipo`, `created`) VALUES
    (1, '2017-10-31', 1, 1, '250000.00', NULL, 'AC', NULL, '10001', b'1', 1, '2017-10-08 01:21:08'),
    (2, '2017-10-13', 1, 1, '73668.08', NULL, 'AC', NULL, '45000', b'1', 2, '2017-10-08 01:21:08'),
    (8, '2017-10-31', 1, 1, '250000.00', NULL, 'AC', NULL, '10002', b'1', 1, '2017-10-08 01:22:55'),
    (9, '2017-10-13', 1, 1, '73668.08', NULL, 'AC', NULL, '45001', b'1', 2, '2017-10-08 01:22:55');

    -- --------------------------------------------------------

    --
    -- Table structure for table `operacion`
    --

    DROP TABLE IF EXISTS `operacion`;
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
    ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

    --
    -- Dumping data for table `operacion`
    --

    INSERT INTO `operacion` (`id`, `agente_emisor_id`, `agente_tenedor_id`, `banco_id`, `nro_cheque`, `importe`, `fecha_venc`, `nro_dias`, `tasa_mensual`, `interes`, `impuesto_cheque`, `gastos`, `compra`, `comision_valor`, `comision_total`, `subtotal`, `iva`, `sellado`, `neto`, `inversor_id`, `observacion`, `estado`, `created`) VALUES
    (1, 11, 1, 1, 10001, '250000.0000', '2017-10-31', 26, '7.2000', '15386.3000', '3000.0000', '0.0000', '0.0000', '0.9800', '2450.0000', '0.0000', '3745.6200', '1750.0000', '223668.0800', 1, '', 0, '2017-10-08 01:10:21'),
    (6, 11, 1, 1, 10002, '250000.0000', '2017-10-31', 26, '7.2000', '15386.3000', '3000.0000', '0.0000', '0.0000', '0.9800', '2450.0000', '0.0000', '3745.6200', '1750.0000', '223668.0800', 1, '', 0, '2017-10-08 01:10:22');

    -- --------------------------------------------------------

    --
    -- Table structure for table `operacion_detalle`
    --

    DROP TABLE IF EXISTS `operacion_detalle`;
    CREATE TABLE IF NOT EXISTS `operacion_detalle` (
    `operacion_id` int(11) DEFAULT NULL,
    `cheque_id` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

    --
    -- Dumping data for table `operacion_detalle`
    --

    INSERT INTO `operacion_detalle` (`operacion_id`, `cheque_id`) VALUES
    (1, 1),
    (1, 2),
    (6, 8),
    (6, 9);

    -- --------------------------------------------------------

    --
    -- Table structure for table `operacion_detalle_transferencia`
    --

    DROP TABLE IF EXISTS `operacion_detalle_transferencia`;
    CREATE TABLE IF NOT EXISTS `operacion_detalle_transferencia` (
    `operacion_id` int(11) NOT NULL,
    `transferencia_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    --
    -- Dumping data for table `operacion_detalle_transferencia`
    --

    INSERT INTO `operacion_detalle_transferencia` (`operacion_id`, `transferencia_id`) VALUES
    (1, 1),
    (6, 2);

    -- --------------------------------------------------------

    --
    -- Table structure for table `transferencias`
    --

    DROP TABLE IF EXISTS `transferencias`;
    CREATE TABLE IF NOT EXISTS `transferencias` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `banco_id` int(11) DEFAULT NULL,
    `cbu_nro` int(11) DEFAULT NULL,
    `cbu_alias` varchar(50) DEFAULT NULL,
    `importe` decimal(11,3) DEFAULT NULL,
    `fecha` date DEFAULT NULL,
    `estado` varchar(4) NOT NULL DEFAULT 'AC',
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

    --
    -- Dumping data for table `transferencias`
    --

    INSERT INTO `transferencias` (`id`, `banco_id`, `cbu_nro`, `cbu_alias`, `importe`, `fecha`, `estado`, `created`) VALUES
    (1, 2, 0, 'alias2', '150000.000', '2017-10-10', 'AC', '2017-10-08 01:21:08'),
    (2, 2, 0, 'alias2', '150000.000', '2017-10-10', 'AC', '2017-10-08 01:22:55');

    --
    -- Constraints for dumped tables
    --

    --
    -- Constraints for table `cheques`
    --
    ALTER TABLE `cheques`
    ADD CONSTRAINT `cheques_ibfk_1` FOREIGN KEY (`bancoId`) REFERENCES `banco` (`id`) ON UPDATE CASCADE,
    ADD CONSTRAINT `cheques_ibfk_2` FOREIGN KEY (`agenteId`) REFERENCES `agente` (`id`) ON UPDATE CASCADE;
    COMMIT;