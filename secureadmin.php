<?php
	if(!isset($_SESSION['id_usuario'])){
 	 session_start();
	}
  header("Expires: Thu, 01 Jan 2004 00:00:01 GMT");              // Fecha en el pasado
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Siempre modificado
  header("Cache-Control: no-cache, must-revalidate");            // HTTP/1.1
  header("Pragma: no-cache");                                  

  if ((!isset($_SESSION['id_usuario']))) {
  	  $archivo="securearea.php";
	  $i=0;
	  while(!file_exists($archivo)){
	  	  $i=$i+1;
	  	  $archivo="../".$archivo;
		  if ($i>5){
			  die ("Error de Aplicación Interna no se puede encontrar archivo de seguridad.");
			  exit;
		  }
	  }
	  
      header("location: $archivo");
      exit;
  }else{
	  require_once("modelo/Usuario.class.php");
	  $user=new Usuario();
	  $res=$user->buscar($_SESSION["id_usuario"]);
	  if ($res==0){
	  	  $archivo="securearea.php";
		  header("location: $archivo");
	  }	

  }
?>
