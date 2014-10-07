<?php

require_once 'BD.class.php';
require_once 'MyException.class.php';
require_once 'Utilidades.class.php';

class Solicitudes {

  private $idSolicitud;
  private $idProveedor;
  private $fechaSolicitud;
  private $idInventario;
  private $cantidadSolicitada;
  private $estadoSolicitud;
  private $fechaRecepcionSolicitada;
  public $bd;
  public $myException;

  public function getFechaRecepcionSolicitada() {
    return $this->fechaRecepcionSolicitada;
  }

  public function setFechaRecepcionSolicitada($fechaRecepcionSolicitada) {
    if (strlen(trim($fechaRecepcionSolicitada)) != 0) {
      $this->fechaRecepcionSolicitada = $fechaRecepcionSolicitada;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO $fechaRecepcionSolicitada ESTA VACIO',
          'admin' => 'atributo $fechaRecepcionSolicitada,function set_idSolicitud ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function getIdSolicitud() {
    return $this->idSolicitud;
  }

  public function getIdProveedor() {
    return $this->idProveedor;
  }

  public function getFechaSolicitud() {
    return $this->fechaSolicitud;
  }

  public function getIdInventario() {
    return $this->idInventario;
  }

  public function getCantidadSolicitada() {
    return $this->cantidadSolicitada;
  }

  public function getEstadoSolicitud() {
    return $this->estadoSolicitud;
  }

  public function setIdSolicitud($idSolicitud) {
    if (strlen(trim($idSolicitud)) != 0) {
      $this->idSolicitud = $idSolicitud;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idSolicitud ESTA VACIO',
          'admin' => 'atributo idSolicitud,function set_idSolicitud ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function setIdProveedor($idProveedor) {
    if (strlen(trim($idProveedor)) != 0) {
      $this->idProveedor = $idProveedor;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idProveedor ESTA VACIO',
          'admin' => 'atributo idProveedor,function setIdProveedor' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function setFechaSolicitud($fechaSolicitud) {
    if (strlen(trim($fechaSolicitud)) != 0) {
      $this->fechaSolicitud = $fechaSolicitud;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO fechaSolicitud ESTA VACIO',
          'admin' => 'atributo fechaSolicitud,function setfechaSolicitud' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function setIdInventario($idInventario) {

    if (strlen(trim($idInventario)) != 0) {
      $this->idInventario = $idInventario;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idInventario ESTA VACIO',
          'admin' => 'atributo idInventario,function setidInventario' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function setCantidadSolicitada($cantidadSolicitada) {

    if (strlen(trim($cantidadSolicitada)) != 0) {
      $this->cantidadSolicitada = $cantidadSolicitada;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO cantidadSolicitada ESTA VACIO',
          'admin' => 'atributo cantidadSolicitada,function setcantidadSolicitada' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function setEstadoSolicitud($estadoSolicitud) {
    if (strlen(trim($estadoSolicitud)) != 0) {
      $this->estadoSolicitud = $estadoSolicitud;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO estadoSolicitud ESTA VACIO',
          'admin' => 'atributo estadoSolicitud,function setestadoSolicitud' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function listar($sqlend, $sqlGroupBy = "", $sqlOrden = "", $sqlLimit = "", $modo = "query") {
    try {
      //PREGUNTO SI VINO EN MODO QUERY O EN MODO COUNT
      $nro_registros = 0;
      $campos = array();
      if ($modo == "query") {
        $sqlCampos = " s.id_solicitud, s.id_proveedor, s.fecha_solicitud, s.id_inventario, "
                . "s.cantidad_solicitada, s.estado_solicitud,s.fecha_recepcion_solicitada,"
                . " i.inv_descripcion , p.nombre_proveedor ";
      } else {
        $sqlCampos = " count(*) as hay ";
      }
      //CONCATENO SQL CAMPOS Y SQLEND
      $sql = "SELECT " . $sqlCampos . " FROM solicitudpedido s "
              . " INNER JOIN proveedor p ON s.ID_PROVEEDOR=p.ID_PROVEEDOR "
              . " INNER JOIN inventarios i ON s.id_inventario=i.ID_INVENTARIO where 1=1 " . $sqlend;

      //AKI PREGUNTO SI VIENE SQLGROUP
      if ($sqlGroupBy != "") {
        $sql.=" GROUP BY " . $sqlGroupBy;
      }
      //AKI PREGUNTO SI VIENE SQL ORDEN
      if ($sqlOrden != "") {
        $sql.=" ORDER BY " . $sqlOrden;
      }
      //AKI PREGUNTO POR EL LIMIT 
      if ($sqlLimit != "") {
        $sql.=" LIMIT " . $sqlLimit;
      }
      //EJECUTO LA CONSULTA
      $res = $this->bd->select($sql, array());
      if ($this->bd->myException->getEstado() == 0) {
        if ($modo == "query") {
          while ($rs = $res->fetch()) {
            $campos[] = array(
                "id_proveedor" => utf8_encode($rs["id_proveedor"]),
                "id_solicitud" => utf8_encode($rs["id_solicitud"]),
                "fecha_solicitud" => utf8_encode($rs["fecha_solicitud"]),
                "id_inventario" => utf8_encode($rs["id_inventario"]),
                "cantidad_solicitada" => utf8_encode($rs["cantidad_solicitada"]),
                "estado_solicitud" => utf8_encode($rs["estado_solicitud"]),
                "inv_descripcion" => utf8_encode($rs["inv_descripcion"]),
                "nombre_proveedor" => utf8_encode($rs["nombre_proveedor"]),
                "fecha_recepcion_solicitada" => utf8_encode($rs["fecha_recepcion_solicitada"])
            );
          }
          return $campos;
        } else {
          if ($rs = $res->fetch()) {
            $numero_registros = $rs["hay"];
          } else {
            $numero_registros = 0;
          }
          return $numero_registros;
        }
      } else {
        $this->myException->setEstado(1);
        foreach ($this->bd->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR AL COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA',
          'user' => $e->getMessage() . '<br>codigo: ' . $e->getCode() . '<br>linea: ', $e->getLine() . '<br> archivo:' . $e->getFile()
      );
      $this->myException->addError($error);
    }//fin del try catch
  }

  public function buscar($idSolicitud) {
    try {
      $this->setIdSolicitud($idSolicitud);
      if ($this->myException->getEstado() == 0) {
        $sql = "Select id_solicitud from solicitudPedido where id_solicitud=?";
        $condicion = array($this->getIdSolicitud());
        $res = $this->bd->ejecutar($sql, $condicion);
        if ($this->bd->myException->getEstado() == 0) {
          if ($rs = $res->fetch()) {
            return 1;
          } else {
            return 0;
          }
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
          }
          return 0;
        }
      } else {
        return 0;
      }
    } catch (Exception $exc) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }
  }

  function crear($idProveedor, $idInventario, $cantidadSolicitada, $fechaRecepcionSolicitada) {
    try {
      $this->setIdProveedor($idProveedor);
      $this->setIdInventario($idInventario);
      $this->setCantidadSolicitada($cantidadSolicitada);
      $this->setFechaSolicitud(date("Y-m-d h:i:s"));
      $this->setEstadoSolicitud("Solicitada");
      $this->setFechaRecepcionSolicitada($fechaRecepcionSolicitada);

      if ($this->myException->getEstado() == 0) {
        $parametros = array(
            "id_proveedor" => $this->getIdProveedor(),
            "id_inventario" => $this->getIdInventario(),
            "fecha_solicitud" => $this->getFechaSolicitud(),
            "cantidad_solicitada" => $this->getCantidadSolicitada(),
            "estado_solicitud" => $this->getEstadoSolicitud(),
            "fecha_recepcion_solicitada" => $this->getFechaRecepcionSolicitada()
        );
        $rs = $this->bd->insert("solicitudPedido", $parametros);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO CREAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }
      } else {
        $this->myException->setEstado(1);
        foreach ($this->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }//fin del for each que me informa del error al realizar en insert
        return 0;
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          "user" => "SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA,",
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile());
      $this->myException->addError($error);
    }
  }

  function actualizar($idSolicitud, $idProveedor, $idInventario, $cantidadSolicitada, $estadoSolicitud, $fechaRecepcionSolicitada) {
    try {
      $this->setIdProveedor($idProveedor);
      $this->setIdSolicitud($idSolicitud);
      $this->setIdInventario($idInventario);
      $this->setCantidadSolicitada($cantidadSolicitada);
      $this->setEstadoSolicitud($estadoSolicitud);
      $this->setFechaRecepcionSolicitada($fechaRecepcionSolicitada);
      if ($this->myException->getEstado() == 0) {
        $condicion = array("id_solicitud" => $this->getIdSolicitud());
        $parametros = array(
            "id_proveedor" => $this->getIdProveedor(),
            "id_inventario" => $this->getIdInventario(),
            "cantidad_solicitada" => $this->getCantidadSolicitada(),
            "estado_solicitud" => $this->getEstadoSolicitud(),
            "fecha_recepcion_solicitada" => $this->getFechaRecepcionSolicitada()
        );
        $rs = $this->bd->update("solicitudPedido", $parametros, $condicion);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO ACTUALIZAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }
      } else {
        $this->myException->setEstado(1);
        foreach ($this->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }//fin del for each que me informa del error al realizar en insert
        return 0;
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          "user" => "SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA,",
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile());
      $this->myException->addError($error);
    }
  }

  function eliminar($idSolicitud) {
    try {
      $this->setIdSolicitud($idSolicitud);

      if ($this->myException->getEstado() == 0) {
        $condicion = array("id_solicitud" => $this->getIdSolicitud());
        $parametros = array("estado_solicitud" => "Cancelada");
        $rs = $this->bd->update("solicitudPedido", $parametros, $condicion);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO ELIMINAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }
      } else {
        $this->myException->setEstado(1);
        foreach ($this->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }//fin del for each que me informa del error al realizar en insert
        return 0;
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          "user" => "SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA,",
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile());
      $this->myException->addError($error);
    }
  }
  
  function actualizarEstado($idSolicitud){
    try {
      $this->setIdSolicitud($idSolicitud);

      if ($this->myException->getEstado() == 0) {
        $condicion = array("id_solicitud" => $this->getIdSolicitud());
        $parametros = array("estado_solicitud" => "Recepcionada");
        $rs = $this->bd->update("solicitudPedido", $parametros, $condicion);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO ELIMINAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }
      } else {
        $this->myException->setEstado(1);
        foreach ($this->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }//fin del for each que me informa del error al realizar en insert
        return 0;
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          "user" => "SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA,",
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile());
      $this->myException->addError($error);
    }
  }

  function __construct() {
    $this->myException = new MyException;
    $this->bd = new BD();
    if ($this->bd->myException->getEstado() != 0) {
      $this->myException->setEstado(1);
      foreach ($this->bd->myException->getMensaje() as $er) {
        $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
      }
    }//fin del if
  }

  public function __destruct() {
    $this->bd = NULL;
  }

//fin del destructor

  /**
   * Metodo Magico que me permite saber el nombre de la clase con la cual estoy trabajando
   * */
  public function __toString() {
    $mensaje = "CLASE SOLICITUDES";
    return $mensaje;
  }

}
