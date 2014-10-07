<?php
session_start();
///CONTROLADOR USUARIO
//****************************	INICIO CLASES REQUERIDAS	****************************************//
//session_start();/*Se inicia la Session para que pueda tomar las variables de session*/
require_once ("../modelo/Usuario.class.php");
require_once ("../modelo/Cargo.class.php");
require_once ("../modelo/Utilidades.class.php");
require_once ("../modelo/Configuracion.class.php");
//****************************	FIN CLASES REQUERIDAS		******************************************//
####################################################################################################
//****************************	INICIO VARIABLES GLOBALES	****************************************//
$objUser = new Usuario();/*Instancia de un objeto de mi clase usuario*/
$resultado="";/**	esta variable sera la encargada de ser mi resulset*/
$respuesta=array();/**	esta variable sera la encargada de dar la respuesta a la vista */
$estado='';/**	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR)*/
$mensaje='';/**	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre*/
$strsql="";/**	esta variable es la que envia a mi clase la query de mi where*/
//$idUsuarioIngresa=$_SESSION["id_usuario"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa=date("Y-m-d H:i:s");/**	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda**/
$campos="";
$cor=0;

//****************************	FIN VALIABLES GLOBALES	******************************************//
####################################################################################################
//****************************	INICIO DE TODOS MIS REQUEST	**************************************//
if(isset($_REQUEST["accion"])){
	$accion=$_REQUEST["accion"];
}else{
	$accion="";
}//accion

if(isset($_REQUEST["id_usuario"])){
	$id_usuario=$_REQUEST["id_usuario"];
}else{
	$id_usuario="";
}//id_usuario

if(isset($_REQUEST["nombre"])){
	$nombre=$_REQUEST["nombre"];
}else{
	$nombre="";
}//nombre

if(isset($_REQUEST["apellido"])){
	$apellido=$_REQUEST["apellido"];
}else{
	$apellido="";
}//apellido

if(isset($_REQUEST["edad"])){
	$edad=$_REQUEST["edad"];
}else{
	$edad="";
}//edad

if(isset($_REQUEST["direccion"])){
	$direccion=$_REQUEST["direccion"];
}else{
	$direccion="";
}//direccion

if(isset($_REQUEST["email"])){
	$email=$_REQUEST["email"];
}else{
	$email="";
}//email

if(isset($_REQUEST["fono"])){
	$fono=$_REQUEST["fono"];
}else{
	$fono="";
}//fono

if(isset($_REQUEST["user"])){
	$user=$_REQUEST["user"];
}else{
	$user="";
}//user

if(isset($_REQUEST["password"])){
	$pass=$_REQUEST["password"];
}else{
	$pass="";
}//pass

if(isset($_REQUEST["clave"])){
	$clave=$_REQUEST["clave"];
}else{
	$clave="";
}//clave

if(isset($_REQUEST["id_cargo"])){
	$id_cargo=$_REQUEST["id_cargo"];
}else{
	$id_cargo="0";
}//id_cargo

