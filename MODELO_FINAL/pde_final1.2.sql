/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     28-06-2014 10:19:44                          */
/*==============================================================*/


drop table if exists pde.tmp_cargosopciones;

rename table pde.cargosopciones to tmp_cargosopciones;

drop table if exists pde.tmp_detalle_pedido;

rename table pde.detalle_pedido to tmp_detalle_pedido;

drop table if exists pde.tmp_opiniones;

rename table pde.opiniones to tmp_opiniones;

drop table if exists pde.tmp_pedidos;

rename table pde.pedidos to tmp_pedidos;

drop table if exists pde.tmp_productos;

rename table pde.productos to tmp_productos;

drop table if exists pde.proveedorproductos;

drop table if exists pde.recepciondetallepedido;

drop table if exists pde.tmp_recepcionpedidos;

rename table pde.recepcionpedidos to tmp_recepcionpedidos;

drop table if exists pde.solicituddetallepedido;

drop table if exists pde.tmp_solicitudpedido;

rename table pde.solicitudpedido to tmp_solicitudpedido;

drop table if exists pde.tmp_subcategorias;

rename table pde.subcategorias to tmp_subcategorias;

drop table if exists pde.tmp_inventarios;

drop table if exists pde.tmp_porciones;

drop table if exists pde.tmp_solicituddetallepedido;

drop table if exists pde.tmp_usuarios;

rename table pde.usuarios to tmp_usuarios;

alter table pde.usuariosopciones
   drop primary key;

drop table if exists pde.tmp_usuariosopciones;

rename table pde.usuariosopciones to tmp_usuariosopciones;

rename table relationship_16 to RELATIONSHIP_16;

/*==============================================================*/
/* Table: cargosopciones                                        */
/*==============================================================*/
create table cargosopciones
(
   ID_OPCION            int not null,
   ID_CARGO             int not null,
   primary key (ID_OPCION, ID_CARGO)
);

insert into cargosopciones (ID_OPCION, ID_CARGO)
select ID_OPCION, ID_CARGO
from pde.tmp_cargosopciones;

/*==============================================================*/
/* Table: detalle_pedido                                        */
/*==============================================================*/
create table detalle_pedido
(
   ID_DETALLEPEDIDO     int(11) not null auto_increment,
   ID_PRODUCTO          int,
   ID_PEDIDO            int,
   DEPE_CANTIDAD        int not null,
   DEPE_PRECIO_UNITARIO float not null,
   primary key (ID_DETALLEPEDIDO)
);

insert into detalle_pedido (ID_DETALLEPEDIDO, ID_PRODUCTO, ID_PEDIDO, DEPE_CANTIDAD, DEPE_PRECIO_UNITARIO)
select ID_DETALLEPEDIDO, ID_PRODUCTO, ID_PEDIDO, DEPE_CANTIDAD, DEPE_PRECIO_UNITARIO
from pde.tmp_detalle_pedido;

/*==============================================================*/
/* Table: opiniones                                             */
/*==============================================================*/
create table opiniones
(
   ID_OPINION           int(11) not null auto_increment,
   ID_NIVELSATISFACCION int,
   OPIN_DESCRIPCION     varchar(1024) not null,
   primary key (ID_OPINION)
);

insert into opiniones (ID_OPINION, ID_NIVELSATISFACCION, OPIN_DESCRIPCION)
select ID_OPINION, ID_NIVELSATISFACCION, OPIN_DESCRIPCION
from pde.tmp_opiniones;

/*==============================================================*/
/* Table: pedidos                                               */
/*==============================================================*/
create table pedidos
(
   ID_PEDIDO            int(11) not null auto_increment,
   ID_ESTADOPEDIDO      int,
   FECHA_INGRESO        datetime not null,
   TOTAL                float not null,
   primary key (ID_PEDIDO)
);

insert into pedidos (ID_PEDIDO, ID_ESTADOPEDIDO, FECHA_INGRESO, TOTAL)
select ID_PEDIDO, ID_ESTADOPEDIDO, FECHA_INGRESO, TOTAL
from pde.tmp_pedidos;

