<?php

////////////////////////////////////////////////////
// Producto - Producto class
//
// Clase Producto que me va a permitir listar, actualizar,
// buscar,eliminar,crear Productos; ademas permite tener un 
// contProducto de acesso del sistema permitiendo agregar y quitar permisos
// 
// Copyright (C) 2012 - 2013  Andres Guaman
//
////////////////////////////////////////////////////

/**
 * Producto - Producto class
 * @package Producto
 * @author Andrés Guamán
 * @copyright 2012 - 2013 Andrés Guamán C.
 * */
require_once "BD.class.php";
require_once "MyException.class.php";
require_once "Utilidades.class.php";

class Producto {

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	ATRIBUTOS	#######################################################
  private $_idProducto;
  private $_nombre;
  private $_porciones;
  private $_descripcion;
  private $_idSubcategoria;
  private $_precio_unitario;
  public $bd;
  public $myException;

  #####################################	FIN DE ATRIBUTOS	###############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	METODOS GET	#######################################################

  public function getIdProducto() {
    return $this->_idProducto;
  }

  public function getIdSubcategoria() {
    return $this->_idSubcategoria;
  }

  public function getDescripcion() {
    return $this->_descripcion;
  }

  public function getPrecioUnitario() {
    return $this->_precio_unitario;
  }

  public function getNombre() {
    return $this->_nombre;
  }

  public function getPorciones() {
    return $this->_porciones;
  }

  #####################################	FIN DE METODOS GET	###############################################
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
  #####################################	METODOS SET	#######################################################