//****************************	FIN DE TODOS MIS REQUEST	****************************************//
####################################################################################################
//****************************	INICIO DEL LOGIN	************************************************//
if($accion=="login"){
	$resultado=$objUser->login($id_usuario,$pass);
	if($objUser->myException->getEstado()==0){
		foreach($resultado as $rs){
			$_SESSION["id_usuario"] = $rs["id_usuario"];
			$_SESSION["nombre"] 	= $rs["nombre"];
			$_SESSION["titulo"]		= Configuracion::$titulo;
			$_SESSION["cargo"]= $rs["cargo"];
			$_SESSION["id_cargo"]= $rs["id_cargo"];
		}
		$estado="ok";
		$mensaje="el valor del id de mi usuario es: ".$_SESSION["id_usuario"];
	}else{
		$estado="error";			 
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado,"mensaje"=>$mensaje);
}//fin del login 
//****************************	FIN DEL LOGIN 	**************************************************//
####################################################################################################
//****************************	INICIO DEL LISTAR	USUARIOS************************************************//
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
	
	if($id_usuario!=0){
		$strsql.=" and u.ID_USUARIO='".$id_usuario."'";
	}
	if($nombre!=""){
    $strsql.=" and u.US_NOMBRE like '%".$nombre."%'";
	}
	
	$arr=array();
				
	$estado="ok";
	$mensaje="";
	$lngRecordCount=0;
  $lngPageCount=0;
	
	$rs=count($objUser->listar($strsql));
	//entra al if en caso de que se pierda la conexion con la base de datos
	if ($objUser->bd->myException->getEstado()==1){
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
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
		
			$campos=$objUser->listar($strsql." LIMIT " . $limite_inicio . ", ". $limite_final);
			if ($objUser->myException->getEstado()==1){
				$estado="error";
				$mensaje=$objUser->myException->getMensaje();
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
//****************************	FIN DEL LISTAR 	USUARIOS**************************************************//
############################################################################################################
//****************************	INICIO DEL AGREGAR USUARIO		*********************************************//
if ($accion=="agregar"){
	$res=$objUser->buscar($id_usuario);
	if($res==0){
		/**	USUARIO NO EXISTE**/
		$dep="entro a ingresar";
		$resultado=$objUser->crear($id_cargo,$user,$clave,$nombre,$apellido,$edad,$direccion,$fono,$email);
		if($objUser->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Usuario Ingresado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objUser->myException->getMensaje();
		}
	}else{
		$dep="entro a actualizar";
		/** USUARIO EXISTE**/
		$resultado=$objUser->actualizar($id_usuario,$id_cargo,$user,$clave,$nombre,$apellido,$edad,$direccion,$fono,$email);
		if($objUser->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Usuario Actualizado Exitosamente";
		}else{
			$estado="error";
			$mensaje=$objUser->myException->getMensaje();
		}
	}
	
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"dep"=>$dep);
}
//****************************	FIN DEL GRABAR USUARIO		***********************************************//
###########################################################################################################
//****************************	INICIO ELIMINAR USUARIO		***********************************************//
if($accion=="eliminar"){
	$res=$objUser->buscar($id_usuario);
	if($res!=0){
		
		$resultado=$objUser->eliminar($id_usuario);
		if($objUser->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Usuario Eliminado Exitosamente";
		}else{

			$estado="error";
			$mensaje=$objUser->myException->getMensaje();
		}
	}else{
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}
//****************************	FIN DEL ELIMINAR USUARIO		*********************************************//
###########################################################################################################
//****************************	INICIO DEL RECORDAR CONTRASEÑA	*****************************************//
if($accion=="recordar"){
	$asunto="PDE - Recuperación de contraseña";
	$rs=$objUser->buscarEmail($email);
	if($objUser->myException->getEstado()==0){
		if(count($resultado)>0){
			$nombre=$rs["nombre"];
			$clave=$rs["clave"];
			$para=array(array("email"=>$rs["email"],"nombre"=>$rs["nombre"]));
			$email=$rs["email"];
			$cuerpo=file_get_contents(Configuracion::$plantilla_recordar_contrasena);
			$cuerpo=str_replace("@nombre_usuario",$nombre,$cuerpo);
			$cuerpo=str_replace("@correo",$email,$cuerpo);
			$cuerpo=str_replace("@pwd",$clave,$cuerpo);
			$res=Utilidades::enviar_correo($para,array(),$asunto,$cuerpo);
			if($res=="ok"){
				$estado="ok";
				$mensaje="La contraseña se a enviado exisotamente al mail ingresado";
			}else{
				$objUser->myException->setEstado(1);
				$objUser->myException->addError(array("admin"=>$res." ".ERROR_RECORDAR));
				$estado="error";
				$mensaje="ERROR AL ENVIAR CORREO CONTACTESE CON SU ADMINISTRADOR DE SISTEMA";
			}			
		}else{
			$estado="no";
			$mensaje="¡La dirección de correo no esta registrada, intente nuevamente!";
		}
	}else{
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado,"mensaje"=>$mensaje);
}
//****************************	FIN DEL RECORDAR CONTRASEÑA		*******************************************//
###########################################################################################################
//****************************	INICIO DEL ACTUALIZAR PERFIL USUARIO	***********************************//
if ($accion=="actualizar_perfil"){
		$resultado=$objUser->actualizarPerfil($id_usuario,$clave,$nombre,$email,$fono,$codigo_area,$fono2,$codigo_area2,$regional,$tema,$idUsuarioIngresa,$fechaIngresa);
		if($objUser->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Usuario Actualizado Exitosamente";
			Usuario::bitacora($idUsuarioIngresa,"Update Perfil",UPDATE_PERFIL);
		}else{
			$estado="error";
			$mensaje=$objUser->myException->getMensaje();
		}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}
//****************************	FIN DEL ACTUALIZAR PERFIL USUARIO	***************************************//
###########################################################################################################
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////	CONTROL DE ACCESOS	///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************	INICIO DEL MARCAR TODOS LOS ACCESOS		***********************************//
if($accion=='marcar_todos'){
	$rst=$objUser->borrarTodosAccesos($id_usuario);
	if($objUser->myException->getEstado()==0){
		$rst=$objUser->marcarTodosAccesos($id_usuario);
		if($objUser->myException->getEstado()==0){
			$estado="ok";
			$mensaje="Accesos asignados exitosamente";
		}else{
			$estado="error";
			$mensaje=$objUser->myException->getMensaje();
		}
	}else{
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}
//****************************	FIN DEL MARCAR TODOS LOS ACCESOS	***************************************//
###########################################################################################################
//****************************	INICIO DEL MARCAR NINGUN ACCESO		***************************************//
if($accion=='marcar_ninguno'){
	$rst=$objUser->borrarTodosAccesos($id_usuario);
	if($objUser->myException->getEstado()==0){
		$estado="ok";
		$mensaje="Perfil sin Accesos";
	}else{
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje);
}
//****************************	FIN DEL MARCAR NINGUN ACCESOS		*****************************************//
###########################################################################################################
//****************************	INICIO DEL MOSTRAR MENU *************************************************//
if($accion=='mostrar_menu'){
	$campos=$objUser->obtenerMenu();
	if($objUser->myException->getEstado()==0){
		$estado="ok";
		$mensaje="Obtuve Menu";
	}else{
		$campos=array();
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"campos"=>$campos);
}
//****************************	FIN DEL MOSTRAR MENU	***************************************************//
###########################################################################################################
//****************************	INICIO DEL MOSTRAR TITULO		*********************************************//
if($accion=='mostrar_titulo'){
	$campos=$objUser->obtenerTitulo(utf8_decode($menu));
	if($objUser->myException->getEstado()==0){
		$estado="ok";
		$mensaje="Perfil Titulos";
	}else{
		$campos=array();
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"campos"=>$campos);
}
//****************************	FIN DEL MOSTRAR TITULO	***************************************************//
###########################################################################################################
//****************************	INICIO DEL QUITAR ACCESO	***********************************************//
if($accion=='quitar_acceso'){
	$res=$objUser->quitarPermiso($id_usuario,$id_opcion);
	if($objUser->myException->getEstado()==0){
		$estado="ok";
		$mensaje="Permiso Eliminado";
	}else{
		$res=0;
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"res"=>$res);
}
//****************************	FIN DEL QUITAR ACCESO	***************************************************//
###########################################################################################################
//****************************	INICIO DEL AGREGAR ACCESOS		*******************************************//
if($accion=='agregar_acceso'){
	$res=$objUser->agregarPermiso($id_usuario,$id_opcion);
	if($objUser->myException->getEstado()==0){
		$estado="ok";
		$mensaje="Permiso Agregado";
	}else{
		$res=0;
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"res"=>$res);
}
//****************************	FIN DEL AGREGAR ACCESOS	*************************************************//
###########################################################################################################
//****************************	INICIO DEL SELECCIONAR PERMISOS	*****************************************//
if($accion=='seleccionar_permisos'){
	$campos=$objUser->seleccionarPermisos($id_usuario);
	if($objUser->myException->getEstado()==0){
		$estado="ok";
		$mensaje="Permisos Seleccionados";
	}else{
		$campos=array();
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta[]=array("estado"=>$estado, "mensaje"=>$mensaje,"campos"=>$campos);	
}
//****************************	FIN DE SELECCIONAR PERMISOS	*********************************************//
###########################################################################################################
###########################################################################################################
//****************************	INICIO DEL ACTUALIZA RUT USUARIO	****************************************//
if($accion=="cambia_ rut_usuario"){
	$num=$objUser->actualizaRutUsuario($id_usuario,$siniestro,$imagen);
	if($objUser->myException->getEstado()==0){
		if($num==1){
			$estado = "ok";
			$mensaje = "Rut cambiado";
		}else{
			$estado = "ok";
			$mensaje = "No se pudo cambiar el rut";
		}
	}else{
		$estado="error";
		$mensaje=$objUser->myException->getMensaje();
	}
	$respuesta=array("estado"=>$estado, "mensaje"=>$mensaje);	
}
//****************************	FIN DE ACTUALIZAR RUT USUARIO	*******************************************//
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