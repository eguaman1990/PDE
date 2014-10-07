<?php
session_start();
require_once("../../secureadmin.php");
if (isset($_REQUEST["id_producto"])) {
  $id_producto = $_REQUEST["id_producto"];
} else {
  $id_producto = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Platos</title>
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
          <legend><?= ($id_producto == 0) ? " Agregar Plato" : "Editar Plato"; ?></legend>

          <div class="hidden"><label for="txtIdPlato">id_producto</label>
            <input type="text" name="txtIdPlato" id="txtIdPlato" required value="<?= $id_producto; ?>">
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="txtSubCategoria">Subcategoria</label>
            <div class="col-md-4"> 
              <select name="txtSubCategoria" id="txtSubCategoria" class="form-control"></select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtNombre">Nombre</label>
            <div class="col-md-4"> 
              <input type="text" name="txtNombre" id="txtNombre" class="form-control" required data-msg-required="Ingrese el Nombre del Plato" placeholder="Nombre del Plato" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtDescripcion">Descripción</label>
            <div class="col-md-4"> 
              <input type="text" name="txtDescripcion" id="txtDescripcion" class="form-control" required data-msg-required="Ingrese la Descripción del Plato" placeholder="Descripción del Plato" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtPrecioUnitario">Precio Unitario</label>
            <div class="col-md-4"> 
              <input type="text" name="txtPrecioUnitario" id="txtPrecioUnitario" class="form-control" required data-msg-required="Ingrese el Precio del Producto" placeholder="Precio Unitario" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtPorciones">Porciones por Plato</label>
            <div class="col-md-4"> 
              <input type="text" name="txtPorciones" id="txtPorciones" class="form-control" required data-msg-required="Ingrese la Porción" placeholder="Cantidad de Porciones" />
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
        listarSubCategorias();
        function listarSubCategorias() {
          $.ajax({
            type: "GET",
            //url:"http://eguamans.esy.es/controller/SubcategoriasController.php",
            url: "../../controller/SubcategoriasController.php",
            data: {
              "accion": "listarCombo"
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    var option = $("<option>", {
                      value: value.id_subcategoria,
                      text: value.subca_descripcion
                    });
                    $("#txtSubCategoria").append($(option));
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
            failure: function(e) {
              window.alert();
            }
          });
        }

        function agregar() {
          $.ajax({
            type: "GET",
            url: "../../controller/productosController.php",
            data: {
              'accion': 'agregar',
              'id_producto': $("#txtIdPlato").val(),
              'nombre': $("#txtNombre").val(),
              'descripcion': $("#txtDescripcion").val(),
              'id_subcategoria': $("#txtSubCategoria").val(),
              'precio_unitario': $("#txtPrecioUnitario").val(),
              'porciones':$("#txtPorciones").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                window.alert(e[0].mensaje);
                window.location = "productosList.php";
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

        $("#btnCancelar").on("click", function() {
          location.href = "platosList.php";
        });

        function buscar() {
          $.ajax({
            type: "POST",
            url: "../../controller/productosController.php",
            data:
                    {
                      'accion': 'listar',
                      'id_producto': $("#txtIdPlato").val()
                    },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtDescripcion").val(value.pro_descripcion);
                    $("#txtPrecioUnitario").val(value.pro_precio_unitario);
                    $("#txtSubCategoria option[value=" + value.id_subcategoria + "]").attr("selected", true);
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

        if ($("#txtIdPlato").val() !== "0") {
          buscar();
        }

      });
    </script>
  </body>
</html>