<?php

/**
 * Description of pedido
 * 
 * @author Edwin_Guaman
 */
class pedido {

  private $idPedido;
  private $idEstadoPedido;
  private $fechaIngreso;
  private $total;
  private $idDetallePedido;
  private $idProducto;
  private $cantidad;
  private $preciounitario;
  public $bd;
  public $myException;

  public function getIdPedido() {
    return $this->idPedido;
  }

  public function getFechaIngreso() {
    return $this->fechaIngreso;
  }

  public function getTotal() {
    return $this->total;
  }

  public function getIdDetallePedido() {
    return $this->idDetallePedido;
  }

  public function getIdProducto() {
    return $this->idProducto;
  }

  public function getCantidad() {
    return $this->cantidad;
  }

  public function getPreciounitario() {
    return $this->preciounitario;
  }

  public function getIdEstadoPedido() {
    return $this->idEstadoPedido;
  }

  public function setIdPedido($idPedido) {
    if (strlen(trim($idPedido)) != 0) {
      $this->idPedido = $idPedido;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO ID_PEDIDO ESTA VACIO',
          'admin' => 'atributo id_pedido,function setIdPedido' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function setFechaIngreso($fechaIngreso) {
    if (strlen(trim($fechaIngreso)) != 0) {
      $this->fechaIngreso = $fechaIngreso;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO fecha ingreso ESTA VACIO',
          'admin' => 'atributo fecha ingreso ,function setFechaIngreso' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setTotal($total) {
    if (strlen(trim($total)) != 0) {
      $this->total = $total;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO total ESTA VACIO',
          'admin' => 'atributo total ,function setTotal' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setIdDetallePedido($idDetallePedido) {
    if (strlen(trim($idDetallePedido)) != 0) {
      $this->idDetallePedio = $idDetallePedido;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idDetallePedido ESTA VACIO',
          'admin' => 'atributo total ,function setidDetallePedido' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setIdProducto($idProducto) {
    if (strlen(trim($idProducto)) != 0) {
      $this->idProducto = $idProducto;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idProducto ESTA VACIO',
          'admin' => 'atributo idProducto ,function setIdProducto' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setCantidad($cantidad) {
    if (strlen(trim($cantidad)) != 0) {
      $this->cantidad = $cantidad;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO cantidad ESTA VACIO',
          'admin' => 'atributo cantidad ,function setCantidad' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setPreciounitario($preciounitario) {
    if (strlen(trim($preciounitario)) != 0) {
      $this->preciounitario = $preciounitario;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO Precio Unitario ESTA VACIO',
          'admin' => 'atributo precioUnitario ,function setPrecioUnitario' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setIdEstadoPedido($idEstadoPedido) {
    if (strlen(trim($idEstadoPedidol)) != 0) {
      $this->idEstadoPedido = $idEstadoPedido;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO total ESTA VACIO',
          'admin' => 'atributo total ,function setTotal' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }
  
  public function crear(){
    
  }

  public function __construct() {
    $this->myException = new MyException;
    $this->bd = new BD();
    if ($this->bd->myException->getEstado() != 0) {
      $this->myException->setEstado(1);
      foreach ($this->bd->myException->getMensaje() as $er) {
        $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
      }
    }//fin del if
  }

//fin del constructor
  /**
   * Metodo Magico ue destruye mi objeto bd 
   * */
  public function __destruct() {
    $this->bd = NULL;
  }

//fin del destructor

  /**
   * Metodo Magico que me permite saber el nombre de la clase con la cual estoy trabajando
   * */
  public function __toString() {
    $mensaje = "CLASE PEDIDO";
    return $mensaje;
  }

}
