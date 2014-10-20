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
            <th data-priority="3">Precio</th>
            <th data-priority="3">Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>15.81</td>
            <th>YHOO <span class="co-name">Yahoo! Inc.</span></th>
            <td>12:25PM</td>
            <td>0.11 (0.67%)</td>
            <td>15.70</td>
          </tr>
        </tbody>
      </table>
    </div>  
    <div id="mensaje"></div>
    <script src="../resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../resources/bootstrap/js/bootstrap.js"></script>
    <script src="../resources/tablesResponsives/js/rwd-table.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).on("ready", function() {
        listar();
        function listar() {
          $.ajax({
            type: 'POST',
            url: "../controller/mobileController.php",
            data: {
              "accion": "listarPedidosCliente"
            },
            success: function(data, textStatus, jqXHR) {
              if(data[0].estado==="ok"){
                if(data[0].campos.length>0){
                  
                }else{
                  $(".table-wrapper").addClass("hidden");
                  $("#mensaje").val("text","No Existen Pedidos Realizados");
                }
              }else{
                alert("Error de Aplicación");
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert("Error de Aplicación");
            }
          });
        }
      });
    </script>
  </body>
</html>
