$(document).ready(function(e) {
  $('#btnIngresar').on('click', function() {
    $.ajax({
      type: "POST",
      url: "controller/loginController.php",
      data: {
        'accion': 'login',
        'id_usuario': $("#txtUser").val(),
        'password': encrypt($("#txtPass").val())
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
  });
});

