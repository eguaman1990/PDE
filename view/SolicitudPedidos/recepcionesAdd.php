<?php
session_start();
require_once("../../secureadmin.php");

if (isset($_REQUEST["id_solicitud"])) {
  $id_solicitud = $_REQUEST["id_solicitud"];
} else {
  $id_solicitud = "0";
}//accion
?>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PDE - Recepción</title>
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
    <?php require_once '../../header.php'; ?>
    <div class="container">
      <form class="form-horizontal" name="frmAdd" method="post" action="" id="frmAdd" >
        <fieldset>

          <!-- Form Name -->
          <legend>Recepciones</legend>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtIdSolicitud">N° Solicitud </label>  
            <div class="col-md-4">
              <input id="txtIdSolicitud" name="txtIdSolicitud" readonly="readonly" 
                     type="text" placeholder="" class="form-control input-md" required=""
                     value="<?= $id_solicitud; ?>">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtProveedor">Proveedor</label>  
            <div class="col-md-4">
              <input id="txtProveedor" name="txtProveedor" readonly="readonly" type="text" placeholder="" 
                     class="form-control input-md">

            </div>
          </div>

           <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtIdInventario">Producto</label>  
            <div class="col-md-4">
              <input id="txtIdInventario" name="txtIdInventario" readonly="readonly" type="text" placeholder="" 
                     class="form-control input-md" required="">

            </div>
          </div>
          
          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtProducto">Producto</label>  
            <div class="col-md-4">
              <input id="txtProducto" name="txtProducto" readonly="readonly" type="text" placeholder="" 
                     class="form-control input-md" required="">

            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCantidadSolicitada">Cantidad Solicitada</label>  
            <div class="col-md-4">
              <input id="txtCantidadSolicitada" readonly="readonly" name="txtCantidadSolicitada" 
                     type="text" placeholder="" class="form-control input-md" required="">

            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtFechaSolicitudEsperada">Fecha Recepción Esperada</label>  
            <div class="col-md-4">
              <input id="txtFechaSolicitudEsperada" name="txtFechaSolicitudEsperada" readonly="readonly" 
                     type="text" placeholder="" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCantidadRecepcionada">Cantidad Recepcionada</label>  
            <div class="col-md-4">
              <input id="txtCantidadRecepcionada" name="txtCantidadRecepcionada" type="text" 
                     placeholder="Ingrese la cantidad Recepcionada" class="form-control input-md" required="">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtDescuento">Descuento</label>  
            <div class="col-md-4">
              <input id="txtDescuento" name="txtDescuento" type="text" placeholder="Ingrese valor del descuento" 
                     class="form-control input-md" required="">
            </div>
          </div>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtEstadoRecepcion">Estado Recepción</label>
            <div class="col-md-4">
              <select id="txtEstadoRecepcion" name="txtEstadoRecepcion" class="form-control" required="">
                <option value="">Selecccione...</option>
                <option value="Completa">Completa</option>
                <option value="Incompleta">Incompleta</option>
              </select>
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
        function buscar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/solicitudesController.php",
            data: {
              'accion': 'listar',
              'id_solicitud': $("#txtIdSolicitud").val()
            }, success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                $.each(data[0].campos, function(key, value) {
                  $("#txtCantidadSolicitada").val(value.cantidad_solicitada);
                  $("#txtFechaSolicitudEsperada").val(value.fecha_recepcion_solicitada);
                  $("#txtProducto").val(value.inv_descripcion);
                  $("#txtProveedor").val(value.nombre_proveedor);
                  $("#txtIdInventario").val(value.id_inventario);
                });
              } else {
                window.alert("Mensaje de Usuario: " + data[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + data[0].mensaje[0].admin);
              }
            }, error: function(jqXHR, textStatus, errorThrown) {
              window.alert(textStatus);
            }
          });
        }

        function agregar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/recepcionesController.php",
            data: {
              'accion':"crear",
              'id_solicitud':$("#txtIdSolicitud").val(),
              'id_recepcion':"0",
              'cantidad_recepcion':$("#txtCantidadRecepcionada").val(),
              'descuento':$("#txtDescuento").val(),
              'estado_recepcion':$("#txtEstadoRecepcion").val(),
              'id_inventario':$("#txtIdInventario").val()
            }, success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                window.alert(data[0].mensaje);
                window.location = "solicitudesList.php";
              } else {
                window.alert("Mensaje de Usuario: " + data[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + data[0].mensaje[0].admin);
              }
            }, error: function(jqXHR, textStatus, errorThrown) {
              window.alert(textStatus);
            }
          });
        }

        if ($("#txtIdSolicitud").val() !== "0") {
          buscar();
        }

        var v = jQuery("#frmAdd").validate({
          submitHandler: function(form) {
            agregar();
          }
        });

        $("#btnCancelar").on("click", function() {
          location.href = "solicitudesList.php";
        });
      });
    </script>
  </body>
</html>
