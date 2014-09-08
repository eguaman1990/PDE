<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="Edwin Guamán" name="author">
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap-theme.css" type="text/css">
    <link href="resources/css/theme.css" rel="stylesheet" type="text/css"/>
  </head>
  
  <body>
    <form class="form-horizontal">
      <fieldset>

        <!-- Form Name -->
        <legend>Form Name</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="txtNombre">Nombre</label>  
          <div class="col-md-4">
            <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese Nombre" class="form-control input-md" >

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="txtApellido">Apellido</label>  
          <div class="col-md-4">
            <input id="txtApellido" name="txtApellido" type="text" placeholder="Ingrese Apellido" class="form-control input-md">

          </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="btnAceptar"></label>
          <div class="col-md-8">
            <button type="button" id="btnAceptar" name="btnAceptar" class="btn btn-success">Aceptar</button>
            <button type="button" id="btnCancelar" name="btnCancelar" class="btn btn-danger">Cancelar</button>
          </div>
        </div>
        <div id="resultado"></div>
      </fieldset>
    </form>
  <script src="resources/js/lib/jquery-1.11.0.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#btnAceptar").on("click",function(){
        $.ajax({
          type: 'POST',
          url:"demoController.php",
          data: {
            "nombre":$("#txtNombre").val(),
            "apellido":$("#txtApellido").val(),
          },
          success:function(data){
            $.each(data,function(ker,value){
              $("#resultado").append(value.user+"<br />");
            })
            
          },
          error:function(e){
            
          }
        });
      });
    });
  </script>
  </body>
</html>
