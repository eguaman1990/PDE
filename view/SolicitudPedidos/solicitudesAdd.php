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
    <title>PDE - Solicitudes</title>
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
          <legend>Solicitudes de Productos</legend>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtIdSolicitud">IdSolicitud</label>  
            <div class="col-md-4">
              <input id="txtIdSolicitud" name="txtIdSolicitud" type="text" placeholder="Ingrese la Cantidad" class="form-control input-md" required=""
                     value="<?= $id_solicitud; ?>">
            </div>
          </div>
          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtIdProveedor">Proveedor</label>
            <div class="col-md-4">
              <select id="txtIdProveedor" name="txtIdProveedor" class="form-control"
                      required data-msg-required="Seleccione un Proveedor">
                <option value="">Seleccione...</option>
              </select>
            </div>
          </div>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtIdProducto">Producto</label>
            <div class="col-md-4">
              <select id="txtIdProducto" name="txtIdProducto" class="form-control"
                      required data-msg-required="Seleccione un Producto">
                <option value="">Seleccione...</option>
              </select>
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtCantidad">Cantidad</label>  
            <div class="col-md-4">
              <input id="txtCantidad" name="txtCantidad" type="text" placeholder="Ingrese la Cantidad" class="form-control input-md" required="">

            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtFechaRecepcionSolicitada">Fecha Estimada Entrega</label>  
            <div class="col-md-4">
              <input id="txtFechaRecepcionSolicitada" name="txtFechaRecepcionSolicitada" type="text" placeholder="Fecha Estimada Entrega" class="form-control input-md" required="">

            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label" for="txtHora">Hora Estimada Entrega</label>  
            <div class="col-md-4">
              <select id="txtHora" name="txtHora" class="form-control"
                      required data-msg-required="Seleccione una Hora">
                <option value="">Seleccione...</option>
                <option value="00:00">00:00</option>
                <option value="01:00">01:00</option>
                <option value="02:00">02:00</option>
                <option value="03:00">03:00</option>
                <option value="04:00">04:00</option>
                <option value="05:00">05:00</option>
                <option value="06:00">06:00</option>
                <option value="07:00">07:00</option>
                <option value="08:00">08:00</option>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
                <option value="19:00">19:00</option>
                <option value="20:00">20:00</option>
                <option value="21:00">21:00</option>
                <option value="22:00">22:00</option>
                <option value="23:00">23:00</option>
              </select>
            </div>
          </div>
          <?php if ($id_solicitud != 0) { ?>
            <div class="form-group">
              <label class="col-md-4 control-label" for="txtEstadoSolicitud">Estado</label>
              <div class="col-md-4">
                <select id="txtEstadoSolicitud" name="txtEstadoSolicitud" class="form-control"
                        required data-msg-required="Seleccione un Estado">
                  <option value="Solicitada">Solicitada</option>
                  
                  <option value="Cancelada">Cancelada</option>
                </select>
              </div>
            </div>
          <?php } ?>
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
        $("#txtFechaRecepcionSolicitada").datepicker();
        listarProveedores();
        listarProductos();
        function listarProveedores() {
          $.ajax({
            type: "POST",
            url: "../../controller/solicitudesController.php",
            data: {
              "accion": "listarComboProveedores"
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    var option = $("<option>", {
                      value: value.id_proveedor,
                      text: value.nombre_proveedor
                    });
                    $("#txtIdProveedor").append($(option));
                  });
                } else {
                  var option = $("<option>", {
                    value: "",
                    text: "No posee Proveedores"
                  });
                  $("#txtIdProveedor").append($(option));
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
        function listarProductos() {
          $.ajax({
            type: "POST",
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
                    $("#txtIdProducto").append($(option));
                  });
                } else {
                  var option = $("<option>", {
                    value: "",
                    text: "No posee Productos"
                  });
                  $("#txtIdProducto").append($(option));
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
            type: 'POST',
            url: "../../controller/solicitudesController.php",
            data: {
              'accion': 'crear',
              'id_solicitud': $("#txtIdSolicitud").val(),
              'id_proveedor': $("#txtIdProveedor").val(),
              'id_inventario': $("#txtIdProducto").val(),
              'cantidad_solicitada': $("#txtCantidad").val(),
              'estado_solicitud':$("#txtEstadoSolicitud").val(),
              'fecha_recepcion_solicitada':$("#txtFechaRecepcionSolicitada").val(),
              'hora_recepcion_solicitada':$("#txtHora").val()
            }, success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                window.alert(data[0].mensaje);
                window.location = "solicitudesList.php";
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
            url: "../../controller/solicitudesController.php",
            data: {
              'accion': 'listar',
              'id_solicitud': $("#txtIdSolicitud").val()
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                $.each(data[0].campos, function(key, value) {
                  $("#txtCantidad").val(value.cantidad_solicitada);
                  $("#txtEstadoSolicitud option[value=" + value.estado_solicitud + "]").attr("selected", true);
                  $("#txtIdProducto option[value=" + value.id_inventario + "]").attr("selected", true);
                  $("#txtIdProveedor option[value=" + value.id_proveedor + "]").attr("selected", true);
                  $("#txtFechaRecepcionSolicitada").val(value.fecha_recepcion_solicitada);
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
          location.href = "solicitudesList.php";
        });

        if ($("#txtIdSolicitud").val() !== "0") {
          buscar();
        }
      });
    </script>
  </body>
</html>
