CREATE TABLE `operacion` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`agente_emisor_id`  int(11) NOT NULL ,
`agente_tenedor_id`  int(11) NOT NULL ,
`banco_id`  int(11) NOT NULL ,
`nro_cheque`  int(15) NOT NULL ,
`importe`  decimal(15,4) NOT NULL ,
`fecha_venc`  date NULL DEFAULT NULL ,
`nro_dias`  int(5) NULL DEFAULT NULL ,
`tasa_mensual`  decimal(5,4) NULL DEFAULT NULL ,
`interes`  decimal(15,4) NULL DEFAULT NULL ,
`impuesto_cheque`  decimal(15,4) NULL DEFAULT NULL ,
`gastos`  decimal(15,4) NULL DEFAULT NULL ,
`compra`  decimal(15,4) NULL DEFAULT NULL ,
`comision_valor`  decimal(15,4) NULL DEFAULT NULL ,
`comision_total`  decimal(15,4) NULL DEFAULT NULL ,
`subtotal`  decimal(15,4) NULL DEFAULT NULL COMMENT 'Total Sin descuentos' ,
`iva`  decimal(15,4) NULL DEFAULT NULL ,
`sellado`  decimal(15,4) NULL DEFAULT NULL ,
`neto`  decimal(15,4) NULL DEFAULT NULL ,
`inversor_id`  int(11) NOT NULL ,
`obveservacion`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`estado`  int(1) NULL DEFAULT 0 ,
`created`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=1
ROW_FORMAT=COMPACT
;

