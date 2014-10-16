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
        listar();
        function listar() {
          $.ajax({
            type: 'POST',
            url: "../../controller/mobileController.php",
            data: {
              "accion": "listarPedidos"
            },
            success: function(data, textStatus, jqXHR) {
              if(data[0].estado==="ok"){
                if(data[0].campos.length >0){
                  var row = "row0";
                  var cor=0;
                  $(".lista").empty();
                  var tabla= $("<table>",{
                    id:"tabla",
                    class:"table table-striped"
                  });
                  var thead=$("<thead>");
                  var tr = $("<tr>");
                  var th=$("<th>",{text:"Nro"});
                  $(tr).append($(th));
                  var th=$("<th>",{text:"Mesa"});
                  $(tr).append($(th));
                  var th=$("<th>",{text:"Plato"});
                  $(tr).append($(th));
                  var th=$("<th>",{text:"Estado"});
                  $(tr).append($(th));
                  var th=$("<th>",{text:"Acciones"});
                  $(tr).append($(th));

                  
                  $(thead).append($(tr));
                  $(tabla).append($(thead));
                  
                  $.each(data[0].campos, function(key,value){
                    if(row === "row0" ){
                      row= "row1";
                    }else{
                      row= "row0";
                    }
                    cor++;
                    var tr = $("<tr>");
                    $(tr).addClass(row);
                    var td=$("<td>",{text:cor});
                    $(tr).append($(td));
                    var td=$("<td>",{text:value.nombre_mesa});
                    $(tr).append($(td));
                    var td=$("<td>",{text:value.nombre_plato});
                    $(tr).append($(td));
                    var td=$("<td>",{text:value.estado_pedido});
                    $(tr).append($(td));
                    var td=$("<td>",{text:"aqui las acciones"});
                    $(tr).append($(td));
                    
                    /*var button = $("<a>", {
                      href: "usuariosAdd.php?id_usuario=" + value.id_usuario,
                      name: "btnEditar",
                      id: "btnEditar",
                      html: "Editar"
                    });
                    $(button).addClass("btn btn-success btn-xs");
                    var btnDelete = $("<a>", {
                      href: "#",
                      name: "btnDelete",
                      html: "Eliminar",
                      id: "btnDelete" + value.id_producto,
                      click: function() {
                        var rs = window.confirm("Desea Eliminar este Usuario?");
                        if (rs === true) {
                            
                        }
                      }
                    });*/
                    $(tabla).append(tr);
                  });
                  $(".lista").append($(tabla));
                }else{
                  $(".lista").html("No Existen Pedidos");
                }
              }else{
                
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }

          });
        }
      });

    </script>
  </body>
</html>
