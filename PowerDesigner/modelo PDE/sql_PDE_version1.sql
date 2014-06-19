/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     21/10/2013 19:55:14                          */
/*==============================================================*/


drop table if exists ACCESO;

drop table if exists CARGOS;

drop table if exists CARGOSOPCIONES;

drop table if exists CATEGORIAS;

drop table if exists DETALLE_PEDIDO;

drop table if exists ESTADOPEDIDO;

drop table if exists INTENTARIOS;

drop table if exists MESA;

drop table if exists NIVELESSATISFACIONES;

drop table if exists OPCIONES;

drop table if exists OPINIONES;

drop table if exists PEDIDOS;

drop table if exists PRODUCTOS;

drop table if exists SUBCATEGORIAS;

drop table if exists USUARIOS;

drop table if exists USUARIOSOPCIONES;

/*==============================================================*/
/* Table: ACCESO                                                */
/*==============================================================*/
create table ACCESO
(
   ID_ACCESO            int not null auto_increment,
   ID_MESA              int,
   TEMPORIZADOR         varchar(1024) not null,
   primary key (ID_ACCESO)
);

/*==============================================================*/
/* Table: CARGOS                                                */
/*==============================================================*/
create table CARGOS
(
   ID_CARGO             int not null auto_increment,
   CA_DESCRIPCION       varchar(1024) not null,
   primary key (ID_CARGO)
);

/*==============================================================*/
/* Table: CARGOSOPCIONES                                        */
/*==============================================================*/
create table CARGOSOPCIONES
(
   ID_OPCION            int not null,
   ID_CARGO             int not null,
   primary key (ID_OPCION, ID_CARGO)
);

/*==============================================================*/
/* Table: CATEGORIAS                                            */
/*==============================================================*/
create table CATEGORIAS
(
   ID_CATEGORIA         int not null auto_increment,
   CA_DESCRIPCION       varchar(100) not null,
   primary key (ID_CATEGORIA)
);

/*==============================================================*/
/* Table: DETALLE_PEDIDO                                        */
/*==============================================================*/
create table DETALLE_PEDIDO
(
   ID_DETALLEPEDIDO     int not null auto_increment,
   ID_PRODUCTO          int,
   ID_PEDIDO            int,
   DEPE_CANTIDAD        int not null,
   DEPE_PRECIO_UNITARIO float not null,
   primary key (ID_DETALLEPEDIDO)
);

/*==============================================================*/
/* Table: ESTADOPEDIDO                                          */
/*==============================================================*/
create table ESTADOPEDIDO
(
   ID_ESTADOPEDIDO      int not null auto_increment,
   ESPE_DESCRIPCION     varchar(100) not null,
   primary key (ID_ESTADOPEDIDO)
);

/*==============================================================*/
/* Table: INTENTARIOS                                           */
/*==============================================================*/
create table INTENTARIOS
(
   ID_INVENTARIO        int not null auto_increment,
   ID_PRODUCTO          int,
   INV_CANTIDAD         int not null,
   INV_FECHA_INGRESO    datetime not null,
   INV_FECHA_VENCIMIENTO datetime not null,
   INV_STOCK_MINIMO     int not null,
   INV_PRECIO_UNITARIO  float not null,
   primary key (ID_INVENTARIO)
);

/*==============================================================*/
/* Table: MESA                                                  */
/*==============================================================*/
create table MESA
(
   ID_MESA              int not null auto_increment,
   ME_POSICION          int not null,
   ME_NOMBRE_MESA       varchar(100) not null,
   primary key (ID_MESA)
);

/*==============================================================*/
/* Table: NIVELESSATISFACIONES                                  */
/*==============================================================*/
create table NIVELESSATISFACIONES
(
   ID_NIVELSATISFACCION int not null auto_increment,
   NISA_DESCRIPCION     varchar(100) not null,
   primary key (ID_NIVELSATISFACCION)
);

/*==============================================================*/
/* Table: OPCIONES                                              */
/*==============================================================*/
create table OPCIONES
(
   ID_OPCION            int not null auto_increment,
   OP_NOMBRE            varchar(1024) not null,
   OP_PAGINA            varchar(1024) not null,
   primary key (ID_OPCION)
);

/*==============================================================*/
/* Table: OPINIONES                                             */
/*==============================================================*/
create table OPINIONES
(
   ID_OPINION           int not null auto_increment,
   ID_NIVELSATISFACCION int,
   OPIN_DESCRIPCION     varchar(1024) not null,
   primary key (ID_OPINION)
);

