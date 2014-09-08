<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PDE - Inventario de Productos</title>
<script src="../../resources/js/lib/jquery-1.9.1.js"></script>
<script src="../../resources/js/lib/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../../resources/css/default.css">
<link rel="stylesheet" type="text/css" href="../../resources/css/menu.css">
<script type="text/javascript">
function avance_pagina($pag){//para cuando hayan varios registros
	//es el boton de pag 2,3,4,etc;
	
	document.getElementById("pag").value=$pag;
	document.form1.btnBuscar.click();//este es el nombre del formulario...
	document.getElementById("pag").value=1;
} 
$(document).ready(function(e) {
	listar();
  function listar(){
		$.ajax({
			type:"POST",
			url:"../../controller/inventariosController.php",
			data:
			{
				'accion':'listar',
				'nombre':$("#txtNombre").val(),
				'pag':$("#pag").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$(".lista").empty();
						$(".paginador").empty();
						var tabla = $("<table>",{
							id:'tabla',
							class:'tabla'
						});
						var thead =$("<thead>");
						var tr =$("<tr>");
						var th = $("<th>",{text:"Nro"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Producto"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Cantidad"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Medida"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Fecha Ingreso"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Fecha Vencimiento"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Stock Mímino"});
						$(tr).append($(th));
						var th = $("<th>",{text:"Acciones"});
						$(tr).append($(th));
						
						$(thead).append($(tr));
						$(tabla).append($(thead));

						$.each(e[0].campos,function(key,value){
							var tr= document.createElement("tr");
							var td = $("<td>",{
								text:value.id_inventario
							});
							$(tr).append($(td));
							var td = $("<td>",{
								text:value.descripcion
							});
							$(tr).append($(td));
							var td = $("<td>",{
								text:value.cantidad
							});
							$(tr).append($(td));
							var td = $("<td>",{
								text:value.unidad
							});
							$(tr).append($(td));
							var td = $("<td>",{
								text:value.fecha_ingreso
							});
							$(tr).append($(td));
							var td = $("<td>",{
								text:value.fecha_vencimiento
							});
							$(tr).append($(td));
							var td = $("<td>",{
								text:value.stock_minimo
							});
							$(tr).append($(td));
							
							var button =$("<a>",{
								href:"inventariosAdd.php?id_inventario="+value.id_inventario,
								name:"btnEditar",
								id:"btnEditar"
							});
							$(button).addClass("btn btn-edit");
							/*var btnDelete =$("<a>",{
								href:"#",
								name:"btnDelete",
								id:"btnDelete"+value.id_inventario,
								click:function(){
									var rs= window.confirm("Desea Eliminar esta Producto del Inventario?");								
									if(rs==true){
										eliminar(value.id_inventario);
									}
								}
							});
							
							
							$(btnDelete).addClass("btn btn-delete");*/
							var td = $("<td>",{
								text:""
							});
							$(td).append($(button));
							//$(td).append($(btnDelete));
							$(tr).append($(td));

							$(tabla).append(tr);	
						});
						$(".lista").append($(tabla));
						$(".paginador").append(e[0].paginador);
					}else{
						$(".lista").html("No existen Productos En nuestro Inventario")
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
	
	$("#btnBuscar").on("click",function(){
		listar();
	});
	
	$("#btnAgregar").on("click",function(){
		window.location="inventariosAdd.php";
	});
	
	function eliminar(id_inventario){
		$.ajax({
			type:"POST",
			url:"../../controller/inventariosController.php",
			data:
			{
				'accion':'eliminar',
				'id_inventario':id_inventario
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
	
});
</script>
</head>

<body>
<? require_once("../../header.php"); ?>
<div class="contenido">
  
  <div class="buscador">
    <form id="form1" name="form1" method="post" action="">
  	  <input id="pag" type="hidden" value="1">
    	<h1>Inventario de Productos</h1>
      <label for="txtNombre">Ingrese Nombre del Producto que desea buscar</label>
      <input type="text" name="txtNombre" id="txtNombre" />
	  	<div class="buttons">
        <input type="button" name="btnBuscar" id="btnBuscar" value="Buscar" class="btn btn-primary" />
        <input type="button" name="btnAgregar" id="btnAgregar" value="Agregar" class="btn btn-warning"/>
			</div>
    </form>
  </div>
	<div class="lista"></div>
  <div class="paginador"></div>
</div>
</body>
</html>
