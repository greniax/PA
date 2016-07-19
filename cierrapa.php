<?php
	include ('session.inc.php');
	include ('class.db.php');

	if (isset($_GET['id'])){
	 	$pa_id = $_GET['id'];	
		#$pa_reprogramado= $_POST['txtreprogramado'];
		#$pa_eficacia = $_POST['txteficacia'];
		$pa_resultado= $_POST['resultado'];
		$pa_fechacierre= $_POST['txtfecha'];
		$pa_status= 'CERRADO';
		$pa_statusgral = 2;


	 $sql = "UPDATE iavdb.TBL_paccion SET pa_resultado = '".$pa_resultado."', pa_fechacierre = '".$pa_fechacierre."', pa_status = '".$pa_status."', pa_statusgral = ".$pa_statusgral." WHERE TBL_paccion.pa_id = ".$pa_id;	

		$dataset->DB_CIERRAPA($sql);

		header ('Location: '.PA_WEBLISTPA);
	}

?>	
