/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     27-06-2014 17:03:16                          */
/*==============================================================*/


drop table if exists pde.tmp_solicituddetallepedido;

rename table pde.solicituddetallepedido to tmp_solicituddetallepedido;

drop table if exists pde.tmp_inventarios;

rename table pde.inventarios to tmp_inventarios;

drop table if exists pde.tmp_porciones;

rename table pde.porciones to tmp_porciones;

/*==============================================================*/
/* Table: RELATIONSHIP_16                                       */
/*==============================================================*/
create table RELATIONSHIP_16
(
   ID_PRODUCTO          int not null,
   ID_PROVEEDOR         int not null,
   primary key (ID_PRODUCTO, ID_PROVEEDOR)
);

/*==============================================================*/
/* Table: RecepcionDetallePedido                                */
/*==============================================================*/
create table RecepcionDetallePedido
(
   ID_RECEPCION         int,
   ID_DETALLE_RECEPCION int not null auto_increment,
   ID_SOLICITUD_DETALLE_PEDIDO int,
   CANTIDAD_RECEPCION   int,
   DESCUENTO            int,
   primary key (ID_DETALLE_RECEPCION)
);

/*==============================================================*/
/* Table: SolicitudDetallePedido                                */
/*==============================================================*/
create table SolicitudDetallePedido
(
   ID_SOLICITUD         int,
   ID_SOLICITUD_DETALLE_PEDIDO int not null auto_increment,
   ID_INVENTARIO        int,
   CANTIDAD_SOLICITADA  int,
   ESTADO_SOLICITUD     enum('Solicitada','Recepcionada','Cancelada','Incompleta'),
   primary key (ID_SOLICITUD_DETALLE_PEDIDO)
);

insert into SolicitudDetallePedido (ID_SOLICITUD, ID_SOLICITUD_DETALLE_PEDIDO, CANTIDAD_SOLICITADA, ESTADO_SOLICITUD)
select ID_SOLICITUD, ID_SOLICITUD_DETALLE_PEDIDO, CANTIDAD_SOLICITADA, ESTADO_SOLICITUD
from pde.tmp_solicituddetallepedido;

/*==============================================================*/
/* Table: acceso                                                */
/*==============================================================*/
create table acceso
(
   ID_ACCESO            int(11) not null auto_increment,
   ID_MESA              int not null,
   ID_USUARIO           int not null,
   TEMPORIZADOR         datetime,
   primary key (ID_ACCESO)
);

/*==============================================================*/
/* Table: cargos                                                */
/*==============================================================*/
create table cargos
(
   ID_CARGO             int(11) not null auto_increment,
   CA_DESCRIPCION       varchar(1024) not null,
   CA_ACTIVO            enum('si','no') not null default SI,
   primary key (ID_CARGO)
);

/*==============================================================*/
/* Table: cargosopciones                                        */
/*==============================================================*/
create table cargosopciones
(
   ID_OPCION            int not null,
   ID_CARGO             int not null,
   primary key (ID_OPCION, ID_CARGO)
);

/*==============================================================*/
/* Table: categorias                                            */
/*==============================================================*/
create table categorias
(
   ID_CATEGORIA         int(11) not null auto_increment,
   CA_DESCRIPCION       varchar(100) not null,
   CA_ACTIVO            enum('si','no') not null default SI,
   primary key (ID_CATEGORIA)
);

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

/*==============================================================*/
/* Table: estadopedido                                          */
/*==============================================================*/
create table estadopedido
(
   ID_ESTADOPEDIDO      int(11) not null auto_increment,
   ESPE_DESCRIPCION     varchar(100) not null,
   primary key (ID_ESTADOPEDIDO)
);

/*==============================================================*/
/* Table: inventarios                                           */
/*==============================================================*/
create table inventarios
(
   ID_INVENTARIO        int(11) not null auto_increment,
   ID_PRODUCTO          int,
   INV_CANTIDAD         int not null,
   INV_FECHA_INGRESO    datetime not null,
   INV_FECHA_VENCIMIENTO datetime not null,
   INV_STOCK_MINIMO     int not null,
   INV_PRECIO_UNITARIO  float not null,
   INV_DESCRIPCION      varchar(256),
   INV_UNIDAD           enum('kilos','litros','gramos'),
   primary key (ID_INVENTARIO)
);

#WARNING: The following insert order will not restore columns: INV_UNIDAD
insert into inventarios (ID_INVENTARIO, ID_PRODUCTO, INV_CANTIDAD, INV_FECHA_INGRESO, INV_FECHA_VENCIMIENTO, INV_STOCK_MINIMO, INV_PRECIO_UNITARIO, INV_DESCRIPCION)
select ID_INVENTARIO, ID_PRODUCTO, INV_CANTIDAD, INV_FECHA_INGRESO, INV_FECHA_VENCIMIENTO, INV_STOCK_MINIMO, INV_PRECIO_UNITARIO, INV_DESCRIPCION
from pde.tmp_inventarios;