/*==============================================================*/
/* Table: productos                                             */
/*==============================================================*/
create table productos
(
   ID_PRODUCTO          int(11) not null auto_increment,
   ID_SUBCATEGORIA      int,
   PRO_DESCRIPCION      varchar(1024) not null,
   PRO_PRECIO_UNITARIO  float not null,
   PRO_ACTIVO           enum('si','no') not null default SI,
   primary key (ID_PRODUCTO)
);

insert into productos (ID_PRODUCTO, ID_SUBCATEGORIA, PRO_DESCRIPCION, PRO_PRECIO_UNITARIO, PRO_ACTIVO)
select ID_PRODUCTO, ID_SUBCATEGORIA, PRO_DESCRIPCION, PRO_PRECIO_UNITARIO, PRO_ACTIVO
from pde.tmp_productos;

alter table proveedor
   alter column ACTIVO drop default;

/*==============================================================*/
/* Table: recepcionPedidos                                      */
/*==============================================================*/
create table recepcionPedidos
(
   ID_RECEPCION         int not null auto_increment,
   ID_SOLICITUD         int,
   FECHA_RECEPCION      datetime,
   CANTIDAD_RECEPCION   int,
   DESCUENTO            int,
   ESTADO_RECEPCION     enum('Completa','Incompleta'),
   primary key (ID_RECEPCION)
);

insert into recepcionPedidos (ID_RECEPCION, FECHA_RECEPCION)
select ID_RECEPCION, FECHA_RECEPCION
from pde.tmp_recepcionpedidos;

/*==============================================================*/
/* Table: solicitudPedido                                       */
/*==============================================================*/
create table solicitudPedido
(
   ID_SOLICITUD         int not null auto_increment,
   ID_PROVEEDOR         int,
   ID_INVENTARIO        int,
   FECHA_SOLICITUD      datetime,
   CANTIDAD_SOLICITADA  int,
   ESTADO_SOLICITUD     enum('Solicitada','Recepcionada','Cancelada'),
   primary key (ID_SOLICITUD)
);

insert into solicitudPedido (ID_SOLICITUD, ID_PROVEEDOR, FECHA_SOLICITUD)
select ID_SOLICITUD, ID_PROVEEDOR, FECHA_SOLICITUD
from pde.tmp_solicitudpedido;

/*==============================================================*/
/* Table: subcategorias                                         */
/*==============================================================*/
create table subcategorias
(
   ID_SUBCATEGORIA      int(11) not null auto_increment,
   ID_CATEGORIA         int,
   SUBCA_DESCRIPCION    varchar(100) not null,
   SUBCA_ACTIVO         enum('si','no') not null default SI,
   primary key (ID_SUBCATEGORIA)
);

insert into subcategorias (ID_SUBCATEGORIA, ID_CATEGORIA, SUBCA_DESCRIPCION, SUBCA_ACTIVO)
select ID_SUBCATEGORIA, ID_CATEGORIA, SUBCA_DESCRIPCION, SUBCA_ACTIVO
from pde.tmp_subcategorias;

/*==============================================================*/
/* Table: usuarios                                              */
/*==============================================================*/
create table usuarios
(
   ID_USUARIO           int(11) not null auto_increment,
   ID_CARGO             int,
   US_USER              varchar(1024) not null,
   US_PASS              varchar(1024) not null,
   US_NOMBRE            varchar(1024) not null,
   US_APELLIDO          varchar(1024) not null,
   US_EDAD              int not null,
   US_DIRECCION         varchar(1024) not null,
   US_TELEFONO          int not null,
   US_EMAIL             varchar(1024) not null,
   US_ACTIVO            enum('si','no') not null default SI,
   primary key (ID_USUARIO)
);

insert into usuarios (ID_USUARIO, ID_CARGO, US_USER, US_PASS, US_NOMBRE, US_APELLIDO, US_EDAD, US_DIRECCION, US_TELEFONO, US_EMAIL, US_ACTIVO)
select ID_USUARIO, ID_CARGO, US_USER, US_PASS, US_NOMBRE, US_APELLIDO, US_EDAD, US_DIRECCION, US_TELEFONO, US_EMAIL, US_ACTIVO
from pde.tmp_usuarios;

