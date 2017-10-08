ALTER TABLE `cheques` ADD `tipo` INT(3) NOT NULL DEFAULT '0' AFTER `espropio`;
ALTER TABLE `cheques` CHANGE `tipo` `tipo` INT(3) NOT NULL DEFAULT '0' COMMENT '0: default, 1: Cheque Recibido, 2: Cheque Pagado';


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sideli`
--

-- --------------------------------------------------------

--
-- Table structure for table `tranferencias`
--

DROP TABLE IF EXISTS `tranferencias`;
CREATE TABLE IF NOT EXISTS `tranferencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banco_id` int(11) DEFAULT NULL,
  `cbu_nro` int(11) DEFAULT NULL,
  `cbu_alias` varchar(50) DEFAULT NULL,
  `importe` decimal(11,3) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(4) NOT NULL DEFAULT 'AC',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




--
-- Database: `sideli`
--

-- --------------------------------------------------------

--
-- Table structure for table `operacion_detalle_transferencia`
--

DROP TABLE IF EXISTS `operacion_detalle_transferencia`;
CREATE TABLE IF NOT EXISTS `operacion_detalle_transferencia` (
  `operacion_id` int(11) NOT NULL,
  `tranferencia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;
