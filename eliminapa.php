<?php
	include ('session.inc.php');
	include ('class.db.php');

	if (isset($_GET['id'])){
	 	$pa_id = $_GET['id'];	
	
		$sql = "DELETE FROM iavdb.TBL_paccion WHERE TBL_paccion.pa_id = ".$pa_id;

		$dataset->DB_ELIMINAPA($sql);

		header ('Location: '.PA_WEBLISTPA);
	}

?>	