/*==============================================================*/
/* Table: PEDIDOS                                               */
/*==============================================================*/
create table PEDIDOS
(
   ID_PEDIDO            int not null auto_increment,
   ID_ESTADOPEDIDO      int,
   FECHA_INGRESO        datetime not null,
   TOTAL                float not null,
   primary key (ID_PEDIDO)
);

/*==============================================================*/
/* Table: PRODUCTOS                                             */
/*==============================================================*/
create table PRODUCTOS
(
   ID_PRODUCTO          int not null auto_increment,
   ID_SUBCATEGORIA      int,
   PRO_DESCRIPCION      varchar(1024) not null,
   PRO_PRECIO_UNITARIO  float not null,
   primary key (ID_PRODUCTO)
);

/*==============================================================*/
/* Table: SUBCATEGORIAS                                         */
/*==============================================================*/
create table SUBCATEGORIAS
(
   ID_SUBCATEGORIA      int not null auto_increment,
   ID_CATEGORIA         int,
   SUBCA_DESCRIPCION    varchar(100) not null,
   primary key (ID_SUBCATEGORIA)
);

/*==============================================================*/
/* Table: USUARIOS                                              */
/*==============================================================*/
create table USUARIOS
(
   ID_USUARIO           int not null auto_increment,
   ID_CARGO             int,
   US_USER              varchar(1024) not null,
   US_PASS              varchar(1024) not null,
   US_NOMBRE            varchar(1024) not null,
   US_APELLIDO          varchar(1024) not null,
   US_EDAD              int not null,
   US_DIRECCION         varchar(1024) not null,
   US_TELEFONO          int not null,
   US_EMAIL             varchar(1024) not null,
   primary key (ID_USUARIO)
);

/*==============================================================*/
/* Table: USUARIOSOPCIONES                                      */
/*==============================================================*/
create table USUARIOSOPCIONES
(
   ID_OPCION            int not null,
   ID_USUARIO           int not null,
   primary key (ID_OPCION, ID_USUARIO)
);

alter table ACCESO add constraint FK_RELATIONSHIP_1 foreign key (ID_MESA)
      references MESA (ID_MESA) on delete restrict on update restrict;

alter table CARGOSOPCIONES add constraint FK_RELATIONSHIP_11 foreign key (ID_CARGO)
      references CARGOS (ID_CARGO) on delete restrict on update restrict;

alter table CARGOSOPCIONES add constraint FK_RELATIONSHIP_12 foreign key (ID_OPCION)
      references OPCIONES (ID_OPCION) on delete restrict on update restrict;

alter table DETALLE_PEDIDO add constraint FK_RELATIONSHIP_6 foreign key (ID_PRODUCTO)
      references PRODUCTOS (ID_PRODUCTO) on delete restrict on update restrict;

alter table DETALLE_PEDIDO add constraint FK_RELATIONSHIP_7 foreign key (ID_PEDIDO)
      references PEDIDOS (ID_PEDIDO) on delete restrict on update restrict;

alter table INTENTARIOS add constraint FK_RELATIONSHIP_5 foreign key (ID_PRODUCTO)
      references PRODUCTOS (ID_PRODUCTO) on delete restrict on update restrict;

alter table OPINIONES add constraint FK_RELATIONSHIP_8 foreign key (ID_NIVELSATISFACCION)
      references NIVELESSATISFACIONES (ID_NIVELSATISFACCION) on delete restrict on update restrict;

alter table PEDIDOS add constraint FK_RELATIONSHIP_2 foreign key (ID_ESTADOPEDIDO)
      references ESTADOPEDIDO (ID_ESTADOPEDIDO) on delete restrict on update restrict;

alter table PRODUCTOS add constraint FK_RELATIONSHIP_4 foreign key (ID_SUBCATEGORIA)
      references SUBCATEGORIAS (ID_SUBCATEGORIA) on delete restrict on update restrict;

alter table SUBCATEGORIAS add constraint FK_RELATIONSHIP_3 foreign key (ID_CATEGORIA)
      references CATEGORIAS (ID_CATEGORIA) on delete restrict on update restrict;

alter table USUARIOS add constraint FK_RELATIONSHIP_9 foreign key (ID_CARGO)
      references CARGOS (ID_CARGO) on delete restrict on update restrict;

alter table USUARIOSOPCIONES add constraint FK_RELATIONSHIP_14 foreign key (ID_USUARIO)
      references USUARIOS (ID_USUARIO) on delete restrict on update restrict;

alter table USUARIOSOPCIONES add constraint FK_RELATIONSHIP_15 foreign key (ID_OPCION)
      references OPCIONES (ID_OPCION) on delete restrict on update restrict;

