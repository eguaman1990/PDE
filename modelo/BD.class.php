<?php
require_once('MyException.class.php');
require_once('Configuracion.class.php');
/**
 * @package
 * Proyecto : PDE
 * Archivo : BD
 * @link 
 * @copyright
 * @autor EDWIN GUAMAN
 * @since fecha 23/09/2013
 * version 1.0
 * Descripcion Clase que encapsula todo lo relacionado con la base de datos con PDO 
 * @since fecha 29/11/2010
 * version 2.0.1

*/
class BD {
	private $_host;
	private $_dbName;
	private $_user;
	private $_pass;
	private $_db;
	public $myException;
	
	public function getHost(){
		return $this->_host;
	}
	
	public function getDbName(){
		return $this->_dbName;
	}
	
	public function getUser(){
		return $this->_user;
	}
	
	public function getPass(){
		return $this->_pass;
	}
	
	public function select($sql,array $parametros){
		try{
			$s_parametros="";
			$consulta=$this->_db->prepare($sql);
			$consulta->execute($parametros);
						
			return $consulta;
			
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL CONSULTAR LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
		
	public function insert($tabla,array $parametros){
		try{
			$values="";
			$campos="";
			$linea="";
						
			foreach ($parametros as $key => $value){
				if ($values==""){
					$values=":".$key;
					$campos=$key;
				}else{
				    $values=$values.",:".$key;
					$campos=$campos.",".$key;
				}
				
				if ($linea==""){
					$linea='$stmt'."->bindValue(':".$key."', '".$value."');";
				}else{
				    $linea=$linea.'$stmt'."->bindValue(':".$key."', '".$value."');";
				}
			}
					
			$sql="insert into ".$tabla." (".$campos.") values (".$values.")";
			$stmt = $this->_db->prepare($sql);
			eval($linea);
			$stmt->execute();
			$err=$stmt->errorInfo();
			if ($err[0]=="00000"){
				return 1;
			}else{
				return 0;
			}
					
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL INSERTAR EN LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
	public function insert2($tabla,array $parametros){
		try{
			$values="";
			$campos="";
			$linea="";
								
			foreach ($parametros as $key => $value){
				if ($values==""){
					$values=":".$key;
					$campos=$key;
				}else{
					if ($key=="password"){
						$values=$values.",password(:".$key.")";
						$campos=$campos.",".$key;
					}else{
				    	$values=$values.",:".$key;
						$campos=$campos.",".$key;
					}
				}
				
				if ($linea==""){
					$linea='$stmt'."->bindValue(':".$key."', '".$value."');";
				}else{
				    $linea=$linea.'$stmt'."->bindValue(':".$key."', '".$value."');";
				}
			}		
					
			$sql="insert into ".$tabla." (".$campos.") values (".$values.")";

			$stmt = $this->_db->prepare($sql);
			eval($linea);
			$stmt->execute();
			$err=$stmt->errorInfo();
			if ($err[0]=="00000"){
				return 1;
			}else{
				return 0;
			}
					
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL INSERTAR EN LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
	public function update($tabla,array $parametros,array $condicion){
		try{
			$values="";
			$linea="";
			$strwhere="";
						
			foreach ($parametros as $key => $value){
				if ($values==""){
					if ($key=="password"){
				    	$values=$key."=password(:".$key.")";
					}else{
						$values=$key."=:".$key;
					}
				}else{
					if ($key=="password"){
				    	$values=$values.",".$key."=password(:".$key.")";
					}else{
						$values=$values.",".$key."=:".$key;
					}
				}
				
				if ($linea==""){
					$linea='$stmt'."->bindValue(':".$key."', '".$value."');";
				}else{
				    $linea=$linea.'$stmt'."->bindValue(':".$key."', '".$value."');";
				}
			}
							
			foreach ($condicion as $key => $value){
				if ($strwhere==""){
					$strwhere=$key."=:".$key;
				}else{
				    $strwhere=$strwhere." and ".$key."=:".$key;
				}
				
				if ($linea==""){
					$linea='$stmt'."->bindValue(':".$key."', '".$value."');";
				}else{
				    $linea=$linea.'$stmt'."->bindValue(':".$key."', '".$value."');";
            
				}
			}
						
			$sql="update ".$tabla." set ".$values." where ".$strwhere;
      
			$stmt = $this->_db->prepare($sql);
			eval($linea);
			$stmt->execute();
			$err=$stmt->errorInfo();
			if ($err[0]=="00000"){
				return 1;
			}else{
				return 0;
			}	
			
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL ACTUALIZAR EN LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
	public function delete($tabla,array $condicion){
		try{
			$linea="";
			$strwhere="";
						
			foreach ($condicion as $key => $value){
				if ($strwhere==""){
					$strwhere=$key."=:".$key;
				}else{
				    $strwhere=$strwhere." and ".$key."=:".$key;
				}
				
				if ($linea==""){
					$linea='$stmt'."->bindValue(':".$key."', '".$value."');";
				}else{
				    $linea=$linea.'$stmt'."->bindValue(':".$key."', '".$value."');";
				}
			}
						
			$sql="delete from ".$tabla." where ".$strwhere;
			$stmt = $this->_db->prepare($sql);
			eval($linea);
			$stmt->execute();
			$err=$stmt->errorInfo();
			if ($err[0]=="00000"){
				return 1;
			}else{
				return 0;
			}
							
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL ELIMINAR EN LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
	public function ejecutar($sql,array $parametros){
		try{
			$s_parametros="";
			$consulta=$this->_db->prepare($sql);
			$consulta->execute($parametros);
						
			return $consulta;
			
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL CONSULTAR LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
	public function lastId(){
		try{
		    return $this->_db->lastInsertId();
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL CONSULTAR EN LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}   
	}
	
	public function rowCount($sql,array $parametros){
		try{
			$s_parametros="";
						
			$consulta=$this->_db->prepare($sql);
			$consulta->execute($parametros);
			$total = $consulta->rowCount();
						
			return $total;
			
		}catch (PDOException $e){
		    $this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR AL CONSULTAR EN LA BASE DE DATOS.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}catch (Exception $e){
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}
	}
	
	public function beginTransaction(){
		$this->_db->beginTransaction();
	}
	
	public function commit(){
		$this->_db->commit();
	}
	
	public function rollBack(){
		$this->_db->rollBack();
	}
	
	public function __construct(){
		$this->_host=Configuracion::$host_bd;
		$this->_dbName=Configuracion::$name_bd;
		$this->_user=Configuracion::$user_bd;
		$this->_pass=Configuracion::$pass_bd;
		$this->myException=new MyException();
		try {
			$this->_db=new PDO('mysql:host='.$this->getHost().';dbname='.$this->getDbName(), $this->getUser(), $this->getPass());
			$this->_db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$this->myException->setEstado(1);
			$error=array(
			       'user'=>'SE PRODUJO UN ERROR. FAVOR COMUNICARSE CON EL ADMINISTRADOR DEL SISTEMA.',
				   'admin'=>$e->getMessage()."<br>codigo: ".$e->getCode()."<br>linea: ".$e->getLine()."<br>archivo: ".$e->getFile()
			);
			$this->myException->addError($error);
		}	
		
    }
	
	
	public function __destruct(){
		$this->_db=null;
    }
}
?>