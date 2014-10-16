<?php
/*session_start();
require_once './secureAdminClient.php';*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="Edwin Guamán" name="author">
    <title>PDE</title>
    <link rel="stylesheet" href="../resources/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../resources/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link href="../resources/css/theme.css" rel="stylesheet" type="text/css"/>
    <title>::Pedido Digital Express::</title>
  </head>
  <body>
    <?php require_once("header.php"); ?>
    <div id="menu" class="panel panel-success">
      <div class="panel-heading">MENU</div>
      <ul id="categoria" class="list-group">
        <li class="list-group-item">
          <p>Papas con carne <span class="negrita derecha">Precio: $1.234</span></p>
          <p class="descripcion">papas fritas con carne <span class="negrita derecha">2 porciones</span> </p>
          <button type="submit" class="btn btn-lg btn-primary btn-block btn-xs" id="ingresar">
            <span class="glyphicon glyphicon-plus"></span>
            Pedir</button>
        </li>
      </ul>
    </div>
    <br />
    <div id="menuCategoria" class="panel panel-success hidden">
      <div class="panel-heading" id="categoriaNombre"></div>
      <ul id="subcategoria" class="list-group"></ul>
      <button id="volverMenu" class="btn btn-primary btn-block" >Volver</button>
    </div>
    <div id="menuPlato" class="panel panel-success hidden">
      <div class="panel-heading" id="subcategoriaNombre"></div>
      <ul id="plato" class="list-group"></ul>
      <button id="volverCategoria" class="btn btn-primary  btn-block" >Volver</button>
    </div>

    <script src="../resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../resources/bootstrap/js/bootstrap.js"></script>
    <script>
      $(document).ready(function() {
        cargaCategorias();

        function ingresarPedido(id_producto,precio_unitario) {
          $.ajax({
            async: false,
            type: 'POST',
            url: "../controller/mobileController.php",
            data: {
              "accion": "ingresar_pedido",
              "id_producto": id_producto,
              "cantidad":"1",
              "precio_unitario":precio_unitario
            },
            success: function(data, textStatus, jqXHR) {
              if(data[0].estado==="ok"){
                window.alert("Pedido Ingresado Exitosamente");
                window.location.href = "index.php";
              }else{
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            error: function(a, b, c) {

            }
          });
        }

        function cargaPlatos(id_subcategoria) {
          $.ajax({
            url: '../controller/mobileController.php?',
            type: 'POST',
            data: {
              accion: 'cargaPlatos',
              id_subcategoria: id_subcategoria
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  var nombreSubCategoria = "";
                  $("#menuPlato").removeClass("hidden");
                  $("#menuCategoria").addClass("hidden");
                  $("#subcategoriaNombre").empty();
                  $("#plato").empty();
                  $.each(e[0].campos, function(key, value) {
                    nombreSubCategoria = value.subca_descripcion;
                    var nombrePlato = $("<p>", {
                      html: value.pro_nombre + ""
                    });

                    var precio = $("<span>", {
                      html: value.pro_precio_unitario
                    });
                    $(precio).addClass("negrita derecha");

                    var descPlato = $("<p>", {
                      html: value.pro_descripcion + ""
                    });
                    descPlato.addClass("descripcion");

                    var porciones = $("<span>", {
                      html: value.pro_porciones + " Persona"
                    });
                    $(porciones).addClass("negrita derecha");

                    var icon = $("<span>", {
                      class: "glyphicon glyphicon-plus"
                    });

                    var btnPedir = $("<button>", {
                      click: function() {
                        ingresarPedido(value.id_producto,value.pro_precio_unitario);
                      }
                    });
                    $(btnPedir).addClass("btn btn-primary");

                    $(btnPedir).append($(icon));
                    $(btnPedir).append(" Pedir");
                    var li = $("<a>", {
                      href: "#",
                      id: "#plato" + value.id_producto
                    });
                    $(li).append($(nombrePlato));
                    $(nombrePlato).append($(precio));
                    $(li).append($(descPlato));
                    $(descPlato).append($(porciones));
                    $(li).append($(btnPedir));
                    $(li).addClass("list-group-item");
                    $("#plato").append($(li));
                  });
                  $("#subcategoriaNombre").append(nombreSubCategoria);
                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            error: function(x) {
              document.title = 'error';
              alert(x.statusText);
              console.log(x);
            }
          });
        }

        function cargaSubCategoria(id_categoria) {
          $.ajax({
            url: '../controller/mobileController.php?',
            type: 'POST',
            data: {
              accion: 'cargaSubcategoria',
              id_categoria: id_categoria
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  var nombreCategoria = "";
                  $("#menuCategoria").removeClass("hidden");
                  $("#menu").addClass("hidden");
                  $("#categoriaNombre").empty();
                  $("#subcategoria").empty();
                  $.each(e[0].campos, function(key, value) {
                    nombreCategoria = value.ca_descripcion;
                    var li = $("<a>", {
                      href: "#",
                      id: "#idSubcategoria" + value.id_subcategoria,
                      text: value.subca_descripcion,
                      click: function() {
                        cargaPlatos(value.id_subcategoria);
                      }
                    });
                    $(li).addClass("list-group-item");
                    $("#subcategoria").append($(li));
                  });
                  $("#categoriaNombre").append(nombreCategoria);
                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            error: function(x) {
              document.title = 'error';
              alert(x.statusText);
              console.log(x);
            }
          });
        }

        function cargaCategorias() {
          $.ajax({
            url: '../controller/mobileController.php?',
            type: 'POST',
            data: {
              accion: 'cargaMenu'
            },
            success: function(e) {
              if (e[0].estado === "ok") {
                if (e[0].campos.length > 0) {
                  $.each(e[0].campos, function(key, value) {
                    var li = $("<a>", {
                      href: "#",
                      id: "#idCategoria" + value.id_categoria,
                      text: value.descripcion,
                      click: function() {
                        cargaSubCategoria(value.id_categoria);
                      }
                    });
                    $(li).addClass("list-group-item");
                    $("#categoria").append($(li));
                  });

                }
              } else {
                window.alert("Mensaje de Usuario: " + e[0].mensaje[0].user);
                window.alert("Mensaje de Administrador: " + e[0].mensaje[0].admin);
              }
            },
            error: function(x) {
              document.title = 'error';
              alert(x.statusText);
              console.log(x);
            }
          });
        }

        $("#volverMenu").on("click", function() {
          $("#menuCategoria").addClass("hidden");
          $("#menu").removeClass("hidden");
        });

        $("#volverCategoria").on("click", function() {
          $("#menuPlato").addClass("hidden");
          $("#menuCategoria").removeClass("hidden");
        });
      });
    </script>
  </body>
</html>