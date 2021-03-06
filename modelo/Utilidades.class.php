<?php
/**
  * @package
  * Proyecto : PDE
  * Archivo  : class/Utilidades.class.php
  * @link
  * @copyright
  * @autor   : Edwin Guaman
  * @since fecha: 09/12/2011.
  * version: version 1.0.
  * Descripcion:  Esta es una clase utilizaria que permite a sistema 
  contar con una cantidad de herramientas para trabajar
  con Rut, String, Fecha, Paginadores, etc.
  1=True
  0=False
*/
require_once('Configuracion.class.php');
require_once('MyException.class.php');

class Utilidades{
    public $myException;
    
	static function subNavPaginacion($PageCurrent, $PageCount) {
		//Construye el Paginador
		if ($PageCurrent % Configuracion::$MAXPAGESPERPAGER != 0){
			$lngAuxPag=Configuracion::$MAXPAGESPERPAGER * (ceil(($PageCurrent)/Configuracion::$MAXPAGESPERPAGER)-1); 
		}else{
			$lngAuxPag=$PageCurrent - 1;	
		}
		$ret = '<table align="center" class="paginador"><tr>';
		if ($PageCurrent > 1){
			// Agregado boton para ir a la primera pagina
			$ret .= '<td><a  href="#" onclick="avance_pagina(1)" title="Primera" class="btn btn-xs btn btn-info">Primera</a></td> <td>&nbsp;&nbsp;</td>';
			
			$ret .= '<td><a href="#"  onclick="avance_pagina('.($PageCurrent - 1).')"  title="Anterior" class="btn btn-xs btn btn-info">Anterior</a></td><td>&nbsp;&nbsp;</td>';			
		}
		
		for($i = 1 + $lngAuxPag; $i <= Configuracion::$MAXPAGESPERPAGER + $lngAuxPag; $i++){
			if ($i <= $PageCount){
				if ($i==$PageCurrent){
					$class_pagina=" active";
				}else{
					$class_pagina="";
				}
				$ret .= '<td id="'.$class_pagina.'"  width="10" height="20" align="center" valign="middle">';
				$ret .= '<a href="#" onclick="javascript:avance_pagina('.$i.');" class="btn btn-xs btn btn-info'.$class_pagina.'">' . $i . '</a></td> <td>&nbsp;&nbsp;</td>';
			}
		}
		if ($PageCurrent < $PageCount){
			$ret .= '<td><a  href="#" onclick="avance_pagina('.($PageCurrent + 1).')" class="btn btn-xs btn btn-info">Siguiente</a></td><td>&nbsp;&nbsp;</td>';
			
			// Agregado boton para ir a la ultima pagina
			$ret .= '<td><a  href="#" onclick="avance_pagina('.($PageCount).')" class="btn btn-xs btn btn-info">&Uacute;ltima</a></td> <td>&nbsp;&nbsp;</td>';
		}
		$ret .= '</tr> </table>';
		return $ret;
	}
	static function subNavPaginacionPortal($PageCurrent, $PageCount) {
		//Construye el Paginador
		if ($PageCurrent % Configuracion::$MAXPAGESPERPAGER != 0){
			$lngAuxPag=Configuracion::$MAXPAGESPERPAGER * (ceil(($PageCurrent)/Configuracion::$MAXPAGESPERPAGER)-1); 
		}else{
			$lngAuxPag=$PageCurrent - 1;	
		}
		$ret = '<table class="paginador"><tr>';
		if ($PageCurrent > 1){
			// Agregado boton para ir a la primera pagina
			$ret .= '<td valign="middle"><div class="primera" onclick="avance_pagina(1)" title="Primera" alt="Primera"></a></div></td>';
			
			$ret .= '<td valign="middle"><div class="anterior" onclick="avance_pagina('.($PageCurrent - 1).')"  alt="Anterior" title="Anterior"></a></div></td>';			
		}
		
		for($i = 1 + $lngAuxPag; $i <= Configuracion::$MAXPAGESPERPAGER + $lngAuxPag; $i++){
			if ($i <= $PageCount){
				if ($i==$PageCurrent){
					$class_pagina="selectedpage";
				}else{
					$class_pagina="pages";
				}
				$ret .= '<td id="'.$class_pagina.'" class="'.$class_pagina.'" width="10" height="12" align="center" valign="middle">';
				$ret .= '<a href="#" onclick="javascript:avance_pagina('.$i.');">' . $i . '</a></td>';
			}
		}
		if ($PageCurrent < $PageCount){
			$ret .= '<td valign="middle"><div class="siguiente" onclick="avance_pagina('.($PageCurrent + 1).')" title="Siguiente" alt="Siguiente"></a></div></td>';
			
			// Agregado boton para ir a la ultima pagina
			$ret .= '<td valign="middle"><div class="ultima" onclick="avance_pagina('.($PageCount).')" title="Ultima" alt="Ultima"></a></div></td>';
		}
		$ret .= '</tr> </table>';
		return $ret;
	}
	
