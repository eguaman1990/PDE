<?php
session_start();
///CONTROLADOR INVENTARIO
//****************************	INICIO CLASES REQUERIDAS	****************************************//
//session_start();/*Se inicia la Session para que pueda tomar las variables de session*/
require_once ("../modelo/Inventario.class.php");
require_once ("../modelo/Configuracion.class.php"); 
//****************************	FIN CLASES REQUERIDAS		******************************************//
####################################################################################################
//****************************	INICIO VARIABLES GLOBALES	****************************************//
$objInventario = new Inventario();/*Instancia de un objeto de mi clase usuario*/
$resultado="";/**	esta variable sera la encargada de ser mi resulset*/
$respuesta=array();/**	esta variable sera la encargada de dar la respuesta a la vista */
$estado='';/**	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR)*/
$mensaje='';/**	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre*/
$strsql="";/**	esta variable es la que envia a mi clase la query de mi where*/
//$idUsuarioIngresa=$_SESSION["id_inventario"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa=date("Y-m-d H:i:s");/**	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda**/
//****************************	FIN VALIABLES GLOBALES	******************************************//
####################################################################################################
//****************************	INICIO DE TODOS MIS REQUEST	**************************************//
if(isset($_REQUEST["accion"])){
	$accion=$_REQUEST["accion"];
}else{
	$accion="";
}//accion

if(isset($_REQUEST["id_inventario"])){
	$id_inventario=$_REQUEST["id_inventario"];
}else{
	$id_inventario="";
}//id_inventario

if(isset($_REQUEST["cantidad"])){
	$cantidad=$_REQUEST["cantidad"];
}else{
	$cantidad="";
}//cantidad

if(isset($_REQUEST["descripcion"])){
	$descripcion=$_REQUEST["descripcion"];
}else{
	$descripcion="";
}//descripcion

if(isset($_REQUEST["stock_minimo"])){
	$stock_minimo=$_REQUEST["stock_minimo"];
}else{
	$stock_minimo="";
}//stock_minimo

if(isset($_REQUEST["fecha_ingreso"])){
	$fecha_ingreso=$_REQUEST["fecha_ingreso"];
}else{
	$fecha_ingreso="";
}//fecha_ingreso

if(isset($_REQUEST["fecha_vencimiento"])){
	$fecha_vencimiento=$_REQUEST["fecha_vencimiento"];
}else{
	$fecha_vencimiento="";
}//fecha_vencimiento

if(isset($_REQUEST["precio_unitario"])){
	$precio_unitario=$_REQUEST["precio_unitario"];
}else{
	$precio_unitario="";
}//precio_unitario

if(isset($_REQUEST["unidad"])){
	$unidad=$_REQUEST["unidad"];
}else{
	$unidad="";
}//unidad

####################################################################################################
//****************************	INICIO DEL LISTAR	INVENTARIO************************************************//
if ($accion=="listar"){
	$paginador="";
	$posicion="";
	$respuesta=array();
	    
	if (isset($_POST["pag"])){
			$lngPageCurrent=$_POST["pag"];
	}else{
			if (isset($_GET["pag"])){
					$lngPageCurrent=$_GET["pag"];
			}else{
					$lngPageCurrent=1;
			}
	}//RECIBIMOS EL NUMERO DE LA PAGINA PARA CONTROLARLO CON EL PAGINADOR 
	
	if($id_inventario!=""){
		$strsql.=" and id_inventario='".$id_inventario."'";
	}
  
  if($descripcion!=""){
    $strsql.=" and inv_descripcion like '%".$descripcion."%'";
  }

	$arr=array();
				
	$estado="ok";
	$mensaje="";
		
	$rs=count($objInventario->listar($strsql));

	//entra al if en caso de que se pierda la conexion con la base de datos
	if ($objInventario->bd->myException->getEstado()==1){
		$estado="error";
		$mensaje=$objInventario->myException->getMensaje();
	}else{
		/*echo "ENTRO AL PAGINADOR";*/
		$lngRecordCount = $rs;
		if ($lngRecordCount>0){
			$lngPageCount = ceil($lngRecordCount / Configuracion::$MAXREGSPERPAGE);
			if ($lngPageCurrent > $lngPageCount) {
				$lngPageCurrent = $lngPageCount;  
			}
			if ($lngPageCurrent < 1) {
				$lngPageCurrent = 1;
			}
			$limite_inicio = Configuracion::$MAXREGSPERPAGE * ($lngPageCurrent - 1);
			$limite_final  = Configuracion::$MAXREGSPERPAGE;
			//echo "listar($sqlend,$arr,$limite_inicio,$limite_final);";
		
			$campos=$objInventario->listar($strsql." LIMIT " . $limite_inicio . ", ". $limite_final);
			if ($objInventario->myException->getEstado()==1){
				$estado="error";
				$mensaje=$objInventario->myException->getMensaje();
			}else{
				$cor=$limite_inicio;
				$estado="ok";
			}
		}else{
			$campos="";
			$estado="no";
		}
	}
	$paginador="";
	$posicion="";
	$respuesta=array();

	/*echo "retorna datos";*/
	$paginador=Utilidades::subNavPaginacion($lngPageCurrent, $lngPageCount);	 
	$posicion=utf8_encode("<div align =\"center\">".$lngRecordCount." Registros encontrados. Mostrando p&aacute;gina ".$lngPageCurrent." de ".$lngPageCount."</div>");
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje, "campos"=>$campos,"cor"=>$cor,"paginador"=>$paginador,"posicion"=>$posicion);
}
//****************************	FIN DEL LISTAR 	INVENTARIO**************************************************//
############################################################################################################
//****************************	INICIO DEL AGREGAR INVENTARIO		*********************************************//
if ($accion=="agregar"){
	$res=$objInventario->buscar($id_inventario);
	if($res==0){
		/**	INVENTARIO NO EXISTE**/
		$dep="entro a ingresar";
		$resultado=$objInventario->crear($fecha_ingreso,$fecha_vencimiento,$cantidad,$precio_unitario,$stock_minimo,$descripcion,$unidad);
		if($objInventario->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Inventario Ingresado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objInventario->myException->getMensaje();
		}
	}else{
		$dep="entro a actualizar";
		/** INVENTARIO EXISTE**/
		$resultado=$objInventario->actualizar($id_inventario,$fecha_ingreso,$fecha_vencimiento,$cantidad,$precio_unitario,$stock_minimo,$descripcion,$unidad);
		if($objInventario->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Inventario Actualizado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objInventario->myException->getMensaje();
		}
	}
	
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"dep"=>$dep);
}
//****************************	FIN DEL GRABAR INVENTARIO		***********************************************//
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