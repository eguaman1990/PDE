<?php

session_start();

require_once '../modelo/Recepcion.class.php';
require_once '../modelo/Solicitudes.class.php';
require_once '../modelo/Inventario.class.php';

$objRecepcion = new Recepcion();
$resultado = "";/** 	esta variable sera la encargada de ser mi resulset */
$respuesta = array();/** 	esta variable sera la encargada de dar la respuesta a la vista */
$estado = '';/** 	esta variable me dira si cada accion se ejecuto bin o de forma erronea (ESTADO=OK || ESTADO=ERROR) */
$mensaje = '';/** 	esta variabla contandra un mensaje dependiendo del estado en el que se encuentre */
$strsql = "";/** 	esta variable es la que envia a mi clase la query de mi where */
//$idUsuarioIngresa=$_SESSION["id_usuario"];/**	idUsuarioIngresa variable que la ocupo para guardar el usuario_ingresa o el usuario modifica segun correcponda**/
$fechaIngresa = date("Y-m-d H:i:s");/** 	fechaIngresa Variavle que me permite gustadar la fecha actual para poder definir fecha_ingresa o fecha_modifica segun corresponda* */
$campos = "";
$cor = 0;

if (isset($_REQUEST["accion"])) {
  $accion = $_REQUEST["accion"];
} else {
  $accion = "";
}

if (isset($_REQUEST["id_recepcion"])) {
  $id_recepcion = $_REQUEST["id_recepcion"];
} else {
  $id_recepcion = "";
}

if (isset($_REQUEST["id_solicitud"])) {
  $id_solicitud = $_REQUEST["id_solicitud"];
} else {
  $id_solicitud = "";
}

if (isset($_REQUEST["id_inventario"])) {
  $id_inventario= $_REQUEST["id_inventario"];
} else {
  $id_inventario= "";
}

if (isset($_REQUEST["descuento"])) {
  $descuento = $_REQUEST["descuento"];
} else {
  $descuento = "";
}

if (isset($_REQUEST["cantidad_recepcion"])) {
  $cantidad_recepcion = $_REQUEST["cantidad_recepcion"];
} else {
  $cantidad_recepcion = "";
}

if (isset($_REQUEST["estado_recepcion"])) {
  $estado_recepcion = $_REQUEST["estado_recepcion"];
} else {
  $estado_recepcion = "";
}

##################################################
//INICIO DEL LISTAR
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

  if ($id_recepcion != 0) {
    $strsql.=" and id_recepcion='" . $id_recepcion . "'";
  }
  if ($descuento != "") {
    $strsql.=" and descuento like '%" . $descuento . "%'";
  }

  $arr = array();

  $estado = "ok";
  $mensaje = "";
  $lngRecordCount = 0;
  $lngPageCount = 0;

  $rs = count($objRecepcion->listar($strsql));
  //entra al if en caso de que se pierda la conexion con la base de datos
  if ($objRecepcion->bd->myException->getEstado() == 1) {
    $estado = "error";
    $mensaje = $objRecepcion->myException->getMensaje();
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

      $campos = $objRecepcion->listar($strsql . " LIMIT " . $limite_inicio . ", " . $limite_final);
      if ($objRecepcion->myException->getEstado() == 1) {
        $estado = "error";
        $mensaje = $objRecepcion->myException->getMensaje();
      } else {
        $cor = $limite_inicio;
        $estado = "ok";
      }
    } else {
      $campos = "";
      $estado = "no";
      $mensaje = "<br /><div class='alert alert-danger'><strong>Lo Siento!</strong> No se encontraron Registros.</div>";
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
//FIN DEL LISTAR
##################################################
//INICIO DEL CREAR
if ($accion == "crear") {
  $res = $objRecepcion->buscar($id_recepcion);
  if ($res == 0) {
    /** 	USUARIO NO EXISTE* */
    $dep = "entro a ingresar";
    $resultado = $objRecepcion->crear($id_solicitud, $descuento, $cantidad_recepcion, $estado_recepcion);
    if ($objRecepcion->myException->getEstado() == 0) {
      $objSolicitudes = new Solicitudes();
      $objSolicitudes->actualizarEstado($id_solicitud);
      if ($objSolicitudes->myException->getEstado() == 0) {
        $objInventario = new Inventario();
        $res=$objInventario->actualizarCantidad($id_inventario, $cantidad_recepcion);
        if($objInventario->myException->getEstado() == 0){
          $estado = "ok";
          $mensaje = "Recepción Ingresado Exitosamente";
        }else{
          $estado = "error";
          $mensaje = $objInventario->myException->getMensaje();
        }
      } else {
        $estado = "error";
        $mensaje = $objSolicitudes->myException->getMensaje();
      }
    } else {
      $estado = "error";
      $mensaje = $objRecepcion->myException->getMensaje();
    }
  } else {
    $dep = "entro a actualizar";
    /** USUARIO EXISTE* */
    $resultado = $objRecepcion->actualizar($id_recepcion, $id_solicitud, $descuento, $cantidad_recepcion, $estado_recepcion);
    if ($objRecepcion->myException->getEstado() == 0) {
      $estado = "ok";
      $mensaje = "Recepción Actualizado Exitosamente";
    } else {
      $estado = "error";
      $mensaje = $objRecepcion->myException->getMensaje();
    }
  }

  $respuesta[] = array("estado" => $estado, "mensaje" => $mensaje, "dep" => $dep);
}
if ($accion == "eliminar") {
  $res = $objRecepcion->buscar($id_recepcion);
  if ($res != 0) {
    $dep = "entro a eliminar";
    $resultado = $objRecepcion->eliminar($id_recepcion);
    if ($objRecepcion->myException->getEstado() == 0) {
      $estado = "ok";
      $mensaje = "Recepcion Eliminado Exitosamente";
    } else {
      $estado = "error";
      $mensaje = $objRecepcion->myException->getMensaje();
    }
  } else {
    $estado = "error";
    $mensaje = $objRecepcion->myException->getMensaje();
  }
  $respuesta[] = array("estado" => $estado, "mensaje" => $mensaje);
}

//FIN DEL CREAR
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header("Content-type: application/json");
$respuesta = json_encode($respuesta);
echo $respuesta;
?>

