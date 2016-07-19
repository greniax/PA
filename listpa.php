<?php

	$APPPAGE='Lista PA';
	$APPDESC='Lista General de Planes de Acción';

	include ('session.inc.php');
	include ('topmenu.php');
	include ('class.db.php');

	$criteriobusqueda = array('Usuario'=>1,'Origen'=>2,'Criterio'=>3,'Status'=>4);


#	if (isset($_POST['txtnorma'])) {
#		$norma = $_POST['txtnorma'];
#		$comentarios = $_POST['txtcomentarios'];
#		$noconformidad = $_POST['txtnoconformidad'];
#		$creiterio = $_POST['criterio'];
#		$causaraiz = $_POST['txtcausaraiz'];
#		$opsolucion = $_POST['optsolucion'];
#		$solucion = $_POST['txtsolucion'];
#		$fecha = $_POST['txtfecha'];
#	}
	$sql= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' ORDER BY pa_statusgral";

	$sql1= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) ORDER BY pa_statusgral";
	
/*	$htmlform.='<form name="frmquery" action="'.$_SERVER['PHP_SELF'].'method=GET enctype="multipart/form-data">';
	$htmlform.='<fieldset><legend>Buscar por: </legend>';

	If (isset($_GET['qry'])){
		if (isset($_GET['uuid'])) {
			$QRY_UUID = $_GET['uuid'];
		}
		If (isset($_GET['origen'])) {
			$QRY_ORIGEN =$_GET['origen'];
		}
		If (isset($_GET['status'])){
			$QRY_STATUS = $_GET['status'];	
		}
		if (isset($_GET['limit'])) {
			$QRY_LIMIT = $_GET['limit'];
		}
		
	$sqlx= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion WHERE pa_asignado = ".$QRY_UUID." AND (pa_refauditoria =".$QRY_ORIGEN." OR STATUS = ".$QRY_STATUS.") ORDER BY pa_statusgral";
	 $sqlx;
	}
 */
#	echo $norma.' y '. $comentarios;
	#	echo $fecha;
#	echo '<a href="'.PA_WEBPA.'?new">Nuevo PA</a> | <a href="'.PA_WEBLOGOUT.'">LogOut</a><br \>'. $_SESSION['username'].';'.$_SESSION['op']."\n";

	echo $htmltag."\n";
?>
<html>
<head>
	<?php echo $metatag."\n"; ?>
	<title><?php echo PA_APPNAME.' :: '.PA_APPDESCRIPTION; ?></title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

	<script>
	function JS_msgbox(x) {
		var urlid=  x;
			if (confirm("¿Esta Ud seguro de eliminar el registro " + urlid + " ? ") == true) {
				urlid = 'eliminapa.php?id='+ urlid;
				/*alert(urlid);*/
				window.location.assign(urlid);						} 
		}
	</script>

</head>
<body>
<?php echo $menu; ?>
<br />
<?php echo $menudesc; ?>
<div id="TabColores">
	<p> Auditorias: <span class="A_iso">ISO</span> | <span class="A_lider">LIDER</span> | <span class="A_integral">INTEGRAL</span> | <span class="A_interna">INTERNA</span> | <span class="A_bsc">BSC</span>   Criterios: <span class="CriterioNC">NO CONFORMIDAD</span> | <span class="CriterioOB">OBSERVACIONES</span>| <span class="CriterioNA">NA</span>   Status: <span class="A_reprog">REPROGRAMADA</span> | <span class="S_cerrada">CERRADA</span> | <span class="S_abierta">ABIERTA</span> | <span class="S_asignada">ASIGNADA</span></p>


</div>
<hr />

		

<div id="container" align="center">

<?php

	if ($_SESSION['op'] == 0) {
	
	$fields = $dataset->DB_ListViewOpenPA($sql,$_SESSION['op']);
	echo $fields;
	}

	if ($_SESSION['op'] == 1) {
	
	$fields = $dataset->DB_OPViewPA($sql1,$_SESSION['op']);
	echo $fields;
	}
?>
</div>

</body>
</html>
