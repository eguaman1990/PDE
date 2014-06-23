<?php
session_start();
require_once("../../secureadmin.php");
require_once('../../modelo/Usuario.class.php');
/* verifico si el usuario tiene acceso a la pagina */
/* if (Usuario::acceso($_SESSION["id_usuario"],$_SERVER['PHP_SELF'])==0){
  header ('location: acceso_denegado.php');
  } */

if (isset($_REQUEST["id_usuario"])) {
  $id_usuario = $_REQUEST["id_usuario"];
} else {
  $id_usuario = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Usuarios</title>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="Edwin Guamán" name="author">
    <link rel="stylesheet" href="../../resources/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../../resources/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link href="../../resources/css/theme.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <? require_once("../../header.php"); ?>
    <div class="container">
      <form class="form-horizontal" name="frmAdd" method="post" action="" id="frmAdd" >
        <fieldset>
          <!-- Form Name -->
          <legend><h1><?= ($id_usuario == 0) ? " Agregar Usuario" : "Editar Usuario"; ?></h1></legend>

          <div class="hidden">  	
            <label for="txtIdUsuario">Id_usuario</label>
            <input type="text" name="txtIdUsuario" id="txtIdUsuario" required value="<?= $id_usuario; ?>">
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="txtNombre">Nombre</label>
            <div class="col-md-4">
              <input class="form-control" type="text" name="txtNombre" id="txtNombre" required data-msg-required="Ingrese su Nombre" placeholder="Nombre">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtApellido">Apellidos</label>
            <div class="col-md-4">
              <input class="form-control" type="text" name="txtApellido" id="txtApellido" required data-msg-required="Ingrese un Apellido" placeholder="Apellido">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCargo">Cargo</label>
            <div class="col-md-4">
              <select class="form-control" name="txtCargo" id="txtCargo"></select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtEdad">Edad</label>
            <div class="col-md-4">
              <input class="form-control" type="number" name="txtEdad" id="txtEdad" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtDireccion">Dirección</label>
            <div class="col-md-4">
              <input class="form-control" type="text" name="txtDireccion" id="txtDireccion" required data-msg-required="Ingrese una Dirección" placeholder="Dirección">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtTelefono">Telefono</label>
            <div class="col-md-4">
              <input class="form-control" type="number" name="txtTelefono" id="txtTelefono" required data-msg-required="Ingrese un numero de telefono" placeholder="Teléfono">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtEmail">Email</label>
            <div class="col-md-4">
              <input class="form-control" type="email" name="txtEmail" id="txtEmail" data-rule-required="true" data-rule-email="true" data-msg-required="Por Favor ingrese un email" data-msg-email="Por Favor ingrese un Email Valido" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtUser">Nombre de Usuario</label>
            <div class="col-md-4">
              <input class="form-control" type="text" name="txtUser" id="txtUser" required placeholder="Nombre de Usuario" data-msg-required="Ingrese un Nombre de Usuario">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtPassword">Password</label>
            <div class="col-md-4">
              <input class="form-control" type="text" name="txtPassword" id="txtPassword" required placeholder="Password" data-msg-required="Ingrese una Password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="btnAgregar"></label>
            <div class="col-md-8">
              <input type="submit" name="btnAceptar" id="btnAceptar" class="btn btn-success" value="Aceptar">
              <input type="button" name="btnCancelar" id="btnCancelar" class="btn btn-danger" value="Cancelar">
            </div>
          </div>
        </fieldset>
      </form>
    </div>

    <script src="../../resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../../resources/js/lib/jquery-ui.js" type="text/javascript"></script>
    <script src="../../resources/js/lib/jquery.validate.js" type="text/javascript"></script>
    <script src="../../resources/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(e) {
        listarCargos();
        function listarCargos() {
          $.ajax({
            type: "POST",
            url: "../../controller/cargosController.php", data: {
              "accion": "listar"
            },
            success: function(e) {
              if (e[0].estado == "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    var option = $("<option>", {
                      value: value.id_cargo,
                      text: value.descripcion
                    });
                    $("#txtCargo").append($(option));
                  });
                } else {
                  var option = $("<option>", {
                    value: "0",
                    text: "No posee Cargos"
                  });
                  $("#txtCargo").append($(option));
                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            failure: function(e) {
              window.alert();
            }
          });
        }

        function agregar() {
          $.ajax({
            type: "POST",
            url: "../../controller/usuarioController.php",
            data:
                    {
                      'accion': 'agregar',
                      'nombre': $("#txtNombre").val(),
                      'apellido': $("#txtApellido").val(),
                      'edad': $("#txtEdad").val(),
                      'direccion': $("#txtDireccion").val(),
                      'email': $("#txtEmail").val(),
                      'fono': $("#txtTelefono").val(),
                      'user': $("#txtUser").val(),
                      'id_usuario': $("#txtIdUsuario").val(),
                      'clave': $("#txtPassword").val(),
                      'id_cargo': $("#txtCargo").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                window.alert(e[0].mensaje);
                window.location = "usuariosList.php";
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            failure: function(e) {
              window.alert();
            }
          });
        }
        var v = jQuery("#frmAdd").validate({
          submitHandler: function(form) {
            agregar();
          }
        });

        function buscarUsuario() {
          $.ajax({
            type: "POST",
            url: "../../controller/usuarioController.php",
            data:
                    {
                      'accion': 'listar',
                      'id_usuario': $("#txtIdUsuario").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtNombre").val(value.nombre);
                    $("#txtApellido").val(value.apellido);
                    $("#txtCargo").val(value.id_cargo);
                    $("#txtEdad").val(value.edad);
                    $("#txtDireccion").val(value.direccion);
                    $("#txtEmail").val(value.email);
                    $("#txtTelefono").val(value.telefono);
                    $("#txtUser").val(value.user);
                    $("#txtPassword").val("12345");
                    $("#txtUser").attr("readonly", "readonly");
                    $("#txtUser").addClass("readonly");
                  });
                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            failure: function(e) {
              window.alert();
            }
          });
        }

        $("#btnCancelar").on("click", function() {
          location.href = "usuariosList.php";
        });

        if ($("#txtIdUsuario").val() != "0") {
          buscarUsuario();
        }
      });
    </script>
  </body>
</html>