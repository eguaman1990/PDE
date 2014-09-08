<?php

session_start();
///CONTROLADOR USUARIO
//****************************	INICIO CLASES REQUERIDAS	****************************************//
//session_start();/*Se inicia la Session para que pueda tomar las variables de session*/
require_once ("../modelo/Mesa.class.php");
require_once ("../modelo/Configuracion.class.php");
//****************************	FIN CLASES REQUERIDAS		******************************************//
####################################################################################################
//****************************	INICIO VARIABLES GLOBALES	****************************************//
$objMesa = new Mesa(); /* Instancia de un objeto de mi clase usuario */
$resultado = "";/** 	esta variable sera la encargada de ser mi resulset */
$respuesta = array();/** 	esta variable sera la encargada de dar la respuesta a la vista */
$estado = '';/** 	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR) */
$mensaje = '';/** 	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre */
$strsql = "";/** 	esta variable es la que envia a mi clase la query de mi where */
//$idUsuarioIngresa=$_SESSION["id_mesa"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa = date("Y-m-d H:i:s");/** 	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda* */
$campos = "";
$lngPageCount = 0;
$lngPageCount = 0;
$cor = 0;
//****************************	FIN VALIABLES GLOBALES	******************************************//
####################################################################################################
//****************************	INICIO DE TODOS MIS REQUEST	**************************************//
if (isset($_REQUEST["accion"])) {
  $accion = $_REQUEST["accion"];
} else {
  $accion = "";
}//accion

if (isset($_REQUEST["id_mesa"])) {
  $id_mesa = $_REQUEST["id_mesa"];
} else {
  $id_mesa = "";
}//id_mesa

if (isset($_REQUEST["nombre_mesa"])) {
  $nombre_mesa = $_REQUEST["nombre_mesa"];
} else {
  $nombre_mesa = "";
}//nombre_mesa

if (isset($_REQUEST["posicion"])) {
  $posicion = $_REQUEST["posicion"];
} else {
  $posicion = "";
}//posicion
####################################################################################################
//****************************	INICIO DEL LISTAR	MESAS	******************************************//
if ($accion == "listar") {
  $paginador = "";
  $posicion = "";
  $respuesta = array();

  if (isset($_POST["pag"])) {
    $lngPageCurrent = $_POST["pag"];
  } else {
    if (isset($_GET["pag"])) {
      $lngPageCurrent = $_GET["pag"];
    } else {
      $lngPageCurrent = 1;
    }
  }//RECIBIMOS EL NUMERO DE LA PAGINA PARA CONTROLARLO CON EL PAGINADOR 

  if ($id_mesa != "") {
    $strsql.=" and id_mesa='" . $id_mesa . "'";
  }

  if ($nombre_mesa != "") {
    $strsql.=" and me_nombre_mesa like'%" . $nombre_mesa . "%'";
  }

  $arr = array();

  $estado = "ok";
  $mensaje = "";

  $rs = count($objMesa->listar($strsql));
  //entra al if en caso de que se pierda la conexion con la base de datos
  if ($objMesa->bd->myException->getEstado() == 1) {
    $estado = "error";
    $mensaje = $objMesa->myException->getMensaje();
  } else {
    /* echo "ENTRO AL PAGINADOR"; */
    $lngRecordCount = $rs;
    if ($lngRecordCount > 0) {
      $lngPageCount = ceil($lngRecordCount / Configuracion::$MAXREGSPERPAGE);
      if ($lngPageCurrent > $lngPageCount) {
        $lngPageCurrent = $lngPageCount;
      }
      if ($lngPageCurrent < 1) {
        $lngPageCurrent = 1;
      }
      $limite_inicio = Configuracion::$MAXREGSPERPAGE * ($lngPageCurrent - 1);
      $limite_final = Configuracion::$MAXREGSPERPAGE;
      //echo "listar($sqlend,$arr,$limite_inicio,$limite_final);";

      $campos = $objMesa->listar($strsql . " LIMIT " . $limite_inicio . ", " . $limite_final);
      if ($objMesa->myException->getEstado() == 1) {
        $estado = "error";
        $mensaje = $objMesa->myException->getMensaje();
      } else {
        $cor = $limite_inicio;
        $estado = "ok";
      }
    } else {
      $campos = "";
      $estado = "no";
      $mensaje="<br /><div class='alert alert-danger'><strong>Lo Siento!</strong> No se encontraron Mesas.</div>";
    }
  }
  $paginador = "";
  $posicion = "";
  $respuesta = array();

  /* echo "retorna datos"; */
  $paginador = Utilidades::subNavPaginacion($lngPageCurrent, $lngPageCount);
  $posicion = utf8_encode("<div align =\"center\">" . $lngRecordCount . " Registros encontrados. Mostrando p&aacute;gina " . $lngPageCurrent . " de " . $lngPageCount . "</div>");
  $respuesta[] = array("estado" => $estado, "mensaje" => $mensaje, "campos" => $campos, "cor" => $cor, "paginador" => $paginador, "posicion" => $posicion);
}
//****************************	FIN DEL LISTAR 	MESAS 	**************************************************//
############################################################################################################
//****************************	INICIO DEL AGREGAR MESA		*********************************************//
if ($accion == "agregar") {
  $res = $objMesa->buscar($id_mesa);
  if ($res == 0) {
    /** 	USUARIO NO EXISTE* */
    $dep = "entro a ingresar";
    $resultado = $objMesa->crear($nombre_mesa, $posicion);
    if ($objMesa->myException->getEstado() == 0) {
      $estado = "ok";
      $mensaje = "Mesa Ingresado Exitosamente";
    } else {
      $estado = "error";
      $mensaje = $objMesa->myException->getMensaje();
    }
  } else {
    $dep = "entro a actualizar";
    /** USUARIO EXISTE* */
    $resultado = $objMesa->actualizar($id_mesa, $nombre_mesa, $posicion);
    if ($objMesa->myException->getEstado() == 0) {
      $estado = "ok";
      $mensaje = "Mesa Actualizado Exitosamente";
    } else {
      $estado = "error";
      $mensaje = $objMesa->myException->getMensaje();
    }
  }

  $respuesta[] = array("estado" => $estado, "mensaje" => $mensaje, "dep" => $dep);
}
//****************************	FIN DEL GRABAR MESA		***********************************************//
###########################################################################################################
###########################################################################################################
//****************************	INICIO ELIMINAR MESA		***********************************************//
if ($accion == "eliminar") {
  $res = $objMesa->buscar($id_mesa);
  if ($res != 0) {
    $dep = "entro a eliminar";
    $resultado = $objMesa->eliminar($id_mesa);
    if ($objMesa->myException->getEstado() == 0) {

      $estado = "ok";
      $mensaje = "Mesa Eliminada Exitosamente";
    } else {

      $estado = "error";
      $mensaje = $objMesa->myException->getMensaje();
    }
  } else {
    $estado = "error";
    $mensaje = $objMesa->myException->getMensaje();
  }
  $respuesta[] = array("estado" => $estado, "mensaje" => $mensaje);
}
//****************************	FIN DEL ELIMINAR MESA	*********************************************//
###########################################################################################################
###########################################################################################################
###########################################################################################################
###########################################################################################################
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header("Content-type: application/json");
$respuesta = json_encode($respuesta);
echo $respuesta;
?>