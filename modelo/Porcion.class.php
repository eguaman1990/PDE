<?php
////////////////////////////////////////////////////
// Porcion - Porcion class
//
// Clase Porcion que me va a permitir listar, actualizar,
// buscar,eliminar,crear Porcion; ademas permite tener un 
// contPorcion de acesso del sistema permitiendo agregar y quitar permisos
// 
// Copyright (C) 2012 - 2013  Andres Guaman
//
////////////////////////////////////////////////////

/**
 * Porcion - Porcion class
 * @package Porcion
 * @author Andrés Guamán
 * @copyright 2012 - 2013 Andrés Guamán C.
 * */
require_once "BD.class.php";
require_once "MyException.class.php";
require_once "Utilidades.class.php";

class Porcion {

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	ATRIBUTOS	#######################################################
  private $_idPorcion;
  private $_idProducto;
  private $_idInventario;
  private $_porcion;
  private $_unidad;
  public $bd;
  public $myException;

  #####################################	FIN DE ATRIBUTOS	###############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	METODOS GET	#######################################################

  public function getIdPorcion() {
    return $this->_idPorcion;
  }

  public function getIdInventario() {
    return $this->_idInventario;
  }

  public function getIdProducto() {
    return $this->_idProducto;
  }

  public function getPorcion() {
    return $this->_porcion;
  }

  public function getUnidad() {
    return $this->_unidad;
  }

  #####################################	FIN DE METODOS GET	###############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	METODOS SET	#######################################################

