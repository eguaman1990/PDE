<?php
session_start();
require_once("../../secureadmin.php");
?>
<html>
  <head>
    <title>PDE - Proveedores</title>
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
    <?php require_once '../../header.php'; ?>
    <div class="container">
      <div class="page-header">
        <h1>Proveedores</h1>
      </div>
      <form id="form1" name="form1" method="post" action="" class="form-horizontal" role="form">
        <input id="pag" type="hidden" value="1">
        <div class="form-group">
          <div class="col-sm-6">
            <input type="text" class="form-control" id="txtNombre" placeholder="Busqueda por Nombre" name="txtNombre">
          </div>
          <button type="button" name="btnBuscar" id="btnBuscar"  class="btn btn-primary btn-sm">Buscar</button>
          <button type="button" name="btnAgregar" id="btnAgregar" class="btn btn-warning btn-sm">Agregar</button>
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
            url: "../../controller/proveedorController.php",
            data: {
              'accion': "listar",
              'nombre': $('#txtNombre').val(),
              'pag': $('#pag').val()
            },
            success: function(data, textStatus, jqXHR) {
              if (data[0].estado === "ok") {
                if (data[0].campos.length > 0) {
                  $(".lista").empty();
                  $(".paginador").empty();
                  var row = "row0";
                  var tabla = $("<table>", {
                    id: 'tabla',
                    class: 'table table-striped'
                  });
                  var thead = $("<thead>");
                  var tr = $("<tr>");
                  var th = $("<th>", {text: "Rut"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Nombre Proveedor"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Direccion"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Telefono"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Celular"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Email"});
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

                    var tr = document.createElement("tr");
                    $(tr).addClass(row);
                    var td = $("<td>", {text: value.rut_proveedor});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.nombre_proveedor});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.direccion});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.telefono});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.celular});
                    $(tr).append($(td));
                    var td = $("<td>", {text: value.email});
                    $(tr).append($(td));
                    var btnEditar = $("<a>", {
                      href: "proveedoresAdd.php?id_proveedor=" + value.id_proveedor,
                      name: "btnEditar",
                      id: "btnEditar",
                      html: "Editar"
                    });
                    $(btnEditar).addClass("btn btn-success btn-xs");
                    var btnEliminar = $("<a>", {
                      href: "#",
                      name: "btnEliminar",
                      id: "btnEliminar" + value.id_proveedor,
                      html: "Eliminar",
                      click: function() {
                        var rs = window.confirm("Desea Eliminar este Proveedor?");
                        if (rs === true) {
                          eliminar(value.id_proveedor);
                        }
                      }
                    });
                    $(btnEliminar).addClass("btn btn-danger btn-xs");
                    var td = $("<td>", {text: ""});
                    $(td).append($(btnEditar));
                    $(td).append("&nbsp;&nbsp;&nbsp;");
                    $(td).append($(btnEliminar));
                    $(tr).append($(td));

                    $(tabla).append(tr);
                  });
                  $(".lista").append($(tabla));
                  $(".paginador").append(data[0].paginador);
                } else {
                  $(".lista").html("No existen Proveedores");
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
            error: function(e) {
              window.alert("Error");
            }
          });
        }

        function eliminar(id_proveedor) {
          $.ajax({
            type: 'POST',
            url: "../../controller/proveedorController.php",
            data: {
              'accion': 'eliminar',
              'id_proveedor': id_proveedor
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

        $("#btnBuscar").on("click", function() {
          listar();
        });
        $("#btnAgregar").on("click", function() {
          window.location = "proveedoresAdd.php";
        });
      });
    </script>
  </body>
</html>
