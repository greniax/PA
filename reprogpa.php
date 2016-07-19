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
	 	$pa_id = $_GET['id'];	
		$pa_reprogramado= $_POST['txtreprogramado'];
		#$pa_eficacia = $_POST['txteficacia'];
		#$pa_resultado= $_POST['resultado'];
		#$pa_fechacumplimiento= $_POST['txtfecha'];
		$pa_fechareprog= $_POST['txtfecha'];
		$pa_status= 'REPROGRAMADO';
		$pa_statusgral = 3;


	 $sql = "UPDATE iavdb.TBL_paccion SET pa_reprogramado = '".$pa_reprogramado."', pa_fechareprog = '".$pa_fechareprog."', pa_status = '".$pa_status."', pa_statusgral = ".$pa_statusgral." WHERE TBL_paccion.pa_id = ".$pa_id;	

		$dataset->DB_REPROGPA($sql);

	if ($cfg_DoEVENT == TRUE){
		$ical = $dataset->CAL_DOiCAL_CAL($pa_id);
		FN_CREA_iCAL($ical,$pa_id);
	}
	
		$htmlOutPut=" ";
				
		$htmlOutPut.='<h3>Que tal ! '.$nombre .',</h3><hr>';
		$htmlOutPut.='<p> Dando seguimiento al Plan de Acción con ID <b>#'.$pa_id.'</b>';
		$htmlOutPut.=' El Plan de Acción con id #'.$pa_id.' ha sido reprogramado por el administrador, debido a que no se cumplió con las fechas establecidas para el cumplimiento de dicho plan. </p><br />';
		$htmlOutPut.='<table><tr><td style="background:#CDCDCD;"><b>Motivo de Reprogramación </b></td><td style="background:#E6E6E6;">'.$pa_reprogramado.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>Status </b></td><td style="background:#E6E6E6;">'.$pa_status.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b>Fecha de Reprogramación</b></td><td style="background:#E6E6E6;">'.$pa_fechareprog.'</td></tr>';
		$htmlOutPut.='<tr><td style="background:#CDCDCD;"><b></b></td><td style="background:#E6E6E6;"></td></tr>';
		$htmlOutPut.='</table><br />';
		$htmlOutPut.='<hr><center> <b>- WPA -</b><br /><pre> '.PA_APPURL.' </pre></center> '."\n";

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
