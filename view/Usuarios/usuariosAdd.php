<?
session_start();
require_once("../../secureadmin.php");
require_once('../../modelo/Usuario.class.php');
	/*verifico si el usuario tiene acceso a la pagina*/
	/*if (Usuario::acceso($_SESSION["id_usuario"],$_SERVER['PHP_SELF'])==0){
		header ('location: acceso_denegado.php');
	}*/

if(isset($_REQUEST["id_usuario"])){
	$id_usuario=$_REQUEST["id_usuario"];
}else{
	$id_usuario="0";
}//accion

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PDE - Usuarios</title>
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
  <h1><?=($id_usuario==0)? " Agregar Usuario": "Editar Usuario"; ?></h1>
  <form name="frmAdd" id="frmAdd" method="post" action="">
			<div class="hidden">  	
      <label for="txtIdUsuario">Id_usuario</label>
      <input type="text" name="txtIdUsuario" id="txtIdUsuario" required value="<?=$id_usuario;?>">
    	</div>
      <label for="txtNombre">Nombre</label>
      <input type="text" name="txtNombre" id="txtNombre" required data-msg-required="Ingrese su Nombre" placeholder="Nombre">
    
      <label for="txtApellido">Apellidos</label>
      <input type="text" name="txtApellido" id="txtApellido" required data-msg-required="Ingrese un Apellido" placeholder="Apellido">
    
    	<label for="txtCargo">Cargo</label>
      <select name="txtCargo" id="txtCargo"></select>
    
      <label for="txtEdad">Edad</label>
      <input type="number" name="txtEdad" id="txtEdad" >
    
      <label for="txtDireccion">Dirección</label>
      <input type="text" name="txtDireccion" id="txtDireccion" required data-msg-required="Ingrese una Dirección" placeholder="Dirección">
    
      <label for="txtTelefono">Telefono</label>
      <input type="number" name="txtTelefono" id="txtTelefono" required data-msg-required="Ingrese un numero de telefono" placeholder="Teléfono">
    
      <label for="txtEmail">Email</label>
      <input type="email" name="txtEmail" id="txtEmail" data-rule-required="true" data-rule-email="true" data-msg-required="Por Favor ingrese un email" data-msg-email="Por Favor ingrese un Email Valido" placeholder="Email">
    
      <label for="txtUser">Nombre de Usuario</label>
      <input type="text" name="txtUser" id="txtUser" required placeholder="Nombre de Usuario" data-msg-required="Ingrese un Nombre de Usuario">
    
      <label for="txtPassword">Password</label>
      <input type="text" name="txtPassword" id="txtPassword" required placeholder="Password" data-msg-required="Ingrese una Password">
    <div class="buttons">
      <input type="submit" name="btnAceptar" id="btnAceptar" class="btn btn-success" value="Aceptar">
      <input type="button" name="btnCancelar" id="btnCancelar" class="btn btn-danger" value="Cancelar">
    </div>
  </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	listarCargos();
  function listarCargos(){
		$.ajax({
			type:"POST",
			url:"../../controller/cargosController.php",
			data:{
				"accion":"listar"
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							var option = $("<option>",{
								value:value.id_cargo,
								text:value.descripcion
							});
							$("#txtCargo").append($(option));
						});
					}else{
						var option= $("<option>",{
							value:"0",
							text:"No posee Cargos"
							});
						$("#txtCargo").append($(option));
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
			url:"../../controller/usuarioController.php",
			data:
			{
				'accion':'agregar',
				'nombre':$("#txtNombre").val(),
				'apellido':$("#txtApellido").val(),
				'edad':$("#txtEdad").val(),
				'direccion':$("#txtDireccion").val(),
				'email':$("#txtEmail").val(),
				'fono':$("#txtTelefono").val(),
				'user':$("#txtUser").val(),
				'id_usuario':$("#txtIdUsuario").val(),
				'clave':$("#txtPassword").val(),
				'id_cargo':$("#txtCargo").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					window.alert(e[0].mensaje);
					window.location="usuariosList.php";
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
	
	function buscarUsuario(){
		$.ajax({
			type:"POST",
			url:"../../controller/usuarioController.php",
			data:
			{
				'accion':'listar',
				'id_usuario':$("#txtIdUsuario").val()
			},
			success: function(e){
				if(e[0].estado=="ok"){
					if(e[0].campos.length>0){
						$.each(e[0].campos,function(key,value){
							$("#txtNombre").val(value.nombre);
							$("#txtApellido").val(value.apellido);
							$("#txtCargo").val(value.id_cargo);
							$("#txtEdad").val(value.edad);
							$("#txtDireccion").val(value.direccion);
							$("#txtEmail").val(value.email);
							$("#txtTelefono").val(value.telefono);
							$("#txtUser").val(value.user);
							$("#txtPassword").val("12345");
							$("#txtUser").attr("readonly","readonly");
							$("#txtUser").addClass("readonly");
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
	
	$("#btnCancelar").on("click",function(){
		location.href="usuariosList.php";
	});
	
	if($("#txtIdUsuario").val()!="0"){
		buscarUsuario();
	}
});
</script>
</body>
</html>