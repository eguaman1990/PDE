<?php

if(isset($_REQUEST["id_producto"])){
	$id_producto=$_REQUEST["id_producto"];
}else{
	$id_producto="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PDE - Productos</title>
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
  <h1><?=($id_producto==0)? " Agregar Producto": "Editar Producto"; ?></h1>
  	<form name="frmAdd" method="post" action="" id="frmAdd">

      <div class="oculta"><label for="txtIdProducto">id_producto</label>
      <input type="text" name="txtIdProducto" id="txtIdProducto" required value="<?=$id_producto;?>"></div>

    	<label for="txtSubCategoria">Subcategoria</label>
      <select name="txtSubCategoria" id="txtSubCategoria"></select>

      <label for="txtDescripcion">Descripción</label>
      <input type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese el Nombre del Producto" placeholder="Nombre del Producto" />

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
			//url:"http://eguamans.esy.es/controller/productosController.php",
			url:"../../controller/productosController.php",
			data:
			{
				'accion':'agregar',
				'id_producto':$("#txtIdProducto").val(),
				'descripcion':$("#txtDescripcion").val(),
				'id_subcategoria':$("#txtSubCategoria").val(),
				'precio_unitario':$("#txtPrecioUnitario").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="productosList.php";
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
		location.href="productosList.php";
	});
	
	function buscar(){
		$.ajax({
			type:"POST",
			url:"../../controller/productosController.php",
			data:
			{
				'accion':'listar',
				'id_producto':$("#txtIdProducto").val()
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
	
	if($("#txtIdProducto").val()!="0"){
		buscar();
	}
	
});
</script>
</body>
</html>