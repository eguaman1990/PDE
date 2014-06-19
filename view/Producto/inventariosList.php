<?php
session_start();
require_once("../../secureadmin.php");
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Inventario de Productos</title>
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
      <div class="page-header">
        <h1>Productos</h1>
      </div>
      <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
        <input id="pag" type="hidden" value="1">
        <div class="form-group">
          <div class="col-sm-6">
            <input class="form-control" type="text" name="txtNombre" id="txtNombre" placeholder="Busqueda por Productos"/>
          </div>
          <input type="button" name="btnBuscar" id="btnBuscar" value="Buscar" class="btn btn-primary" />
          <input type="button" name="btnAgregar" id="btnAgregar" value="Agregar" class="btn btn-warning" />
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
            type: "POST",
            url: "../../controller/inventariosController.php",
            data: {
              'accion': 'listar',
              'descripcion': $("#txtNombre").val(),
              'pag': $("#pag").val()
            },
            success: function(e) {
              if (e[0].estado == "ok") {
                if (e[0].campos.length > 0) {
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
                  var th = $("<th>", {text: "Producto"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Cantidad"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Medida"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Fecha Ingreso"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Fecha Vencimiento"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Stock Mímino"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Acciones"});
                  $(tr).append($(th));

                  $(thead).append($(tr));
                  $(tabla).append($(thead));

                  $.each(e[0].campos, function(key, value) {
                    var tr = document.createElement("tr");
                    var td = $("<td>", {
                      text: value.id_inventario
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.descripcion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.cantidad
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.unidad
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.fecha_ingreso
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.fecha_vencimiento
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.stock_minimo
                    });
                    $(tr).append($(td));

                    var button = $("<a>", {
                      href: "inventariosAdd.php?id_inventario=" + value.id_inventario,
                      name: "btnEditar",
                      id: "btnEditar"
                    });
                    $(button).addClass("btn btn-edit");
                    /*var btnDelete =$("<a>",{
                     href:"#",
                     name:"btnDelete",
                     id:"btnDelete"+value.id_inventario,
                     click:function(){
                     var rs= window.confirm("Desea Eliminar esta Producto del Inventario?");								
                     if(rs==true){
                     eliminar(value.id_inventario);
                     }
                     }
                     });
                     
                     
                     $(btnDelete).addClass("btn btn-delete");*/
                    var td = $("<td>", {
                      text: ""
                    });
                    $(td).append($(button));
                    //$(td).append($(btnDelete));
                    $(tr).append($(td));

                    $(tabla).append(tr);
                  });
                  $(".lista").append($(tabla));
                  $(".paginador").append(e[0].paginador);
                } else {
                  $(".lista").html("No existen Productos En nuestro Inventario")
                }

              } else if (e[0].estado === "no") {
                $(".lista").empty();
                $(".paginador").empty();
                $(".lista").append(e[0].mensaje);
                $(".paginador").append(e[0].paginador);
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

        $("#btnBuscar").on("click", function() {
          listar();
        });

        $("#btnAgregar").on("click", function() {
          window.location = "inventariosAdd.php";
        });

        function eliminar(id_inventario) {
          $.ajax({
            type: "POST",
            url: "../../controller/inventariosController.php",
            data:
                    {
                      'accion': 'eliminar',
                      'id_inventario': id_inventario
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

      });
    </script>
  </body>
</html>