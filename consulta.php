<?php

	$APPPAGE='Consulta PA';
	$APPDESC='Consulta de Planes de Acción';

	include ('session.inc.php');
	include ('topmenu.php');
	include ('class.db.php');
$perPage=10;

	if ($_SESSION['op'] == 1 AND (isset($_GET['u']))){
		$sql= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_Usuarios.usr_uuid = ".$_GET['u']." AND pa_statusgral <> 2 ORDER BY pa_id";
	}
	
	else if ($_SESSION['op'] == 1){
		$sql= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_statusgral <> 2 ORDER BY pa_id";
	}
			
	else {
	       	$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado)WHERE TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' AND TBL_paccion.pa_statusgral <> 2 ORDER BY pa_id";
	}

	if(!empty($_GET['optpag'])){
	   $perPage = $_GET['optpag'];
	}

	if(!empty($_GET['status'])){
	   $status = $_GET['status'];}
	else { $status = '';
	}

	if(!empty($_GET['criterio'])){
	   $criterio = $_GET['criterio'];}
	else { $criterio = '';
	}

	if(!empty($_GET['origen'])){
	   $origen = $_GET['origen'];}
	else { $origen = '';
	}

	if(!empty($_GET['qry'])){
	$qry = $_GET['qry'];
	
	switch ($qry){
		case 1 :
			if($_SESSION['op'] == 1) {

				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) ORDER BY pa_id";
			}
			else if (($_SESSION['op'] == 1) || $_GET['u'] ){
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado)WHERE TBL_Usuarios.usr_uuid = ".$_GET['u']." ORDER BY pa_id"; }
			else {
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado)WHERE TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' ORDER BY pa_id";
			}
			
			break;
	// ################### ORGIGEN #############################
		case 2 :
			if ($_SESSION['op'] == 1 AND (!empty($_GET['u']))){
				$sql ="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_refauditoria = ".$origen." AND TBL_Usuarios.usr_uuid = '".$_GET['u']."' ORDER BY pa_id";
			}
			else if($_SESSION['op'] == 1 ) {
				$sql ="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_refauditoria = ".$origen."  ORDER BY pa_id";
			}
	/*		else if ($_SESSION['op'] == 1 AND (!empty($_GET['u']))){
				$sql ="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_refauditoria = ".$origen." AND TBL_Usuarios.usr_uuid = '".$_GET['u']."' ORDER BY pa_id";
	} */
			else  {
				$sql ="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_refauditoria = ".$origen." AND TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' ORDER BY pa_id";
			}

			break;
	// ################### STATUS ##############################
		case 3 :
			if ($_SESSION['op'] == 1 AND (isset($_GET['u']))) {
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_statusgral = \"".$status."\" AND TBL_Usuarios.usr_uuid = '".$_GET['u']."' ORDER BY pa_id";
			}
			else if ($_SESSION['op'] == 1) {
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_statusgral = \"".$status."\" ORDER BY pa_id";
			}
			else {
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_statusgral = \"".$status."\" AND TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' ORDER BY pa_id";
			}
			break;
	// ################# CRITERIO ###############################		
		case 4 :
			if ($_SESSION['op'] == 1 AND (isset($_GET['u']))) {
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_criterio = ".$criterio." AND TBL_Usuarios.usr_uuid = '".$_GET['u']."' ORDER BY pa_id";
			}
			else if ($_SESSION['op'] == 1){
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_criterio = ".$criterio." ORDER BY pa_id";
			}
			else {
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_criterio = ".$criterio." AND TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' ORDER BY pa_id";
			}

			break;
		case 5 :
			$sql="";
			break;
		case 6 :
			$sql ="";
			break;
		default :
			if ($_SESSION['op'] == 1 AND (isset($_GET['u']))){
				
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_Usuarios.usr_uuid = '".$_GET['u']."' pa_statusgral <> 2 ORDER BY pa_id";
			}
			else if ($_SESSION['op'] == 1){
				$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_paccion.pa_statusgral <> 2 ORDER BY pa_id";

			#	$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion  ORDER BY pa_id";
			}
			else { $sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado)WHERE TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' AND TBL_paccion.pa_statusgral <> 2 ORDER BY pa_id";
			}
			break;
	}
}

	
$page = 1;
if(!empty($_GET["page"])) {
$page = $_GET["page"];
}

