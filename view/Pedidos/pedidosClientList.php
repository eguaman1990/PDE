<?php
session_start();
require_once "../../secureadmin.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PDE - Pedidos</title>
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
        <h1>Lista Pedidos</h1>
      </div>
      <div class="lista"></div>
    </div>
    <script src="../../resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../../resources/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).on("ready", function() {
        var EN_COLA = "1";
        var EN_PREPARACION = "2";
        var LISTO = "3";
        listar();
        function prepararPedido(id_detalle_pedido) {
          $.ajax({
            type: 'POST',
            url: "../../controller/mobileController.php",
            data: {
              "accion": "prepararPedido",
              "id_detalle_pedido": id_detalle_pedido
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                listar();
              }else{
                
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
          });
        }
        
        function pedidoListo(id_detalle_pedido) {
          $.ajax({
            type: 'POST',
            url: "../../controller/mobileController.php",
            data: {
              "accion": "pedidoListo",
              "id_detalle_pedido": id_detalle_pedido
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                listar();
              }else{
                
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
          });
        }
        var t;
        function listar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/mobileController.php",
            data: {
              "accion": "listarPedidos"
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                if (data[0].campos.length > 0) {
                  var row = "row0";
                  var cor = 0;
                  $(".lista").empty();
                  var tabla = $("<table>", {
                    id: "tabla",
                    class: "table table-striped"
                  });
                  var thead = $("<thead>");
                  var tr = $("<tr>");
                  var th = $("<th>", {text: "Nro"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Mesa"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Plato"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Estado"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Fecha Pedido"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Acciones"});
                  $(tr).append($(th));
                  $(thead).append($(tr));
                  $(tabla).append($(thead));
                  $.each(data[0].campos, function(key, value) {
                    if (row === "row0") {
                      row = "row1";
                    } else {
                      row = "row0";
                    }
                    cor++;
                    var tr = $("<tr>");
                    $(tr).addClass(row);
                    var td = $("<td>", {text: cor});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.nombre_mesa});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.nombre_plato});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.estado_pedido});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.fecha_pedido});
                    $(tr).append($(td));
                    var td = $("<td>");
                    $(tr).append($(td));
                    if (value.id_estado_pedido === EN_COLA) {
                      var button = $("<a>", {
                        href: "#",
                        name: "btnPreparar",
                        id: "btnPreparar" + value.id_detalle_pedido,
                        html: "Preparar",
                        click: function() {
                          prepararPedido(value.id_detalle_pedido);
                        }

                      });
                      $(button).addClass("btn btn-success btn-lg");
                      $(td).append($(button));
                    }

                    if (value.id_estado_pedido === EN_PREPARACION) {

                      var btnDelete = $("<a>", {
                        href: "#",
                        name: "btnListo",
                        html: "Listo",
                        id: "btnListo" + value.id_producto,
                        click: function() {
                          pedidoListo(value.id_detalle_pedido);
                        }
                      });
                      $(btnDelete).addClass("btn btn-primary btn-lg");
                      $(td).append($(btnDelete));
                      $(tr).append($(td));
                    }
                   
                    $(tabla).append($(tr));
                  });
                  $(".lista").append($(tabla));
                } else {
                  $(".lista").html("No Existen Pedidos");
                }
              } else {

              }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }

          });
          t = setTimeout(function() {
            listar();
          }, 3000);
        }
      });

    </script>
  </body>
</html>
