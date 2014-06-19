<?php
session_start();
require_once("../../secureadmin.php");
if(isset($_REQUEST["id_mesa"])){
	$id_mesa=$_REQUEST["id_mesa"];
}else{
	$id_mesa="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mesas</title>
<script src="../../resources/js/lib/jquery-1.9.1.js"></script>
<script src="../../resources/js/lib/jquery-ui.js"></script>
<script src="../../resources/js/lib/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="../../resources/css/default.css">
<link rel="stylesheet" type="text/css" href="../../resources/css/menu.css">

</head>

<body>
<? require_once("../../header.php"); ?>
<div class="contenido">
	<div class="contenido-box formulario">
  <h1><?=($id_mesa==0)? " Agregar Mesa": "Editar Mesa"; ?></h1>
  	<form name="frmAdd" method="post" action="" id="frmAdd">
  	  <div class="oculta">
        <label for="txtIdMesa">id_mesa</label>
        <input type="text" name="txtIdMesa" id="txtIdMesa" required value="<?=$id_mesa;?>">
      </div>
      
      <label for="txtNombreMesa">Nombre Mesa</label>
      <input type="text" name="txtNombreMesa" id="txtNombreMesa" required data-msg-required="Ingrese el Nombre de la Mesa" placeholder="Nombre de la Mesa" />
    
      <label for="txtPosicion">Posición</label>
      <input type="text" name="txtPosicion" id="txtPosicion" required data-msg-required="Ingrese el Número de la Posición" placeholder="Posición" />

      <div class="buttons">
        <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
        <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
      </div>
  	</form>
  <div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	
	function agregar(){
		$.ajax({
			type:"POST",
			url:"../../controller/mesasController.php",
			data:
			{
				'accion':'agregar',
				'id_mesa':$("#txtIdMesa").val(),
				'nombre_mesa':$("#txtNombreMesa").val(),
				'posicion':$("#txtPosicion").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="mesasList.php";
				}else{
					window.alert("Mensaje de Usuario: "+e[0].mensaje[0].user);
					window.alert("Mensaje de Administrador: "+e[0].mensaje[0].admin);
				}
			},
			failure:function(e){
				window.alert();
			}
		});
	}
	
	var v = jQuery("#frmAdd").validate({
		submitHandler: function(form) {
			agregar();
		}
	});
	
	function buscar(){
		$.ajax({
			type:"POST",
			url:"../../controller/mesasController.php",
			data:
			{
				'accion':'listar',
				'id_mesa':$("#txtIdMesa").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							$("#txtNombreMesa").val(value.nombre_mesa);
							$("#txtPosicion").val(value.posicion);
						});
					}
				}else{
					window.alert("Mensaje de Usuario: "+e[0].mensaje[0].user);
					window.alert("Mensaje de Administrador: "+e[0].mensaje[0].admin);
				}
			},
			failure:function(e){
				window.alert();
			}
		});	
	}
	
	if($("#txtIdMesa").val()!="0"){
		buscar();
	}
	
	$("#btnCancelar").on("click",function(){
		location.href="mesasList.php";
	});
	
});
</script>
</body>
</html>