$start = ($page-1)*$perPage;
if($start < 0) $start = 0;
#echo $sql;
$query =  $sql . " limit " . $start . "," . $perPage; 
$faq = $dataset->DB_RunQuery($query);

if(empty($_GET["rowcount"])) {
$_GET["rowcount"] = $dataset->DB_GetNumRows($sql);
}
$pages  = ceil($_GET["rowcount"]/$perPage);

$SELF_PHP = strlen($_SERVER['QUERY_STRING']) ? basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'] : basename($_SERVER['PHP_SELF']);
if (!empty($pages)){
	$output = '';
	$nav='<div class="stacked-icons">';
	
	for($i=1;$i<=$pages;$i++){
		$nav.='<span class="fa-stack fa-1x"><i class="fa fa-file-o fa-stack-2x"></i><a href="consulta.php?'.$_SERVER['QUERY_STRING'].'&page='.$i.'"><strong class="fa-stack-1x fa-stack-text navnumber">'.$i.'</strong></a></span>';
	};
	
	$nav.="</div>";
}	
 else {
	 $output = '<span class="noresults"> No se encontraron resultados </span>';
 }

if(!empty($faq)) {
	$output .= '<input type="hidden" class="pagenum" value="' . $page . '" /><input type="hidden" class="total-page" value="' . $pages . '" />';
	$output.= '<div id="issue_nav">'.$nav.'</div> Total de Registros= '. $_GET['rowcount']. '<br /> '; #.$sql;
	foreach($faq as $k=>$v) {
	$output.="<div class=\"container_issue\">
	<table class=\"issue-table\">
		<tbody>
			<tr><td>
					<div class=\"issue-message\">".mb_strimwidth($faq[$k]['pa_noconformidad'], 0, 100,"..."). "</div></td>
				<td class=\"issue_top_right\"><ul class=\"list-inline\">
						<li class=\"issue-meta\"><span title=\"".$dataset->DB_GetClaveOrigen($faq[$k]['pa_refauditoria'])."\" class=\"issue-meta-label\">".$dataset->DB_GetOrigen($faq[$k]['pa_refauditoria'])."</span></li>
	<li class=\"issue-meta\"><span class=\"issue-meta-label\">".date_format(date_create($faq[$k]['pa_creado']), 'Y-m-d')."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">". $faq[$k]['pa_id']."</span></li>
						<li class=\"issue-meta\"><span title=\"Mail\" class=\"issue-meta-label\"><a href=\"#\"><i class=\"fa fa-envelope-o fa-1x fa-fw\"></i></a></span></li><li class=\"issue-meta\"><span title=\"Evento\" class=\"issue-meta-label\"><a href=\"ical/".$faq[$k]['pa_id'].".ics\"><i class=\"fa fa-calendar-check-o fa-1x fa-fw\"></i></a></span></li></ul>

				</td>
			</tr>
			<tr><td>
					<div class=\"issue_bottom\">
						<ul class=\"list-inline\">
						<li class=\"issue-meta\"><span class=\"issue-meta-label ".$dataset->GetCSSCriterio_($faq[$k]['pa_criterio'])."\">".$faq[$k]['pa_criterio']."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\"><i class=\"fa fa-circle fa-1x fa-fw\" style=\"color:".$dataset->GetCSSStatus_($faq[$k]['pa_statusgral']).";\"></i>".$faq[$k]['pa_status']."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$faq[$k]['usr_nombre']." ".$faq[$k]['usr_paterno']." </span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">";
       		if ($faq[$k]['pa_statusgral'] <> 1){ $output.= " Cumplimiento: ".date_format(date_create($faq[$k]['pa_fechacumplimiento']), 'Y-m-d')."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\"> Reprogramado: ".date_format(date_create($faq[$k]['pa_fechareprog']), 'Y-m-d')." </span></li>";}
				
				$output.= "	</ul>
					</div>
				</td>
				<td>";
	/*	<div class=\"issue_bottom_right\"><button type=\"button\" class=\"btn btn-default btn-sm\"> Ver</button> | <button type=\"button\" class=\"btn btn-default btn-sm\">Reprogramar</button> | <button type=\"button\" class=\"btn btn-default btn-sm\">Cerrar</button> | <button type=\"button\" class=\"btn btn-default btn-sm\">Eliminar</button></div>*/
	$output.= $dataset->GetStatusSearchPA($faq[$k]['pa_statusgral'],$faq[$k]['pa_id'],$_SESSION['op']);
	$output.="	</td>
			</tr>
		</tbody>
	</table>
</div>";
	}//Fin del Foreach
} // Fin del If (!empty($faq))