	static public function esconde_clave($clave){
		//Calcula el uid
		$clave=trim($clave);
		$strclave="";
		$pos=0;
		$pos=strlen($clave);
		for($i=0;$i<$pos;$i++){
			$strclave=$strclave.chr(ord(substr($clave,$i,1))+3);
		}
		return $strclave;
	}
	
	static public function muestra_clave($clave){
		//Lee el uid
		$clave=trim($clave);
		$strclave="";
		$pos=0;
		$pos=strlen($clave);
		for($i=0;$i<$pos;$i++){
			$strclave=$strclave.chr(ord(substr($clave,$i,1))-3);
		}
		return $strclave;
	}
	
	static public function formatea_numero($numero){
		$num=str_replace(".","",$numero);
		$num=number_format($num,0,",",".");
		return $num;
	}
	
	static public function desformatea_numero($numero){
		$num=str_replace(".","",$numero);
		return $num;
	}
	
	static public function getIP() {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif (isset($_SERVER['HTTP_VIA'])){
		    $ip = $_SERVER['HTTP_VIA'];
		}elseif (isset($_SERVER['REMOTE_ADDR'])){
		    $ip = $_SERVER['REMOTE_ADDR'];
		}else{
		    $ip = "unknown";
		}
		
		return $ip;
	}
	
	#retorna fecha en formato yyyy-mm-dd
	static public function fechaMysql($auxFecha){
        if (strlen($auxFecha)>0){
		    $fecha_retorno=substr($auxFecha,6,4)."-".substr($auxFecha,0,2)."-".substr($auxFecha,3,2);
				
	    }else{
	         $fecha_retorno='0000-00-00';
	    }
	    return $fecha_retorno;
    }
  
    #retorna fecha en formato dd-mm-yyyy
	static public function fechaUsuario($auxFecha){
        if (strlen($auxFecha)>0 && $auxFecha!='0000-00-00'){
	        $fecha_retorno=substr($auxFecha,8,2)."-".substr($auxFecha,5,2)."-".substr($auxFecha,0,4);
	    }else{
	        $fecha_retorno="";
	    }
	    return $fecha_retorno;
    }
	
	static public function limpia_texto($texto){
	  $cadena="";
	  for ($r=0;$r<strlen($texto);$r++){
		  if (substr($texto,$r,1)!="'" && substr($texto,$r,1)!="|" && 
		  ord(substr($texto,$r,1))!=10 && ord(substr($texto,$r,1))!=13  && ord(substr($texto,$r,1))!=9){
		      $cadena=$cadena.substr($texto,$r,1);
		  }  	
	  }
		  return trim($cadena);
 	 }
	
