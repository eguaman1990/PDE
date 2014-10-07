<?php
session_start();
require_once("../../secureadmin.php");
if (isset($_REQUEST["id_subcategoria"])) {
  $id_subcategoria = $_REQUEST["id_subcategoria"];
} else {
  $id_subcategoria = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>PDE - SubCategorias</title>
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
          <legend><?= ($id_subcategoria == 0) ? " Agregar SubCategoría" : "Editar SubCategoría"; ?></legend>

          <input class="form-control" type="hidden" name="txtIdSubcategoria" id="txtIdSubcategoria" required value="<?= $id_subcategoria; ?>">
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCategoria">Categoría</label>
            <div class="col-md-4"> 
              <select class="form-control" name="txtCategoria" id="txtCategoria"></select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="txtDescripcion">Descripción</label>
            <div class="col-md-4">  
              <input class="form-control" type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese una SubCategoría" placeholder="SubCategoría"/>
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
        listarCategorias();
        function listarCategorias() {
          $.ajax({
            type: "POST",
            url: "../../controller/categoriaController.php",
            data: {
              "accion": "listarCombo"
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    var option = $("<option>", {
                      value: value.id_categoria,
                      text: value.descripcion
                    });
                    $("#txtCategoria").append($(option));
                  });
                } else {
                  var option = $("<option>", {
                    value: "0",
                    text: "No posee Categorias"
                  });
                  $("#txtCategoria").append($(option));
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
            url: "../../controller/subcategoriasController.php",
            data: {
              'accion': 'agregar',
              'id_subcategoria': $("#txtIdSubcategoria").val(),
              'descripcion': $("#txtDescripcion").val(),
              'id_categoria': $("#txtCategoria").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                window.alert(e[0].mensaje);
                window.location = "subcategoriasList.php";
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
            url: "../../controller/subcategoriasController.php",
            data: {
              'accion': 'listar',
              'id_subcategoria': $("#txtIdSubcategoria").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtCategoria option[value=" + value.id_categoria + "]").attr("selected", true);
                    $("#txtDescripcion").val(value.subca_descripcion);
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

        if ($("#txtIdSubcategoria").val() != "0") {
          buscar();
        }

        $("#btnCancelar").on("click", function() {
          location.href = "subcategoriasList.php";
        });
      });
    </script>
  </body>
</html>