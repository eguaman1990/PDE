/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     09-04-2014 21:51:20                          */
/*==============================================================*/


drop table if exists acceso;

drop table if exists cargos;

drop table if exists cargosopciones;

drop table if exists categorias;

drop table if exists detalle_pedido;

drop table if exists estadopedido;

drop table if exists inventarios;

drop table if exists mesa;

drop table if exists nivelessatisfaciones;

drop table if exists opciones;

drop table if exists opiniones;

drop table if exists pedidos;

drop table if exists porciones;

drop table if exists productos;

drop table if exists subcategorias;

drop table if exists usuarios;

drop table if exists usuariosopciones;

/*==============================================================*/
/* User: pde                                                    */
/*==============================================================*/
create user pde;

/*==============================================================*/
/* Table: acceso                                                */
/*==============================================================*/
create table acceso
(
   ID_ACCESO            int(11) not null auto_increment,
   ID_MESA              int,
   TEMPORIZADOR         varchar(1024) not null,
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
   ID_PRODUCTO          int(11),
   INV_CANTIDAD         int not null,
   INV_FECHA_INGRESO    datetime not null,
   INV_FECHA_VENCIMIENTO datetime not null,
   INV_STOCK_MINIMO     int not null,
   INV_PRECIO_UNITARIO  float not null,
   primary key (ID_INVENTARIO)
);

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
   ID_PORCION           int not null auto_increment,
   ID_PRODUCTO          int,
   ID_INVENTARIO        int,
   PORC_PORCION         int,
   PORC_UNIDAD          enum('Litros','Kilos','Gramos'),
   primary key (ID_PORCION)
);

/*==============================================================*/
/* Table: productos                                             */
/*==============================================================*/
create table productos
(
   ID_PRODUCTO          int(11) not null auto_increment,
   ID_SUBCATEGORIA      int,
   PRO_DESCRIPCION      varchar(1024) not null,
   PRO_PRECIO_UNITARIO  float not null,
   primary key (ID_PRODUCTO)
);

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
   primary key (ID_OPCION, ID_USUARIO)
);

alter table acceso add constraint FK_FK_RELATIONSHIP_1 foreign key (ID_MESA)
      references mesa (ID_MESA) on delete restrict on update restrict;

alter table cargosopciones add constraint FK_FK_RELATIONSHIP_11 foreign key (ID_CARGO)
      references cargos (ID_CARGO) on delete restrict on update restrict;

alter table cargosopciones add constraint FK_FK_RELATIONSHIP_12 foreign key (ID_OPCION)
      references opciones (ID_OPCION) on delete restrict on update restrict;

alter table detalle_pedido add constraint FK_FK_RELATIONSHIP_6 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table detalle_pedido add constraint FK_FK_RELATIONSHIP_7 foreign key (ID_PEDIDO)
      references pedidos (ID_PEDIDO) on delete restrict on update restrict;

alter table inventarios add constraint FK_RELATIONSHIP_5 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO);

alter table opiniones add constraint FK_FK_RELATIONSHIP_8 foreign key (ID_NIVELSATISFACCION)
      references nivelessatisfaciones (ID_NIVELSATISFACCION) on delete restrict on update restrict;

alter table pedidos add constraint FK_FK_RELATIONSHIP_2 foreign key (ID_ESTADOPEDIDO)
      references estadopedido (ID_ESTADOPEDIDO) on delete restrict on update restrict;

alter table porciones add constraint FK_RELATIONSHIP_13 foreign key (ID_PRODUCTO)
      references productos (ID_PRODUCTO) on delete restrict on update restrict;

alter table porciones add constraint FK_RELATIONSHIP_14 foreign key (ID_INVENTARIO)
      references inventarios (ID_INVENTARIO) on delete restrict on update restrict;

alter table productos add constraint FK_FK_RELATIONSHIP_4 foreign key (ID_SUBCATEGORIA)
      references subcategorias (ID_SUBCATEGORIA) on delete restrict on update restrict;

alter table subcategorias add constraint FK_FK_RELATIONSHIP_3 foreign key (ID_CATEGORIA)
      references categorias (ID_CATEGORIA) on delete restrict on update restrict;

alter table usuarios add constraint FK_FK_RELATIONSHIP_9 foreign key (ID_CARGO)
      references cargos (ID_CARGO) on delete restrict on update restrict;

alter table usuariosopciones add constraint FK_FK_RELATIONSHIP_14 foreign key (ID_USUARIO)
      references usuarios (ID_USUARIO) on delete restrict on update restrict;

alter table usuariosopciones add constraint FK_FK_RELATIONSHIP_15 foreign key (ID_OPCION)
      references opciones (ID_OPCION) on delete restrict on update restrict;

