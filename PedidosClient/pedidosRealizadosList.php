<?php
session_start();
require_once './secureAdminClient.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="UTF-8">
    <title>Pedidos Realizados Pendientes</title>
    <link href="../resources/tablesResponsives/css/docs.min.css" rel="stylesheet" type="text/css"/>
    <link href="../resources/tablesResponsives/css/rwd-table.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../resources/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../resources/bootstrap/css/bootstrap-theme.css" type="text/css">
  </head>
  <body>
    <?php require_once("header.php"); ?>
    <div class="table-responsive" data-pattern="priority-columns" id="pedidosList">
      <table cellspacing="0" id="tech-companies-1" class="table table-small-font table-bordered table-striped">
        <thead>
          <tr>
            <th data-priority="1">N°</th>
            <th>Plato</th>
            <th data-priority="3">Estado</th>
            <th data-priority="3">Fecha</th>
            <th data-priority="3">Precio</th>
          </tr>
        </thead>
        <tbody class="lista">
        </tbody>
      </table>
    </div>  
    <div id="mensaje"></div>
    <div id="hora"></div>
    <div id="hora1"></div>
    <script src="../resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../resources/bootstrap/js/bootstrap.js"></script>
    <script src="../resources/tablesResponsives/js/rwd-table.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).on("ready", function() {
        listar();
        //$(".focus-btn-group").addClass("hidden");
        function listar() {
          $.ajax({
            type: 'POST',
            url: "../controller/mobileController.php",
            data: {
              "accion": "listarPedidosCliente"
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                if (data[0].campos.length > 0) {
                  var cor = 0;
                  $(".lista").empty();
                  $.each(data[0].campos, function(key, value) {
                    cor++;
                    var tr = $("<tr>");
                    var td = $("<td>", {text: cor});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.nombre_plato});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.estado_pedido});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.fecha_pedido});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.precio_unitario});
                    $(tr).append($(td));

                    $(".lista").append($(tr));
                  });

                } else {
                  $(".table-wrapper").addClass("hidden");
                  $("#mensaje").val("text", "No Existen Pedidos Realizados");
                }
              } else {
                alert("Error de Aplicación");
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert("Error de Aplicación");
            }
          });
          t = setTimeout(function() {
            listar();
          }, 3000);
          
        }

        
        var minuto = 0;
        var t;
        var timer_is_on = 0;

        function timedCount(valor,segundo,minuto) {
          if (segundo < 10) {
            $("#"+valor).html("0" + minuto + ":0" + segundo);
          }else{
            $("#"+valor).html("0" + minuto + ":" + segundo);
          }
          segundo = segundo + 1;
          if(segundo==60){
            segundo=0;
            minuto=minuto+1;
          }
          t = setTimeout(function() {
            timedCount(valor,segundo,minuto);
          }, 1000);
        }

        function startCount() {
          if (!timer_is_on) {
            timer_is_on = 1;
            timedCount();
          }
        }

        function stopCount() {
          clearTimeout(t);
          timer_is_on = 0;
        }
        
        timedCount("hora",0,0);
        timedCount("hora1",10,0);
        $('.table-responsive').responsiveTable({
          addFocusBtn:false
        });
      });
    </script>
  </body>
</html>