  public function setIdPorcion($idPorcion) {
    if (strlen(trim($idPorcion)) != 0) {
      $this->_idPorcion = $idPorcion;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idPorcion ESTA VACIO',
          'admin' => 'atributo idPorcion,function setIdPorcion ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

//fin del setIdPorcion

  public function setIdInventario($idSubcategoria) {
    if (strlen(trim($idSubcategoria)) != 0) {
      $this->_idInventario = $idSubcategoria;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO id_inventario ESTA VACIO',
          'admin' => 'atributo id_inventario ,function setIdInventario ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

//fin del setIdPorcion

  public function setIdProducto($val) {
    if (strlen(trim($val)) != 0) {
      $this->_idProducto = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO IdProducto ESTA VACIO',
          'admin' => 'atributo IdProducto,function setIdProducto ' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setPorcion($val) {
    if (strlen(trim($val)) != 0) {
      $this->_porcion = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO porcion ESTA VACIO',
          'admin' => 'atributo porcion,function setPorcion' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setUnidad($val) {
    if (strlen(trim($val)) != 0) {
      $this->_unidad = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO Unidad ESTA VACIO',
          'admin' => 'atributo unidad ,function setUnidad' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  #####################################	FIN DE LOS METODOS SET	#############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	INICIO DE LOS METODOS		#############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*   * ***********************************	FUNCION CREAR		************************************************** */

  /**
   * Public function crear
   * 	Me permite Crear un Porcion al Sistema
   * @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
   * @param  	$id_categoria valor con el que el Porcion se loguea
   * @param	$id_producto	IdProducto del Porcion regitrado
   * */
  public function crear($idInventario, $id_producto, $porcion, $unidad) {
    try {
      $this->setIdInventario($idInventario);
      $this->setIdProducto($id_producto);
      $this->setPorcion($porcion);
      $this->setUnidad($unidad);

      /* aki pregunto si se cumplieron todas las validaciones de los SET	** */
      if ($this->myException->getEstado() == 0) {
        #ES 0 SI NO EXISTE EL Porcion					
        $parametros = array(
            "id_inventario" => $this->getIdInventario(),
            "id_producto" => $this->getIdProducto(),
            "porc_porcion" => $this->getPorcion(),
            "porc_unidad" => $this->getUnidad()
        );
        $rs1 = $this->bd->insert('Porciones', $parametros);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO CREAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }//fin del if que verifica que la coneccion no se pierda
      } else {
        $this->myException->setEstado(1);
        foreach ($this->myException->getMensaje() as $er) {
          $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
        }//fin del for each que me informa del error al realizar en insert
        return 0;
      }//fin del if verifica que la conexion no se haya perdido
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }//fin del try catch
  }

//fin de la funcion crear
  /*   * ***********************************	FIN DE LA FUNCION CREAR		************************************************** */
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*   * ***********************************	FUNCION ACTUALIZAR	******************************************************** */

  /**
   * Public function ACTUALIZAR
   * 	Me permite Actualizar un Porcion existente en el Sistema
   * @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
   * @param  $id_categoria valor con el que el Porcion se loguea
   * @param	$id_producto	IdProducto del Porcion regitrado
   * */
  public function actualizar($id_porcion, $id_inventario, $id_producto, $porcion, $unidad) {
    try {
      $this->setIdPorcion($id_porcion);
      $this->setIdInventario($id_inventario);
      $this->setIdProducto($id_producto);
      $this->setPorcion($porcion);
      $this->setUnidad($unidad);
      /*       * *	aki pregunto si se cumplieron todas las validaciones de los SET	** */
      if ($this->myException->getEstado() == 0) {
        $condicion = array("id_porcion" => $this->getIdPorcion());
        $parametros = array("id_producto" => $this->getIdProducto(), "id_inventario" => $this->getIdInventario(),
            "porc_porcion" => $this->getPorcion(),"porc_unidad"=>$this->getUnidad());

        $rs1 = $this->bd->update('porciones', $parametros, $condicion);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO ACTUALIZAR " . $this->__toString() . " " . $parametros));
          }//fin del for each que me informa del error al realizar en insert
        }//fin del if que verifica que la coneccion no se pierda
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }//fin del try catch
  }

//fin de la funcion actualizar
  /*   * ***********************************	FIN DE LA FUNCION ACTUALIZAR		************************************************** */
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*   * ***********************************	INICIO DE LA FUNCION BUSCAR		********************************************** */

  /**
   * Funcion Buscar que me permite validar si el Porcion existe
   * @return RETORNA VALOR 1 si el Porcion existe, VALOR 0 si el Porcion no existe
   * @param  $idPorcion valor con el que el Porcion se loguea
   */
  public function buscar($idPorcion) {
    $this->setIdPorcion($idPorcion);
    try {
      if ($this->myException->getEstado() == 0) {
        #verifico que no existan ese Porcion
        $strsql = "select id_porcion from porciones where id_porcion=?";
        $condicion = array($this->getIdPorcion());
        $res = $this->bd->ejecutar($strsql, $condicion);
        if ($this->bd->myException->getEstado() == 0) {
          if ($rs = $res->fetch()) {
            return 1; //devuelve 1 si encuentra
          } else {
            return 0; //devuelve 0 si no encuentra anda
          }//fin del if que me permite verificar si encontro datos o no
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin']));
          }
          return 0;
        }//fin del if que me contPorciona que no se haya caido la consulta
      } else {
        return 0;
      }//fin del if que me contPorciona que no se haya caido l coneccion
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }//fin del try catch
  }

//fin de la funcio buscar
  /*   * *********************	FIN DE LA FUNCION BUSCAR	*********************************** */
  /////////////////////////////////////////////////////////////////////////////////////////////
  /*   * *********************	INICIO DE LA FUNCION LISTAR		******************************* */

  /**
   * Funcion Listar que me permite listar todos loss parametros de mi consulta
   * @return RETORNA un array de valores que son los datos de mi siniestro
   * @param  $sqlend trae conformado el WHERE que se le pega a la query, ej: "WHERE 1=1"
   * @param  $sqlGroupBy recibe el campo con el cual se va a agrupar la lista, ej: t1.campo1, t2.campo2
   * @param  $sqlorden debe traer el alias y el campos por el cual se ordena puede ser uno o mas, ej: t1.campo1, t2.campo2
   * @param  $sqllimit indica el limite de la consulta, ej: 0,20
   * @param  $modo indica si el metodo devuelve el recordset o el numero de regisgtro que se obtienen a partir de la query // query - count		
   */
  public function listar($sqlend, $sqlGroupBy = "", $sqlOrden = "", $sqlLimit = "", $modo = "query") {
    try {
      //PREGUNTO SI VINO EN MODO QUERY O EN MODO COUNT
      $nro_registros = 0;
      $campos = array();
      if ($modo == "query") {
        $sqlCampos = " por.id_porcion, i.inv_descripcion, por.porc_porcion, por.porc_unidad, pro.pro_descripcion, pro.id_producto,por.id_inventario ";
      } else {
        $sqlCampos = " count(*) as hay ";
      }
      //CONCATENO SQL CAMPOS Y SQLEND
      $sql = "SELECT " . $sqlCampos . " from porciones por INNER JOIN productos pro ON por.ID_PRODUCTO=pro.ID_PRODUCTO "
              . "INNER JOIN inventarios i ON por.ID_INVENTARIO=i.ID_INVENTARIO where 1=1 " . $sqlend;

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
                "id_porcion" => utf8_encode($rs["id_porcion"]),
                "inv_descripcion" => utf8_encode($rs["inv_descripcion"]),
                "porc_porcion" => utf8_encode($rs["porc_porcion"]),
                "porc_unidad" => utf8_encode($rs["porc_unidad"]),
                "pro_descripcion" => utf8_encode($rs["pro_descripcion"]),
                "id_producto" => utf8_encode($rs["id_producto"]),
                "id_inventario" => utf8_encode($rs["id_inventario"])
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

  /*   * ***********************************	FIN DE LA FUNCTION LISTAR		************************************* */
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*   * ***********************************	FUNCION ELIMINAR	******************************************************** */

  /**
   * Public function ELIMINAR
   * 	Me permite Eliminar un Usuario existente en el Sistema
   * @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
   * @param	$eliminar	variable que guarda la fecha en la cual se registra el usuario
   * */
  public function eliminar($id) {
    try {
      $this->setIdPorcion($id);
      /*       * *	aki pregunto si se cumplieron todas las validaciones de los SET	** */
      if ($this->myException->getEstado() == 0) {
        $condicion = array("id_porcion" => $this->getIdPorcion());
        $rs1 = $this->bd->delete('porciones',$condicion);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . " METODO ELIMINAR " . $this->__toString() . " " . $condicion));
          }//fin del for each que me informa del error al realizar en insert
        }//fin del if que verifica que la coneccion no se pierda
      }
    } catch (Exception $e) {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . "<br>archivo: " . $e->getFile()
      );
      $this->myException->addError($error);
    }//fin del try catch
  }

//fin de la funcion actualizar
  /*   * ***********************************	FIN DE LA FUNCION ELIMINAR	************************************************** */

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	FIN DE LOS METODOS		###############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	CONSTRUCTOR Y DESTRUCTOR	###########################################
  /**
   * Metodo magico en el cual inicializo la clase bd y la myException
   * */
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
   * Metodo Magico que me permite saber el IdProducto de la clase con la cual estoy trabajando
   * */
  public function __toString() {
    $mensaje = "CLASE Porcion";
    return $mensaje;
  }

  #####################################	FIN DEL CONSTRUCTOR Y DESTRUCTOR	#################################################
}

?>