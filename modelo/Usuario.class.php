<?php
////////////////////////////////////////////////////
// Usuario - Usuario class
//
// Clase Usuario que me va a permitir listar, actualizar,
// buscar,eliminar,crear usuarios; ademas permite tener un 
// control de acesso del sistema permitiendo agregar y quitar permisos
// 
// Copyright (C) 2012 - 2013  Andres Guaman
//
////////////////////////////////////////////////////

/**
 * Usuario - Usuario class
 * @package Usuario
 * @author Andrés Guamán
 * @copyright 2012 - 2013 Andrés Guamán C.
**/
require_once './BD.class.php';
require_once './MyException.class.php';
require_once "./Utilidades.class.php";
class Usuario
{
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	ATRIBUTOS	#######################################################
	private $_idUsuario;
	private $_idCargo;
	private $_user;
	private $_clave;
	private $_nombre;
	private $_apellido;
	private $_direccion;
	private $_email;
	private $_fono;
	private $_password;
	private $_uid;
	private $edad;

	public $bd; 
	public $myException;
	#####################################	FIN DE ATRIBUTOS	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS GET	#######################################################
	public function getIdUsuario(){ return $this->_idUsuario;	}
	public function getClave()		{ return $this->_clave;	}
	public function getNombre()		{ return $this->_nombre;	}
	public function getEmail()		{	return $this->_email;	}
	public function getFono()		{ return $this->_fono;	}
	public function getPassword()	{ return $this->_password;		}
	public function getUid()			{ return $this->_uid;			}
	public function getApellido()		{ return $this->_apellido;	}
	public function getUser()		{ return $this->_user;	}
	public function getDireccion()		{ return $this->_direccion;	}
	public function getIdCargo()		{ return $this->_idCargo;	}
	public function getEdad()		{ return $this->_edad;	}
	#####################################	FIN DE METODOS GET	###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	METODOS SET	#######################################################
	public function setIdUsuario($idUsuario){
	  if(strlen(trim($idUsuario))!=0){
		  $this->_idUsuario=$idUsuario;
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO ID_USUARIO ESTA VACIO',
				'admin'=>'atributo id_usuario,function setIdUsuario '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin del setIdUsuario
	
	public function setClave($clave){
		if(strlen(trim($clave))!=0){
			$this->_clave=$clave;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO ID_USUARIO ESTA VACIO',
				'admin'=>'atributo clave,function setClave '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setNombre($val){
		if(strlen(trim($val))!=0){
			$this->_nombre=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO NOMBRE ESTA VACIO',
				'admin'=>'atributo nombre,function setNombre '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setEmail($val){
		if(strlen(trim($val))!=0){
			$this->_email=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO EMAIL ESTA VACIO',
				'admin'=>'atributo email,function setEmail '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setFono($val){
		if(strlen(trim($val))!=0){
			$this->_fono=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO FONO1 ESTA VACIO',
				'admin'=>'atributo fono,function setFono '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}

	public function setPassword($password){
	  if(strlen(trim($password))!=0){
		  $this->_password=base64_decode($password);
	  }else{
		  $this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO PASSWORD ESTA VACIO',
				'admin'=>'atributo Password,function setPassword'.$this->__toString()
		  );
		  $this->myException->addError($error);			  
	  }//fin del if
	}//fin de setPassword
	
	public function setUid($clave){
		if(strlen(trim($clave))!=0){
			$util = new Utilidades();
			$this->_uid=$util->esconde_clave($clave);
		}else{
			$this->myException->setEstado(1);
			$error=array(
				'user'=>'CAMPO UID ESTA VACIO.',
				'admin'=>'atributo UID,function setuid'.$this->__toString()
			);
			$this->myException->addError($error);
		}//fin del if
	}//fin del setUid
	
	public function setApellido($val){
		if(strlen(trim($val))!=0){
			$this->_apellido=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO APELLIDO ESTA VACIO',
				'admin'=>'atributo APELLIDO,function setApellido '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setUser($val){
		if(strlen(trim($val))!=0){
			$this->_user=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO User ESTA VACIO',
				'admin'=>'atributo User,function setUser'.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setDireccion($val){
		if(strlen(trim($val))!=0){
			$this->_direccion=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO Direccion ESTA VACIO',
				'admin'=>'atributo Direccion,function setDireccion '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setIdCargo($val){
		if(strlen(trim($val))!=0){
			$this->_idCargo=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO IdCargo ESTA VACIO',
				'admin'=>'atributo IdCargo,function IdCargo '.$this->__toString()
		  );
		  $this->myException->addError($error);			  
		}
	}
	
	public function setEdad($val){
		if(strlen(trim($val))!=0){
			$this->_edad=$val;
		}else{
			$this->myException->setEstado(1);
		  $error=array(
				'user'=>'CAMPO EDAD ESTA VACIO',
				'admin'=>'atributo EDAD,function setEdad '.$this->__toString()
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
		*	Me permite Crear un Usuario al Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param	$id_usuario_ingresa	variable que guarda el id_usuario de la persona que crea un nuevo usuario
		* @param	$fecha_ingresa	variable que guarda la fecha en la cual se registra el usuario
    **/
	public function crear($id_cargo,$user,$clave,$nombre,$apellido,$edad,$direccion,$fono,$email){
		try{
			$this->setIdCargo($id_cargo);
			$this->setUser($user);
			$this->setClave($clave);
			$this->setNombre($nombre);
			$this->setApellido($apellido);
			$this->setEdad($edad);
			$this->setDireccion($direccion);
			$this->setEmail($email);
			$this->setFono($fono);	
			
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese usuario
				if ($this->buscar($this->getIdUsuario())==0){
					#ES 0 SI NO EXISTE EL USUARIO					
					$parametros=array(
						"ID_CARGO"=>$this->getIdCargo(),
						"US_NOMBRE"=>$this->getNombre(),
						"US_APELLIDO"=>$this->getApellido(),
						"US_EDAD"=>$this->getEdad(),
						"US_DIRECCION"=>$this->getDireccion(),
						"US_TELEFONO"=>$this->getFono(),
						"US_EMAIL"=>$this->getEmail(),
						"US_USER"=>$this->getUser(),
						"US_PASS"=>$this->getClave(),
						"US_ACTIVO"=>"SI"
					);
					$rs1=$this->bd->insert('usuarios',$parametros);
					if ($this->bd->myException->getEstado()==0){
						return 1;
					}else{
						$this->myException->setEstado(1);
						foreach($this->bd->myException->getMensaje() as $er){
							$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO CREAR ".$this->__toString()." ".$parametros));
						}//fin del for each que me informa del error al realizar en insert
					}//fin del if que verifica que la coneccion no se pierda
				}
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
		*	Me permite Actualizar un Usuario existente en el Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param	$fecha_ingresa	variable que guarda la fecha en la cual se registra el usuario
    **/
	public function actualizar($id_usuario,$id_cargo,$user,$clave,$nombre,$apellido,$edad,$direccion,$fono,$email){
		try{
			$this->setIdUsuario($id_usuario);
			$this->setIdCargo($id_cargo);
			$this->setUser($user);
			$this->setClave($clave);
			$this->setNombre($nombre);
			$this->setApellido($apellido);
			$this->setEdad($edad);
			$this->setDireccion($direccion);
			$this->setEmail($email);
			$this->setFono($fono);	
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("ID_USUARIO"=>$this->getIdUsuario());
					$parametros=array(
						"ID_CARGO"=>$this->getIdCargo(),
						"US_NOMBRE"=>$this->getNombre(),
						"US_APELLIDO"=>$this->getApellido(),
						"US_EDAD"=>$this->getEdad(),
						"US_DIRECCION"=>$this->getDireccion(),
						"US_TELEFONO"=>$this->getFono(),
						"US_EMAIL"=>$this->getEmail(),
						"US_USER"=>$this->getUser(),
						"US_PASS"=>$this->getClave(),
						"US_ACTIVO"=>"SI"
					);
					
					$rs1=$this->bd->update('usuarios',$parametros,$condicion);
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
	/*************************************	FUNCION ACTUALIZAR	*********************************************************/
	/**
		* Public function ELIMINAR
		*	Me permite Eliminar un Usuario existente en el Sistema
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param	$eliminar	variable que guarda la fecha en la cual se registra el usuario
    **/
	public function eliminar($id_usuario){
		try{
			$this->setIdUsuario($id_usuario);
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("ID_USUARIO"=>$this->getIdUsuario());
					$parametros=array(
						"US_ACTIVO"=>"NO"
					);
					
					$rs1=$this->bd->update('usuarios',$parametros,$condicion);
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
	/*************************************	INICIO DE LA FUNCION BUSCAR		***********************************************/
	/**
		* Funcion Buscar que me permite validar si el usuario existe
		* @return RETORNA VALOR 1 si el usuario existe, VALOR 0 si el usuario no existe
		* @param  $idUsuario valor con el que el usuario se loguea
     */
	public function buscar($idUsuario){
		$this->setIdUsuario($idUsuario);
		try{
			if ($this->myException->getEstado()==0){
				#verifico que no existan ese usuario
				$strsql="select id_usuario from usuarios where id_usuario=?";
				$condicion=array($this->getIdUsuario());
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
				}//fin del if que me controla que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que me controla que no se haya caido l coneccion
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}//fin del try catch
	}//fin de la funcio buscar
	/*************************************	FIN DE LA FUNCION BUSCAR	***************************************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION LOGIN	********************************************/
	/**
		* Funcion Login que me permite validar el logueo de un usuario 
		* @return RETORNA un array de valores que van a ser parte de mis variables de SESSION
		* @param  $usuario valor con el que el usuario se loguea
		* @param	$pass	valor de la password de mi usuario
     */
	function login($usuario,$pass){
		try{
			$this->setIdUsuario($usuario);
			$this->setPassword($pass);
			$campos=array();
			if ($this->myException->getEstado()==0){
				$strsql="SELECT u.id_usuario, u.us_nombre,u.us_apellido, u.id_cargo, c.ca_descripcion FROM usuarios u INNER JOIN cargos c ON c.id_cargo=u.id_cargo WHERE u.us_activo='SI' and us_user=? and us_pass=password(?)";
				$arr=array($this->getIdUsuario(),$this->getPassword());
				$res=$this->bd->select($strsql,$arr);
				if ($this->bd->myException->getEstado()==0){
					if ($rs=$res->fetch()){
						$campos[]=array(
							"id_usuario"=>utf8_encode($rs["id_usuario"]),
							"nombre"=>utf8_encode($rs["us_nombre"]." ".$rs["us_apellido"]),
							"id_cargo"=>utf8_encode($rs["id_cargo"]),
							"cargo"=>utf8_encode($rs["ca_descripcion"])
						);
						return $campos;
					}else{
							$this->myException->setEstado(1);
							$error=array(
							'user'=>'Usuario y Password Erroneo',
							'admin'=>"");
							$this->myException->addError($error);
							return 0;
						//fin del if que me controla que no se haya caido la consulta
					}
				}else{
					$this->myException->setEstado(1);
					foreach($this->bd->myException->getMensaje() as $er){
						$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
					}
					return 0;
				}//fin del if que me controla que no se haya caido la consulta
			}else{
				return 0;
			}//fin del if que verifica que la coneccion no se haya perdido
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
				'user'=>'SE PRODUJO UN ERROR AL COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA',
				'user'=>$e->getMessage().'<br>codigo: '.$e->getCode().'<br>linea: ',$e->getLine().'<br> archivo:'.$e->getFile()
			);
			$this->myException->addError($error);
		}//fin de la function try catch
	}//fin de la function login 
	/*************************************	FIN DE LA FUNCION LOGIN		***************************************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DEL METODO ESTATICO ACCESO *******************************************/
	/**
		* Funcion Estática acceso 
		* @return RETORNA un true o un false dependiendo si el usuario tiene el acceso a la pagina o no
		* @param  $id_usuario valor con el que el usuario se loguea
		* @param	$opcion	es el nombre de la pagina php en la cual el usuario se encuentra ubicado en ese momento
     */
	static function acceso($id_usuario, $opcion){
		try{
			$bd= new BD();
			$largo=strlen($opcion);
			$x=0;
			$sitio=$opcion;
			for($i=($largo-1); $i>=0; --$i){
				++$x;
				if (substr($opcion,$i-1, 1)=='/'){
					$sitio=substr($opcion,$i, $x);
					break;
				}
			}

			$strsql="select ac.id_usuario, ac.id_opcion from acceso ac inner join opcion op on ac.id_opcion=op.id_opcion where ac.id_usuario=? and ac.id_opcion=?";
			
			$arr=array($id_usuario, $sitio);
			$stmt=$bd->select($strsql, $arr);
			if ($bd->myException->getEstado()==1){
				$this->myException->setEstado(1);
				foreach($bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
				}
				return 0;
			}
			
			if ($stmt->fetch()){
				return 1;
			}else{
				return 0;
			}
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			    'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DEL METODO ESTATICO ACCESO ***********************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	public function listarUsuarios($sqlend,$sqlGroupBy="",$sqlOrden="",$sqlLimit="",$modo="query"){
		try{
			//PREGUNTO SI VINO EN MODO QUERY O EN MODO COUNT
			$nro_registros=0;
			if($modo=="query"){
				$sqlCampos="r.id_oficina_denuncia, u.id_usuario,u.nombre,u.tipo_usuario,u.email,u.fono1,u.fono2,u.codigo_area,u.activo,
			IF(u.imagen='','default_avatar.jpg',u.imagen) as imagen,u.revisor ,u.uid,	u.codigo_area2,(r.nombre) AS regional , u.tema";	
			}else{
				$sqlCampos=" count(*) as hay ";
			}
			//CONCATENO SQL CAMPOS Y SQLEND
			$sql="SELECT ".$sqlCampos." FROM usuario u INNER JOIN oficina_denuncia r ON u.id_regional=r.id_oficina_denuncia WHERE 1=1 ".$sqlend;
			
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
							"id_usuario"=>utf8_encode($rs["id_usuario"]),
							"nombre"=>utf8_encode($rs["nombre"]),
							"tipo_usuario"=>$rs["tipo_usuario"],
							"email"=>utf8_encode($rs["email"]),
							"fono1"=>$rs["fono1"],
							"codigo_area"=>$rs["codigo_area"],
							"fono2"=>$rs["fono2"],
							"codigo_area2"=>$rs["codigo_area2"],
							"activo"=>$rs["activo"],
							"imagen"=>$rs["imagen"],
							"tema"=>$rs["tema"],
							"revisor"=>$rs["revisor"],
							"clave"=>utf8_encode( Utilidades::muestra_clave($rs["uid"])),
							"regional"=>$rs["regional"],
							"id_regional"=>$rs['id_oficina_denuncia']
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
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/*************************************	INICIO DE LA FUNCION LISTAR		************************************/
	/**
		* Funcion Listar que me permite listar todos loss parametros de mi usuario 
		* @return RETORNA un array de valores que son los datos de mi usuario
		* @param  $sqlend recibe una string que forma parte de mi Query al momento de consultar mi usuario. En definitiva este es mi where
		* @param  $sqlorden recibe el campo con el cual se va a ordenar la lista de usuarios
    */
	public function listar($sqlend,$sqlorden=""){
		try{
			$sql="SELECT u.ID_USUARIO,u.ID_CARGO,c.CA_DESCRIPCION, 
				u.US_USER,u.US_NOMBRE,u.US_APELLIDO,u.US_EDAD,u.US_DIRECCION,u.US_TELEFONO, u.US_EMAIL 
				FROM usuarios u INNER JOIN cargos c ON u.ID_CARGO=c.ID_CARGO WHERE 1=1 and US_ACTIVO='SI' ".$sqlend;
			
			if(strlen($sqlorden)!=0){
				$sql=$sql." ORDER BY ".$sqlorden;
			}
			$res=$this->bd->select($sql,array());
			if($this->bd->myException->getEstado()==0){
				while($rs=$res->fetch()){
					$campos[]=array(
						"id_usuario"=>utf8_encode($rs["ID_USUARIO"]),
						"user"=>utf8_encode($rs["US_USER"]),
						"id_cargo"=>utf8_encode($rs["ID_CARGO"]),
						"cargo_descripcion"=>utf8_decode($rs["CA_DESCRIPCION"]),
						"nombre"=>utf8_encode($rs["US_NOMBRE"]),
						"apellido"=>utf8_encode($rs["US_APELLIDO"]),
						"edad"=>utf8_encode($rs["US_EDAD"]),
						"direccion"=>utf8_encode($rs["US_DIRECCION"]),
						"telefono"=>utf8_encode($rs["US_TELEFONO"]),
						"email"=>utf8_encode($rs["US_EMAIL"])
					);
				}
				return $campos;
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
	/*************************************	FIN DE LA FUNCTION LISTAR 	**************************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCTION EMAIL		************************************/
	/**
		* Funcion buscarEmail me permite buscar el emmail de usuario en especifico; esto lo utilizo para el recordar contraseña
		* @return RETORNA un array de valores que son los datos de mi usuario
		* @param  $email String que recibe el email de mi usuario
    */
	public function buscarEmail($email){
		try{
			$this->setEmail($email);
			$campos= array();
			if($this->myException->getEstado()==0){
				$sql="select id_usuario, nombre, uid, email from usuario where email=?";
				$para= array($this->getEmail());
				$res=$this->bd->select($sql,$para);
				if($this->bd->myException->getEstado()==0){
					while($rs=$res->fetch()){
						$campos=array(
							"id_usuario"=>$rs["id_usuario"],
							"nombre"=>$rs["nombre"],
							"email"=>$rs["email"],
							"clave"=>Utilidades::muestra_clave($rs["uid"])
						);
						return $campos;
					};
				}else{
					$this->myException->setEstado(1);
					$this->myException->addError($this->bd->myException->getMensaje());
					return 0;
				}
			}else{
				$this->myException->setEstado(1);
				$this->myException->addError($this->bd->myException->getMensaje());
				return 0;
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
				'user'=>'SE PRODUJO UN ERROR AL COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA',
				'user'=>$e->getMessage().'<br>codigo: '.$e->getCode().'<br>linea: ',$e->getLine().'<br> archivo:'.$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCTION EMAIL 	****************************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCTION ACTUALIZAR IMAGEN		************************/
	/**
		* Funcion actualizarImagen me premite actualizar la imagen de mi usuario
		* @return RETORNA un array de valores que son los datos de mi usuario
		* @param  $id_usuario String que recibe el ID de mi usuario
		* @param  $imagen String que recibe el nombre de la imaagen de mi usuario
    */
	
	public function actualizarImagen($id_usuario,$imagen){
		try{
			$this->setIdUsuario($id_usuario);
			$this->setImagen($imagen);
			
			$parametros=array(
				'imagen'=>$this->getImagen()
			);
			$condicion=array('id_usuario'=>$this->getIdUsuario());
			if ($this->myException->getEstado()==0){
				#verifico si existe el usuario para nodificarlo
				if($this->buscar($this->getIdUsuario())==1){
					$rs1=$this->bd->update('usuario',$parametros,$condicion);
					if ($this->bd->myException->getEstado()==0){
						return 1;
					}else{
						$this->myException->setEstado(1);
						foreach($this->myException->getMensaje() as $er){
							$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
						}//fin del for each que me informa del error al realizar en update
						return 0;
					}//fin del if que verifica que la coneccion no se pierda
				}
			}else{
				return 0;
			}//fin del if que verifica la conexion
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			    'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}//fin del try catch
	}//FIN de la funcion Actualizar
	/*************************************	FIN DE LA FUNCTION ACTUALIZAR IMAGEN	****************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	FUNCION ACTUALIZAR PERFIL	*********************************************************/
	/**
		* Public function actualizarPerfil	permite al usuario actualizar su perfil
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param  $id_usuario valor con el que el usuario se loguea
		* @param	$clave	password con el que el usuario se loguea 
		* @param	$nombre	nombre del usuario regitrado
		* @param	$email	email del usuario el cual es requerido para enviar los posibles webmanager
		* @param	$fono1	fono del usuario con el cual se puede contactar
		* @param	$codigo_area	codigo de area de donde se encuentra mi usuario
		* @param	$fono2	
		* @param	$codigo_area2
		* @param	$id_regional	region a la cual pertenece mi usuario 
		* @param	$tema	tema de usuario con el cual se mostrara la pagina 
		* @param	$id_usuario_ingresa	variable que guarda el id_usuario de la persona que crea un nuevo usuario
		* @param	$fecha_ingresa	variable que guarda la fecha en la cual se registra el usuario
    **/
	public function actualizarPerfil($id_usuario,$clave,$nombre,$email,$fono1,$codigo_area,$fono2,$codigo_area2,$id_regional,$tema,$id_usuario_ingresa,$fecha_ingresa){
		try{
			$this->setIdUsuario($id_usuario);
			$this->setClave($clave);
			$this->setNombre($nombre);
			$this->setEmail($email);
			$this->setFono1($fono1);
			$this->setCodigoArea($codigo_area);
			$this->setFono2($fono2);
			$this->setCodigoArea2($codigo_area2);
			$this->setRegional($id_regional);
			$this->setTema($tema);
			$this->setUid($clave);
			$this->setIdUsuarioIngresa($id_usuario_ingresa);
			$this->setFechaIngresa($fecha_ingresa);
			/***	aki pregunto si se cumplieron todas las validaciones de los SET	***/
			if ($this->myException->getEstado()==0){
					$condicion=array("id_usuario"=>$this->getIdUsuario());
					$parametros=array(
						"clave"=>$this->getClave(),
						"nombre"=>$this->getNombre(),
						"email"=>$this->getEmail(),
						"fono1"=>$this->getFono1(),
						"codigo_area"=>$this->getCodigoArea(),
						"fono2"=>$this->getFono2(),
						"codigo_area2"=>$this->getCodigoArea2(),
						"id_regional"=>$this->getRegional(),
						"uid"=>$this->getUid(),
						"tema"=>$this->getTema(),
						"id_usuario_modifica"=>$this->getIdUsuarioIngresa(),
						"fecha_modifica"=>$this->getFechaIngresa()
					);
					$rs1=$this->bd->update('usuario',$parametros,$condicion);
					if ($this->bd->myException->getEstado()==0){
						return 1;
					}else{
						$this->myException->setEstado(1);
						foreach($this->bd->myException->getMensaje() as $er){
							$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
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
	/*************************************	FIN DE LA FUNCION ACTUALIZAR	PERFIL	****************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION BORRAR ACCESOS	******************************/
	/**
		* Public function borrarAccesos me permite borrar todos los accesos de un usuario
		* @param  $id_usuario valor con el que el usuario se loguea
    **/
	public function borrarTodosAccesos($id_usuario){
		$this->setIdUsuario($id_usuario);
		try{
			$condicion=array("id_usuario"=>$this->getIdUsuario());
			$res=$this->bd->delete("acceso",$condicion);
			if($this->bd->myException->getEstado()==0){
				return 1;
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO borrarTodosAccesos ".$this->__toString()));
				}//fin del for each que me informa del error al realizar en insert
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION BORRAR TODOS ACCESOS	********************************/
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION MARCAR TODOS ACCESOS	******************************/
	/**
		* Public function marcarTodosAccesos me permite borrar todos los accesos de un usuario
		* @param  $id_usuario valor con el que el usuario se loguea
    **/
	public function marcarTodosAccesos($id_usuario){
		$this->setIdUsuario($id_usuario);
		try{
			$sql="select id_opcion from opcion";
			$rst=$this->bd->select($sql,array());
			if($this->bd->myException->getEstado()==0){
				foreach($rst as $rs){
					$parametros=array("id_usuario"=>$this->getIdUsuario(),"id_opcion"=>$rs["id_opcion"]);
					$rst=$this->bd->insert("acceso",$parametros);
					if($this->bd->myException->getEstado()==1){
						$this->myException->setEstado(1);
						foreach($this->bd->myException->getMensaje() as $er){
							$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO marcarTodosAccesos ".$this->__toString()));
						}//fin del for each que me informa del error 		
						break;
					}
				}
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO marcarTodosAccesos ".$this->__toString()));
				}//fin del for each que me informa del error 
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION MARCAR TODOS ACCESOS	**************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION OBTENER MENU	********************************/
	/**
		* Public function obtenerMenu me permite lista todos los menu para el control de mi accesos
		* @return  retorna un array de el nombre de los menus
    **/
	public function obtenerMenu($id_usuario){
		$this->setIdUsuario($id_usuario);
		$campos=array();
		try{
			$sql="SELECT o.op_nombre, o.op_pagina FROM usuarios u 
						INNER JOIN usuariosopciones uo ON u.id_usuario=uo.id_usuario
						INNER JOIN opciones o ON o.ID_OPCION=uo.ID_OPCION
						WHERE 1=1 AND u.id_usuario='".$this->getIdUsuario()."'";
			$rst= $this->bd->ejecutar($sql,array());
			if($this->bd->myException->getEstado()==0){
				while($rs=$rst->fetch()){
					$campos[]=array(
						"op_nombre"=>utf8_encode($rs["op_nombre"]),
						"op_pagina"=>utf8_encode($rs["op_pagina"])
					);
				};
				return $campos;
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO obtenerMenu ".$this->__toString()));
				}//fin del for each que me informa del error 
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION OBTENER MENU	**********************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION OBTENER TITULO	******************************/
	/**
		* Public function obtenerTitulo me permite listar todos los titulos 
		* @param  $menu valor del menu de mis accesos
		* @param  $id_usuario valor con el que el usuario se loguea
		* @return  retorna un array de el nombre de todos los titulos de mis opciones
    **/
	public function obtenerTitulo($menu){
		try{
			$sql="SELECT id_opcion,id_opcion as programa, descripcion FROM opcion where menu='".$menu."'";
			$rst= $this->bd->ejecutar($sql,array());
			if($this->bd->myException->getEstado()==0){
				while($rs=$rst->fetch()){
					$campos[]=array("descripcion"=>utf8_encode($rs["descripcion"]),"id_opcion"=>utf8_encode($rs["id_opcion"]),"programa"=>$rs["programa"]);
				};
				return $campos;
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO obtenerTitulo ".$this->__toString()));
				}//fin del for each que me informa del error 
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION OBTENER TITULO	********************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION SELECCIONAR PERMISOS		**********************/
	/**
		* Public function seleccionarPermisos me permite obtener todos los permisos que tiene asignado mi usuario
		* @param  $id_usuario valor con el que el usuario se loguea
		* @return  retorna un array de el nombre de todos los titulos de mis opciones
    **/
	public function seleccionarPermisos($id_usuario){
		$this->setIdUsuario($id_usuario);
		try{
			$sql="SELECT id_opcion from acceso where id_usuario=?";
			$parametros=array($this->getIdUsuario());
			$rst= $this->bd->ejecutar($sql,$parametros);
			if($this->bd->myException->getEstado()==0){
				while($rs=$rst->fetch()){
					$campos[]=array("opcion1"=>$rs["id_opcion"]);
				};
				return $campos;
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO seleccionarPermisos ".$this->__toString()));
				}//fin del for each que me informa del error 
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION OBTENER MENU	**********************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION AGREGAR PERMISO	****************************/
	/**
		* Public function agregarPermiso me permite agregar un permiso a un usuario del sistema
		* @param  $id_usuario valor con el que el usuario se loguea
		* @param  $opcion valor de la opcion a la cual se le va a agregar el permiso (es el nombre de la pagina)
		* @return  retorna un 1 si es agregado exitosamente
    **/
	public function agregarPermiso($id_usuario,$opcion){
		$this->setIdUsuario($id_usuario);
		try{
			$parametros=array("id_usuario"=>$this->getIdUsuario(),"id_opcion"=>$opcion);
			$rst= $this->bd->insert("acceso",$parametros);
			if($this->bd->myException->getEstado()==0){
				return 1;
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO agregarPermiso".$this->__toString()));
				}//fin del for each que me informa del error 
				return 0;
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION AGREGAR PERMISO		******************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION QUITAR PERMISO		****************************/
	/**
		* Public function quitarPermiso me permite agregar un permiso a un usuario del sistema
		* @param  $id_usuario valor con el que el usuario se loguea
		* @param  $opcion valor de la opcion a la cual se le va a agregar el permiso (es el nombre de la pagina)
		* @return  retorna un 1 si es agregado exitosamente
    **/
	public function quitarPermiso($id_usuario,$opcion){
		$this->setIdUsuario($id_usuario);
		try{
			$parametros=array("id_usuario"=>$this->getIdUsuario(),"id_opcion"=>$opcion);
			$rst= $this->bd->delete("acceso",$parametros);
			if($this->bd->myException->getEstado()==0){
				return 1;
			}else{
				$this->myException->setEstado(1);
				foreach($this->bd->myException->getMensaje() as $er){
					$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO agregarPermiso".$this->__toString()));
				}//fin del for each que me informa del error 
				return 0;
			}
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION OBTENER MENU	**********************************/
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	INICIO DE LA FUNCION ACTUALIZA RUT USUARIO		****************************/
	/**
		* Public function actualizaRutUsuario
		* @param  $id_usuario valor de rut a cambiar
		* @param  $id_siniestro siniestro asociado al rut
		* @param  $id_imagen imagen donde se digito el rut
		* @return  retorna un 1 si es actualizado
    **/
	public function actualizaRutUsuario($idUsuario,$idSiniestro,$idImagen){
		$this->setIdUsuario($idUsuario);
		$this->setSiniestro($idSiniestro);
		$this->setImagen($idImagen);
		try{
			 if($this->myException->getEstado()==0){
				 $sql="select id_recepcion,id_documento,(id_trabajador) as id_trabajador_antiguo,(id_siniestro) as id_siniestro_antiguo 
							 from digitacion where id_imagen=?";
				 $res = $this->bd->select($sql,array($this->getImagen()));
				 if($this->bd->myException->getEstado()==0){
				 		if($rs = $res->fetch()){
								$id_recepcion=$rs["id_recepcion"];
	  						$id_documento=$rs["id_documento"];
								$id_trabajador_antiguo=$rs["id_trabajador_antiguo"];
								$id_siniestro_antiguo=$rs["id_siniestro_antiguo"];
							  //$this->bd->beginTransaction();
								#actualizo recepcion
								$re = $this->bd->ejecutar("update recepcion set id_trabajador= ? where id_recepcion= ?",
																					array($this->getIdUsuario(),$id_recepcion));
								if($this->bd->myException->getEstado()==0){													
									if($re==1){
										 #actualizo documento
										 $re = $this->bd->ejecutar("update documento set id_siniestro= ? where id_documento= ? and id_recepcion= ?",
																			array($this->getSiniestro(),$id_documento,$id_recepcion));
										 if($this->bd->myException->getEstado()==0){									
											 if($re==1){
													#actualizo digitacion
													$re = $this->bd->ejecutar("update digitacion set id_trabajador= ? ,id_siniestro= ? ,estado= 'DIGITADO' where id_imagen=?",
																										array($this->getIdUsuario(),$this->getSiniestro(),$this->getImagen()));
												if($this->bd->myException->getEstado()==0){													
														if($re==1){
															//$this->bd->commit();
															
															return 1;
														}else{
															//$this->bd->rollBack();
															return 0;	
														}
												}else{
													$this->myException->setEstado(1);
													$error=array(
														'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
														'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
													);
													$this->myException->addError($error);
													return 0;
												}
											 }else{
													//$this->bd->rollBack();
													return 0;
											 }
										}else{
											$this->myException->setEstado(1);
											$error=array(
												'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
												'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
											);
											$this->myException->addError($error);
											return 0;
										}
									}else{
										//$this->bd->rollBack();
										return 0;
									}
								}else{
									$this->myException->setEstado(1);
									$error=array(
			   						'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
										'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
									);
									$this->myException->addError($error);
									return 0;
								}
						}else{
								$id_recepcion="";
	  						$id_documento="";
	  						$id_trabajador_antiguo="";
	  						$id_siniestro_antiguo="";
						}
						
				 }else{
				 		$this->myException->setEstado(1);
						$error=array(
			   			'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
							'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
						);
						$this->myException->addError($error);
						return 0;
				 }
			 }else{
			 		$this->myException->setEstado(1);
					foreach($this->bd->myException->getMensaje() as $er){
						$this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']." METODO actualizaRutUsuario".$this->__toString()));
					}//fin del for each que me informa del error 
					return 0;
			 }
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			   'user'=>'SE PRODUJO UN ERROR. COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	/*************************************	FIN DE LA FUNCION ACTUALIZA RUT USUARIO	**********************************/
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*************************************	FUNCION BITACORA		***************************************************/
	/**
		* static function function bitacora
		*	Me permite guardar una gestion en la tabla bitacora en la cual me permite guardar todo lo realizado por mi usuario
		* @return RETORNA VALOR 1 SI ES INGRESADO EXITOSAMENTE
		* @param 	$id_usuario	String	ID con el cual se logea mi usuario
		* @param	$accion	String Es la accion que realiza mi usuario
		* @param	$observacion	String Es la observacion 
    **/
		
	static function bitacora($id_usuario,$accion,$observacion){
		try{
				$bd= new BD();
		    $fecha=date('Y-m-d H:i:s');
		    $parametros=array('id_usuario'=>$id_usuario,'fecha'=>$fecha,"accion"=>$accion,'observacion'=>$observacion);
		    $rs=$bd->insert('bitacora',$parametros);
		    if ($bd->myException->getEstado()==0){
			    return 1;
		    }else{
			    $this->myException->setEstado(1);
			    foreach($bd->myException->getMensaje() as $er){
				    $this->myException->addError(array('user'=>$er['user'],'admin'=>$er['admin']));
			    }//fin del foreach
			    return 0;
		    }//fin del if que controla si el insert se realizo con exito
		}catch(Exception $e){
			$this->myException->setEstado(1);
			$error=array(
				'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA',
				'admin'=>$e->getMessage().'<br>codigo: '.$e->getCode().'<br>linea: ',$e->getFile().'<br> archivo:'.$e->getFile()
			);
		}//fin del try catch
	}//fin de la funcion bitacora
	/*************************************	FIN DE LA FUNCION BITACORA	*************************************************/
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	#####################################	FIN DE LOS METODOS		###############################################
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		* Metodo Magico que me permite saber el nombre de la clase con la cual estoy trabajando
    **/
	public function __toString(){
		$mensaje="CLASE USUARIO";
	    return $mensaje;
	}
	#####################################	FIN DEL CONSTRUCTOR Y DESTRUCTOR	#################################################
}

?>