#	$sql= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_Usuarios.usr_usuario = '".$_SESSION['username']."' ORDER BY pa_statusgral";

#	$sql1= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) ORDER BY pa_statusgral";
	
	echo $htmltag."\n";
?>
<html>
<head>
	<?php echo $metatag."\n"; ?>
	<title><?php echo PA_APPNAME.' :: '.PA_APPDESCRIPTION; ?></title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">

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
<?php /*<div id="TabColores">
	<p> Auditorias: <span class="A_iso">ISO</span> | <span class="A_lider">LIDER</span> | <span class="A_integral">INTEGRAL</span> | <span class="A_interna">INTERNA</span> | <span class="A_bsc">BSC</span>   Criterios: <span class="CriterioNC">NO CONFORMIDAD</span> | <span class="CriterioOB">OBSERVACIONES</span>| <span class="CriterioNA">NA</span>   Status: <span class="A_reprog">REPROGRAMADA</span> | <span class="S_cerrada">CERRADA</span> | <span class="S_abierta">ABIERTA</span> | <span class="S_asignada">ASIGNADA</span></p>

</div>
<hr />
 */
?>
<!-- ************ Div Criterios de Consulta **************** -->
<form>
<div class="divconsulta">
	<legend>Criterio de Busqueda</legend>
<?php 
	$sqlu="SELECT usr_uuid, usr_usuario, usr_nombre,usr_paterno FROM TBL_Usuarios";
	if ($_SESSION['op'] == 1 AND (!isset($_GET['u']))) {
	echo $dataset->DB_FillUsernameSearch($sqlu,'optuser','OnChange="location.href=this[this.selectedIndex].value"',0,1);
	}
 	if ($_SESSION['op'] == 1 AND (!empty($_GET['u']))) {
  		echo $dataset->DB_FillUsernameSearch($sqlu,'optuser','OnChange="location.href=this[this.selectedIndex].value"',$_GET['u'],1); //1 para mostrar Num registros o quitar parametro
	}
 
	if (!empty($_GET['u'])){
		$u = $_GET['u'];}
	else { $u=null;}

?>	
<span class="spanconsulta"> </span> 
<input type="radio" name="btquery" value="origen"> Origen <input type="radio" name="btquery" value="status"> Status <input type="radio" name="btquery" value="criterio">Criterio 
<div id="qryorigen" class="query_field"><!-- Criterio Origen -->
<?php
	$action = 'OnChange="location.href=this[this.selectedIndex].value"';
	$sql_origen = "SELECT id, origen, clave FROM TBL_origen WHERE activo = 1";
echo $dataset->DB_FillOrigenSearch($sql_origen,'optcriterio',$action,$u);
?>

</div>
<div id="qrystatus" class="query_field"> <!-- Criterio Status -->
<?php 		$action = 'OnChange="location.href=this[this.selectedIndex].value"';
		$sql_status =" SELECT DISTINCT pa_status, pa_statusgral FROM TBL_paccion ";
	echo $dataset->DB_FillStatusSearch($sql_status,'optcriterio',$action,$u); ?>
</div>
<div id="qrycriterio" class="query_field"><!-- Criterio -->
<?php 		$action = 'OnChange="location.href=this[this.selectedIndex].value"';
		$sql_criterio = "SELECT DISTINCT pa_criterio FROM TBL_paccion";
	echo $dataset->DB_FillCriterioSearch($sql_criterio,'optcriterio',$action,$u); ?>
</form>
</div>
</div>
</form>
<!-- *********** Div Container ****************** -->

<div id="containersearch">

<?php
/*
	if ($_SESSION['op'] == 0) {
	
	$fields = $dataset->DB_ListViewOpenPA($sql,$_SESSION['op']);
	echo $fields;
	}

	if ($_SESSION['op'] == 1) {
	
	$fields = $dataset->DB_OPViewPA($sql1,$_SESSION['op']);
	echo $fields;
	}
 */
	print $output;
?>
</div>
</body>
</html>
