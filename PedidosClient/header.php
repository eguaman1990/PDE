<?php
require_once "../modelo/Configuracion.class.php";
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">PDE &nbsp;&nbsp; <?=$_SESSION["mesa"]?> </a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="<?=Configuracion::$RAIZ;?>PedidosCLient/index.php">Menú</a></li>
        <li><a href="<?=Configuracion::$RAIZ;?>PedidosCLient/pedidosRealizadosList.php">Pedidos Realizados</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>