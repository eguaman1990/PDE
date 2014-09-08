<?php
session_start();
require_once("../../secureadmin.php");

if (isset($_REQUEST["id_categoria"])) {
  $id_categoria = $_REQUEST["id_categoria"];
} else {
  $id_categoria = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Categorías</title>
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
          <legend><?= ($id_categoria == 0) ? " Agregar Categoría" : "Editar Categoría"; ?></legend>
          <form name="frmAdd" id="frmAdd" method="post" action="">
            <div class="hidden"><label for="txtIdCategoria">id_categoria</label></div>
            <input type="hidden" name="txtIdCategoria" id="txtIdCategoria" required value="<?= $id_categoria; ?>">

            <div class="form-group">
              <label class="col-md-4 control-label" for="txtDescripcion">Descripción</label>
              <div class="col-md-4">  
                <input class="form-control" type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese una Categoría" placeholder="Categoría">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="btnAgregar"></label>
              <div class="col-md-8">
                <input type="submit" name="btnAceptar" id="btnAceptar" value="Aceptar" class="btn btn-success">
                <input type="button" name="btnCancelar" id="btnCancelar" value="Cancelar" class="btn btn-danger">
              </div>
            </div>
          </form>
        </fieldset>
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
            url: "../../controller/categoriaController.php",
            data:
                    {
                      'accion': 'agregar',
                      'id_categoria': $("#txtIdCategoria").val(),
                      'descripcion': $("#txtDescripcion").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                window.alert(e[0].mensaje);
                window.location = "categoriasList.php";
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

        function buscarCategoria() {
          $.ajax({
            type: "POST",
            url: "../../controller/categoriaController.php",
            data:
                    {
                      'accion': 'listar',
                      'id_categoria': $("#txtIdCategoria").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtDescripcion").val(value.descripcion);

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

        if ($("#txtIdCategoria").val() != "0") {
          buscarCategoria();
        }

        $("#btnCancelar").on("click", function() {
          location.href = "categoriasList.php";
        });

      });
    </script>
  </body>
</html>