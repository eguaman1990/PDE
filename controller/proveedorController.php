<?php
session_start();

require_once '../modelo/Proveedor.class.php';

$objProveedor = new Proveedor();
$resultado="";/**	esta variable sera la encargada de ser mi resulset*/
$respuesta=array();/**	esta variable sera la encargada de dar la respuesta a la vista */
$estado='';/**	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR)*/
$mensaje='';/**	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre*/
$strsql="";/**	esta variable es la que envia a mi clase la query de mi where*/
//$idUsuarioIngresa=$_SESSION["id_usuario"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa=date("Y-m-d H:i:s");/**	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda**/
$campos="";
$cor=0;

if(isset($_REQUEST["accion"])){
  $accion=$_REQUEST["accion"];
}else{
  $accion="";
}

if(isset($_REQUEST["id_proveedor"])){
  $id_proveedor=$_REQUEST["id_proveedor"];
}else{
  $id_proveedor="";
}

if(isset($_REQUEST["rut_proveedor"])){
  $rut_proveedor=$_REQUEST["rut_proveedor"];
}else{
  $rut_proveedor="";
}

if(isset($_REQUEST["nombre_proveedor"])){
  $nombre_proveedor=$_REQUEST["nombre_proveedor"];
}else{
  $nombre_proveedor="";
}

if(isset($_REQUEST["direccion"])){
  $direccion=$_REQUEST["direccion"];
}else{
  $direccion="";
}

if(isset($_REQUEST["telefono"])){
  $telefono=$_REQUEST["telefono"];
}else{
  $telefono="";
}

if(isset($_REQUEST["celular"])){
  $celular=$_REQUEST["celular"];
}else{
  $celular="";
}
if(isset($_REQUEST["email"])){
  $email=$_REQUEST["email"];
}else{
  $email="";
}
##################################################
//INICIO DEL LISTAR
if($accion=="listar"){
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
	
	if($id_proveedor!=0){
		$strsql.=" and id_proveedor='".$id_proveedor."'";
	}
	if($nombre_proveedor!=""){
			$strsql.=" and nombre_proveedor like '%".$nombre_proveedor."%'";
	}
	
	$arr=array();
				
	$estado="ok";
	$mensaje="";
	$lngRecordCount=0;
  $lngPageCount=0;
	
	$rs=count($objProveedor->listar($strsql));
	//entra al if en caso de que se pierda la conexion con la base de datos
	if ($objProveedor->bd->myException->getEstado()==1){
		$estado="error";
		$mensaje=$objProveedor->myException->getMensaje();
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
		
			$campos=$objProveedor->listar($strsql." LIMIT " . $limite_inicio . ", ". $limite_final);
			if ($objProveedor->myException->getEstado()==1){
				$estado="error";
				$mensaje=$objProveedor->myException->getMensaje();
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
//FIN DEL LISTAR
##################################################
//INICIO DEL CREAR
if($accion=="crear"){
  $res=$objProveedor->buscar($id_proveedor);
	if($res==0){
		/**	USUARIO NO EXISTE**/
		$dep="entro a ingresar";
		$resultado=$objProveedor->crear($rut_proveedor,$nombre_proveedor,$direccion,$telefono,$celular,$email);
		if($objProveedor->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Proveedor Ingresado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objProveedor->myException->getMensaje();
		}
	}else{
		$dep="entro a actualizar";
		/** USUARIO EXISTE**/
		$resultado=$objProveedor->actualizar($id_proveedor,$rut_proveedor,$nombre_proveedor,$direccion,$telefono,$celular,$email);
		if($objProveedor->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Proveedor Actualizado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objProveedor->myException->getMensaje();
		}
	}
	
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"dep"=>$dep);
}
if($accion=="eliminar"){
  $res=$objProveedor->buscar($id_proveedor);
	if($res!=0){
		$dep="entro a eliminar";
		$resultado=$objProveedor->eliminar($id_proveedor);
		if($objProveedor->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Proveedor Eliminado Exitosamente";
		}else{

			$estado="error";
			$mensaje=$objProveedor->myException->getMensaje();
		}
	}else{
		$estado="error";
		$mensaje=$objProveedor->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}

//FIN DEL CREAR
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header("Content-type: application/json");
$respuesta=json_encode($respuesta);
echo $respuesta;
?>
