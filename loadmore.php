<?php
require_once ('class.db.php');
$perPage = 15;

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
	#$origen = 9;
	#$status = 0;
	switch ($qry){
	case 1 :
		$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) ORDER BY pa_id";
		break;
	case 2 :
		$sql ="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_refauditoria = ".$origen."  ORDER BY pa_id";
		break;
	case 3 :
		$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_statusgral = \"".$status."\"  ORDER BY pa_id";
		break;
	case 4 :
		$sql="SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE pa_criterio = ".$criterio."  ORDER BY pa_id";
		break;
	case 5 :
		$sql="sql1";
		break;
	case 6 :
		$sql ="sql";
		break;
	default :
		$sql ="SELECT * FROM TBL_paccion ORDER BY pa_id";
		break;
	}
}
else {
	$sql= "SELECT pa_id,pa_norma,pa_comentarios,pa_noconformidad,pa_criterio,usr_nombre,usr_paterno,pa_refauditoria,pa_fechacumplimiento,pa_status,pa_creado,pa_fechacierre,pa_fechareprog,pa_statusgral FROM TBL_paccion LEFT JOIN TBL_Usuarios ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) ORDER BY pa_id";
}

$page = 1;
if(!empty($_GET["page"])) {
$page = $_GET["page"];
}

$start = ($page-1)*$perPage;
if($start < 0) $start = 0;

$query =  $sql . " limit " . $start . "," . $perPage; 
$faq = $dataset->DB_RunQuery($query);

if(empty($_GET["rowcount"])) {
$_GET["rowcount"] = $dataset->DB_GetNumRows($sql);
}
$pages  = ceil($_GET["rowcount"]/$perPage);
$output = '';
if(!empty($faq)) {
	$output .= '<input type="hidden" class="pagenum" value="' . $page . '" /><input type="hidden" class="total-page" value="' . $pages . '" />';
	
	foreach($faq as $k=>$v) {
	$output.="<div class=\"container_issue\">
	<table class=\"issue-table\">
		<tbody>
			<tr><td>
					<div class=\"issue-message\">".mb_strimwidth($faq[$k]['pa_noconformidad'], 0, 80,"..."). "</div></td>
				<td class=\"issue_top_right\"><ul class=\"list-inline\">
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$faq[$k]['pa_creado']."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">". $faq[$k]['pa_id']."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\"> Mail</span></li></ul>

				</td>
			</tr>
			<tr><td>
					<div class=\"issue_bottom\">
						<ul class=\"list-inline\">
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$faq[$k]['pa_criterio']."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$faq[$k]['pa_status']."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$faq[$k]['usr_nombre']." ".$faq[$k]['usr_paterno']." </span></li>
					<li class=\"issue-meta\"><span class=\"issue-meta-label\"> FC: ".date_format(date_create($faq[$k]['pa_fechacumplimiento']), 'Y-m-d')."</span></li>
						<li class=\"issue-meta\"><span class=\"issue-meta-label\"> FR:".date_format(date_create($faq[$k]['pa_fechareprog']), 'Y-m-d')." </span></li>

						</ul>
					</div>
				</td>
				<td>
					<div class=\"isue_bottom_right\">Ver | Reprogramar | Cerrar | Eliminar</div></td>
			</tr>
		</tbody>
	</table>
</div>";
	}//Fin del Foreach
} // Fin del If (!empty($faq))
$debugg="<div id=\"msgdebug\">";
#echo '{{ '. $sql .' }} <br />". $_SERVER['PHP_SELF']." - ".$_SERVER['QUERY_STRING'] .
$debugg.= "<br />". $rowcount= $dataset->DB_GetNumRows($sql)."<br /></div>";
print $debugg;
print $output;
?>
