<?php
session_start();
$_SESSION["incorrectlogin"] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
   	<meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <script type="text/javascript" src="resources/js/lib/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="resources/js/lib/jquery-ui.js"></script>
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="resources/css/signin.css" />
    <script>
      var hexcase = 0;
      var b64pad = "";

      function encdpwd(input)
      {
        try {
          b64pad;
        } catch (e) {
          b64pad = '';
        }//fin del try catch

        var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
        var output = "";
        var len = input.length;

        for (var i = 0; i < len; i += 3)
        {
          var triplet = (input.charCodeAt(i) << 16) | (i + 1 < len ? input.charCodeAt(i + 1) << 8 : 0) | (i + 2 < len ? input.charCodeAt(i + 2) : 0);
          for (var j = 0; j < 4; j++)
          {
            if (i * 8 + j * 6 > input.length * 8) {
              output += b64pad;
            } else {
              output += tab.charAt((triplet >>> 6 * (3 - j)) & 0x3F);
            }
          }//fin del for 1
        }//fin del for2;
        return output;
      }//fin del la function encpwd

      $(document).ready(function(e) {
        $("#ingresar").on("click", function() {

          if ($("#txtUsuario").val() === "") {
            alert("Campo Usuario Vacio");
          } else if ($("#txtPassword").val() === "") {
            alert("Campo Password Vacio");
          } else {
            $.ajax({
              type: "POST",
              url: "controller/usuarioController.php",
              data:{
                        'accion': 'login',
                        'id_usuario': $("#txtUsuario").val(),
                        'password': encdpwd($("#txtPassword").val())
                      },
              success: function(e) {
                if (e[0].estado === "ok") {
                  window.location = "index.php";
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
      });
    </script>
    <title>.:Pedido Digital Express:.</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  </head>
  <body>
    <div class="container">
      <form role="form" class="form-signin">
        
        <img src="resources/images/logo2.png" alt="" style="margin-left: auto; margin-right: auto;"/>
        <h3 class="form-signin-heading">Pedido Digital Express</h3>
        <input type="text" autofocus="" required="" placeholder="Nombre Usuario" class="form-control" id="txtUsuario" />
        <input type="password" required="" placeholder="Clave" class="form-control" id="txtPassword" />
        <button type="button" class="btn btn-lg btn-primary btn-block" id="ingresar">Ingresar</button>
      </form>
    </div>
  </body>
</html>