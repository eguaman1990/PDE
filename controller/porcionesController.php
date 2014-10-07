<?php
session_start();
///CONTROLADOR PORCION
//****************************	INICIO CLASES REQUERIDAS	****************************************//
//session_start();/*Se inicia la Session para que pueda tomar las variables de session*/
require_once ("../modelo/Porcion.class.php");
require_once ("../modelo/Configuracion.class.php"); 
//****************************	FIN CLASES REQUERIDAS		******************************************//
####################################################################################################
//****************************	INICIO VARIABLES GLOBALES	****************************************//
$objPorcion = new Porcion();/*Instancia de un objeto de mi clase usuario*/
$resultado="";/**	esta variable sera la encargada de ser mi resulset*/
$respuesta=array();/**	esta variable sera la encargada de dar la respuesta a la vista */
$estado='';/**	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR)*/
$mensaje='';/**	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre*/
$strsql="";/**	esta variable es la que envia a mi clase la query de mi where*/
//$idUsuarioIngresa=$_SESSION["id_porcion"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa=date("Y-m-d H:i:s");/**	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda**/
$campos = "";
$lngPageCount = 0;
$lngPageCount = 0;
$cor = 0;
$lngRecordCount=0;
//****************************	FIN VALIABLES GLOBALES	******************************************//
####################################################################################################
//****************************	INICIO DE TODOS MIS REQUEST	**************************************//
if(isset($_REQUEST["accion"])){
	$accion=$_REQUEST["accion"];
}else{
	$accion="";
}//accion

if(isset($_REQUEST["id_porcion"])){
	$id_porcion=$_REQUEST["id_porcion"];
}else{
	$id_porcion="";
}//id_porcion

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

if(isset($_REQUEST["porcion"])){
	$porcion=$_REQUEST["porcion"];
}else{
	$porcion="";
}//porcion

if(isset($_REQUEST["unidadMedida"])){
  $unidadMedida=$_REQUEST["unidadMedida"];
}else{
  $unidadMedida="";
}

####################################################################################################
//****************************	INICIO DEL LISTAR	PORCION************************************************//
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
	
	if($id_porcion!=""){
		$strsql.=" and por.id_porcion='".$id_porcion."'";
	}
  
  if($id_producto!=""){
    $strsql.=" and pro.id_producto='".$id_producto."'";
  }
  
  if($id_inventario!=""){
    $strsql.=" and por.id_inventario='".$id_inventario."'";
  }
  
	
	$arr=array();
				
	$estado="ok";
	$mensaje="";
		
	$rs=count($objPorcion->listar($strsql));
	//entra al if en caso de que se pierda la conexion con la base de datos
	if ($objPorcion->bd->myException->getEstado()==1){
		$estado="error";
		$mensaje=$objPorcion->myException->getMensaje();
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
		
			$campos=$objPorcion->listar($strsql." LIMIT " . $limite_inicio . ", ". $limite_final);
			if ($objPorcion->myException->getEstado()==1){
				$estado="error";
				$mensaje=$objPorcion->myException->getMensaje();
			}else{
				$cor=$limite_inicio;
				$estado="ok";
			}
		}else{
			$campos="";
			$estado="no";
      $mensaje="<br /><div class='alert alert-danger'><strong>Lo Siento!</strong> No se encontraron Registros.</div>";
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
//****************************	FIN DEL LISTAR 	PORCION**************************************************//
############################################################################################################
//****************************	INICIO DEL AGREGAR PORCION		*********************************************//
if ($accion=="agregar"){
	$res=$objPorcion->buscar($id_porcion);
	if($res==0){
		/**	PORCION NO EXISTE**/
		$dep="entro a ingresar";
		$resultado=$objPorcion->crear($id_producto, $id_inventario,$porcion,$unidadMedida);
		if($objPorcion->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Porcion Ingresado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objPorcion->myException->getMensaje();
		}
	}else{
		$dep="entro a actualizar";
		/** PORCION EXISTE**/
		$resultado=$objPorcion->actualizar($id_porcion,$id_producto,$id_inventario,$porcion,$unidadMedida);
		if($objPorcion->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Porcion Actualizado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objPorcion->myException->getMensaje();
		}
	}
	
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"dep"=>$dep);
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