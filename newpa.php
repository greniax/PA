<?php
	include ('session.inc.php');
	include ('class.db.php');

	function FN_CREAXML($rss){
		$filename = 'pa.xml';
		$dirname = 'xml';

		$xmlFileName = $dirname.'/'.$filename;
		if (!is_file($xmlFileName)){
			$XML = fopen($xmlFileName, "w");
			fwrite($XML,$rss);
			fclose($XML);
		}
		else {
			unlink($xmlFileName.'_old');
			rename($xmlFileName, $xmlFileName.'_old');
			$XML = fopen($xmlFileName, "w");
			fwrite($XML,$rss);
			fclose($XML);
		}

		return $msg ='XML Generado ';
	}


	if (isset($_POST['optasignado'])) {
		$pa_asignado = $_POST['optasignado'];
		$pa_norma = '';
		$pa_comentarios = '';
		$pa_noconformidad = $_POST['txtnoconformidad'];
		$pa_criterio = $_POST['criterio'];
		$pa_refauditoria = $_POST['optrefauditoria'];
		$pa_statusgral = 1;
	 	$pa_status = 'ABIERTA';	

	$sql = "INSERT INTO TBL_paccion (pa_norma, pa_comentarios, pa_noconformidad, pa_criterio, pa_refauditoria,pa_status, pa_statusgral, pa_asignado) values ('$pa_norma','$pa_comentarios','$pa_noconformidad','$pa_criterio','$pa_refauditoria','$pa_status','$pa_statusgral','$pa_asignado')";

		$dataset->DB_NEWPA($sql);
       
	$last_pa_id = mysql_insert_id(); // id asignado

         $rss = $dataset->RSS_DO(); /* SE GENERA EL STRING PARA EL XML */
       
   	 $email = $dataset->DB_GETEMAIL($_POST['optasignado']);	// int uuid
	 $fullname = $dataset->DB_GETUSERNAME($_POST['optasignado']); //int uuid
 
	 FN_CREAXML($rss);
	
/*		 header ('Location: '.PA_WEBLISTPA);

	}
	else {
		echo 'Algo Pasó'.$sql;
	}
 */
		
	$htmlOutPut=" "; 		// Se genera string para aviso por email
	 /*if (isset($_POST['optasignado'])) { 		*/
		$_asignado = $_POST['optasignado'];
		$_fullname = $dataset->DB_GETUSERNAME($_asignado);
		$_norma = '';
		$_comentarios = '';
		$_noconformidad = $_POST['txtnoconformidad'];
		$_criterio = $_POST['criterio'];
		$_refauditoria = $dataset->DB_GetClaveOrigen($_POST['optrefauditoria']);
		$_statusgral = 1;
			
		$htmlOutPut.='<h3>Que tal ! '.$_fullname .',</h3><hr>';
		$htmlOutPut.='<p>Se ha generado una solicitud de Plan de Acción con ID <b>#'.$last_pa_id.'</b>';
		$htmlOutPut.=' con la siguiente información :</p><br />';
		$htmlOutPut.='<table><tr><td style="background:#CDCDCD;"><b>Origen </b></td><td style="background:#E6E6E6;">'.$_refauditoria.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>No Conformidad/Observacion</b></td><td style="background:#E6E6E6;">'.$_noconformidad.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>Criterio</b></td><td style="background:#E6E6E6;">'.$_criterio.'</td></tr>';
		$htmlOutPut.='</table><br />';
		$htmlOutPut.='<p>Te sugerimos visitar el portal de Planes de Acción, para aceptar lo anterior '."\n";
		$htmlOutPut.='y proponer tus planes de acción asi como establecer tu fecha de compromiso para '."\n";
		$htmlOutPut.='el cumplimiento del mismo.</p>';

		
# 	require "config.inc.php";	
// Pear Mail Library
	require "tools/Mail/PHPMailerAutoload.php";

	$mail = new PHPMailer;

	$mail->CharSet = "UTF-8";
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $MailInfo['host'];
	$mail->SMTPAuth = $MailInfo['auth'];
	$mail->Username = $MailInfo['username'];
	$mail->Password = $MailInfo['password'];
	$mail->SMTPSecure = 'tls';
	$mail->Port = $MailInfo['puerto'];
	$mail->setFrom('adpc.iav@grupoautofin.com', 'Planes de Accion');
	$mail->addAddress($email, $nombre);     // Add a recipient
	$mail->addCC('adpc.iav@grupoautofin.com');     // Add a recipient

	$subject = '[PA] Asignación de Plan de Acción';
	$mail->Subject = $subject;
	$mail->Body    = $htmlOutPut;
	$mail->AltBody = 'Este es un mensaje de notificación, se ha generado un nuevo plan de acción, favor de visitar su portal.';
	$mail->isHTML(true);                                  // Set email format to HTML

	if(!$mail->send()) {
	        echo 'Message could not be sent.';
    		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
 		header ('Location: '.PA_WEBLISTPA);
 #  		echo 'Message has been sent';
		}

	}


?>	
