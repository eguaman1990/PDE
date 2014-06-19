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

USE `pde`;

/*Data for the table `acceso` */

LOCK TABLES `acceso` WRITE;

UNLOCK TABLES;

/*Data for the table `cargos` */

LOCK TABLES `cargos` WRITE;

insert  into `cargos`(`ID_CARGO`,`CA_DESCRIPCION`,`CA_ACTIVO`) values (1,'Administrador','SI'),(2,'Cajero','NO'),(3,'Bodeguera','SI');

UNLOCK TABLES;

/*Data for the table `cargosopciones` */

LOCK TABLES `cargosopciones` WRITE;

UNLOCK TABLES;

/*Data for the table `categorias` */

LOCK TABLES `categorias` WRITE;

insert  into `categorias`(`ID_CATEGORIA`,`CA_DESCRIPCION`,`CA_ACTIVO`) values (1,'Bebidas','SI'),(2,'Snack','SI'),(3,'Licores','SI'),(4,'Promociones','SI'),(5,'Demo Categoria','NO'),(6,'Platos','SI');

UNLOCK TABLES;

/*Data for the table `detalle_pedido` */

LOCK TABLES `detalle_pedido` WRITE;

UNLOCK TABLES;

/*Data for the table `estadopedido` */

LOCK TABLES `estadopedido` WRITE;

insert  into `estadopedido`(`ID_ESTADOPEDIDO`,`ESPE_DESCRIPCION`) values (1,'En Cola'),(2,'En Preparacion'),(3,'Listo');

UNLOCK TABLES;

/*Data for the table `inventarios` */

LOCK TABLES `inventarios` WRITE;

UNLOCK TABLES;

/*Data for the table `mesa` */

LOCK TABLES `mesa` WRITE;

insert  into `mesa`(`ID_MESA`,`ME_POSICION`,`ME_NOMBRE_MESA`,`ME_ACTIVO`) values (1,1,'Mesa 1','SI'),(2,2,'Mesa 2','SI'),(3,2,'mesa demo','NO');

UNLOCK TABLES;

/*Data for the table `nivelessatisfaciones` */

LOCK TABLES `nivelessatisfaciones` WRITE;

UNLOCK TABLES;

/*Data for the table `opciones` */

LOCK TABLES `opciones` WRITE;

UNLOCK TABLES;

/*Data for the table `opiniones` */

LOCK TABLES `opiniones` WRITE;

UNLOCK TABLES;

/*Data for the table `pedidos` */

LOCK TABLES `pedidos` WRITE;

UNLOCK TABLES;

/*Data for the table `productos` */

LOCK TABLES `productos` WRITE;

insert  into `productos`(`ID_PRODUCTO`,`ID_SUBCATEGORIA`,`PRO_DESCRIPCION`,`PRO_PRECIO_UNITARIO`) values (1,1,'Ron Barcelo',5000),(2,3,'demo',1234),(3,2,'qweqwe',13123),(4,5,'pizza alemana',3000);

UNLOCK TABLES;

/*Data for the table `subcategorias` */

LOCK TABLES `subcategorias` WRITE;

insert  into `subcategorias`(`ID_SUBCATEGORIA`,`ID_CATEGORIA`,`SUBCA_DESCRIPCION`,`SUBCA_ACTIVO`) values (1,3,'Ron','SI'),(2,1,'Lata','SI'),(3,2,'Papas','SI'),(4,4,'Calientes','SI'),(5,6,'Pizzas','SI');

UNLOCK TABLES;

/*Data for the table `usuarios` */

LOCK TABLES `usuarios` WRITE;

insert  into `usuarios`(`ID_USUARIO`,`ID_CARGO`,`US_USER`,`US_PASS`,`US_NOMBRE`,`US_APELLIDO`,`US_EDAD`,`US_DIRECCION`,`US_TELEFONO`,`US_EMAIL`,`US_ACTIVO`) values (1,2,'Admin','*00A51F3F48415C7D4E8908980D443C29C69B60C9','Edwin','Guaman',23,'lalala',123456,'es.aguaman@gmail.comm','SI'),(2,1,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','nombre','apellido',1,'123',0,'a@a.cl','NO'),(3,1,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','123','23',123,'123',0,'123@123.cl','NO'),(4,2,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','asd','2qw',123,'qweqwe',0,'123@123.cl','NO'),(5,1,'123','*00A51F3F48415C7D4E8908980D443C29C69B60C9','123','123',132,'132',123,'es.aguaman@gmail.com','SI');

UNLOCK TABLES;

/*Data for the table `usuariosopciones` */

LOCK TABLES `usuariosopciones` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
