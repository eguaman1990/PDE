<?php
////////////////////////////////////////////////////
// Inventario - Inventario class
//
// Clase Inventario que me va a permitir listar, actualizar,
// buscar,eliminar,crear Inventarios; ademas permite tener un 
// contInventario de acesso del sistema permitiendo agregar y quitar permisos
// 
// Copyright (C) 2012 - 2013  Andres Guaman
//
////////////////////////////////////////////////////

/**
 * Inventario - Inventario class
 * @package Inventario
 * @author Andrés Guamán
 * @copyright 2012 - 2013 Andrés Guamán C.
**/
require_once "BD.class.php";
require_once "MyException.class.php";
require_once "Utilidades.class.php";
class Inventario
{
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	ATRIBUTOS	#######################################################
	private $_idInventario;
	private $_cantidad;
	private $_fecha_ingreso;
	private $_fecha_vencimiento;
	private $_stock_minimo;
	private $_precio_unitario;
	private $_descripcion;
	private $_unidad;
	
	public $bd; 
	public $myException;
	#####################################	FIN DE ATRIBUTOS	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS GET	#######################################################
	public function getIdInventario(){ return $this->_idInventario;	}
	public function getFechaIngreso(){ return $this->_fecha_ingreso;	}
	public function getFechaVencimiento(){ return $this->_fecha_vencimiento;	}
	public function getStockMinimo(){ return $this->_stock_minimo;	}
	public function getCantidad()		{ return $this->_cantidad;	}
	public function getPrecioUnitario()		{ return $this->_precio_unitario;	}
	public function getDescripcion()		{ return $this->_descripcion;	}
	public function getUnidad()		{ return $this->_unidad;	}
	#####################################	FIN DE METODOS GET	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS SET	#######################################################
	public function setIdInventario($idInventario){
	  if(strlen(trim($idInventario))!=0){
		  $this->_idInventario=$idInventario;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO idInventario ESTA VACIO',
				'admin'=>'atributo idInventario,function setIdInventario '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del setIdInventario
			
	public function setFechaIngreso($fechaIngreso){
	  if(strlen(trim($fechaIngreso))!=0){
		  $this->_fecha_ingreso=$fechaIngreso;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO fecha_ingreso ESTA VACIO',
				'admin'=>'atributo fecha_ingreso,function setFechaIngreso '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del set
	
	public function setFechaVencimiento($fechaVencimiento){
	  if(strlen(trim($fechaVencimiento))!=0){
		  $this->_fecha_vencimiento=$fechaVencimiento;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO fecha_vencimiento ESTA VACIO',
				'admin'=>'atributo fecha_vencimieto,function setFechaVencimiento '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del set
	
	public function setStockMinimo($stockMinimo){
	  if(strlen(trim($stockMinimo))!=0){
		  $this->_stock_minimo=$stockMinimo;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO stockMinimo ESTA VACIO',
				'admin'=>'atributo stockMinimo,function setStockMinimo '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del set
	
	public function setCantidad($val){
		if(strlen(trim($val))!=0){
			$this->_cantidad=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Cantidad ESTA VACIO',
				'admin'=>'atributo Cantidad,function setCantidad '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setPrecioUnitario($val){
		if(strlen(trim($val))!=0){
			$this->_precio_unitario=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Precio Unitario ESTA VACIO',
				'admin'=>'atributo precio_unitario,function setPrecioUnitario'.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setDescripcion($val){
		if(strlen(trim($val))!=0){
			$this->_descripcion=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Descripcion ESTA VACIO',
				'admin'=>'atributo descripcion,function setDescripcion'.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setUnidad($val){
		if(strlen(trim($val))!=0){
			$this->_unidad=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Unidad ESTA VACIO',
				'admin'=>'atributo unidad,function setUnidad'.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	#####################################	FIN DE LOS METODOS SET	#############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	INICIO DE LOS METODOS		#############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	FUNCION CREAR		***************************************************/
	/**
		* Public function crear
		*	Me permite Crear un Inventario al Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param  	$id_categoria valor con el que el Inventario se loguea
		* @param	$cantidad	Cantidad del Inventario regitrado
    **/
	public function crear($fechaIngreso,$fechaVencimiento,$cantidad,$precioUnitario,$stockMinimo,$descripcion,$unidad){
		try{
			$this->setFechaIngreso(Utilidades::fechaMysql($fechaIngreso));
			$this->setFechaVencimiento(Utilidades::fechaMysql($fechaVencimiento));
			$this->setStockMinimo($stockMinimo);
			$this->setCantidad($cantidad);
			$this->setPrecioUnitario($precioUnitario);
			$this->setDescripcion($descripcion);
			$this->setUnidad($unidad);
			
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					#ES 0 SI NO EXISTE EL Inventario					
					$parametros=array(
						"INV_FECHA_INGRESO"=>$this->getFechaIngreso(),
						"INV_FECHA_VENCIMIENTO"=>$this->getFechaVencimiento(),
						"INV_CANTIDAD"=>$this->getCantidad(),
						"INV_PRECIO_UNITARIO"=>$this->getPrecioUnitario(),
						"INV_STOCK_MINIMO"=>$this->getStockMinimo(),
						"INV_DESCRIPCION"=>$this->getDescripcion(),
						"INV_UNIDAD"=>$this->getUnidad()
					);
					$rs1=$this->bd->insert('inventarios',$parametros);
					if ($this->bd->myException->getEstado()==0){
						return 1;
					}else{
						$this->myException->setEstado(1);
						foreach($this->bd->myException->getMensaje() as $er){
							$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO CREAR ".$this->__toString()." ".$parametros));
						}//fin del for each que me informa del error al realizar en insert
					}//fin del if que verifica que la coneccion no se pierda
			}else{
				$this->myException->setEstado(1);
				foreach($this->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
				}//fin del for each que me informa del error al realizar en insert
				return 0;
			}//fin del if verifica que la conexion no se haya perdido
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}//fin del try catch
	}//fin de la funcion crear
	/*************************************	FIN DE LA FUNCION CREAR		***************************************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	FUNCION ACTUALIZAR	*********************************************************/
	/**
		* Public function ACTUALIZAR
		*	Me permite Actualizar un Inventario existente en el Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param  $id_categoria valor con el que el Inventario se loguea
		* @param	$cantidad	Cantidad del Inventario regitrado
		**/
	public function actualizar($id_inventario, $fechaIngreso,$fechaVencimiento,$cantidad,$precioUnitario,$stockMinimo,$descripcion,$unidad){
		try{
			$this->setFechaIngreso(Utilidades::fechaMysql($fechaIngreso));
			$this->setFechaVencimiento(Utilidades::fechaMysql($fechaVencimiento));
			$this->setStockMinimo($stockMinimo);
			$this->setCantidad($cantidad);
			$this->setPrecioUnitario($precioUnitario);
			$this->setDescripcion($descripcion);
			$this->setUnidad($unidad);
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("id_inventario"=>$this->getIdInventario());
					$parametros=array(
						"INV_FECHA_INGRESO"=>$this->getFechaIngreso(),
						"INV_FECHA_VENCIMIENTO"=>$this->getFechaVencimiento(),
						"INV_CANTIDAD"=>$this->getCantidad(),
						"INV_PRECIO_UNITARIO"=>$this->getPrecioUnitario(),
						"INV_STOCK_MINIMO"=>$this->getStockMinimo(),
						"INV_DESCRIPCION"=>$this->getDescripcion(),
						"INV_UNIDAD"=>$this->getUnidad()
					);
					
					$rs1=$this->bd->update('Inventarios',$parametros,$condicion);
					if ($this->bd->myException->getEstado()==0){
						return 1;
					}else{
						$this->myException->setEstado(1);
						foreach($this->bd->myException->getMensaje() as $er){
							$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO ACTUALIZAR ".$this->__toString()." ".$parametros));
						}//fin del for each que me informa del error al realizar en insert
					}//fin del if que verifica que la coneccion no se pierda
				}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}//fin del try catch
	}//fin de la funcion actualizar
	/*************************************	FIN DE LA FUNCION ACTUALIZAR		***************************************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION BUSCAR		***********************************************/
	/**
		* Funcion Buscar que me permite validar si el Inventario existe
		* @return RETORNA VALOR 1 si el Inventario existe, VALOR 0 si el Inventario no existe
		* @param  $idInventario valor con el que el Inventario se loguea
     */
	public function buscar($idInventario){
		$this->setIdInventario($idInventario);
		try{
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese Inventario
				$strsql="select id_inventario from Inventarios where id_inventario=?";
				$condicion=array($this->getIdInventario());
				$res=$this->bd->ejecutar($strsql,$condicion);
				if ($this->bd->myException->getEstado()==0){
					if ($rs=$res->fetch()){
						return 1;//devuelve 1 si encuentra
					}else{
						return 0;//devuelve 0 si no encuentra anda
					}//fin del if que me permite verificar si encontro datos o no
				}else{
					$this->myException->setEstado(1);
					foreach($this->bd->myException->getMensaje() as $er){
						$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
					}
					return 0;
				}//fin del if que me contInventarioa que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que me contInventarioa que no se haya caido l coneccion
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}//fin del try catch
	}//fin de la funcio buscar
	/***********************	FIN DE LA FUNCION BUSCAR	************************************/
	/////////////////////////////////////////////////////////////////////////////////////////////
	/***********************	INICIO DE LA FUNCION LISTAR		********************************/
	/**
		* Funcion Listar que me permite listar todos loss parametros de mi consulta
		* @return RETORNA un array de valores que son los datos de mi siniestro
		* @param  $sqlend trae conformado el WHERE que se le pega a la query, ej: "WHERE 1=1"
		* @param  $sqlGroupBy recibe el campo con el cual se va a agrupar la lista, ej: t1.campo1, t2.campo2
		* @param  $sqlorden debe traer el alias y el campos por el cual se ordena puede ser uno o mas, ej: t1.campo1, t2.campo2
		* @param  $sqllimit indica el limite de la consulta, ej: 0,20
		* @param  $modo indica si el metodo devuelve el recordset o el numero de regisgtro que se obtienen a partir de la query // query - count		
    */
	public function listar($sqlend,$sqlGroupBy="",$sqlOrden="",$sqlLimit="",$modo="query"){
		try{
			//PREGUNTO SI VINO EN MODO QUERY O EN MODO COUNT
			$nro_registros=0;
      $campos=array();
			$campos=array();
			if($modo=="query"){
				$sqlCampos=" ID_INVENTARIO, INV_CANTIDAD, INV_FECHA_INGRESO, INV_FECHA_VENCIMIENTO, INV_STOCK_MINIMO, INV_PRECIO_UNITARIO, INV_DESCRIPCION, INV_UNIDAD ";	
			}else{
				$sqlCampos=" count(*) as hay ";
			}
			//CONCATENO SQL CAMPOS Y SQLEND
			$sql="SELECT ".$sqlCampos." FROM inventarios WHERE 1=1 ".$sqlend;
			
			//AKI PREGUNTO SI VIENE SQLGROUP
			if($sqlGroupBy!=""){
				$sql.=" GROUP BY ".$sqlGroupBy;
			}
			//AKI PREGUNTO SI VIENE SQL ORDEN
			if($sqlOrden!=""){
				$sql.=" ORDER BY ".$sqlOrden;
			}
			//AKI PREGUNTO POR EL LIMIT 
			if($sqlLimit!=""){
				$sql.=" LIMIT ".$sqlLimit;
			}
			//EJECUTO LA CONSULTA
			$res=$this->bd->select($sql,array());
			if($this->bd->myException->getEstado()==0){
				if($modo=="query"){
					while($rs=$res->fetch()){
						$campos[]=array(
							"id_inventario"=>utf8_encode($rs["ID_INVENTARIO"]),
							"cantidad"=>utf8_encode($rs["INV_CANTIDAD"]),
							"fecha_ingreso"=>utf8_encode($rs["INV_FECHA_INGRESO"]),
							"fecha_vencimiento"=>utf8_encode($rs["INV_FECHA_VENCIMIENTO"]),
							"stock_minimo"=>utf8_encode($rs["INV_STOCK_MINIMO"]),
							"precio_unitario"=>utf8_encode($rs["INV_PRECIO_UNITARIO"]),
							"descripcion"=>utf8_encode($rs["INV_DESCRIPCION"]),
							"unidad"=>utf8_encode($rs["INV_UNIDAD"])
						);
					}
					return $campos;
				}else{
					if($rs=$res->fetch()){
						$numero_registros=$rs["hay"];
					}else{
						$numero_registros=0;					
					}
					return $numero_registros;
				}
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
				}
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
				'user'=>'SE PRODUJO UN ERROR AL COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA',
				'user'=>$e->getMessage().'<br>codigo: '.$e->getCode().'<br>linea: ',$e->getLine().'<br> archivo:'.$e->getFile()
			);
			$this->myException->addError($error);
		}//fin del try catch
	}
	/*************************************	FIN DE LA FUNCTION LISTAR		**************************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	FIN DE LOS METODOS		###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	CONSTRUCTOR Y DESTRUCTOR	###########################################
	/**
		* Metodo magico en el cual inicializo la clase bd y la myException
    **/
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
		$mensaje="CLASE Inventario";
	    return $mensaje;
	}
	#####################################	FIN DEL CONSTRUCTOR Y DESTRUCTOR	#################################################
}

?>