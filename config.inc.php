<?php

	define ('PA_APPNAME','WPA');
	define ('PA_APPDESCRIPTION','Plan de Correcciones, Acciones Correctivas y Preventivas');
	define ('PA_APPVERSION','0.0.2');


	define ('PA_WEBDENEGADO','login.php');
	define ('PA_WEBLOGIN','login.php');
	define ('PA_WEBLOGOUT','logout.php');
	define ('PA_WEBCHECKLOGIN','checklogin.php');
	define ('PA_WEBLISTPA','consulta.php');
	define ('PA_WEBPA','pa.php');
	define ('PA_WEBVIEWPA','viewpa.php');
	define ('PA_WEBDASHBOARD','dashboard.php');
	define ('ICAL_UID','IAV'); 	// {editable} UID para los eventos formato ical
	include ('meta.php');		// se requiere meta.php para generar los encabezados HTML (Doctype y Meta)

	// Variable MailInfo para configurar conexión con servidor SMTP
	$MailInfo = array (
		 //Editar Informacion de la cuenta y servidor SMTP
		'host' => 'smtp.mail.com',
		'port' => '587',
		'auth' => 'true',
		'username' => 'user@mail.com',
		'password' => 'passwd',
		'puerto' => '587'
	);

	$cfg_DoICAL = True;
	$cfg_DoEMAIL = True;
	$cfg_DoEVENT = True;
		
?>	
