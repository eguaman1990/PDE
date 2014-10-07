<?php

require_once 'BD.class.php';
require_once 'MyException.class.php';
require_once 'Utilidades.class.php';

class Recepcion {

  public $bd;
  public $myExcepcion;
  private $idRecepcion;
  private $idSolicitud;
  private $fechaRecepcion;
  private $cantidadRecepcion;
  private $descuento;
  private $estadoRecepcion;

  public function getIdRecepcion() {
    return $this->idRecepcion;
  }

  public function getIdSolicitud() {
    return $this->idSolicitud;
  }

  public function getFechaRecepcion() {
    return $this->fechaRecepcion;
  }

  public function getCantidadRecepcion() {
    return $this->cantidadRecepcion;
  }

  public function getDescuento() {
    return $this->descuento;
  }

  public function getEstadoRecepcion() {
    return $this->estadoRecepcion;
  }

  public function setIdRecepcion($idRecepcion) {
    $this->idRecepcion = $idRecepcion;
  }

  public function setIdSolicitud($idSolicitud) {
    $this->idSolicitud = $idSolicitud;
  }

  public function setFechaRecepcion($fechaRecepcion) {
    $this->fechaRecepcion = $fechaRecepcion;
  }

  public function setCantidadRecepcion($cantidadRecepcion) {
    $this->cantidadRecepcion = $cantidadRecepcion;
  }

  public function setDescuento($descuento) {
    $this->descuento = $descuento;
  }

  public function setEstadoRecepcion($estadoRecepcion) {
    $this->estadoRecepcion = $estadoRecepcion;
  }

  function buscar($idRecepcion) {
    try {
      $this->setIdRecepcion($idRecepcion);
      if ($this->myException->getEstado() == 0) {
        $sql = "Select id_recepcion from recepcionpedidos where id_recepcion=?";
        $condicion = array($this->getIdRecepcion());
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
  
  function crear($idSolicitud,$descuento,$cantidadRecepcion,$estadoRecepcion){
    try {
      $this->setIdSolicitud($idSolicitud);
      $this->setDescuento($descuento);
      $this->setCantidadRecepcion($cantidadRecepcion);
      $this->setFechaRecepcion(date("Y-m-d h:i:s"));
      $this->setEstadoRecepcion($estadoRecepcion);
      

      if ($this->myException->getEstado() == 0) {
        $parametros = array(
            "id_solicitud" => $this->getIdSolicitud(),
            "descuento" => $this->getDescuento(),
            "fecha_recepcion" => $this->getFechaRecepcion(),
            "cantidad_recepcion" => $this->getCantidadRecepcion(),
            "estado_recepcion" => $this->getEstadoRecepcion()
        );
        $rs = $this->bd->insert("recepcionPedidos", $parametros);
        if ($this->bd->myException->getEstado() == 0) {
          return 1;
        } else {
          $this->myException->setEstado(1);
          foreach ($this->bd->myException->getMensaje() as $er) {
            $this->myException->addError(array('user' => $er['user'], 'admin' => $er['admin'] . 
                " METODO CREAR " . $this->__toString() . " " . $parametros));
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
          'admin' => $e->getMessage() . "<br>codigo: " . $e->getCode() . "<br>linea: " . $e->getLine() . 
          "<br>archivo: " . $e->getFile());
      $this->myException->addError($error);
    }
  }
  
  public function __construct(){
	    $this->myException= new MyException;
	    $this->bd = new BD();
	    if  ($this->bd->myException->getEstado()!=0){
		    $this->myException->setEstado(1);
	  	    foreach($this->bd->myException->getMensaje() as $er){
			    $this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
		    }
	    }//fin del if
	}//fin del constructor
	/**
		* Metodo Magico ue destruye mi objeto bd 
    **/
	public function __destruct(){
	    $this->bd=NULL;
	}//fin del destructor
	
	/**
		* Metodo Magico que me permite saber el Cantidad de la clase con la cual estoy trabajando
    **/
	public function __toString(){
		$mensaje="CLASE Recepcion";
	    return $mensaje;
	}

}
