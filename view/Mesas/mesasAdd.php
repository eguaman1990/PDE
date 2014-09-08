<?php
session_start();
require_once("../../secureadmin.php");
if (isset($_REQUEST["id_mesa"])) {
  $id_mesa = $_REQUEST["id_mesa"];
} else {
  $id_mesa = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>Mesas</title>
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
          <legend><?= ($id_mesa == 0) ? " Agregar Mesa" : "Editar Mesa"; ?></legend>

          <div class="hidden">
            <label for="txtIdMesa">id_mesa</label>
            <input type="text" name="txtIdMesa" id="txtIdMesa" required value="<?= $id_mesa; ?>">
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="txtNombreMesa">Nombre Mesa</label>
            <div class="col-md-4"> 
              <input type="text" class="form-control" name="txtNombreMesa" id="txtNombreMesa" required data-msg-required="Ingrese el Nombre de la Mesa" placeholder="Nombre de la Mesa" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtPosicion">Posición</label>
            <div class="col-md-4"> 
              <input type="text" class="form-control" name="txtPosicion" id="txtPosicion" required data-msg-required="Ingrese el Número de la Posición" placeholder="Posición" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="btnAgregar"></label>
            <div class="col-md-8">
              <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
              <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
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
            type: "POST",
            url: "../../controller/mesasController.php",
            data:
                    {
                      'accion': 'agregar',
                      'id_mesa': $("#txtIdMesa").val(),
                      'nombre_mesa': $("#txtNombreMesa").val(),
                      'posicion': $("#txtPosicion").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                window.alert(e[0].mensaje);
                window.location = "mesasList.php";
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

        function buscar() {
          $.ajax({
            type: "POST",
            url: "../../controller/mesasController.php",
            data:
                    {
                      'accion': 'listar',
                      'id_mesa': $("#txtIdMesa").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtNombreMesa").val(value.nombre_mesa);
                    $("#txtPosicion").val(value.posicion);
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

        if ($("#txtIdMesa").val() != "0") {
          buscar();
        }

        $("#btnCancelar").on("click", function() {
          location.href = "mesasList.php";
        });

      });
    </script>
  </body>
</html>