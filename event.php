<?php
	include ('class.db.php');
	include ('config.inc.php');

// Pear Mail Library
	require "tools/Mail/PHPMailerAutoload.php";

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
/*$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'adpc.iav@grupoautofin.com';                 // SMTP username
$mail->Password = 'Vzatpo34';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
 */
$mail->Host = $MailInfo['host'];
$mail->SMTPAuth = $MailInfo['auth'];
$mail->Username = $MailInfo['username'];
$mail->Password = $MailInfo['password'];
$mail->SMTPSecure = 'tls';
$mail->Port = $MailInfo['puerto'];
$mail->setFrom('adpc.iav@grupoautofin.com', 'Planes de Accion');
$mail->addAddress('sistemas.iav@grupoautofin.com', 'LAbrego039');     // Add a recipient
#$mail->addAddress('ellen@example.com');               // Name is optional
#$mail->addReplyTo('info@example.com', 'Information');
#$mail->addCC('cc@example.com');
#$mail->addBCC('bcc@example.com');
#$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
#$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->Subject ='Prueba de envio WPA';
$mail->Body    = 'Este es el Mensaje <b>del Evento!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->isHTML(true);                                  // Set email format to HTML


$id = $_GET['pa_id'];
	$ical = $dataset->CAL_DOiCAL_CAL($id);
#	echo $ical;

#	$rss = $dataset->RSS_DO(); //Genera String RSS
#	$ical = $dataset->CAL_iCALDO(); 

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
	function FN_ADD_iCAL_EVENT($id,$ical){

		$userid= $id;
		$filename ='calendario.ics';
		$dirname ='ical';
	 	$iCalStr ='';	
		if(!is_dir($dirname.'/'.$userid)){
			    mkdir($userid,0755);
			}
	
			$iCalFile = $dirname.'/'.$userid.'/'.$filename;
		if(!is_file($iCalFile)){
			$iCalFile = fopen($iCalFile,"w");
			$iCalStr = "BEGIN:VCALENDAR\n";
			$iCalStr.= "VERSION:2.0\n";
			$iCalStr.= $ical;
			$iCalStr.= "END:VCALENDAR\n";

			fwrite($iCalFile,$iCalStr);
			fclose($iCalFile);
			$msg = "Se Creo el archivo ".$iCalFile." y se agregó el evento";
		} else {

			$iCalFile = fopen($iCalFile,"a");
			$iCalStr.= $ical;
			fseek($iCalFile, -2, SEEK_END);
			fwrite($iCalFile,$iCalStr);
			fclose($iCalFile);
			$msg = "Se agregó el evento con éxito";
		}	
		
		return $msg;
	}
	
/*	$mail = $smtp->send($to, $headers, $body);

	if (PEAR::isError($mail)) {
    		echo('<p>' . $mail->getMessage() . '</p>');
	} else {
		    echo('<p>Message successfully sent!</p>');
	}
 */
?>
<html>
<head>
<style rel="stylesheet" type="text/css">
#loader-icon {position: fixed;top: 50%;width:100%;height:100%;text-align:center;display:none;}
</style>

</head>
<body>
<div id="loader-icon"><img width="100px" height="100px" src="css/img/ajax-loader.gif" /></div>

</body>
</html>
<?php
#	$mail->Ical= FN_CREA_iCAL(00039);
#	echo '<hr><p>'. FN_CREA_iCAL(00039).'</p>';
#	if(!$mail->send()) {
#	        echo 'Message could not be sent.';
#    		echo 'Mailer Error: ' . $mail->ErrorInfo;
#	} else {
#    		echo 'Message has been sent';|
#
	#}
#	echo FN_CREAXML($rss);
	echo FN_CREA_iCAL($ical,$id);
	echo '<br />###############################<br />';
	echo FN_ADD_iCAL_EVENT($id,$ical);
/*	if (isset($_GET['id'])){
		$id = $_GET['id'];
 */
#	 header ('Location: '.PA_WEBLISTPA);

?>
