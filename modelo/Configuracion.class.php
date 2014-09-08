<?php

/**
 * @package
 * Proyecto : NuevoPDE
 * Archivo : Configuracion
 * @link 
 * @copyright
 * @autor Andres Guaman
 * @since fecha 15/11/2011
 * version 1.0.1
 * Descripcion Clase contiene la parametrizacion del sistema
 */
class Configuracion {
  #Datos de la conexion a la Base de Datos

  /*static $host_bd = '127.0.0.1';
  static $name_bd = 'pde';
  static $user_bd = 'root';
  static $pass_bd = '';*/

  /* static $host_bd='mysql.hostinger.es';
    static $name_bd='u402354703_pde';
    static $user_bd='u402354703_pde';
    static $pass_bd='123456'; */

 static $host_bd='www.eguaman.cl';
    static $name_bd='c47pde';
    static $user_bd='c47pdeUser';
    static $pass_bd='pde123456'; 

  #Paginador
  static public $MAXREGSPERPAGE = 10; //Cantidad Maxima de registros por p�gina
  static public $MAXPAGESPERPAGER = 20; //Cantidad M�xima de paginas mostradas por el paginador
  #Otros parametros
  static public $titulo = ".:: Pedido Digital Express ::.";
  static public $debug = 0;

  #sesion activa mobile (tiempo en horas)
  static public $TIEMPO_SESION = 4;
  static public $RAIZ="http://www.eguaman.cl/";

  //static public $RAIZ="http://eguamans.esy.es/";
	//static public $RAIZ = "http://localhost/PDE/";
		static public $RAIZ_CLIENT="http://www.eguaman.cl/PedidosClient/";
  //static public $RAIZ_CLIENT = "http://localhost/PDE/PedidosClient/";
  //ESTADOS DEL PEDIDO
  static public $EN_COLA = 1;
  static public $EN_PREPARACION = 2;
  static public $LISTO = 3;
}
