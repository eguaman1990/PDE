<?php
require_once('Configuracion.class.php');
require_once('Utilidades.class.php');
/**
 * @package
 * Proyecto : Fastfinger
 * Archivo : MyException
 * @link 
 * @copyright
 * @autor Carlos Jara Leyton
 * @since fecha 23/09/2011
 * version 1.0.1
 * Descripcion Clase que encapsula y controla todo lo relacionado con las excepciones

*/
class MyException{
	private $_estado;
	private $_mensaje;
	
	public function getEstado(){
		return $this->_estado;
	}
	
	public function getMensaje(){
		return $this->_mensaje;
	}
    
	public function setEstado($estado){
		$this->_estado=$estado;
		return true;
	}
	
	public function addError($value){
		$this->_mensaje[] = $value;
		if (Configuracion::$debug==1){
			if (strlen($value["admin"])!=0){
				if($_SESSION["id_usuario"]=='aguaman'){
					Utilidades::enviar_correo(array(array("email"=>"andres.guaman@milano.cl","nombre"=>"Andres Guaman")),array(),Configuracion::$debug_titulo,$value["admin"]);	
				}elseif($_SESSION["id_usuario"]=='13.455.897-0'){
					Utilidades::enviar_correo(array(array("email"=>"julio.guajardo@milano.cl","nombre"=>"Julio Guajardo")),array(),Configuracion::$debug_titulo,$value["admin"]);	
				}elseif($_SESSION["id_usuario"]=='fas'){
					Utilidades::enviar_correo(array(array("email"=>"fabian.arellano@milano.cl","nombre"=>"Fredy Mercury")),array(),Configuracion::$debug_titulo,$value["admin"]);	
				}elseif($_SESSION["id_usuario"]=='cjl'){
					Utilidades::enviar_correo(array(array("email"=>"carlos.jara@milano.cl","nombre"=>"Carlos Jara")),array(),Configuracion::$debug_titulo,$value["admin"]);	
				}else{
					Utilidades::enviar_correo(Configuracion::$debug_user,array(),Configuracion::$debug_titulo,$value["admin"]);
				}
			}
		}
	}
	
	public function __construct() {
        $_estado=0;
		$_mensaje=array();
	}

}?>