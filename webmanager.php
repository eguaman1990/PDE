<?

	define('MAIL_HOST', 'ns7.netlinux.cl');              //Server de email
	define('MAIL_USER', 'contacto@eguaman.cl');          //user email
	define('MAIL_PASSWORD', 'Hol@1234');              //pass email
	define('MAIL_FROM', 'contacto@eguaman.cl');             //cuenta de origen
	define('MAIL_FROM_NAME', 'WEBMANAGER');            //nombre cuenta origen
	//define('PARA', 'mauricio.poblete@milano.cl;hernan.sion@milano.cl');            //destinatario del email
	define('PARA', 'es.aguaman@gmail.com');            //destinatario del email
	define('PARA_ERROR', 'andrew_d.r.a@hotmail.com');          //destinatario del email
	define('COPIA', 'edwin.guaman@inacapmail.cl');          //copia del email
	//define('COPIA', 'andres.guaman@milano.cl');          //copia del email      //copia del email
	define('ASUNTO', 'demo de correo.');           //asunto del email
	
	# PRIMER ECXEL GENERADO
	#direccion donde quiero crear el excel
	
	


$CuerpoMensaje="Se envia Adjunto";

	reporta(PARA, COPIA, ASUNTO, $CuerpoMensaje, $log/*, $Log2 */);

/* * *******************************************
  Funcion Reporte resultado del proceso
 * ****************************************** */

	function reporta($para, $cc, $asunto, $cuerpo , $adjunto/*, $adjunto2 */) {
		include("modelo/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = MAIL_HOST;
		$mail->SMTPAuth = true;
		$mail->Username = MAIL_USER;
		$mail->Password = MAIL_PASSWORD;
		$mail->From = MAIL_FROM;
		$mail->FromName = MAIL_FROM_NAME;
	
		if ($para != "") {
			$copia = str_replace(";", ",", $para);
			$copias = explode(",", $copia);
			foreach ($copias as $dir) {
				echo "valor de los para $dir <br />";
				$mail->AddAddress($dir, $dir);
			}
		}
	
		if ($cc != "") {
			$copia = str_replace(";", ",", $cc);
			$copias = explode(",", $copia);
			foreach ($copias as $dir) {
				echo "valor de los copia $dir <br />";
				$mail->AddCC($dir, $dir);
			}
		}
		$mail->WordWrap = 50;
		if ($adjunto != "") {
			$mail->AddAttachment($adjunto);
			echo "tiene adjunto <br />";
		}else{
			echo "no tiene adjunto <br />";
		}
		echo $asunto;
		echo $cuerpo;
		
		$mail->IsHTML(true);
		$mail->Subject = utf8_decode($asunto);
		$mail->Body = utf8_decode($cuerpo);
	
		if ($mail->Send()) {
			echo "ENVIADO";
		} else {
			echo "Se produjo un error al enviar el reporte de carga.";
		}
	}
?> 