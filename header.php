<?php
require_once "modelo/Configuracion.class.php";
require_once "modelo/Usuario.class.php";
$objUsuario = new Usuario();
$resultado = $objUsuario->obtenerMenu($_SESSION["id_usuario"]);
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
      <a class="navbar-brand" href="#">Pedido Digital Expres</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        
        <li><a href="<?=Configuracion::$RAIZ;?>view/Producto/inventariosList.php">Productos</a></li>
        <li><a href="<?=Configuracion::$RAIZ;?>view/Platos/platosList.php">Platos</a></li>
        <li><a href="<?=Configuracion::$RAIZ;?>view/Porciones/porcionesList.php">Porciones</a></li>
        <li><a href="<?=Configuracion::$RAIZ;?>view/Pedidos/pedidosList.php">Pedidos de Clientes</a></li>
        <li><a href="<?=Configuracion::$RAIZ;?>view/SolicitudPedidos/solicitudesList.php">Solicitud Productos</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?=Configuracion::$RAIZ;?>view/Usuarios/usuariosList.php">Usuarios</a></li>
            <li><a href="<?=Configuracion::$RAIZ;?>view/Cargos/cargosList.php">Cargos</a></li>
            <li><a href="<?=Configuracion::$RAIZ;?>view/Categorias/categoriasList.php">Categorías</a></li>
            <li><a href="<?=Configuracion::$RAIZ;?>view/SubCategorias/subcategoriasList.php">Subcategorías</a></li>
            <li><a href="<?=Configuracion::$RAIZ;?>view/Mesas/mesasList.php">Mesas</a></li>
            <li><a href="<?=Configuracion::$RAIZ;?>view/Proveedores/proveedoresList.php">Proveedores</a></li>
            <!--<li class="divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>-->
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>