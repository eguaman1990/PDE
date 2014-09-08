<?php
require_once 'BD.class.php';
require_once 'MyException.class.php';
require_once 'Utilidades.class.php';

class Proveedor {
  private $_idProveedor;
  private $_rutProveedor;
  private $_nombreProveedor;
  private $_direccion;
  private $_telefono;
  private $_celular;
  private $_email;
  public $bd;
  public $myException;

  public function get_idProveedor() {
    return $this->_idProveedor;
  }

  public function get_rutProveedor() {
    return $this->_rutProveedor;
  }

  public function get_nombreproveedor() {
    return $this->_nombreProveedor;
  }

  public function get_direccion() {
    return $this->_direccion;
  }

  public function get_telefono() {
    return $this->_telefono;
  }

  public function get_celular() {
    return $this->_celular;
  }

  public function get_email() {
    return $this->_email;
  }

  public function set_idProveedor($_idProveedor) {
    if (strlen(trim($_idProveedor)) != 0) {
      $this->_idProveedor = $_idProveedor;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO ID_PROVEEDOR ESTA VACIO',
          'admin' => 'atributo id_proveedor,function set_idProveedor ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function set_rutProveedor($_rutProveedor) {
    if (strlen(trim($_rutProveedor)) != 0) {
      $this->_rutProveedor = $_rutProveedor;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO ID_PROVEEDOR ESTA VACIO',
          'admin' => 'atributo id_proveedor,function set_idProveedor ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function set_nombreproveedor($_nombreproveedor) {
    if (strlen(trim($_nombreproveedor)) != 0) {
      $this->_nombreProveedor = $_nombreproveedor;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO nombreproveedor ESTA VACIO',
          'admin' => 'atributo nombreproveedor,function set_nombreproveedor ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function set_direccion($_direccion) {
    if (strlen(trim($_direccion)) != 0) {
      $this->_direccion = $_direccion;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO ID_PROVEEDOR ESTA VACIO',
          'admin' => 'atributo id_proveedor,function set_idProveedor ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function set_telefono($_telefono) {
    if (strlen(trim($_telefono)) != 0) {
      $this->_telefono = $_telefono;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO telefono ESTA VACIO',
          'admin' => 'atributo telefono,function set_telefono' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

  public function set_celular($_celular) {
    $this->_celular = $_celular;
  }

  public function set_email($_email) {
    $this->_email = $_email;
  }

  public function listar($sqlend, $sqlGroupBy = "", $sqlOrden = "", $sqlLimit = "", $modo = "query") {
    try {
      //PREGUNTO SI VINO EN MODO QUERY O EN MODO COUNT
      $nro_registros = 0;
      $campos = array();
      if ($modo == "query") {
        $sqlCampos = " id_proveedor,rut_proveedor,nombre_proveedor,direccion,telefono,celular, email ";
      } else {
        $sqlCampos = " count(*) as hay ";
      }
      //CONCATENO SQL CAMPOS Y SQLEND
      $sql = "SELECT " . $sqlCampos . " FROM proveedor WHERE 1=1 and activo='SI' " . $sqlend;

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
                "rut_proveedor" => utf8_encode($rs["rut_proveedor"]),
                "nombre_proveedor" => utf8_encode($rs["nombre_proveedor"]),
                "direccion" => utf8_encode($rs["direccion"]),
                "email" => utf8_encode($rs["email"]),
                "telefono" => $rs["telefono"],
                "celular" => $rs["celular"]
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

  public function buscar($idProveedor) {
    try {
      $this->set_idProveedor($idProveedor);
      if ($this->myException->getEstado() == 0) {
        $sql = "Select id_proveedor from proveedor where id_proveedor=?";
        $condicion = array($this->get_idProveedor());
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

  function crear($rutProveedor, $nombreProveedor, $direccion, $telefono, $celular, $email) {
    try {
      $this->set_rutProveedor($rutProveedor);
      $this->set_nombreproveedor($nombreProveedor);
      $this->set_direccion($direccion);
      $this->set_telefono($telefono);
      $this->set_celular($celular);
      $this->set_email($email);

      if ($this->myException->getEstado() == 0) {
        $parametros = array(
            "RUT_PROVEEDOR" => $this->get_rutProveedor(),
            "NOMBRE_PROVEEDOR" => $this->get_nombreproveedor(),
            "DIRECCION" => $this->get_direccion(),
            "TELEFONO" => $this->get_telefono(),
            "CELULAR" => $this->get_celular(),
            "EMAIL" => $this->get_email()
        );
        $rs = $this->bd->insert("proveedor", $parametros);
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

  function actualizar($idProveedor, $rutProveedor, $nombreProveedor, $direccion, $telefono, $celular, $email) {
    try {
      $this->set_idProveedor($idProveedor);
      $this->set_rutProveedor($rutProveedor);
      $this->set_nombreproveedor($nombreProveedor);
      $this->set_direccion($direccion);
      $this->set_telefono($telefono);
      $this->set_celular($celular);
      $this->set_email($email);
      if ($this->myException->getEstado() == 0) {
        $condicion = array("ID_PROVEEDOR" => $this->get_idProveedor());
        $parametros = array(
            "RUT_PROVEEDOR" => $this->get_rutProveedor(),
            "NOMBRE_PROVEEDOR" => $this->get_nombreproveedor(),
            "DIRECCION" => $this->get_direccion(),
            "TELEFONO" => $this->get_telefono(),
            "CELULAR" => $this->get_celular(),
            "EMAIL" => $this->get_email()
        );
        
        $rs = $this->bd->update("proveedor", $parametros, $condicion);
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

  function eliminar($idProveedor) {
    try {
      $this->set_idProveedor($idProveedor);

      if ($this->myException->getEstado() == 0) {
        $condicion = array("ID_PROVEEDOR" => $this->get_idProveedor());
        $parametros = array("ACTIVO" => "NO");
        $rs = $this->bd->update("proveedor", $parametros, $condicion);
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
    $mensaje = "CLASE PROVEEDOR";
    return $mensaje;
  }

}

?>