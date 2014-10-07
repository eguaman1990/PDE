<?php
session_start();
require_once("../../secureadmin.php");
require_once('../../modelo/Usuario.class.php');
/* verifico si el usuario tiene acceso a la pagina */
/* if (Usuario::acceso($_SESSION["id_usuario"],$_SERVER['PHP_SELF'])==0){
  header ('location: acceso_denegado.php');
  } */

if (isset($_REQUEST["id_proveedor"])) {
  $id_proveedor = $_REQUEST["id_proveedor"];
} else {
  $id_proveedor = "0";
}//accion
?>
<html>
  <head>
    <title>PDE - Proveedor</title>
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
      <form class="form-horizontal"  name="frmAdd" method="post" action="" id="frmAdd" >
        <fieldset>

          <!-- Form Name -->
          <legend>Prooveedor</legend>

          <div class="form-group">
            <label class="col-md-4 control-label" for="txtIdProveedor">Id_proveedor</label>  
            <div class="col-md-5">
              <input id="txtIdProveedor" name="txtIdProveedor" type="text" class="form-control input-md" required="" value="<?= $id_proveedor ?>">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtRut">RUT</label>  
            <div class="col-md-5">
              <input id="txtRut" name="txtRut" type="text" placeholder="12.234.567-8" class="form-control input-md" required="">

            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtNombre">Nombre Proveedor</label>  
            <div class="col-md-5">
              <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre Proveedor" class="form-control input-md" required="">

            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtDireccion">Dirección</label>  
            <div class="col-md-5">
              <input id="txtDireccion" name="txtDireccion" type="text" placeholder="Ingrese una Dirección" class="form-control input-md" required="">

            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCelular">Celular</label>  
            <div class="col-md-5">
              <input id="txtCelular" name="txtCelular" type="text" placeholder="Ingrese un celular" class="form-control input-md">

            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtTelefono">Teléfono</label>  
            <div class="col-md-5">
              <input id="txtTelefono" name="txtTelefono" type="text" placeholder="Ingrese un teléfono" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtEmail">Email</label>  
            <div class="col-md-5">
              <input id="txtEmail" name="txtEmail" type="email" placeholder="example@example555.com" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Button (Double) -->
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
        function agregar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/proveedorController.php",
            data: {
              'accion': 'crear',
              'id_proveedor': $("#txtIdProveedor").val(),
              'rut_proveedor': $("#txtRut").val(),
              'nombre_proveedor': $("#txtNombre").val(),
              'direccion': $("#txtDireccion").val(),
              'telefono': $("#txtTelefono").val(),
              'celular': $("#txtCelular").val(),
              'email': $("#txtEmail").val()
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                window.alert(data[0].mensaje);
                window.location = "proveedoresList.php";
              } else {
                window.alert("Mensaje de Usuario: " + data[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + data[0].mensaje[0].admin);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              window.alert(textStatus);
            }
          });
        }

        function buscar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/proveedorController.php",
            data: {
              'accion': 'listar',
              'id_proveedor': $("#txtIdProveedor").val()
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                $.each(data[0].campos, function(key, value) {
                  $("#txtRut").val(value.rut_proveedor);
                  $("#txtNombre").val(value.nombre_proveedor);
                  $("#txtDireccion").val(value.direccion);
                  $("#txtTelefono").val(value.telefono);
                  $("#txtCelular").val(value.celular);
                  $("#txtEmail").val(value.email);
                });
              } else {
                window.alert("Mensaje de Usuario: " + data[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + data[0].mensaje[0].admin);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              window.alert(textStatus);
            }
          });
        }

        var v = jQuery("#frmAdd").validate({
          submitHandler: function(form) {
            agregar();
          }
        });

        $("#btnCancelar").on("click", function() {
          location.href = "proveedoresList.php";
        });

        if ($("#txtIdProveedor").val() !== "0") {
          buscar();
        }
      });
    </script>
  </body>
</html>
