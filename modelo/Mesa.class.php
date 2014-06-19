<?
////////////////////////////////////////////////////
// Mesa - Mesa class
//
// Clase Mesa que me va a permitir listar, actualizar,
// buscar,eliminar,crear Mesas; ademas permite tener un 
// contMesa de acesso del sistema permitiendo agregar y quitar permisos
// 
// Copyright (C) 2012 - 2013  Andres Guaman
//
////////////////////////////////////////////////////

/**
 * Mesa - Mesa class
 * @package Mesa
 * @author Andrés Guamán
 * @copyright 2012 - 2013 Andrés Guamán C.
**/
require_once "BD.class.php";
require_once "MyException.class.php";
require_once "Utilidades.class.php";
class Mesa
{
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	ATRIBUTOS	#######################################################
	private $_idMesa;
	private $_nombreMesa;
	private $_posicion;
	
	public $bd; 
	public $myException;
	#####################################	FIN DE ATRIBUTOS	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS GET	#######################################################
	public function getIdMesa(){ return $this->_idMesa;	}
	public function getNombreMesa() { return $this->_nombreMesa;	}
	public function getPosicion(){ return $this->_posicion;}
	#####################################	FIN DE METODOS GET	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS SET	#######################################################
	public function setIdMesa($idMesa){
	  if(strlen(trim($idMesa))!=0){
		  $this->_idMesa=$idMesa;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO ID_Mesa ESTA VACIO',
				'admin'=>'atributo id_Mesa,function setIdMesa '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del setIdMesa

	public function setNombreMesa($val){
		if(strlen(trim($val))!=0){
			$this->_nombreMesa=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO NombreMesa ESTA VACIO',
				'admin'=>'atributo NombreMesa,function setNombreMesa '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
		public function setPosicion($val){
		if(strlen(trim($val))!=0){
			$this->_posicion=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Posicion ESTA VACIO',
				'admin'=>'atributo Posicion,function setPosicion'.$this->__toString()
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
		*	Me permite Crear un Mesa al Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param  	$id_Mesa valor con el que el Mesa se loguea
		* @param	$nombreMesa	NombreMesa del Mesa regitrado
    **/
	public function crear($nombreMesa,$posicion){
		try{
			$this->setNombreMesa($nombreMesa);
			$this->setPosicion($posicion);
				
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					#ES 0 SI NO EXISTE EL Mesa					
					$parametros=array(
						"ME_POSICION"=>$this->getPosicion(),
						"ME_NOMBRE_MESA"=>$this->getNombreMesa()
						
					);
					$rs1=$this->bd->insert('mesa',$parametros);
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
		*	Me permite Actualizar un Mesa existente en el Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param  $id_Mesa valor con el que el Mesa se loguea
		* @param	$nombreMesa	NombreMesa del Mesa regitrado
		**/
	public function actualizar($id_mesa,$nombreMesa,$posicion){
		try{
			$this->setIdMesa($id_mesa);
			$this->setNombreMesa($nombreMesa);
			$this->setPosicion($posicion);
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("ID_MESA"=>$this->getIdMesa());
					$parametros=array("ME_NOMBRE_MESA"=>$this->getNombreMesa(),"ME_POSICION"=>$this->getPosicion());
					
					$rs1=$this->bd->update('mesa',$parametros,$condicion);
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
		* Funcion Buscar que me permite validar si el Mesa existe
		* @return RETORNA VALOR 1 si el Mesa existe, VALOR 0 si el Mesa no existe
		* @param  $idMesa valor con el que el Mesa se loguea
     */
	public function buscar($idMesa){
		$this->setIdMesa($idMesa);
		try{
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese Mesa
				$strsql="select id_mesa from mesa where id_mesa=?";
				$condicion=array($this->getIdMesa());
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
				}//fin del if que me contMesaa que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que me contMesaa que no se haya caido l coneccion
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
				$sqlCampos="id_mesa, me_nombre_mesa,me_posicion";	
			}else{
				$sqlCampos=" count(*) as hay ";
			}
			//CONCATENO SQL CAMPOS Y SQLEND
			$sql="SELECT ".$sqlCampos." FROM mesa WHERE 1=1 and me_activo='SI' ".$sqlend;
			
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
							"id_mesa"=>utf8_encode($rs["id_mesa"]),
							"nombre_mesa"=>utf8_encode($rs["me_nombre_mesa"]),
							"posicion"=>utf8_encode($rs["me_posicion"])
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
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	FUNCION ELIMINAR	*********************************************************/
	/**
		* Public function ELIMINAR
		*	Me permite Eliminar un Usuario existente en el Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param	$eliminar	variable que guarda la fecha en la cual se registra el usuario
    **/
	public function eliminar($id){
		try{
			$this->setIdMesa($id);
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("ID_MESA"=>$this->getIdMesa());
					$parametros=array(
						"ME_ACTIVO"=>"NO"
					);
					
					$rs1=$this->bd->update('mesa',$parametros,$condicion);
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
	/*************************************	FIN DE LA FUNCION ELIMINAR	***************************************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		* Metodo Magico que me permite saber el NombreMesa de la clase con la cual estoy trabajando
    **/
	public function __toString(){
		$mensaje="CLASE MESA";
	    return $mensaje;
	}
	#####################################	FIN DEL CONSTRUCTOR Y DESTRUCTOR	#################################################
}

?>