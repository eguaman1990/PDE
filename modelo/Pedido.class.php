<?php

/**
 * Description of pedido
 * 
 * @author Edwin_Guaman
 */
require_once "BD.class.php";
require_once "MyException.class.php";
require_once "Configuracion.class.php";
require_once "Utilidades.class.php";

class Pedido {

  private $idPedido;
  private $idEstadoPedido;
  private $fechaIngreso;
  private $total;
  private $idDetallePedido;
  private $idProducto;
  private $cantidad;
  private $preciounitario;
  private $idAcceso;
  public $bd;
  public $myException;

  public function getIdPedido() {
    return $this->idPedido;
  }

  public function getIdAcceso() {
    return $this->idAcceso;
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

  public function setIdAcceso($idAcceso) {
    if (strlen(trim($idAcceso)) != 0) {
      $this->idAcceso = $idAcceso;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO ID_ACCESO ESTA VACIO',
          'admin' => 'atributo id_acceso,function setIdAcceso' . $this->__toString()
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

  public function crear($fecha_ingreso, $id_acceso, $id_producto, $cantidad, $precio_unitario) {
    try {
      $id_pedido = 0;
      $this->setFechaIngreso($fecha_ingreso);
      $this->setIdAcceso($id_acceso);
      $this->setCantidad($cantidad);
      $this->setIdProducto($id_producto);
      $this->setPreciounitario($precio_unitario);
      /*       * *
       * 1.- Valido si existe el pedido con id de acceso
       * 
       */
      $id_pedido = $this->pedidoExiste($id_acceso);
      if ($id_pedido == 0) {
        //pedido no existe
        if ($this->myException->getEstado() == 0) {
          #ES 0 SI NO EXISTE EL Producto					
          $this->bd->beginTransaction();
          //INGRESO EL PEDIDO
          $parametros = array(
              "ID_ACCESO" => $this->getIdAcceso(),
              "FECHA_INGRESO" => $this->getFechaIngreso()
          );
          $rs1 = $this->bd->insert('pedidos', $parametros);
          if ($this->bd->myException->getEstado() == 0) {
            $this->setIdPedido($this->bd->lastId());
            $parametrosDetalle = array(
                "ID_PRODUCTO" => $this->getIdProducto(),
                "ID_PEDIDO" => $this->getIdPedido(),
                "DEPE_CANTIDAD" => $this->getCantidad(),
                "DEPE_PRECIO_UNITARIO" => $this->getPreciounitario(),
                "ID_ESTADO_PEDIDO" => Configuracion::$EN_COLA
            );
            $rs1 = $this->bd->insert('detalle_pedido', $parametrosDetalle);
            if ($this->bd->myException->getEstado() == 0) {
              $this->bd->commit();
              return 1;
            } else {
              $this->bd->rollBack();
              $this->myException->setEstado(1);
              foreach ($this->bd->myException->getMensaje() as $er) {
                $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO CREAR " . $this->__toString() . " " . $parametros));
              }//fin del for each que me informa del error al realizar en insert
            }
          } else {
            $this->bd->rollBack();
            $this->myException->setEstado(1);
            foreach ($this->bd->myException->getMensaje() as $er) {
              $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO CREAR " . $this->__toString() . " " . $parametros));
            }//fin del for each que me informa del error al realizar en insert
          }//fin del if que verifica que la coneccion no se pierda
        } else {
          $this->bd->rollBack();
          $this->myException->setEstado(1);
          foreach ($this->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
          }//fin del for each que me informa del error al realizar en insert
          return 0;
        }//fin del if verifica que la conexion no se haya perdido
      } else {
        //pedido existe agrego solo el detalle del pedido
        if ($this->bd->myException->getEstado() == 0) {
          $this->setIdPedido($id_pedido);
          $parametrosDetalle = array(
              "ID_PRODUCTO" => $this->getIdProducto(),
              "ID_PEDIDO" => $this->getIdPedido(),
              "DEPE_CANTIDAD" => $this->getCantidad(),
              "DEPE_PRECIO_UNITARIO" => $this->getPreciounitario(),
              "ID_ESTADO_PEDIDO" => Configuracion::$EN_COLA
          );
          $rs1 = $this->bd->insert('detalle_pedido', $parametrosDetalle);
          if ($this->bd->myException->getEstado() == 0) {
            return 1;
          } else {
            $this->myException->setEstado(1);
            foreach ($this->bd->myException->getMensaje() as $er) {
              $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO CREAR " . $this->__toString() . " " . $parametros));
            }//fin del for each que me informa del error al realizar en insert
          }
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO CREAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }//fin del if que verifica que la coneccion no se pierda
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }
  }

  public function pedidoExiste($idAcceso) {
    try {
      $this->setIdAcceso($idAcceso);
      $sql = "SELECT ID_PEDIDO FROM pedidos WHERE ID_ACCESO=?";
      $res = $this->bd->select($sql, array($this->getIdAcceso()));
      if ($this->bd->myException->getEstado() == 0) {
        if ($rs = $res->fetch()) {
          return $rs["ID_PEDIDO"];//devuelve 1 si encuentra
        } else {
          return 0; //devuelve 0 si no encuentra anda
        }//fin del if que me permite verificar si encontro datos o no
      } else {
        $this->myException->setEstado(1);
        foreach ($this->bd->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }
        return 0;
      }//fin del if que me contAccesoa que no se haya caido la consulta
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }
  }

  public function listarPedidosPendientes() {
    try {
      $sql = "SELECT m.ID_MESA,m.ME_NOMBRE_MESA, dp.ID_DETALLEPEDIDO, dp.ID_PRODUCTO, p.PRO_NOMBRE, p.PRO_PRECIO_UNITARIO, 
        dp.ID_ESTADO_PEDIDO,e.ESPE_DESCRIPCION FROM detalle_pedido dp 
        INNER JOIN pedidos pe ON pe.ID_PEDIDO = dp.ID_PEDIDO
        INNER JOIN productos p ON dp.ID_PRODUCTO=p.ID_PRODUCTO 
        INNER JOIN estadopedido e ON dp.ID_ESTADO_PEDIDO=e.ID_ESTADOPEDIDO 
        INNER JOIN acceso a ON a.ID_ACCESO=pe.ID_ACCESO
        INNER JOIN mesa m ON m.ID_MESA=a.ID_MESA
        WHERE e.ID_ESTADOPEDIDO=? OR e.ID_ESTADOPEDIDO=?";
      $condicion = array(Configuracion::$EN_COLA, Configuracion::$EN_PREPARACION);
      $res = $this->bd->select($sql, $condicion);
      if ($this->bd->myException->getEstado() == 0) {
        while ($rs = $res->fetch()) {
          $campos[] = array(
              "id_detalle_pedido" => $rs["ID_DETALLEPEDIDO"],
              "id_producto"=>$rs["ID_PRODUCTO"],
              "nombre_plato"=>$rs["PRO_NOMBRE"],
              "precio_unitario"=>$rs["PRO_PRECIO_UNITARIO"],
              "estado_pedido"=>$rs["ESPE_DESCRIPCION"],
              "id_mesa"=>$rs["ID_MESA"],
              "nombre_mesa"=>$rs["ME_NOMBRE_MESA"]
          );
        }
         return $campos;
      } else {
        $this->myException->setEstado(1);
        foreach ($this->bd->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }
        return 0;
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
    }
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
