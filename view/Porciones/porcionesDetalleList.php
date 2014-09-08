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
    <title>Detalle Porciones </title>
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
        <h1>Detalle de las Porciones del Plato <b id="pro_descripcion"></b></h1>
      </div>
      <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
        <div class="hidden">
          <input type="text" name="txtIdProducto" id="txtIdProducto" required value="<?= $id_producto; ?>">
          <input id="pag" type="hidden" value="1">
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <input type="text" name="txtNombre" id="txtNombre"  placeholder="Busqueda por Porción" class="form-control"/>
          </div>
          <input type="button" name="btnBuscar" id="btnBuscar" value="Buscar" class="btn btn-primary" />
          <input type="button" name="btnAgregar" id="btnAgregar" value="Agregar Porciones" class="btn btn-warning" />
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
        obtenerProducto();
        obtenerPorciones();
        function obtenerProducto() {
          $.ajax({
            type: "POST",
            url: "../../controller/productosController.php",
            data: {
              "accion": "listar",
              "id_producto": $("#txtIdProducto").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    $("#pro_descripcion").html("\"" + value.pro_descripcion + "\"");
                  });
                } else {
                  window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                  window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            failure: function(e) {
              window.alert("Error");
            }
          });
        }

        function obtenerPorciones() {
          $.ajax({
            type: "POST",
            url: "../../controller/porcionesController.php",
            data: {
              'accion': 'listar',
              'nombre': $("#txtNombre").val(),
              'id_producto': $("#txtIdProducto").val(),
              'pag': $("#pag").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
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
                  var th = $("<th>", {text: "Porcion"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Unidad"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Acciones"});
                  $(tr).append($(th));

                  $(thead).append($(tr));
                  $(tabla).append($(thead));

                  $.each(e[0].campos, function(key, value) {
                    var tr = document.createElement("tr");
                    var td = $("<td>", {
                      text: value.id_porcion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.inv_descripcion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.porc_porcion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.porc_unidad
                    });
                    $(tr).append($(td));
                    var button = $("<a>", {
                      href: "porcionesAdd.php?id_producto=" + value.id_producto + "&id_porcion=" + value.id_porcion,
                      name: "btnEditar",
                      id: "btnEditar",
                      html: "Editar"
                    });
                    $(button).addClass("btn btn-success btn-xs");
                    var btnDelete = $("<a>", {
                      href: "#",
                      name: "btnDelete",
                      id: "btnDelete" + value.id_porcion,
                      html: "Eliminar",
                      click: function() {
                        var rs = window.confirm("Desea Eliminar esta Producto?");
                        if (rs === true) {
                          eliminar(value.id_porcion);
                        }
                      }
                    });
                    $(btnDelete).addClass("btn btn-danger btn-xs");


                    var td = $("<td>", {
                      text: ""
                    });
                    $(td).append($(button));
                    $(td).append("&nbsp;&nbsp;&nbsp;");
                    $(td).append($(btnDelete));
                    $(tr).append($(td));

                    $(tabla).append(tr);
                  });
                  $(".lista").append($(tabla));
                  $(".paginador").append(e[0].paginador);
                } else {
                  $(".lista").html("No existen Productos");
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

        function eliminar(id_porcion) {
          $.ajax({
            type: "POST",
            url: "../../controller/porcionesController.php",
            data: {
              'accion': 'eliminar',
              'id_porcion': id_porcion
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                window.alert(e[0].mensaje);
                window.location = "porcionesDetalleList.php?id_producto=" + $("#txtIdProducto").val();
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
          window.location = "porcionesAdd.php?id_producto=" + $("#txtIdProducto").val();
        });
      });
    </script>
  </body>
</html>
