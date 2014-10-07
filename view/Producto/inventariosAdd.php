<?php
session_start();
require_once("../../secureadmin.php");
if (isset($_REQUEST["id_inventario"])) {
  $id_inventario = $_REQUEST["id_inventario"];
} else {
  $id_inventario = "0";
}//accion
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Inventario</title>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="Edwin Guamán" name="author">
    <link rel="stylesheet" href="../../resources/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../../resources/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link href="../../resources/css/theme.css" rel="stylesheet" type="text/css"/>
    <link href="../../resources/css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <? require_once("../../header.php"); ?>
    <div class="container">
      <form class="form-horizontal" name="frmAdd" method="post" action="" id="frmAdd" >
        <fieldset>
          <legend><?= ($id_inventario == 0) ? " Agregar Producto" : "Editar Producto"; ?></legend>


          <input class="form-control" type="text" name="txtIdInventario" id="txtIdInventario" required value="<?= $id_inventario; ?>">

          <div class="form-group">
            <label class="col-md-4 control-label" for="txtDescripcion">Descripción:</label>
            <div class="col-md-4">                
              <input class="form-control" type="text" name="txtDescripcion" id="txtDescripcion" required data-msg-required="Ingrese el Nombre del Producto para el Inventario" placeholder="Nombre del Producto para Inventario" />
            </div>
          </div>        
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCantidad">Cantidad:</label>
            <div class="col-md-4">   
              <input class="form-control" type="text" name="txtCantidad" id="txtCantidad" required data-msg-required="Ingrese la Cantidad" placeholder="Cantidad" />
            </div>
          </div>        
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtPrecioUnitario">Precio Unitario:</label>
            <div class="col-md-4">        
              <input class="form-control" type="text" name="txtPrecioUnitario" id="txtPrecioUnitario" required data-msg-required="Ingrese el Precio del Producto" placeholder="Precio Unitario" />
            </div>
          </div>        
          <div class="form-group">      
            <label class="col-md-4 control-label" for="txtUnidad">Unidad de Medida:</label>
            <div class="col-md-4">
              <select class="form-control" id="txtUnidad" required data-msg-required="Seleccione una Unidad">
                <option value="">Seleccione...</option>
                <option value="Kilos">Kilos</option>
                <option value="Gramos">Gramos</option>
                <option value="Litros">Litros</option>
              </select>
            </div>
          </div>        
          <div class="form-group">      
            <label class="col-md-4 control-label" for="txtStockMinimo">Stock Mínimo: </label>
            <div class="col-md-4">                
              <input class="form-control" type="text" name="txtStockMinimo" id="txtStockMinimo" required data-msg-required="Ingrese el Stock Mínimo" placeholder="Stock Mínimo" />
            </div>
          </div>        
          <div class="form-group">      
            <label class="col-md-4 control-label" for="txtFechaIngreso">Fecha Ingreso:</label>
            <div class="col-md-4">              
              <input class="form-control" type="text" name="txtFechaIngreso" id="txtFechaIngreso" required data-msg-required="Ingrese Fecha Ingreso" placeholder="Fecha Ingreso" />
            </div>
          </div>        
          <div class="form-group">      
            <label class="col-md-4 control-label" for="txtFechaVencimiento">Fecha Vencimiento:</label>
            <div class="col-md-4">        
              <input class="form-control" type="text" name="txtFechaVencimiento" id="txtFechaVencimiento" required data-msg-required="Ingrese la Fecha de Vencimiento" placeholder="Fecha Vencimiento" />
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
        $("#txtFechaIngreso").datepicker();
        $("#txtFechaVencimiento").datepicker();
        function agregar() {
          $.ajax({
            type: "POST",
            url: "../../controller/inventariosController.php",
            data:
                    {
                      'accion': 'agregar',
                      'id_inventario': $("#txtIdInventario").val(),
                      'descripcion': $("#txtDescripcion").val(),
                      'cantidad': $("#txtCantidad").val(),
                      'precio_unitario': $("#txtPrecioUnitario").val(),
                      'fecha_ingreso': $("#txtFechaIngreso").val(),
                      'fecha_vencimiento': $("#txtFechaVencimiento").val(),
                      'stock_minimo': $("#txtStockMinimo").val(),
                      'unidad': $("#txtUnidad").val()
                    },
            success: function(e) {
              if (e[0].estado == "ok") {
                window.alert(e[0].mensaje);
                window.location = "inventariosList.php";
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
          window.location = "inventariosList.php";
        });

        function buscar() {
          $.ajax({
            type: "POST",
            url: "../../controller/inventariosController.php",
            data:
                    {
                      'accion': 'listar',
                      'id_inventario': $("#txtIdInventario").val()
                    },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#txtDescripcion").val(value.descripcion);
                    $("#txtPrecioUnitario").val(value.precio_unitario);
                    $("#txtFechaIngreso").val(value.fecha_ingreso);
                    $("#txtFechaVencimiento").val(value.fecha_vencimiento);
                    $("#txtCantidad").val(value.cantidad);
                    $("#txtStockMinimo").val(value.stock_minimo);
                    $("#txtUnidad option[value=" + value.unidad + "]").attr("selected", true);
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

        if ($("#txtIdInventario").val() !== "0") {
          buscar();
        }

      });
    </script>
  </body>
</html>