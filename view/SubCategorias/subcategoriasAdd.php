<?php
session_start();
require_once("../../secureadmin.php");
if(isset($_REQUEST["id_subcategoria"])){
	$id_subcategoria=$_REQUEST["id_subcategoria"];
}else{
	$id_subcategoria="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PDE - SubCategorias</title>
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
    <h1><?=($id_subcategoria==0)? " Agregar SubCategoría": "Editar SubCategoría"; ?></h1>
	  <form name="frmAdd" method="post" action="" id="frmAdd">
  
      <div class="oculta"><label for="txtIdSubcategoria">id_subcategoria</label></div>
      <input type="hidden" name="txtIdSubcategoria" id="txtIdSubcategoria" required value="<?=$id_subcategoria;?>">
  
    	<label for="txtCategoria">Categoría</label>
      <select name="txtCategoria" id="txtCategoria"></select>
  
      <label for="txtDescripcion">Descripción</label>
      <input type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese una SubCategoría" placeholder="SubCategoría"/>
  	<div class="buttons">
      <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
      <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
  	</div>
  </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	listarCategorias();
  function listarCategorias(){
		$.ajax({
			type:"POST",
			url:"../../controller/categoriaController.php",
			data:{
				"accion":"listarCombo"
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							var option = $("<option>",{
								value:value.id_categoria,
								text:value.descripcion
							});
							$("#txtCategoria").append($(option));
						});
					}else{
						var option= $("<option>",{
							value:"0",
							text:"No posee Categorias"
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
			type:"POST",
			url:"../../controller/subcategoriasController.php",
			data:
			{
				'accion':'agregar',
				'id_subcategoria':$("#txtIdSubcategoria").val(),
				'descripcion':$("#txtDescripcion").val(),
				'id_categoria':$("#txtCategoria").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="subcategoriasList.php";
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
			url:"../../controller/subcategoriasController.php",
			data:
			{
				'accion':'listar',
				'id_subcategoria':$("#txtIdSubcategoria").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){							
							$("#txtCategoria option[value="+ value.id_categoria +"]").attr("selected",true);
							$("#txtDescripcion").val(value.subca_descripcion);						
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
	
	if($("#txtIdSubcategoria").val()!="0"){
		buscar();
	}
	
	$("#btnCancelar").on("click",function(){
		location.href="subcategoriasList.php";
	});
});
</script>
</body>
</html>