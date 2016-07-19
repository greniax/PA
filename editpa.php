<?php
	include ('session.inc.php');
	include ('class.db.php');


	function FN_CREA_iCAL($ical,$id) {  // string - ical, int- id
		$filename = $id.'.ics';
		$dirname = 'ical';
		$icalFileName = $dirname.'/'.$filename;
		if (!is_file($icalFileName)){
			$ICAL = fopen($icalFileName, "w");
			fwrite($ICAL,$ical);
			fclose($ICAL);
		}
		else {
			unlink($icalFileName.'_old');
			rename($icalFileName, $icalFileName.'_old');
			$ICAL = fopen($icalFileName, "w");
			fwrite($ICAL,$ical);
			fclose($ICAL);
		}
		return $ical;
	}

	if (isset($_GET['id'])){
		$responsables ='';
		$pa_causaraiz= $_POST['txtcausaraiz'];
		$pa_tiposol = $_POST['optsolucion'];
		$pa_descsol= $_POST['txtsolucion'];
		#$pa_responsables= $_POST['optresponsables'];
		$pa_eficacia= $_POST['txteficacia'];
		$pa_fechacumplimiento= $_POST['txtfecha'];
		$pa_archivo = $_POST['txtfile'];
		$pa_status= 'PROCESO';
		$pa_statusgral = 0;
		$pa_id= $_GET['id'];
		foreach ($_POST['optresponsables'] as $responsable){
			$responsables .= $responsable.'; ';
		}
		$pa_responsables = $responsables;

		#if (file_exists($pa_archivo)) {
			move_uploaded_file($pa_archivo,"uploads/".$pa_archivo);
		#}

	 $sql = "UPDATE iavdb.TBL_paccion SET pa_causaraiz = '".$pa_causaraiz."', pa_tiposol ='".$pa_tiposol."', pa_descsol = '".$pa_descsol."', pa_eficacia ='".$pa_eficacia."', pa_responsables ='".$pa_responsables."', pa_fechacumplimiento = '".$pa_fechacumplimiento."', pa_status = '".$pa_status."', pa_statusgral = ".$pa_statusgral." WHERE TBL_paccion.pa_id = ".$pa_id;	

		$dataset->DB_EDITPA($sql);

		$_userid = $dataset->DB_GetFieldByPAID($pa_id,'pa_asignado');
		$nombre = $dataset->DB_GETUSERNAME($_userid); 
		$email	= $dataset->DB_GETEMAIL($_userid);

	if ($cfg_DoEVENT == True){  // GENERA EVENTO ical
		$ical = $dataset->CAL_DOiCAL_CAL($pa_id);
		FN_CREA_iCAL($ical,$pa_id);
	}


		$htmlOutPut=" ";
				
		$htmlOutPut.='<h3>Que tal ! '.$nombre .',</h3><hr>';
		$htmlOutPut.='<p> Dando seguimiento al Plan de Acción con ID <b>#'.$pa_id.'</b>';
		$htmlOutPut.=' Se acepta la solicitud con la siguiente información :</p><br />';
		$htmlOutPut.='<table><tr><td style="background:#CDCDCD;"><b>Causa raíz </b></td><td style="background:#E6E6E6;">'.$pa_causaraiz.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>Tipo de Solución y Descripción</b></td><td style="background:#E6E6E6;">'.$pa_tiposol.',<br>'.$pa_descsol.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>Eficacia de las acciones tomadas</b></td><td style="background:#E6E6E6;">'.$pa_eficacia.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>Fecha de Cumplimiento</b></td><td style="background:#E6E6E6;">'.$pa_fechacumplimiento.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b></b></td><td style="background:#E6E6E6;"></td></tr>';
		$htmlOutPut.='</table><br />';
		$htmlOutPut.='<hr><center> <b>- WPA -</b><br /><pre>Imperio Automotriz de Veracruz </pre></center> '."\n";

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
#	$mail->addAddress('sistemas.iav@grupoautofin.com', $nombre);     // Add a recipient
	$mail->addAddress($email, $nombre);     // Add a recipient
	$mail->addCC('adpc.iav@grupoautofin.com');     // Add a recipient
	$mail->addCC('sistemas.iav@grupoautofin.com');     // Add a recipient
	$subject = '[PA #'.$pa_id.'] Aceptado - Plan de Acción';
	if ($cfg_DoEVENT == True){
		$mail->addAttachment('ical/'.$pa_id.'.ics');
	}
	$mail->Subject = $subject;
	$mail->Body    = $htmlOutPut;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->isHTML(true);                                  // Set email format to HTML

	if(!$mail->send()) {
	        echo 'Message could not be sent.';
    		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		header ('Location: '.PA_WEBLISTPA);
	}	
}
?>	