  public function setIdProducto($idProducto) {
    if (strlen(trim($idProducto)) != 0) {
      $this->_idProducto = $idProducto;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO idProducto ESTA VACIO',
          'admin' => 'atributo idProducto,function setIdProducto ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

//fin del setIdProducto

  public function setIdSubcategoria($idSubcategoria) {
    if (strlen(trim($idSubcategoria)) != 0) {
      $this->_idSubcategoria = $idSubcategoria;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO id_categoria ESTA VACIO',
          'admin' => 'atributo id_categoria,function setIdSubcategoria ' . $this->__toString()
      );
      $this->myException->addError($error);
    }//fin del if
  }

//fin del setIdProducto

  public function setDescripcion($val) {
    if (strlen(trim($val)) != 0) {
      $this->_descripcion = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO Descripcion ESTA VACIO',
          'admin' => 'atributo Descripcion,function setDescripcion ' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setNombre($val) {
    if (strlen(trim($val)) != 0) {
      $this->_nombre = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO Nombre ESTA VACIO',
          'admin' => 'atributo Nombre,function setNombre ' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setPorciones($val) {
    if (strlen(trim($val)) != 0) {
      $this->_porciones = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO Porciones ESTA VACIO',
          'admin' => 'atributo Porciones,function setPorciones ' . $this->__toString()
      );
      $this->myException->addError($error);
    }
  }

  public function setPrecioUnitario($val) {
    if (strlen(trim($val)) != 0) {
      $this->_precio_unitario = $val;
    } else {
      $this->myException->setEstado(1);
      $error = array(
          'user' => 'CAMPO Precio Unitario ESTA VACIO',
          'admin' => 'atributo precio_unitario,function setPrecioUnitario' . $this->__toString()
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
   * 	Me permite Crear un Producto al Sistema
   * @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
   * @param  	$id_categoria valor con el que el Producto se loguea
   * @param	$descripcion	Descripcion del Producto regitrado
   * */
  public function crear($idSubcategoria, $descripcion, $precioUnitario, $nombre, $porciones) {
    try {
      $this->setIdSubcategoria($idSubcategoria);
      $this->setDescripcion($descripcion);
      $this->setPrecioUnitario($precioUnitario);
      $this->setNombre($nombre);
      $this->setPorciones($porciones);

      /*       * *	aki pregunto si se cumplieron todas las validaciones de los SET	** */
      if ($this->myException->getEstado() == 0) {
        #ES 0 SI NO EXISTE EL Producto					
        $parametros = array(
            "ID_SUBCATEGORIA" => $this->getIdSubcategoria(),
            "PRO_DESCRIPCION" => $this->getDescripcion(),
            "PRO_PRECIO_UNITARIO" => $this->getPrecioUnitario(),
            "PRO_NOMBRE" => $this->getNombre(),
            "PRO_PORCIONES" => $this->getPorciones()
        );
        $rs1 = $this->bd->insert('productos', $parametros);
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
   * 	Me permite Actualizar un Producto existente en el Sistema
   * @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
   * @param  $id_categoria valor con el que el Producto se loguea
   * @param	$descripcion	Descripcion del Producto regitrado
   * */
  public function actualizar($id_producto, $id_subcategoria, $descripcion, $precio_unitario,$nombre,$porciones) {
    try {
      $this->setIdProducto($id_producto);
      $this->setIdSubcategoria($id_subcategoria);
      $this->setDescripcion($descripcion);
      $this->setPrecioUnitario($precio_unitario);
      $this->setNombre($nombre);
      $this->setPorciones($porciones);
      /*       * *	aki pregunto si se cumplieron todas las validaciones de los SET	** */
      if ($this->myException->getEstado() == 0) {
        $condicion = array("id_producto" => $this->getIdProducto());
        $parametros = array("PRO_DESCRIPCION" => $this->getDescripcion(), "ID_SUBCATEGORIA" > $this->getIdSubcategoria(),
            "PRO_PRECIO_UNITARIO" => $this->getPrecioUnitario(),"PRO_NOMBRE" => $this->getNombre(),
            "PRO_PORCIONES" => $this->getPorciones());

        $rs1 = $this->bd->update('productos', $parametros, $condicion);
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
   * Funcion Buscar que me permite validar si el Producto existe
   * @return RETORNA VALOR 1 si el Producto existe, VALOR 0 si el Producto no existe
   * @param  $idProducto valor con el que el Producto se loguea
   */
  public function buscar($idProducto) {
    $this->setIdProducto($idProducto);
    try {
      if ($this->myException->getEstado() == 0) {
        #verifico que no existan ese Producto
        $strsql = "select id_producto from productos where id_producto=?";
        $condicion = array($this->getIdProducto());
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
        }//fin del if que me contProductoa que no se haya caido la consulta
      } else {
        return 0;
      }//fin del if que me contProductoa que no se haya caido l coneccion
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
        $sqlCampos = " p.id_producto,p.id_subcategoria,p.pro_descripcion,p.pro_precio_unitario,s.subca_descripcion,"
                . "p.pro_nombre,p.pro_porciones ";
      } else {
        $sqlCampos = " count(*) as hay ";
      }
      //CONCATENO SQL CAMPOS Y SQLEND
      $sql = "SELECT " . $sqlCampos . " FROM productos p  INNER JOIN subcategorias s ON p.id_subcategoria = s.id_subcategoria
			 WHERE 1=1 and p.pro_activo='SI' " . $sqlend;

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
                "id_producto" => utf8_encode($rs["id_producto"]),
                "id_subcategoria" => utf8_encode($rs["id_subcategoria"]),
                "subca_descripcion" => utf8_encode($rs["subca_descripcion"]),
                "pro_descripcion" => utf8_encode($rs["pro_descripcion"]),
                "pro_precio_unitario" => "$ " . number_format(utf8_encode($rs["pro_precio_unitario"])),
                "pro_nombre" => utf8_encode($rs["pro_nombre"]),
                "pro_porciones" => utf8_encode($rs["pro_porciones"]),
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
      $this->setIdProducto($id);
      /*       * *	aki pregunto si se cumplieron todas las validaciones de los SET	** */
      if ($this->myException->getEstado() == 0) {
        $condicion = array("ID_PRODUCTO" => $this->getIdProducto());
        $parametros = array(
            "PRO_ACTIVO" => "NO"
        );

        $rs1 = $this->bd->update('productos', $parametros, $condicion);
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
   * Metodo Magico que me permite saber el Descripcion de la clase con la cual estoy trabajando
   * */
  public function __toString() {
    $mensaje = "CLASE Producto";
    return $mensaje;
  }

  #####################################	FIN DEL CONSTRUCTOR Y DESTRUCTOR	#################################################
}

?>