/*==============================================================*/
/* Table: mesa                                                  */
/*==============================================================*/
create table mesa
(
   ID_MESA              int(11) not null auto_increment,
   ME_POSICION          int not null,
   ME_NOMBRE_MESA       varchar(100) not null,
   ME_ACTIVO            enum('si','no') not null default SI,
   primary key (ID_MESA)
);

/*==============================================================*/
/* Table: nivelessatisfaciones                                  */
/*==============================================================*/
create table nivelessatisfaciones
(
   ID_NIVELSATISFACCION int(11) not null auto_increment,
   NISA_DESCRIPCION     varchar(100) not null,
   primary key (ID_NIVELSATISFACCION)
);

/*==============================================================*/
/* Table: opciones                                              */
/*==============================================================*/
create table opciones
(
   ID_OPCION            int(11) not null auto_increment,
   OP_NOMBRE            varchar(1024) not null,
   OP_PAGINA            varchar(1024) not null,
   primary key (ID_OPCION)
);

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

/*==============================================================*/
/* Table: porciones                                             */
/*==============================================================*/
create table porciones
(
   ID_PORCION           int(11) not null auto_increment,
   ID_PRODUCTO          int,
   ID_INVENTARIO        int,
   PORC_PORCION         int,
   PORC_UNIDAD          enum('litros','kilos','gramos'),
   primary key (ID_PORCION)
);

#WARNING: The following insert order will not restore columns: PORC_UNIDAD
insert into porciones (ID_PORCION, ID_PRODUCTO, ID_INVENTARIO, PORC_PORCION)
select ID_PORCION, ID_PRODUCTO, ID_INVENTARIO, PORC_PORCION
from pde.tmp_porciones;

/*==============================================================*/
/* Table: proveedor                                             */
/*==============================================================*/
create table proveedor
(
   ID_PROVEEDOR         int not null auto_increment,
   RUT_PROVEEDOR        int,
   NOMBRE_PROVEEDOR     int,
   DIRECCION            varchar(100),
   TELEFONO             varchar(12),
   CELULAR              varchar(12),
   EMAIL                varchar(50),
   primary key (ID_PROVEEDOR)
);

/*==============================================================*/
/* Table: recepcionPedidos                                      */
/*==============================================================*/
create table recepcionPedidos
(
   ID_RECEPCION         int not null auto_increment,
   FECHA_RECEPCION      datetime,
   primary key (ID_RECEPCION)
);

rename table solicitudpedido to solicitudPedido;

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

/*==============================================================*/
/* Table: usuariosopciones                                      */
/*==============================================================*/
create table usuariosopciones
(
   ID_OPCION            int not null,
   ID_USUARIO           int not null,
   primary key (ID_USUARIO, ID_OPCION)
);

alter table RELATIONSHIP_16 add constraint FK_RELATIONSHIP_17 foreign key (ID_PROVEEDOR)
      references proveedor (ID_PROVEEDOR) on delete restrict on update restrict;

alter table RELATIONSHIP_16 add constraint FK_RELATIONSHIP_18 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table RecepcionDetallePedido add constraint FK_RELATIONSHIP_22 foreign key (ID_SOLICITUD_DETALLE_PEDIDO)
      references SolicitudDetallePedido (ID_SOLICITUD_DETALLE_PEDIDO) on delete restrict on update restrict;

alter table RecepcionDetallePedido add constraint FK_RELATIONSHIP_23 foreign key (ID_RECEPCION)
      references recepcionPedidos (ID_RECEPCION) on delete restrict on update restrict;

alter table SolicitudDetallePedido add constraint FK_RELATIONSHIP_19 foreign key (ID_SOLICITUD)
      references solicitudPedido (ID_SOLICITUD) on delete restrict on update restrict;

alter table SolicitudDetallePedido add constraint FK_RELATIONSHIP_21 foreign key (ID_INVENTARIO)
      references inventarios (ID_INVENTARIO) on delete restrict on update restrict;

alter table acceso add constraint FK_FK_FK_RELATIONSHIP_1 foreign key (ID_MESA)
      references mesa (ID_MESA) on delete restrict on update restrict;

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

alter table solicitudPedido add constraint FK_RELATIONSHIP_20 foreign key (ID_PROVEEDOR)
      references proveedor (ID_PROVEEDOR) on delete restrict on update restrict;

alter table subcategorias add constraint FK_FK_FK_RELATIONSHIP_3 foreign key (ID_CATEGORIA)
      references categorias (ID_CATEGORIA) on delete restrict on update restrict;

alter table usuarios add constraint FK_FK_FK_RELATIONSHIP_9 foreign key (ID_CARGO)
      references cargos (ID_CARGO) on delete restrict on update restrict;

alter table usuariosopciones add constraint FK_FK_FK_RELATIONSHIP_14 foreign key (ID_USUARIO)
      references usuarios (ID_USUARIO) on delete restrict on update restrict;

alter table usuariosopciones add constraint FK_FK_FK_RELATIONSHIP_15 foreign key (ID_OPCION)
      references opciones (ID_OPCION) on delete restrict on update restrict;

