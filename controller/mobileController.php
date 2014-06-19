<?php
session_start();

if (isset($_SERVER['HTTP_ORIGIN'])) {
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}
///CONTROLADOR PORCION
//****************************	INICIO CLASES REQUERIDAS	****************************************//
//session_start();/*Se inicia la Session para que pueda tomar las variables de session*/
require_once ("../modelo/Configuracion.class.php"); 
require_once ("../modelo/Acceso.class.php");
require_once ("../modelo/Categoria.class.php");
require_once ("../modelo/Subcategoria.class.php");
require_once ("../modelo/Producto.class.php");
//****************************	FIN CLASES REQUERIDAS		******************************************//
####################################################################################################
//****************************	INICIO VARIABLES GLOBALES	****************************************//
$resultado="";/**	esta variable sera la encargada de ser mi resulset*/
$respuesta=array();/**	esta variable sera la encargada de dar la respuesta a la vista */
$estado='';/**	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR)*/
$mensaje='';/**	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre*/
$strsql="";/**	esta variable es la que envia a mi clase la query de mi where*/
//$idUsuarioIngresa=$_SESSION["id_porcion"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa=date("Y-m-d H:i:s");/**	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda**/
$objAcceso = new Acceso();
//****************************	FIN VALIABLES GLOBALES	******************************************//
####################################################################################################
//****************************	INICIO DE TODOS MIS REQUEST	**************************************//
if(isset($_REQUEST["accion"])){
	$accion=$_REQUEST["accion"];
}else{
	$accion="";
}//accion

if(isset($_REQUEST["codigo"])){
	$codigo=$_REQUEST["codigo"];
}else{
	$codigo="";
}//codigo

if(isset($_REQUEST["id_producto"])){
	$id_producto=$_REQUEST["id_producto"];
}else{
	$id_producto="";
}//id_producto

if(isset($_REQUEST["id_inventario"])){
	$id_inventario=$_REQUEST["id_inventario"];
}else{
	$id_inventario="";
}//id_inventario

if(isset($_REQUEST["id_categoria"])){
	$id_categoria=$_REQUEST["id_categoria"];
}else{
	$id_categoria="";
}//id_categoria

if(isset($_REQUEST["porcion"])){
	$porcion=$_REQUEST["porcion"];
}else{
	$porcion="";
}//porcion

####################################################################################################
//****************************	INICIO DEL LISTAR	PORCION************************************************//
if ($accion=="login"){
	
	$res=$objAcceso->login($codigo);
	if($res==1){
		//como es NULL se debe actualizar el campo temporizador
		$estado="ok";
		$objAcceso->actualizar($codigo);
		if($objAcceso->myException->getEstado()==0){
			$estado="ok";
			$strsql =" and a.id_acceso ='".$codigo."'";
			$resultado=$objAcceso->listar($strsql);
			if($objAcceso->myException->getEstado()==0){
				foreach($resultado as $rs){
					$_SESSION["id_acceso"] = $rs["id_acceso"];
					$_SESSION["id_mesa"] 	= $rs["id_mesa"];
					$_SESSION["mesa"] =		$rs["mesa"];
					$_SESSION["temporizador"]		= $rs["temporizador"];
				}
				$estado="ok";
				$mensaje="el valor del id de mi acceso es: ".$_SESSION["id_acceso"];
			}else{
				$estado="error";			 
				$mensaje=$objAcceso->myException->getMensaje();
			}

		}else{
			$estado="error";
			$mensaje=$objAcceso->myException->getMensaje();
		}		
	}else{
		//tiene temporizador pero se debe validar si paso el tiempo de sesion o no.
		$estado="error";
		$dep="es malo";
	}
	$mensaje="login";
	$dep="login";
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"dep"=>$dep);
}
//****************************	FIN DEL LISTAR 	PORCION**************************************************//
############################################################################################################
//****************************	INICIO DEL AGREGAR PORCION		*********************************************//
if ($accion=="cargaMenu"){
	$objCategoria = new Categoria();

	$campos=$objCategoria->listar("");
		if($objCategoria->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Categorias Listadas Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objCategoria->myException->getMensaje();
		}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"campos"=>$campos);
}
//****************************	FIN DEL GRABAR PORCION		***********************************************//
###########################################################################################################
############################################################################################################
//****************************	INICIO DEL AGREGAR PORCION		*********************************************//
if ($accion=="cargaSubcategoria"){
	$objSubcategoria = new Subcategoria();
	if($id_categoria!=""){
		$strsql =" and s.id_categoria='$id_categoria' ";
	}
	$campos=$objSubcategoria->listar("");
		if($objSubcategoria->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Categorias Listadas Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objSubcategoria->myException->getMensaje();
		}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"campos"=>$campos);
}
//****************************	FIN DEL GRABAR PORCION		***********************************************//
###########################################################################################################
###########################################################################################################
//****************************	INICIO ELIMINAR PORCION	***********************************************//
if($accion=="eliminar"){
	$res=$objPorcion->buscar($id_porcion);
	if($res!=0){
		$dep="entro a eliminar";
		$resultado=$objPorcion->eliminar($id_porcion);
		if($objPorcion->myException->getEstado()==0){

			$estado="ok";
			$mensaje="Porcion Eliminado Exitosamente";
		}else{

			$estado="error";
			$mensaje=$objPorcion->myException->getMensaje();
		}
	}else{
		$estado="error";
		$mensaje=$objPorcion->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}
//****************************	FIN DEL ELIMINAR PORCION		*********************************************//
###########################################################################################################
###########################################################################################################
###########################################################################################################
###########################################################################################################
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header("Content-type: application/json");
$respuesta=json_encode($respuesta);
echo $respuesta;
?>