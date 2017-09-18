CREATE TABLE `inversor` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`razon_social`  varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`cuit`  varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`domicilio`  varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
`estado`  int(11) NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=3
ROW_FORMAT=COMPACT
;
