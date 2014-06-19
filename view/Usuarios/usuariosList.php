<?php
session_start();
require_once("../../secureadmin.php");
?>
<!doctype html>
<html>
  <head>
    <title>PDE - Usuarios</title>
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
        <h1>Usuarios</h1>
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
            type: "POST",
            url: "../../controller/usuarioController.php",
            data: {
              'accion': 'listar',
              'nombre': $("#txtNombre").val(),
              'pag': $("#pag").val()
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $(".lista").empty();
                  $(".paginador").empty();
                  var row = "row0";
                  var tabla = $("<table>", {
                    id: 'tabla',
                    class: 'table table-striped'
                  });
                  var thead = $("<thead>");
                  var tr = $("<tr>");
                  var th = $("<th>", {text: "User"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Nombres"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Apellidos"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Cargo"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Edad"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Direccion"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Telefono"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Email"});
                  $(tr).append($(th));
                  var th = $("<th>", {text: "Acciones"});
                  $(tr).append($(th));

                  $(thead).append($(tr));
                  $(tabla).append($(thead));

                  $.each(e[0].campos, function(key, value) {
                    if (row === "row0") {
                      row = "row1";
                    } else {
                      row = "row0";
                    }


                    var tr = document.createElement("tr");
                    $(tr).addClass(row);
                    var td = $("<td>", {
                      text: value.user
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.nombre
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.apellido
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.cargo_descripcion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.edad
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.direccion
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.telefono
                    });
                    $(tr).append($(td));
                    var td = $("<td>", {
                      text: value.email
                    });
                    $(tr).append($(td));

                    var button = $("<a>", {
                      href: "usuariosAdd.php?id_usuario=" + value.id_usuario,
                      name: "btnEditar",
                      id: "btnEditar"
                    });
                    $(button).addClass("btn btn-edit");
                    var btnDelete = $("<a>", {
                      href: "#",
                      name: "btnDelete",
                      id: "btnDelete" + value.id_usuario,
                      click: function() {
                        var rs = window.confirm("Desea Eliminar este Usuario?");
                        if (rs === true) {
                          eliminar(value.id_usuario);
                        }
                      }
                    });


                    $(btnDelete).addClass("btn btn-delete");
                    var td = $("<td>", {
                      text: ""
                    });
                    $(td).append($(button));
                    $(td).append($(btnDelete));
                    $(tr).append($(td));

                    $(tabla).append(tr);


                  });
                  $(".lista").append($(tabla));
                  $(".paginador").append(e[0].paginador);

                } else if (e[0].estado === "no") {
                  $(".lista").empty();
                  $(".paginador").empty();
                  $(".lista").append(e[0].mensaje);
                  $(".paginador").append(e[0].paginador);
                } else {
                  $(".lista").html("No existen Usuarios");
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

        function eliminar(id_usuario) {
          $.ajax({
            type: "POST",
            url: "../../controller/usuarioController.php",
            data:
                    {
                      'accion': 'eliminar',
                      'id_usuario': id_usuario
                    },
            success: function(e) {
              if (e[0].estado === "ok") {
                window.alert(e[0].mensaje);
                window.location = "usuariosList.php";
              } else {

                window.alert("Mensaje de Usuario: " + e[0].mensaje.user);
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
          window.location = "usuariosAdd.php";
        });
      });
    </script>
  </body>
</html>
