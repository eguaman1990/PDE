/*
SQLyog Ultimate v8.61 
MySQL - 5.5.8-log : Database - pde
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pde` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `acceso` */

DROP TABLE IF EXISTS `acceso`;

CREATE TABLE `acceso` (
  `ID_ACCESO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_MESA` int(11) DEFAULT NULL,
  `TEMPORIZADOR` varchar(1024) NOT NULL,
  PRIMARY KEY (`ID_ACCESO`),
  KEY `FK_RELATIONSHIP_1` (`ID_MESA`),
  CONSTRAINT `FK_RELATIONSHIP_1` FOREIGN KEY (`ID_MESA`) REFERENCES `mesa` (`ID_MESA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `acceso` */

LOCK TABLES `acceso` WRITE;

UNLOCK TABLES;

/*Table structure for table `cargos` */

DROP TABLE IF EXISTS `cargos`;

CREATE TABLE `cargos` (
  `ID_CARGO` int(11) NOT NULL AUTO_INCREMENT,
  `CA_DESCRIPCION` varchar(1024) NOT NULL,
  PRIMARY KEY (`ID_CARGO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cargos` */

LOCK TABLES `cargos` WRITE;

insert  into `cargos`(`ID_CARGO`,`CA_DESCRIPCION`) values (1,'Administrador'),(2,'Cajero'),(3,'bodeguera');

UNLOCK TABLES;

/*Table structure for table `cargosopciones` */

DROP TABLE IF EXISTS `cargosopciones`;

CREATE TABLE `cargosopciones` (
  `ID_OPCION` int(11) NOT NULL,
  `ID_CARGO` int(11) NOT NULL,
  PRIMARY KEY (`ID_OPCION`,`ID_CARGO`),
  KEY `FK_RELATIONSHIP_11` (`ID_CARGO`),
  CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`ID_CARGO`) REFERENCES `cargos` (`ID_CARGO`),
  CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`ID_OPCION`) REFERENCES `opciones` (`ID_OPCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cargosopciones` */

LOCK TABLES `cargosopciones` WRITE;

UNLOCK TABLES;

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `CA_DESCRIPCION` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_CATEGORIA`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `categorias` */

LOCK TABLES `categorias` WRITE;

insert  into `categorias`(`ID_CATEGORIA`,`CA_DESCRIPCION`) values (1,'Bebidas'),(2,'Snack'),(3,'Licores'),(4,'Promociones');

UNLOCK TABLES;

/*Table structure for table `detalle_pedido` */

DROP TABLE IF EXISTS `detalle_pedido`;

CREATE TABLE `detalle_pedido` (
  `ID_DETALLEPEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRODUCTO` int(11) DEFAULT NULL,
  `ID_PEDIDO` int(11) DEFAULT NULL,
  `DEPE_CANTIDAD` int(11) NOT NULL,
  `DEPE_PRECIO_UNITARIO` float NOT NULL,
  PRIMARY KEY (`ID_DETALLEPEDIDO`),
  KEY `FK_RELATIONSHIP_6` (`ID_PRODUCTO`),
  KEY `FK_RELATIONSHIP_7` (`ID_PEDIDO`),
  CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID_PRODUCTO`),
  CONSTRAINT `FK_RELATIONSHIP_7` FOREIGN KEY (`ID_PEDIDO`) REFERENCES `pedidos` (`ID_PEDIDO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detalle_pedido` */

LOCK TABLES `detalle_pedido` WRITE;

UNLOCK TABLES;

/*Table structure for table `estadopedido` */

DROP TABLE IF EXISTS `estadopedido`;

CREATE TABLE `estadopedido` (
  `ID_ESTADOPEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `ESPE_DESCRIPCION` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_ESTADOPEDIDO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `estadopedido` */

LOCK TABLES `estadopedido` WRITE;

insert  into `estadopedido`(`ID_ESTADOPEDIDO`,`ESPE_DESCRIPCION`) values (1,'En Cola'),(2,'En Preparacion'),(3,'Listo');

UNLOCK TABLES;

/*Table structure for table `inventarios` */

DROP TABLE IF EXISTS `inventarios`;

CREATE TABLE `inventarios` (
  `ID_INVENTARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRODUCTO` int(11) DEFAULT NULL,
  `INV_CANTIDAD` int(11) NOT NULL,
  `INV_FECHA_INGRESO` datetime NOT NULL,
  `INV_FECHA_VENCIMIENTO` datetime NOT NULL,
  `INV_STOCK_MINIMO` int(11) NOT NULL,
  `INV_PRECIO_UNITARIO` float NOT NULL,
  PRIMARY KEY (`ID_INVENTARIO`),
  KEY `FK_RELATIONSHIP_5` (`ID_PRODUCTO`),
  CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID_PRODUCTO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `inventarios` */

LOCK TABLES `inventarios` WRITE;

UNLOCK TABLES;

/*Table structure for table `mesa` */

DROP TABLE IF EXISTS `mesa`;

CREATE TABLE `mesa` (
  `ID_MESA` int(11) NOT NULL AUTO_INCREMENT,
  `ME_POSICION` int(11) NOT NULL,
  `ME_NOMBRE_MESA` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_MESA`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `mesa` */

LOCK TABLES `mesa` WRITE;

insert  into `mesa`(`ID_MESA`,`ME_POSICION`,`ME_NOMBRE_MESA`) values (1,1,'Mesa 1'),(2,2,'Mesa 2');

UNLOCK TABLES;

/*Table structure for table `nivelessatisfaciones` */

DROP TABLE IF EXISTS `nivelessatisfaciones`;

CREATE TABLE `nivelessatisfaciones` (
  `ID_NIVELSATISFACCION` int(11) NOT NULL AUTO_INCREMENT,
  `NISA_DESCRIPCION` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_NIVELSATISFACCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nivelessatisfaciones` */

LOCK TABLES `nivelessatisfaciones` WRITE;

UNLOCK TABLES;

/*Table structure for table `opciones` */

DROP TABLE IF EXISTS `opciones`;

CREATE TABLE `opciones` (
  `ID_OPCION` int(11) NOT NULL AUTO_INCREMENT,
  `OP_NOMBRE` varchar(1024) NOT NULL,
  `OP_PAGINA` varchar(1024) NOT NULL,
  PRIMARY KEY (`ID_OPCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `opciones` */

LOCK TABLES `opciones` WRITE;

UNLOCK TABLES;

/*Table structure for table `opiniones` */

DROP TABLE IF EXISTS `opiniones`;

CREATE TABLE `opiniones` (
  `ID_OPINION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_NIVELSATISFACCION` int(11) DEFAULT NULL,
  `OPIN_DESCRIPCION` varchar(1024) NOT NULL,
  PRIMARY KEY (`ID_OPINION`),
  KEY `FK_RELATIONSHIP_8` (`ID_NIVELSATISFACCION`),
  CONSTRAINT `FK_RELATIONSHIP_8` FOREIGN KEY (`ID_NIVELSATISFACCION`) REFERENCES `nivelessatisfaciones` (`ID_NIVELSATISFACCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `opiniones` */

LOCK TABLES `opiniones` WRITE;

UNLOCK TABLES;

/*Table structure for table `pedidos` */

DROP TABLE IF EXISTS `pedidos`;

CREATE TABLE `pedidos` (
  `ID_PEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ESTADOPEDIDO` int(11) DEFAULT NULL,
  `FECHA_INGRESO` datetime NOT NULL,
  `TOTAL` float NOT NULL,
  PRIMARY KEY (`ID_PEDIDO`),
  KEY `FK_RELATIONSHIP_2` (`ID_ESTADOPEDIDO`),
  CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`ID_ESTADOPEDIDO`) REFERENCES `estadopedido` (`ID_ESTADOPEDIDO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pedidos` */

LOCK TABLES `pedidos` WRITE;

UNLOCK TABLES;

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `ID_PRODUCTO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_SUBCATEGORIA` int(11) DEFAULT NULL,
  `PRO_DESCRIPCION` varchar(1024) NOT NULL,
  `PRO_PRECIO_UNITARIO` float NOT NULL,
  PRIMARY KEY (`ID_PRODUCTO`),
  KEY `FK_RELATIONSHIP_4` (`ID_SUBCATEGORIA`),
  CONSTRAINT `FK_RELATIONSHIP_4` FOREIGN KEY (`ID_SUBCATEGORIA`) REFERENCES `subcategorias` (`ID_SUBCATEGORIA`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `productos` */

LOCK TABLES `productos` WRITE;

insert  into `productos`(`ID_PRODUCTO`,`ID_SUBCATEGORIA`,`PRO_DESCRIPCION`,`PRO_PRECIO_UNITARIO`) values (1,1,'Ron Barcelo',5000),(2,3,'demo',1234),(3,2,'qweqwe',13123);

UNLOCK TABLES;

/*Table structure for table `subcategorias` */

DROP TABLE IF EXISTS `subcategorias`;

CREATE TABLE `subcategorias` (
  `ID_SUBCATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CATEGORIA` int(11) DEFAULT NULL,
  `SUBCA_DESCRIPCION` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_SUBCATEGORIA`),
  KEY `FK_RELATIONSHIP_3` (`ID_CATEGORIA`),
  CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categorias` (`ID_CATEGORIA`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `subcategorias` */

LOCK TABLES `subcategorias` WRITE;

insert  into `subcategorias`(`ID_SUBCATEGORIA`,`ID_CATEGORIA`,`SUBCA_DESCRIPCION`) values (1,3,'Ron'),(2,1,'Lata'),(3,2,'Papas'),(4,4,'Calientes');

UNLOCK TABLES;

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CARGO` int(11) DEFAULT NULL,
  `US_USER` varchar(1024) NOT NULL,
  `US_PASS` varchar(1024) NOT NULL,
  `US_NOMBRE` varchar(1024) NOT NULL,
  `US_APELLIDO` varchar(1024) NOT NULL,
  `US_EDAD` int(11) NOT NULL,
  `US_DIRECCION` varchar(1024) NOT NULL,
  `US_TELEFONO` int(11) NOT NULL,
  `US_EMAIL` varchar(1024) NOT NULL,
  `US_ACTIVO` enum('SI','NO') NOT NULL DEFAULT 'SI',
  PRIMARY KEY (`ID_USUARIO`),
  KEY `FK_RELATIONSHIP_9` (`ID_CARGO`),
  CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`ID_CARGO`) REFERENCES `cargos` (`ID_CARGO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

LOCK TABLES `usuarios` WRITE;

insert  into `usuarios`(`ID_USUARIO`,`ID_CARGO`,`US_USER`,`US_PASS`,`US_NOMBRE`,`US_APELLIDO`,`US_EDAD`,`US_DIRECCION`,`US_TELEFONO`,`US_EMAIL`,`US_ACTIVO`) values (1,2,'Admin','12345','Edwin','Guaman',23,'lalala',123456,'es.aguaman@gmail.comm','SI'),(2,1,'123','123456','nombre','apellido',1,'123',0,'a@a.cl','NO'),(3,1,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','123','23',123,'123',0,'123@123.cl','NO'),(4,2,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','asd','2qw',123,'qweqwe',0,'123@123.cl','NO'),(5,1,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','123','123',132,'132',123,'es.aguaman@gmail.com','SI');

UNLOCK TABLES;

/*Table structure for table `usuariosopciones` */

DROP TABLE IF EXISTS `usuariosopciones`;

CREATE TABLE `usuariosopciones` (
  `ID_OPCION` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  PRIMARY KEY (`ID_OPCION`,`ID_USUARIO`),
  KEY `FK_RELATIONSHIP_14` (`ID_USUARIO`),
  CONSTRAINT `FK_RELATIONSHIP_14` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`),
  CONSTRAINT `FK_RELATIONSHIP_15` FOREIGN KEY (`ID_OPCION`) REFERENCES `opciones` (`ID_OPCION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usuariosopciones` */

LOCK TABLES `usuariosopciones` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
