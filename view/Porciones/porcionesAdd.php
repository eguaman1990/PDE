<?php
session_start();
require_once("../../secureadmin.php");
if (isset($_REQUEST["id_porcion"])) {
  $id_porcion = $_REQUEST["id_porcion"];
} else {
  $id_porcion = "0";
}//accion
if (isset($_REQUEST["id_producto"])) {
  $id_producto = $_REQUEST["id_producto"];
} else {
  $id_producto = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Porciones</title>
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
          <legend><?= $id_porcion == 0 ? " Agregar Porción" : "Editar Porción"; ?></legend>
          <div class="hidden">
            <input type="text" name="txtIdPorcion" id="txtIdPorcion"  value="<?=$id_porcion; ?>" />
            <input type="text" name="txtIdProducto" id="txtIdProducto"  value="<?=$id_producto; ?>" />
            </div>
          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtProducto">Producto</label>
            <div class="col-md-4">
              <select id="txtProducto" name="txtProducto" class="form-control" required data-msg-required="Seleccione un Producto">
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtPorcion">Porcion</label>  
            <div class="col-md-4">
              <input id="txtPorcion" name="txtPorcion" type="text" placeholder="Ingrese Porción" 
                     class="form-control input-md" required data-msg-required="Ingrese el tamaño de la Porción">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtUnidadMedida">Unidad Medida</label>
            <div class="col-md-4">
              <select id="txtUnidadMedida" name="txtUnidadMedida" class="form-control" required data-msg-required="Seleccione una Unidad de Medida">
                <option value="">Seleccione...</option>
                <option value="Gramos">Gramos</option>
                <option value="Litros">Litros</option>
                <option value="Kilos">Kilos</option>
                <option value="Mililitros">Mililitros</option>
              </select>
            </div>
          </div>

          <!-- Button (Double) -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="btnAgregar"></label>
            <div class="col-md-8">
              <button id="btnAgregar" name="btnAgregar" class="btn btn-success" type="submit">Aceptar</button>
              <button id="btnCancelar" name="btnCancelar" class="btn btn-danger" type="button">Cancelar</button>
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
        listarProductos();
        function listarProductos() {
          $.ajax({
            type: "GET",
            url: "../../controller/inventariosController.php",
            data: {
              "accion": "listarTodosProductos"
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    var option = $("<option>", {
                      value: value.id_inventario,
                      text: value.descripcion
                    });
                    $("#txtProducto").append($(option));
                  });
                } else {
                  var option = $("<option>", {
                    value: "0",
                    text: "No posee Subcategorias"
                  });
                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            error: function(e) {
              window.alert(e);
            }
          });
        }

        function agregar() {
          $.ajax({
            type: "GET",
            //url:"http://eguamans.esy.es/controller/porcionesController.php",
            url: "../../controller/porcionesController.php",
            data: {
              'accion': 'agregar',
              'id_inventario': $("#txtIdProducto").val(),
              'id_producto': $("#txtProducto").val(),
              'porcion': $("#txtPorcion").val(),
              'unidadMedida': $("#txtUnidadMedida").val(),
              'id_porcion':$("#txtIdPorcion").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                window.alert(e[0].mensaje);
                window.location = "porcionesDetalleList.php?id_producto="+$("#txtIdProducto").val();
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            error: function(e) {
              window.alert(e);
            }
          });
        }

        var v = jQuery("#frmAdd").validate({
          submitHandler: function(form) {
            agregar();
          }
        });

        $("#btnCancelar").on("click", function() {
          location.href = "porcionesDetalleList.php?id_producto="+$("#txtIdProducto").val();
        });

        function buscar() {
          $.ajax({
            type: "POST",
            url: "../../controller/porcionesController.php",
            data: {
              'accion': 'listar',
              'id_porcion': $("#txtIdPorcion").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtPorcion").val(value.porc_porcion);
                    $("#txtUnidadMedida option[value=" + value.porc_unidad + "]").attr("selected", true);
                    $("#txtProducto option[value=" + value.id_inventario + "]").attr("selected", true);
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

        if ($("#txtIdPorcion").val() !== "0" && $("#txtIdProducto").val() !== "0") {
          buscar();
        }

      });
    </script>
  </body>
</html>