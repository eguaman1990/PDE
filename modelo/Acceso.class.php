<?php
////////////////////////////////////////////////////
// Acceso - Acceso class
//
// Clase Acceso que me va a permitir listar, actualizar,
// buscar,eliminar,crear acceso; ademas permite tener un 
// contAcceso de acesso del sistema permitiendo agregar y quitar permisos
// 
// Copyright (C) 2012 - 2013  Andres Guaman
//
////////////////////////////////////////////////////

/**
 * Acceso - Acceso class
 * @package Acceso
 * @author Andrés Guamán
 * @copyright 2012 - 2013 Andrés Guamán C.
**/
require_once "BD.class.php";
require_once "MyException.class.php";
require_once "Utilidades.class.php";
class Acceso
{
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	ATRIBUTOS	#######################################################
	private $_idAcceso;
	private $_temporizador;
	private $_idMesa;
	
	public $bd; 
	public $myException;
	#####################################	FIN DE ATRIBUTOS	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS GET	#######################################################
	public function getIdAcceso(){ return $this->_idAcceso;	}
	public function getIdMesa(){ return $this->_idMesa;	}
	public function getTemporizador()		{ return $this->_temporizador;	}
	#####################################	FIN DE METODOS GET	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS SET	#######################################################
	public function setIdAcceso($idAcceso){
	  if(strlen(trim($idAcceso))!=0){
		  $this->_idAcceso=$idAcceso;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO idAcceso ESTA VACIO',
				'admin'=>'atributo idAcceso,function setIdAcceso '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del setIdAcceso
	
	public function setIdMesa($idMesa){
	  if(strlen(trim($idMesa))!=0){
		  $this->_idMesa=$idMesa;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO id_categoria ESTA VACIO',
				'admin'=>'atributo id_categoria,function setIdMesa '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del setIdAcceso

	public function setTemporizador($val){
		if(strlen(trim($val))!=0){
			$this->_temporizador=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Temporizador ESTA VACIO',
				'admin'=>'atributo Temporizador,function setTemporizador '.$this->__toString()
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
		*	Me permite Crear un Acceso al Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param 	$id_categoria valor con el que el Acceso se loguea
		* @param	$temporizador	Temporizador del Acceso regitrado
    **/
	public function crear($idMesa, $temporizador){
		try{
			$this->setIdMesa($idMesa);
			$this->setTemporizador($temporizador);
				
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					#ES 0 SI NO EXISTE EL Acceso					
					$parametros=array(
						"ID_CATEGORIA"=>$this->getIdMesa(),
						"SUBCA_DESCRIPCION"=>$this->getTemporizador()
					);
					$rs1=$this->bd->insert('acceso',$parametros);
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
	/*************************************	FUNCION LOGIN		***************************************************/
	/**
		* Public function login
		*	Me permite login un Acceso al Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param 	$id_acceso id de acceso al sistema 
		* @param	$id_mesa	Id de la mesa en la cual estara ingresado el paciente
		
    **/
	public function login($idAcceso){
		$this->setIdAcceso($idAcceso);
		try{
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese Acceso
				$strsql="select id_acceso from acceso where id_acceso=? AND "
                . " (ISNULL(temporizador) or DATEDIFF(NOW(),TEMPORIZADOR)=0);";
				$condicion=array($this->getIdAcceso());
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
				}//fin del if que me contAccesoa que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que me contAccesoa que no se haya caido l coneccion
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
		*	Me permite Actualizar un Acceso existente en el Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param  $id_categoria valor con el que el Acceso se loguea
		* @param	$temporizador	Temporizador del Acceso regitrado
		**/
	public function actualizar($idAcceso){
		try{
			$this->setIdAcceso($idAcceso);
			$this->setTemporizador(date("Y-m-d h:i:s"));
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("id_acceso"=>$this->getIdAcceso());
					$parametros=array("temporizador"=>$this->getTemporizador());
					
					$rs1=$this->bd->update('acceso',$parametros,$condicion);
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
		* Funcion Buscar que me permite validar si el Acceso existe
		* @return RETORNA VALOR 1 si el Acceso existe, VALOR 0 si el Acceso no existe
		* @param  $idAcceso valor con el que el Acceso se loguea
     */
	public function buscar($idAcceso){
		$this->setIdAcceso($idAcceso);
		try{
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese Acceso
				$strsql="select id_subcategoria from acceso where id_subcategoria=?";
				$condicion=array($this->getIdAcceso());
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
				}//fin del if que me contAccesoa que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que me contAccesoa que no se haya caido l coneccion
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
  public function validaSession($idAcceso){
		$this->setIdAcceso($idAcceso);
		try{
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese Acceso
				$strsql="SELECT ID_ACCESO FROM acceso WHERE id_acceso=? AND DATEDIFF(NOW(),TEMPORIZADOR)=0;";
				$condicion=array($this->getIdAcceso());
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
				}//fin del if que me contAccesoa que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que me contAccesoa que no se haya caido l coneccion
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
			if($modo=="query"){
				$sqlCampos=" a.ID_ACCESO,a.ID_MESA,a.TEMPORIZADOR,m.ME_NOMBRE_MESA ";	
			}else{
				$sqlCampos=" count(*) as hay ";
			}
			//CONCATENO SQL CAMPOS Y SQLEND
			$sql="SELECT ".$sqlCampos." FROM acceso a INNER JOIN mesa m ON a.ID_MESA=m.ID_MESA 
			 WHERE 1=1 AND m.ME_ACTIVO='SI' ".$sqlend;
			
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
							"id_acceso"=>utf8_encode($rs["ID_ACCESO"]),
							"id_mesa"=>utf8_encode($rs["ID_MESA"]),
							"temporizador"=>utf8_encode($rs["TEMPORIZADOR"]),
							"mesa"=>utf8_encode($rs["ME_NOMBRE_MESA"])
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
		* Metodo Magico que me permite saber el Temporizador de la clase con la cual estoy trabajando
    **/
	public function __toString(){
		$mensaje="CLASE Acceso";
	    return $mensaje;
	}
	#####################################	FIN DEL CONSTRUCTOR Y DESTRUCTOR	#################################################
}

?>