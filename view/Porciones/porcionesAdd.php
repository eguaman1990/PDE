<?php
session_start();
require_once("../../secureadmin.php");
if(isset($_REQUEST["id_porcion"])){
	$id_porcion=$_REQUEST["id_porcion"];
}else{
	$id_porcion="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PDE - Porciones</title>
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
  <h1><?=($id_porcion==0)? " Agregar Porción": "Editar Porción"; ?></h1>
  	<form name="frmAdd" method="post" action="" id="frmAdd">

      <div class="oculta"><label for="txtIdPorcion">id_porcion</label>
      <input type="text" name="txtIdPorcion" id="txtIdPorcion" required value="<?=$id_porcion;?>"></div>

    	<label for="txtSubCategoria">Subcategoria</label>
      <select name="txtSubCategoria" id="txtSubCategoria"></select>

      <label for="txtDescripcion">Descripción</label>
      <input type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese el Nombre del Porción" placeholder="Nombre del Porción" />

      <label for="txtPrecioUnitario">Precio Unitario</label>
      <input type="text" name="txtPrecioUnitario" id="txtPrecioUnitario" required data-msg-required="Ingrese el Precio del Procuto" placeholder="Precio Unitario" />
      <div class="buttons">
        <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
        <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
      </div>
  	</form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	listarSubCategorias();
  function listarSubCategorias(){
		$.ajax({
			type:"GET",
			//url:"http://eguamans.esy.es/controller/SubcategoriasController.php",
			url:"../../controller/SubcategoriasController.php",
			data:{
				"accion":"listarCombo"
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							var option = $("<option>",{
								value:value.id_subcategoria,
								text:value.subca_descripcion
							});
							$("#txtSubCategoria").append($(option));
						});
					}else{
						var option= $("<option>",{
							value:"0",
							text:"No posee Subcategorias"
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
	
	function agregar(){
		$.ajax({
			type:"GET",
			//url:"http://eguamans.esy.es/controller/porcionesController.php",
			url:"../../controller/porcionesController.php",
			data:
			{
				'accion':'agregar',
				'id_porcion':$("#txtIdPorcion").val(),
				'descripcion':$("#txtDescripcion").val(),
				'id_subcategoria':$("#txtSubCategoria").val(),
				'precio_unitario':$("#txtPrecioUnitario").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="porcionesList.php";
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
	
	$("#btnCancelar").on("click",function(){
		location.href="porcionesList.php";
	});
	
	function buscar(){
		$.ajax({
			type:"POST",
			url:"../../controller/porcionesController.php",
			data:
			{
				'accion':'listar',
				'id_porcion':$("#txtIdPorcion").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							$("#txtDescripcion").val(value.pro_descripcion);
							$("#txtPrecioUnitario").val(value.pro_precio_unitario);
							$("#txtSubCategoria option[value="+ value.id_subcategoria +"]").attr("selected",true);
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
	
	if($("#txtIdPorcion").val()!="0"){
		buscar();
	}
	
});
</script>
</body>
</html>