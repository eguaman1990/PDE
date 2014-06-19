<?php
session_start();
require_once("../../secureadmin.php");

if(isset($_REQUEST["id_categoria"])){
	$id_categoria=$_REQUEST["id_categoria"];
}else{
	$id_categoria="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PDE - Categorías</title>
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
    <h1><?=($id_categoria==0)? " Agregar Categoría": "Editar Categoría"; ?></h1>
  	<form name="frmAdd" id="frmAdd" method="post" action="">
      <div class="oculta"><label for="txtIdCategoria">id_categoria</label></div>
      <input type="hidden" name="txtIdCategoria" id="txtIdCategoria" required value="<?=$id_categoria;?>">
    
      <label for="txtDescripcion">Descripción</label>
      <input type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese una Categoría" placeholder="Categoría">
    	<div class="buttons">
        <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
        <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
	    </div>
  </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	
	function agregar(){
		$.ajax({
			type:"POST",
			url:"../../controller/categoriaController.php",
			data:
			{
				'accion':'agregar',
				'id_categoria':$("#txtIdCategoria").val(),
				'descripcion':$("#txtDescripcion").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="categoriasList.php";
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
	
	function buscarCategoria(){
		$.ajax({
			type:"POST",
			url:"../../controller/categoriaController.php",
			data:
			{
				'accion':'listar',
				'id_categoria':$("#txtIdCategoria").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							$("#txtDescripcion").val(value.descripcion);
							
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
	
	if($("#txtIdCategoria").val()!="0"){
		buscarCategoria();
	}
	
	$("#btnCancelar").on("click",function(){
		location.href="categoriasList.php";
	});
	
});
</script>
</body>
</html>