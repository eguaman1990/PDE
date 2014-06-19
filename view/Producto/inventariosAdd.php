<?php
session_start();
require_once("../../secureadmin.php");
if(isset($_REQUEST["id_inventario"])){
	$id_inventario=$_REQUEST["id_inventario"];
}else{
	$id_inventario="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PDE - Inventario</title>
<script src="../../resources/js/lib/jquery-1.9.1.js"></script>
<script src="../../resources/js/lib/jquery-ui.js"></script>
<script src="../../resources/js/lib/jquery.validate.js"></script>
<link rel="stylesheet" type="text/css" href="../../resources/css/default.css">
<link rel="stylesheet" type="text/css" href="../../resources/css/menu.css">
<link rel="stylesheet" type="text/css" href="../../resources/css/jquery-ui-1.10.4.custom.min.css">
</head>

<body>
<? require_once("../../header.php"); ?>
<div class="contenido">
	<div class="contenido-box formulario">
  <h1><?=($id_inventario==0)? " Agregar Inventario": "Editar Inventario"; ?></h1>
  	<form name="frmAdd" method="post" action="" id="frmAdd">

			<div class="oculta">
	      <label for="txtIdInventario">id_inventario</label>
  	    <input type="text" name="txtIdInventario" id="txtIdInventario" required value="<?=$id_inventario;?>">
      </div>

    	<label for="txtDescripcion">Descripción</label>
			<input type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese el Nombre del Producto para el Inventario" placeholder="Nombre del Producto para Inventario" />

      <label for="txtCantidad">Cantidad</label>
      <input type="text" name="txtCantidad" id="txtCantidad" required data-msg-required="Ingrese la Cantidad" placeholder="Cantidad" />
      
      <label for="txtPrecioUnitario">Precio Unitario</label>
      <input type="text" name="txtPrecioUnitario" id="txtPrecioUnitario" required data-msg-required="Ingrese el Precio del Producto" placeholder="Precio Unitario" />
      
      <label for="txtUnidad">Unidad de Medida</label>
      <select id="txtUnidad" required data-msg-required="Seleccione una Unidad">
      	<option value="">Seleccione...</option>
        <option value="Kilos">Kilos</option>
        <option value="Gramos">Gramos</option>
        <option value="Litros">Litros</option>
      </select>
      
      <label for="txtStockMinimo">Stock Mínimo</label>
      <input type="text" name="txtStockMinimo" id="txtStockMinimo" required data-msg-required="Ingrese el Stock Mínimo" placeholder="Stock Mínimo" />
      
      <label for="txtFechaIngreso">Fecha Ingreso</label>
      <input type="text" name="txtFechaIngreso" id="txtFechaIngreso" required data-msg-required="Ingrese Fecha Ingreso" placeholder="Fecha Ingreso" />
      
      <label for="txtFechaVencimiento">Fecha Vencimiento</label>
      <input type="text" name="txtFechaVencimiento" id="txtFechaVencimiento" required data-msg-required="Ingrese la Fecha de Vencimiento" placeholder="Fecha Vencimiento" />

      
      <div class="buttons">
        <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
        <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
      </div>
  	</form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	$( "#txtFechaIngreso" ).datepicker();
	$( "#txtFechaVencimiento" ).datepicker();
	function agregar(){
		$.ajax({
			type:"POST",
			url:"../../controller/inventariosController.php",
			data:
			{
				'accion':'agregar',
				'id_inventario':$("#txtIdInventario").val(),
				'descripcion':$("#txtDescripcion").val(),
				'cantidad':$("#txtCantidad").val(),
				'precio_unitario':$("#txtPrecioUnitario").val(),
				'fecha_ingreso':$("#txtFechaIngreso").val(),
				'fecha_vencimiento':$("#txtFechaVencimiento").val(),
				'stock_minimo':$("#txtStockMinimo").val(),
				'unidad':$("#txtUnidad").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="inventariosList.php";
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
	
	$("#btnAgregar").on("click",function(){
		window.location="inventariosList.php";
	});
	
	function buscar(){
		$.ajax({
			type:"POST",
			url:"../../controller/inventariosController.php",
			data:
			{
				'accion':'listar',
				'id_inventario':$("#txtIdInventario").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							$("#txtDescripcion").val(value.descripcion);
							$("#txtPrecioUnitario").val(value.precio_unitario);
							$("#txtFechaIngreso").val(value.fecha_ingreso);
							$("#txtFechaVencimiento").val(value.fecha_vencimiento);
							$("#txtCantidad").val(value.cantidad);
							$("#txtStockMinimo").val(value.stock_minimo);
							$("#txtUnidad option[value="+ value.unidad +"]").attr("selected",true);
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
	
	if($("#txtIdInventario").val()!="0"){
		buscar();
	}
	
});
</script>
</body>
</html>