<?php
session_start();
///CONTROLADOR PRODUCTO
//****************************	INICIO CLASES REQUERIDAS	****************************************//
//session_start();/*Se inicia la Session para que pueda tomar las variables de session*/
require_once ("../modelo/Producto.class.php");
require_once ("../modelo/Configuracion.class.php"); 
//****************************	FIN CLASES REQUERIDAS		******************************************//
####################################################################################################
//****************************	INICIO VARIABLES GLOBALES	****************************************//
$objProducto = new Producto();/*Instancia de un objeto de mi clase usuario*/
$resultado="";/**	esta variable sera la encargada de ser mi resulset*/
$respuesta=array();/**	esta variable sera la encargada de dar la respuesta a la vista */
$estado='';/**	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR)*/
$mensaje='';/**	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre*/
$strsql="";/**	esta variable es la que envia a mi clase la query de mi where*/
//$idUsuarioIngresa=$_SESSION["id_producto"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa=date("Y-m-d H:i:s");/**	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda**/
//****************************	FIN VALIABLES GLOBALES	******************************************//
####################################################################################################
//****************************	INICIO DE TODOS MIS REQUEST	**************************************//
if(isset($_REQUEST["accion"])){
	$accion=$_REQUEST["accion"];
}else{
	$accion="";
}//accion

if(isset($_REQUEST["id_producto"])){
	$id_producto=$_REQUEST["id_producto"];
}else{
	$id_producto="";
}//id_producto

if(isset($_REQUEST["id_subcategoria"])){
	$id_subcategoria=$_REQUEST["id_subcategoria"];
}else{
	$id_subcategoria="";
}//id_subcategoria

if(isset($_REQUEST["descripcion"])){
	$descripcion=$_REQUEST["descripcion"];
}else{
	$descripcion="";
}//descripcion

if(isset($_REQUEST["precio_unitario"])){
	$precio_unitario=$_REQUEST["precio_unitario"];
}else{
	$precio_unitario="";
}//precio_unitario

####################################################################################################
//****************************	INICIO DEL LISTAR	PRODUCTO************************************************//
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
	
	if($id_producto!=""){
		$strsql.=" and p.id_producto='".$id_producto."'";
	}
  
  if($descripcion!=""){
		$strsql.=" and p.pro_descripcion like '%".$descripcion."%'";
	}
	
	$arr=array();
				
	$estado="ok";
	$mensaje="";
		
	$rs=count($objProducto->listar($strsql));
	//entra al if en caso de que se pierda la conexion con la base de datos
	if ($objProducto->bd->myException->getEstado()==1){
		$estado="error";
		$mensaje=$objProducto->myException->getMensaje();
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
		
			$campos=$objProducto->listar($strsql." LIMIT " . $limite_inicio . ", ". $limite_final);
			if ($objProducto->myException->getEstado()==1){
				$estado="error";
				$mensaje=$objProducto->myException->getMensaje();
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
//****************************	FIN DEL LISTAR 	PRODUCTO**************************************************//
############################################################################################################
//****************************	INICIO DEL AGREGAR PRODUCTO		*********************************************//
if ($accion=="agregar"){
	$res=$objProducto->buscar($id_producto);
	if($res==0){
		/**	PRODUCTO NO EXISTE**/
		$dep="entro a ingresar";
		$resultado=$objProducto->crear($id_subcategoria, $descripcion,$precio_unitario);
		if($objProducto->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Producto Ingresado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objProducto->myException->getMensaje();
		}
	}else{
		$dep="entro a actualizar";
		/** PRODUCTO EXISTE**/
		$resultado=$objProducto->actualizar($id_producto,$id_subcategoria,$descripcion,$precio_unitario);
		if($objProducto->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Producto Actualizado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objProducto->myException->getMensaje();
		}
	}
	
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"dep"=>$dep);
}
//****************************	FIN DEL GRABAR PRODUCTO		***********************************************//
###########################################################################################################
###########################################################################################################
//****************************	INICIO ELIMINAR PRODUCTO	***********************************************//
if($accion=="eliminar"){
	$res=$objProducto->buscar($id_producto);
	if($res!=0){
		$dep="entro a eliminar";
		$resultado=$objProducto->eliminar($id_producto);
		if($objProducto->myException->getEstado()==0){

			$estado="ok";
			$mensaje="Producto Eliminado Exitosamente";
		}else{

			$estado="error";
			$mensaje=$objProducto->myException->getMensaje();
		}
	}else{
		$estado="error";
		$mensaje=$objProducto->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}
//****************************	FIN DEL ELIMINAR PRODUCTO		*********************************************//
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