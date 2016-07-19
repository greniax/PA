<?php

	$APPPAGE='Calendario PA';
	$APPDESC='Calendario de Planes de Acción';

	include ('session.inc.php');
	include ('topmenu.php');
	include ('class.db.php');
	require_once('class.SimpleCalendar.php');

	error_reporting(E_ALL ^ E_WARNING);


	if ($_SESSION['op'] == 0) {

#$sql = "Select * from TBL_paccion WHERE pa_id=008";
#$sql = "Select * FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_Usuarios.usr_usuario = '".$_SESSION['username']."'";
#$id = '00044';
#$iduser = '007';
#list($event, $start, $end) = $dataset->CAL_GetEventXid(007);
$iduser = $dataset->DB_GETUSERID($_SESSION['username']);
echo $iduser.'%%%%%%%%'.$_SESSION['username'];
$events = $dataset->CAL_GetEventListXid($iduser);

$calendar = new SimpleCalendar();
$calendar->setStartOfWeek('sunday');
$calendar->setDate(date('Y-m-d'));
	foreach ($events as $event) {
		list($event, $start, $end) = $dataset->CAL_GetEventXid($event);
		$calendar->addDailyHtml($event, $start, $end);
		}
	} # Fin de Condifion OP == 0

	if ($_SESSION['op'] == 1) {

		$calendar = new SimpleCalendar();
		$calendar->setStartOfWeek('sunday');
		$calendar->setDate(date('Y-m-d'));
		$uuids = $dataset->CAL_GetUsuariosUUID();
		
	foreach ($uuids as $uuid) {
		$events = $dataset->CAL_GetEventListXid($uuid);
		foreach ($events as $event) {
		#	echo $uuid.'->'.$event.'<br />';
			list($event, $start, $end) = $dataset->CAL_GetEventXid($event);
			$calendar->addDailyHtml($event, $start, $end);
		
		} 
	} 

		echo 'Los operadores tendrán que esperar =)';
	}

	echo $htmltag."\n";
#print_r ($events);
?>
<html>
<head>
	<?php echo $metatag."\n"; ?>
	<title><?php echo PA_APPNAME.' :: '.PA_APPDESCRIPTION; ?></title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/SimpleCalendar.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
</head>
<body>
<?php echo $menu; ?>
<br />
<?php echo $menudesc; ?>

<?php $calendar->show(true); 
echo $_SESSION['username']; ?>
</body>
</html>
