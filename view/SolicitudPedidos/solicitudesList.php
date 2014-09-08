<?php
session_start();
require_once("../../secureadmin.php");
if (isset($_REQUEST["id_producto"])) {
  $id_producto = $_REQUEST["id_producto"];
} else {
  $id_producto = "0";
}//accion
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Solicitud Pedidos</title>
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="Edwin Guamán" name="author">
    <link rel="stylesheet" href="../../resources/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../../resources/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link href="../../resources/css/theme.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <?php require_once '../../header.php'; ?>
    <div class="container">
      <div class="page-header">
        <h1>Solicitudes</h1>
      </div>
      <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
        <div class="hidden">
          <input type="text" name="txtIdProducto" id="txtIdProducto" required value="<?= $id_producto; ?>">
          <input id="pag" type="hidden" value="1">
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input type="text" name="txtNombre" id="txtNombre"  placeholder="Busqueda por Solicitud" class="form-control"/>
          </div>
          <input type="button" name="btnBuscar" id="btnBuscar" value="Buscar" class="btn btn-primary" />
          <input type="button" name="btnAgregar" id="btnAgregar" value="Solicitar Productos" class="btn btn-warning" />
        </div>
      </form>
      <div class="lista"></div>
      <div class="paginador"></div>  
    </div>
    <script src="../../resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../../resources/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript">
      function avance_pagina($pag) {//para cuando hayan varios registros
        //es el boton de pag 2,3,4,etc;
        document.getElementById("pag").value = $pag;
        document.form1.btnBuscar.click();//este es el nombre del formulario...
        document.getElementById("pag").value = 1;
      }
      $(document).ready(function(e) {
        listar();
        function listar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/solicitudesController.php",
            async: false,
            data: {
              'accion': 'listar',
              'nombre': $("#txtNombre").val(),
              'pag': $("#pag").val()
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                if (data[0].campos.length > 0) {
                  $(".lista").empty();
                  $(".paginador").empty();
                  var tabla = $("<table>", {
                    id: 'tabla',
                    class: 'table table-striped'
                  });
                  var thead = $("<thead>");
                  var tr = $("<tr>");
                  var th = $("<th>", {text: "Nro"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Producto Solicitado"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Proveedor"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Cantidad"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Estado"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Fecha Solicitud"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Fecha Recepción Solicitada"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Acciones"});
                  $(tr).append($(th));

                  $(thead).append($(tr));
                  $(tabla).append($(thead));

                  $.each(data[0].campos, function(key, value) {
                    var classTr = "";
                    if (value.estado_solicitud === "Solicitada") {
                      classTr = "info";
                    } else if (value.estado_solicitud === "Recepcionada") {
                      classTr = "success";
                    } else if (value.estado_solicitud === "Cancelada") {
                      classTr = "danger";
                    }
                    var tr = document.createElement("tr");
                    $(tr).addClass(classTr);
                    var td = $("<td>", {
                      text: value.id_solicitud
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.inv_descripcion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.nombre_proveedor
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.cantidad_solicitada});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.estado_solicitud});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.fecha_solicitud});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.fecha_recepcion_solicitada});
                    $(tr).append($(td));
                    if (value.estado_solicitud !== "Recepcionada" &&  value.estado_solicitud !== "Cancelada") {
                      var button = $("<a>", {
                        href: "solicitudesAdd.php?id_solicitud=" + value.id_solicitud,
                        name: "btnEditar",
                        id: "btnEditar",
                        html: "Editar"
                      });
                      $(button).addClass("btn btn-success btn-xs");
                      var btnDelete = $("<a>", {
                        href: "#",
                        name: "btnDelete",
                        id: "btnDelete" + value.id_solicitud,
                        html: "Cancelar Solicitud",
                        click: function() {
                          var rs = window.confirm("Desea Cancelar esta Solicitud?");
                          if (rs === true) {
                            eliminar(value.id_solicitud);
                          }
                        }
                      });
                      $(btnDelete).addClass("btn btn-danger btn-xs");

                      var btnRecepcionar=$("<a>",{
                        href:"recepcionesAdd.php?id_solicitud="+value.id_solicitud,
                        name:"btnRecepcionar",
                        id:"btnRecepcionar",
                        html:"Recepcionar"
                      });
                      $(btnRecepcionar).addClass("btn btn-primary btn-xs")
                      var td = $("<td>", {text: ""});
                      $(td).append($(button));
                      $(td).append("&nbsp;&nbsp;&nbsp;");
                      $(td).append($(btnDelete));
                      $(td).append("&nbsp;&nbsp;&nbsp;");
                      $(td).append($(btnRecepcionar));
                      $(tr).append($(td));
                    } else {
                      var td = $("<td>", {text: ""});
                      $(tr).append($(td));
                    }

                    $(tabla).append(tr);
                  });
                  $(".lista").append($(tabla));
                  $(".paginador").append(data[0].paginador);
                } else {
                  $(".lista").html("No Existen Solicitudes de Productos");
                }
              } else if (data[0].estado === "no") {
                $(".lista").empty();
                $(".paginador").empty();
                $(".lista").append(data[0].mensaje);
                $(".paginador").append(data[0].paginador);
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
        
        function eliminar(id_solicitud) {
          $.ajax({
            type: 'POST',
            url: "../../controller/solicitudesController.php",
            data: {
              'accion': 'eliminar',
              'id_solicitud': id_solicitud
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                window.alert(data[0].mensaje);
                window.location = "proveedoresList.php";
              } else {
                window.alert("Mensaje de Usuario: " + data[0].mensaje.user);
                window.alert("Mensaje de Administrador: " + data[0].mensaje[0].admin);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
          });
        }

        $("#btnAgregar").on("click", function() {
          window.location.href = "solicitudesAdd.php";
        });
        
        $("#btnBuscar").on("click", function() {
          listar();
        });

      });
    </script>
  </body>
</html>