/*==============================================================*/
/* Table: usuariosopciones                                      */
/*==============================================================*/
create table usuariosopciones
(
   ID_OPCION            int not null,
   ID_USUARIO           int not null,
   primary key (ID_USUARIO, ID_OPCION)
);

insert into usuariosopciones (ID_OPCION, ID_USUARIO)
select ID_OPCION, ID_USUARIO
from pde.tmp_usuariosopciones;

alter table RELATIONSHIP_16 add constraint FK_RELATIONSHIP_17 foreign key (ID_PROVEEDOR)
      references proveedor (ID_PROVEEDOR) on delete restrict on update restrict;

alter table RELATIONSHIP_16 add constraint FK_RELATIONSHIP_18 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table acceso add constraint FK_RELATIONSHIP_24 foreign key (ID_USUARIO)
      references usuarios (ID_USUARIO) on delete restrict on update restrict;

alter table cargosopciones add constraint FK_FK_FK_RELATIONSHIP_11 foreign key (ID_CARGO)
      references cargos (ID_CARGO) on delete restrict on update restrict;

alter table cargosopciones add constraint FK_FK_FK_RELATIONSHIP_12 foreign key (ID_OPCION)
      references opciones (ID_OPCION) on delete restrict on update restrict;

alter table detalle_pedido add constraint FK_FK_FK_RELATIONSHIP_6 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table detalle_pedido add constraint FK_FK_FK_RELATIONSHIP_7 foreign key (ID_PEDIDO)
      references pedidos (ID_PEDIDO) on delete restrict on update restrict;

alter table inventarios add constraint FK_FK_RELATIONSHIP_5 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table opiniones add constraint FK_FK_FK_RELATIONSHIP_8 foreign key (ID_NIVELSATISFACCION)
      references nivelessatisfaciones (ID_NIVELSATISFACCION) on delete restrict on update restrict;

alter table pedidos add constraint FK_FK_FK_RELATIONSHIP_2 foreign key (ID_ESTADOPEDIDO)
      references estadopedido (ID_ESTADOPEDIDO) on delete restrict on update restrict;

alter table porciones add constraint FK_FK_RELATIONSHIP_13 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table porciones add constraint FK_FK_RELATIONSHIP_14 foreign key (ID_INVENTARIO)
      references inventarios (ID_INVENTARIO) on delete restrict on update restrict;

alter table productos add constraint FK_FK_FK_RELATIONSHIP_4 foreign key (ID_SUBCATEGORIA)
      references subcategorias (ID_SUBCATEGORIA) on delete restrict on update restrict;

alter table recepcionPedidos add constraint FK_RELATIONSHIP_22 foreign key (ID_SOLICITUD)
      references solicitudPedido (ID_SOLICITUD) on delete restrict on update restrict;

alter table solicitudPedido add constraint FK_RELATIONSHIP_20 foreign key (ID_PROVEEDOR)
      references proveedor (ID_PROVEEDOR) on delete restrict on update restrict;

alter table solicitudPedido add constraint FK_RELATIONSHIP_21 foreign key (ID_INVENTARIO)
      references inventarios (ID_INVENTARIO) on delete restrict on update restrict;

alter table subcategorias add constraint FK_FK_FK_RELATIONSHIP_3 foreign key (ID_CATEGORIA)
      references categorias (ID_CATEGORIA) on delete restrict on update restrict;

alter table usuarios add constraint FK_FK_FK_RELATIONSHIP_9 foreign key (ID_CARGO)
      references cargos (ID_CARGO) on delete restrict on update restrict;

alter table usuariosopciones add constraint FK_FK_FK_RELATIONSHIP_14 foreign key (ID_USUARIO)
      references usuarios (ID_USUARIO) on delete restrict on update restrict;

alter table usuariosopciones add constraint FK_FK_FK_RELATIONSHIP_15 foreign key (ID_OPCION)
      references opciones (ID_OPCION) on delete restrict on update restrict;

