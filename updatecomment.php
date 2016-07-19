<?php
	include ('session.inc.php');
	include ('class.db.php');

	if (isset($_GET['id'])){
		$pa_id = $_GET['id'];
		$pa_comentario = $_POST['txtcomentario'];
/*
		$pa_causaraiz= $_POST['txtcausaraiz'];
		$pa_tiposol = $_POST['optsolucion'];
		$pa_descsol= $_POST['txtsolucion'];
		#$pa_responsables= $_POST['optresponsables'];
		$pa_fechacumplimiento= $_POST['txtfecha'];
		$pa_archivo = $_POST['txtfile'];
		$pa_status= 'PROCESO';
		$pa_statusgral = 0;
		$pa_id= $_GET['id'];
		foreach ($_POST['optresponsables'] as $responsable){
			$responsables .= $responsable.'; ';
		}
		$pa_responsables = $responsables;
 */
		#if (file_exists($pa_archivo)) {
			move_uploaded_file($pa_archivo,"uploads/".$pa_archivo);
		#}

		/*	 $sql = "UPDATE iavdb.TBL_paccion SET pa_causaraiz = '".$pa_causaraiz."', pa_tiposol ='".$pa_tiposol."', pa_descsol = '".$pa_descsol."', pa_responsables ='".$pa_responsables."', pa_fechacumplimiento = '".$pa_fechacumplimiento."', pa_status = '".$pa_status."', pa_statusgral = ".$pa_statusgral." WHERE TBL_paccion.pa_id = ".$pa_id;	*/

	#	$dataset->DB_EDITCOMMENT($pa_id, $pa_comentario);

		header ('Location: '.PA_WEBVIEWPA.'?id='.$pa_id);
	}

?>	
