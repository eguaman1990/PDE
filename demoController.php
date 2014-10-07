<?php

require_once './modelo/BD.class.php';

$bd = new BD();

$res = $bd->select("select * from usuarios", array());
while ($rs = $res->fetch()) {
  $campos[] = array(
      "id_usuario" => utf8_encode($rs["ID_USUARIO"]),
      "user" => utf8_encode($rs["US_USER"]),
      "nombre" => utf8_encode($rs["US_NOMBRE"]),
      "apellido" => utf8_encode($rs["US_APELLIDO"]),
  );
}

$respuesta=$campos;
//$respuesta="Hola Yo me llamo ".$_POST["nombre"]." ".$_POST["apellido"];

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
header("Content-type: application/json");
$respuesta = json_encode($respuesta);
echo $respuesta;
?>
