-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: iavdb
-- ------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
--
-- Table structure for table `TBL_Usuarios`
--

DROP TABLE IF EXISTS `TBL_Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TBL_Usuarios` (
  `usr_uuid` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `usr_nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `usr_paterno` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `usr_materno` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usr_usuario` varchar(12) COLLATE latin1_spanish_ci NOT NULL,
  `usr_passwd` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `usr_idempleado` int(6) unsigned zerofill DEFAULT NULL,
  `usr_depto` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usr_puesto` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usr_email` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usr_operador` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usr_uuid`),
  UNIQUE KEY `usr_uuid` (`usr_uuid`),
  KEY `usr_usuario` (`usr_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla de Usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TBL_Usuarios`
--

LOCK TABLES `TBL_Usuarios` WRITE;
/*!40000 ALTER TABLE `TBL_Usuarios` DISABLE KEYS */;
INSERT INTO `TBL_Usuarios` VALUES (001,'LUIS ANTONIO','ABREGO','SANCHEZ','LAbrego039','1c40d36534a0c626178ad0ffefff1a24',003603,'ADMINISTRACION','JEFE DE SISTEMAS','sistemas@autofin.com',1),(003,'JAIME IVAN','VELEZ','ORTEGA','JVelez028','ffd771072c38bcf94553418142fbbe84',NULL,'REFACCIONES','GERENTE REFACCIONES','refacc.@autofin.com',0);
/*!40000 ALTER TABLE `TBL_Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TBL_origen`
--

DROP TABLE IF EXISTS `TBL_origen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TBL_origen` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `origen` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `clave` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` tinytext COLLATE latin1_spanish_ci,
  `activo` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla de criterios de origen para PA';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TBL_origen`
--

LOCK TABLES `TBL_origen` WRITE;
/*!40000 ALTER TABLE `TBL_origen` DISABLE KEYS */;
INSERT INTO `TBL_origen` VALUES (17,'PRODUCTO NO CONFORME','P','Producto no conforme',1),(2,'REVISION POR LA DIRECCION','RAD','Revisión por la alta dirección',1),(3,'COMITE DE CALIDAD','CC','Comité de Calidad',1),(4,'QUEJAS/RECLAMOS DE CLIENTES ','QR','QUEJAS O RECLAMOS DE CLIENTES',1),(5,'FALLA REPETITIVA EN EL PROCESO','FRP','Falla repetitiva en el proceso',1),(7,'LIDER','CL','Certificación LIDER',1),(8,'SAI GLOBAL','SAI','Certificación ISO SAI GLOBAL',1),(9,'INCUMPLIMIENTO INDICADORES DE PROCESO','IIP','INCUMPLIMIENTO DE INDICADORES DE PROCESOS, TABLERO DE CONTROL DE INDICADORES/BSC',1),(10,'INTERNA','AI','AUDITORIA INTERNA',1),(11,'ANALISIS DE DATOS','AD','ANALISIS DE DATOS',1),(12,'MEDICIONES Y TENDENCIAS SATISFACCION CLIENTE','MTSC','MEDICIONES Y TENDENCIAS DE LA SATISFACCION DEL CLIENTE',1),(13,'MEDIOCION Y TENDENCIA DE PROCESOS','MTP','MEDICIONES Y TENDENCIAS DE LOS PROCESOS',1),(14,'ANALISIS DE MERCADO','AM','ANALISIS DE MERCADO',1),(15,'RESULTADOS DE AUTOEVALUACIONES','RE','RESULTADOS DE AUTOEVALUACIONES',1),(16,'OTROS QUE AFECTEN CALIDAD DEL SERVICIO','OTROS','OTROS QUE AFECTEN LA CALIDAD DEL SERVICIO',1),(1,'PRODUCTO NO CONFORME','PNC','PRODUCTO NO CONFORME',1);
/*!40000 ALTER TABLE `TBL_origen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TBL_paccion`
--

DROP TABLE IF EXISTS `TBL_paccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TBL_paccion` (
  `pa_id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'Id Plan de Accion',
  `pa_norma` varchar(8) COLLATE latin1_spanish_ci NOT NULL COMMENT 'No de Norma',
  `pa_comentarios` mediumtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Comentarios',
  `pa_noconformidad` text COLLATE latin1_spanish_ci NOT NULL COMMENT 'No conformidad observaciones',
  `pa_criterio` varchar(3) COLLATE latin1_spanish_ci NOT NULL COMMENT 'criterio NC-OB',
  `pa_causaraiz` text COLLATE latin1_spanish_ci,
  `pa_tiposol` varchar(2) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pa_descsol` text COLLATE latin1_spanish_ci,
  `pa_responsables` tinytext COLLATE latin1_spanish_ci,
  `pa_fechacumplimiento` date DEFAULT NULL,
  `pa_status` varchar(15) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pa_reprogramado` tinytext COLLATE latin1_spanish_ci,
  `pa_statusgral` int(1) NOT NULL DEFAULT '0',
  `pa_eficacia` text COLLATE latin1_spanish_ci,
  `pa_resultado` text COLLATE latin1_spanish_ci,
  `pa_creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pa_refauditoria` int(2) DEFAULT NULL,
  `pa_asignado` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pa_event` text COLLATE latin1_spanish_ci,
  `pa_fechareprog` date DEFAULT NULL,
  `pa_fechacierre` date DEFAULT NULL,
  PRIMARY KEY (`pa_id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla de Plan de Accion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TBL_paccion`
--

LOCK TABLES `TBL_paccion` WRITE;
/*!40000 ALTER TABLE `TBL_paccion` DISABLE KEYS */;
INSERT INTO `TBL_paccion` VALUES (00043,'','[ 08/03/2016 06:03:13 ] MCgil039 : Hola, soy la adpc y soy feliz;[ 08/03/2016 05:03:17 ] LAbrego039 : Esta es una observaciÃ³n a este plan de acciÃ³n; ','Cumplimiento a la perspectiva de proceso (instructivos, mapas de proceso y polÃ­ticas de hospitalidad) desarrollo e implementaciÃ³n','NA','Desconocimiento del personal operativo ajeno al Ã¡rea de hospitalidad.','AP','ClÃ­nicas de atenciÃ³n al cliente apegado a los lineamientos de los manuales e instructivos del Ã¡rea con el personal de operaciÃ³n de la agencia.\r\n','MERCADOTECNIA; ','2016-02-15','CERRADO',NULL,2,'No eficaz. No se cumple con perspectiva de procesos de hospitalidad de acuerdo al SC.','NE','2016-01-15 00:12:52',4,'009',NULL,NULL,'2016-02-08'),(00041,'','','Cumplimiento al coaching e inducciÃ³n con un mÃ­nimo de 17 puntos.','NA','Causa raÃ­z de la\r\n        debilidad\r\nno se tiene claro el tema de la re-ingenierÃ­a\r\n','AP','DescripciÃ³n de la SoluciÃ³n\r\n1. Realizar auditoria de re-ingenierÃ­a con e el auditor de Corporativo.\r\n2. Realizar las actividades establecidas para su minuta.\r\n3. herramientas revisar con garantÃ­as los seguimiento de las ventas.','GERENTE REFACCIONES; ','2016-01-31','CERRADO','2016-02-02',2,'No eficaz. No se cumple con el coahing de refacciones','NE','2016-01-12 15:31:56',4,'003',NULL,'2016-03-16','2016-03-16');
/*!40000 ALTER TABLE `TBL_paccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TBL_puestos`
--

DROP TABLE IF EXISTS `TBL_puestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TBL_puestos` (
  `id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'id de puesto',
  `puesto` varchar(120) COLLATE latin1_spanish_ci NOT NULL COMMENT 'puesto',
  `descripcion` varchar(200) COLLATE latin1_spanish_ci DEFAULT NULL COMMENT 'descripcion del puesto',
  `depto` int(2) DEFAULT NULL COMMENT 'id del depto al que pertenece',
  `activo` int(1) NOT NULL DEFAULT '1' COMMENT 'activo/inactivo - (1/0)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Tabla de Puestos / Perfiles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TBL_puestos`
--

LOCK TABLES `TBL_puestos` WRITE;
/*!40000 ALTER TABLE `TBL_puestos` DISABLE KEYS */;
INSERT INTO `TBL_puestos` VALUES (001,'JEFE DE SISTEMAS','JEFE DE SISTEMAS',1,1),(002,'GCIA ADMVA','GERENCIA ADMINISTRATIVA',1,1),(003,'GERENCIA GENERAL','GERENCIA GENERAL',1,1),(004,'GERENCIA REFACCIONES','GERENCIA DE REFACCIONES',4,1),(005,'GERENTE AUTOS NUEVOS','GERENCIA DE AUTOS NUEVOS',3,1),(006,'GERENTE AUTOS SEMINUEVOS','GERENCIA DE AUTOS SEMINUEVOS',5,1),(007,'GERENTE SERVICIO','GERENCIA DE SERVICIO',2,1),(008,'CORD. MERCADOTECNIA','COORDINADOR DE MERCADOTECNIA',1,1),(009,'JEFE DE MANTTO','JEFE DE MANTENIMIENTO',1,1),(010,'JEFE DE HYP','JEFE DE HOJALATERIA Y PINTURA',2,1),(011,'JEFE DE PREPARADORES','JEFE DE ACONDICIONAMIENTO UNIDADES NUEVAS',3,1),(012,'JEFE DE ALMACEN','JEFE DE ALMACEN DE REFACCIONES',4,1),(013,'JEFE CREDITO','JEFE DE CREDITO Y COBRANZA',1,1),(014,'BUSINESS MANAGER','BUSINESS MANAGER',3,1),(015,'GERENTE SICREA','GERENCIA DE SICREA',3,1),(016,'F&I','FINANCIAL AND INSSURANCE',3,1),(017,'JEFE DE RRHH','JEFE DE RECURSOS HUMANOS',1,1);
/*!40000 ALTER TABLE `TBL_puestos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-19 19:05:56