	static public function enviar_correo($para,$cc,$asunto,$cuerpo,$adjunto="",$prioridad=""){
		//require_once "/var/www/mutualdocII/lib/class.phpmailer.php";
		require_once "/opt/sitio/mutualdoc.milano.cl/lib/class.phpmailer.php";
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host     = Configuracion::$mail_Host; 
	    $mail->SMTPAuth = true;
	    $mail->Username = Configuracion::$mail_User;
	    $mail->Password = Configuracion::$mail_Pass;
	    $mail->From     = Configuracion::$mail_From;
		$mail->FromName = Configuracion::$mail_From_name;
		if($prioridad!=""){
			$mail->Priority=$prioridad;
		}
		if ($adjunto!=""){
			$mail->AddAttachment($adjunto);
		}
		if (sizeof($para)){
			foreach($para as $p){
				$mail->AddAddress(utf8_encode($p["email"]),utf8_encode($p["nombre"]));
			}
		}
		if (sizeof($cc)){
			foreach($cc as $p){
				$mail->AddCC(utf8_encode($p["email"]),utf8_encode($p["nombre"]));
			}
		}
		
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject=utf8_decode($asunto);
		$mail->Body=utf8_decode($cuerpo);
		if ($mail->Send()){
			return "ok";
		}else{	
			return $mail->ErrorInfo;
		}
	}

	
	static public function cuentaHoja($t_imagen,$user){
	  	$t_total_hojas=0;
		if (!is_dir(Configuracion::$path_tmp_usuario.$user)){
			exec("mkdir ".Configuracion::$path_tmp_usuario.$user);
		}else{
			exec("rm ".Configuracion::$path_tmp_usuario.$user."/info");
			exec("pdftk ".$t_imagen." dump_data output ".Configuracion::$path_tmp_usuario.$user."/info");
			if (is_file(Configuracion::$path_tmp_usuario.$user."/info")){
				$info=fopen(Configuracion::$path_tmp_usuario.$user."/info","r");
				if ($info){
					while(!feof($info)){
						$linea=fgets($info,255);
						if (substr($linea,0,14)=='NumberOfPages:'){
							$t_total_hojas=intval(substr($linea,15,10));
						}
					}
				}
				fclose($info);
			}
		}
		
		return intval($t_total_hojas);
	}
	  
	  
	static function fecha_impresion($fecha){
		
		$dia="";
		$mes="";
		$anio="";
		$dia=substr($fecha,8,2);
		
		
		//echo $t."<br>";
		$num_mes=intval(substr($fecha,5,2));
		if($num_mes==1){
			$mes="Enero";	
		}elseif($num_mes==2){
			$mes="Febrero";
		}elseif($num_mes==3){
			$mes="Marzo";
		}elseif($num_mes==4){
			$mes="Abril";	
		}elseif($num_mes==5){		
			$mes="Mayo";
		}elseif($num_mes==6){
			$mes="Junio";
		}elseif($num_mes==7){
			$mes="Julio";
		}elseif($num_mes==8){
			$mes="Agosto";
		}elseif($num_mes==9){
			$mes="Septiembre";
		}elseif($num_mes==10){
			$mes="Octubre";
		}elseif($num_mes==11){
			$mes="Noviembre";
		}elseif($num_mes==12){
			$mes="Diciembre";
		}else{
			$mes="Error";
		}
		
		$anio=substr($fecha,0,4);
		$diax=jddayofweek ( cal_to_jd(CAL_GREGORIAN, $num_mes,$dia, $anio) , 1 ); 
		
		if($diax=="Monday"){
			$diax="Lunes";
		}else if($diax=="Tuesday"){
			$diax="Martes";
		}else if($diax=="Wednesday"){
			$diax="Miercoles";
		}else if($diax=="Thursday"){
			$diax="Jueves";
		}else if($diax=="Friday"){
			$diax="Viernes";
		}else if($diax=="Saturday"){
			$diax="Sabado";
		}else if($diax=="Sunday"){
			$diax="Domingo";
		}else {
			$diax="ERROR";
		}
		
		return $diax.", ".$dia." de ".$mes." del ".$anio;
	}

	static function limpiaRut($texto){
	    $rut_numero="";
	    for ($r=0;$r<strlen($texto);$r++){
		    if (substr($texto,$r,1)=="-"){
		        break;
		    }else{
		        if (substr($texto,$r,1)!="."){
			        $rut_numero=$rut_numero.substr($texto,$r,1);
			    }
		    }
	    }
	    return $rut_numero;
    }
  
	#Verifica que el rut ingresado sea valido
	#Debe estar en formato xxxxxxxx-x
	static function validarut($rut){
		$sUsr=strtoupper(limpiaRut($rut));
		if (!preg_match("/(\d{7,8})-([\dK])/", strtoupper($sUsr), $aMatch)){
			return false;
		}
		$sRutBase = substr(strrev($aMatch[1]),0,8);
		$sCodigoVerificador=$aMatch[2];
		$iCont=2;
		$iSuma=0;
		for ($i=0;$i<strlen($sRutBase);$i++){
			if ($iCont>7){
				$iCont=2;
			}
			$iSuma+= ($sRutBase{$i}) *$iCont;
			$iCont++;
		}
		$iDigito = 11-($iSuma%11);
		$sCaracter = substr("-123456789K0", $iDigito, 1);
		return ($sCaracter == $sCodigoVerificador);
	}
	
	#Devuelve el rut con los puntos y el digito verificador
	#recibe algo como 13455897 y devuelve 13.455.897-0
	function rutDenumeroArut($rut){
		$rut=strtoupper(trim(Utilidades::limpiaRut($rut)));
		$digito=Utilidades::digitorut($rut);
		return number_format($rut,0,"",".").'-'.$digito;
	}
	
	#Devuelve el digito verificador del rut recibido  
	#Debe estar en formato xxxxxxxx ó xx.xxx.xxx
	static function digitorut($auxRut){
		$serie=2;
		$largo=strlen($auxRut);
		$pos=strlen($auxRut)-1;
		$auxstr=substr($auxRut,$pos,1);
		for ($i=0;$i<=$largo;$i++){
			$pos=strlen($auxRut)-1;
			$sum=$sum + substr($auxRut,$pos,1) * $serie; 
			$auxRut=substr($auxRut,0,$pos);
			$serie=$serie+1;
			if ($serie>7){
				$serie=2;
			}  
		}
		
		$digito=11-($sum-((floor($sum/11))*11));
		if ($digito==11){
			$muestradig=0;
		}elseif ($digito==10){
			$muestradig="k";
		}else{
			$muestradig=$digito;
		}
		return $muestradig;      
	}


    function __construct(){
		$this->myException=new MyException();
    }
	
}
?>