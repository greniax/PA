<?php 	
/**
 * @File viewpa.php
 * @author Luis Antonio Abrego Sanchez
 * @email labrego at gmail dot com
 * @content Programa para visualizar el
 * 	contenido del Plan de Acción
 * 	para su seguimiento
 * @date 16/Jun/2014
 * @Last 15/Dic/2015
 * @version 0.1.1
 * **/
##########################################

	$APPNAME = 'WPA';
	$APPPAGE = 'VISTA';
	$APPDESC = 'Vista del PA';

	include ('session.inc.php');
	include ('class.db.php');
	include ('topmenu.php'); 

##########################################

	$JSCRIPT='<script>
function OpenWin() {
	var OpenWin = window.open("uploadpa.php?id=<?php echo $_GET[\'id\']; ?>", "MsgWindow", "width=430, height=400");
}
function closeWin() {
	    OpenWin.close();   // Closes the new window
	    }
</script>';

	$sql = "SELECT * FROM TBL_paccion";

if(isset($_GET['id'])) {
#	$result = $dataset->DB_SQLORDIE($sql);
#		if (!mysql_num_rows($result)<=0) {
#			while ($row = mysql_fetch_assoc($result)){
#				$id = $row['pa_id'];
#				$norma = $row['pa_norma'];
#				$comentarios = $row['pa_comentarios'];
#				$noconformidad = $row['pa_noconformidad'];
#				$criterio = $row['pa_criterio'];
#				$causaraiz = $row['pa_causaraiz'];
#				$tiposolucion = $row['pa_tiposol'];
#				$descsolucion = $row['pa_descsol'];
#				$responsables = $row['pa_responsables'];
#				$fechacumplimiento = $row['pa_fechacumplimiento'];
#				$status = $row['pa_status'];
#				$reprogramado = $row['pa_reprogramado'];
#				$statusgral = $row['pa_statusgral'];
#				$eficacia = $row['pa_eficacia'];
#				$resultado = $row['pa_resultado'];
#				$creado = $row['pa_creado'];
#				$refauditoria = $row['pa_refauditoria'];
#				$asignado = $row['pa_asignado'];
#				$op = $_SESSION['op'];
#			}
	$pa = $dataset->DB_ItemPA($_GET['id'],$_SESSION['op']);
	
}
	


	function FN_GetEficacia($eficacia) {
		switch ($eficacia){
				case 'E':
					$html = " Eficaz <input type=\"radio\" name=\"eficacia\" value=\"E\" checked=\"checked\" disabled/> No Eficaz <input type=\"radio\" name=\"eficacia\" value=\"NE\" disabled/>";
					break;
				case 'NE':
					$html = " Eficaz <input type=\"radio\" name=\"eficacia\" value=\"E\" disabled/> No Eficaz <input type=\"radio\" name=\"eficacia\" value=\"NE\" checked=\"checked\" disabled/>";
					break;
				case '':
					$html = " Eficaz <input type=\"radio\" name=\"eficacia\" value=\"E\" disabled/> No Eficaz <input type=\"radio\" name=\"eficacia\" value=\"NE\" disabled/>";
					break;

		}
		return $html;
	}

	function FN_GetCriterio($criterio) {
		switch ($criterio){
				case 'NC-':
					$html = " NC- <input type=\"radio\" name=\"criterio\" value=\"NC-\" checked=\"checked\" disabled/>  NC+ <input type=\"radio\" name=\"criterio\" value=\"NC+\" disabled/> OB <input type=\"radio\" name=\"criterio\" value=\"OB\" disabled/> NA <input type=\"radio\" name=\"criterio\" value=\"NA\" disabled/>" ;
					break;
				case 'NC+':
					$html = " NC- <input type=\"radio\" name=\"criterio\" value=\"NC-\" disabled/>  NC+ <input type=\"radio\" name=\"criterio\" value=\"NC+\" checked=\"checked\" disabled/> OB <input type=\"radio\" name=\"criterio\" value=\"OB\" disabled/> NA <input type=\"radio\" name=\"criterio\" value=\"NA\" disabled/>" ;
					break;
				case 'OB':
					$html = " NC- <input type=\"radio\" name=\"criterio\" value=\"NC-\" disabled/>  NC+ <input type=\"radio\" name=\"criterio\" value=\"NC+\" disabled/> OB <input type=\"radio\" name=\"criterio\" value=\"OB\" checked=\"checked\" disabled/> NA <input type=\"radio\" name=\"criterio\" value=\"NA\"  disabled/> ";
					break;
				case 'NA':
					$html = " NC- <input type=\"radio\" name=\"criterio\" value=\"NC-\" disabled/>  NC+ <input type=\"radio\" name=\"criterio\" value=\"NC+\" disabled/> OB <input type=\"radio\" name=\"criterio\" value=\"OB\" disabled/>  NA <input type=\"radio\" name=\"criterio\" value=\"NA\" checked=\"checked\" disabled/>";
					break;
	}
		return $html;
	}

	function FN_GetTipoSol($tipo) {
		switch ($tipo){
			case 'AC':
				$tiposol = 'Accion Correctiva';
				break;
			case 'AP':
				$tiposol = 'Accion Preventiva';
				break;
			case 'CI':
				$tiposol = 'Correccion Inmediata';
				break;
			case '':
				$tiposol ='';
			}
			return $tiposol;
	}

	function FN_GetStatusGralPA ($status){
		switch ($status) {
			case 0:
				$stat = 'Asignado';
				break;
			case 1:
				$stat = 'Abierto';
				break;
			case 2:
				$stat = 'Cerrado';
				break;
			case 3:
				$stat = 'Reprogramado';
				break;
		}
		return $stat;

	}

	function FN_GetStatusLabel ($status){
		if (!isset($status)){
			$label = "Sin Aceptar";}
		else {	$label = $status; }
		return $label;
	}

	function FN_ClassVigente($fecha, $status){
			$actual = DATE("Y-m-d");
			$v ='';
		#	if ($actual < $fecha) { $v = 'vigente';}
			if ($actual > $fecha && $status != 'CERRADO'){ $v = 'caduco';}
			if ($actual > $fecha && $status == 'CERRADO'){ $v = 'vigente';}

			return $v;
	}
/*	function FN_RefAudit($ref) {
		switch ($ref) {
			case 0:
				$r = 'AUDITORIA INTERNA';
				break;
			case 1:
				$r = 'INTEGRAL NISSAN';
				break;
			case 2: 
				$r = 'LIDER';
				break;
			case 3:
				$r = 'SAI GLOBAL';
				break;
			case 4:
				$r = 'BSC';
				break;
	}
		return $r;
	}
	*/

	function sdir($path, $pa_id){ 
		#	echo $pa_id . "-".$path; 
		$FullPathDir = $path."/".$pa_id;
		 if (is_dir($FullPathDir)){

			if ($handle = opendir($FullPathDir)) {
			    while (false !== ($entry = readdir($handle))) {
		            if ($entry != "." && $entry != "..") {
		                echo " <a href=\"".$path.$pa_id."/".$entry."\"> ".$entry."</a><br /> \n";
			        }
		        }
			}
		    closedir($handle);
			}
			else {
				echo "¡ No se encontraron archivos para mostrar !";
			}
	} 	    
	

	
	echo $htmltag."\n";
?>
<html>
<head>
	<?php echo $metatag."\n"; ?>

	<title><?php echo PA_APPNAME." :: ".PA_APPDESCRIPTION;?> </title>
		<link rel="stylesheet" type="text/css" href="css/viewpa.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

	<script>
		function OpenWin() {
			var OpenWin = window.open("uploadpa.php?id=<?php echo $_GET['id']; ?>", "MsgWindow", "width=430, height=400");
		 }
		function closeWin() {
	    		OpenWin.close();   // Closes the new window
	   	 }
	</script>

</head>
<body>
<?php echo $menu; ?>
<br />
<?php echo $menudesc; ?>
<br />
<div id="pa_wrapper">
	<div id="header">
		<div id="id"><?php echo $pa['id'];?></div><div id="asignado"><?php echo '<br />'. $pa['asignado']; ?></div>
		<div id="status"><?php echo FN_GetStatusLabel($pa['status']);?></div><div id="creado"><?php #echo '<br />'.$pa['creado'];?></div>
	</div>
	<!-- <div id="container"> -->
		<div id="left-content">
			<dl>
				<dt>Origen :</dt><dd> <?php /* echo FN_RefAudit($pa['refauditoria']); */ echo ($origen = $dataset->DB_GetOrigen($pa['refauditoria'])); echo ' - ' .$claveorigen = $dataset->DB_GetClaveOrigen($pa['refauditoria']);?></dd>
			
				<dt>No Conformidad / Observaciones :</dt><dd> <?php echo $pa['noconformidad']; ?></dd>
			<fieldset>
 				<legend>Criterio</legend>
					<?php echo FN_GetCriterio($pa['criterio']); ?>	
			</fieldset>

			<dt>Creado</dt><dd><?php echo date_format(date_create($pa['creado']), 'Y-m-d'); ?></dd>
			<dt>Archivos</dt><dd><div style="position:relative;top:1px;text-align:right;padding-bottom:5px;padding-right:3px;">
<?php if ($pa['statusgral'] <> 2) { 
	echo '<a href="#" OnClick="OpenWin()" >Cargar Archivos</a></div><br \>';
		 sdir("uploads/",$_GET['id']); 
		}
	else { 
		 sdir("uploads/",$_GET['id']);
	}
?>
	<dd>
	</dl>
		</div>
		<div id="center-content">
			<dl>
				<dt> Causa Raiz :</dt><dd><?php echo $pa['causaraiz'];?></dd>
				<dt>Tipo de Solucion :</dt><dd class="solucion"><?php echo FN_GetTipoSol($pa['tiposolucion']); ?></dd>
				<dt>Descripcion :</dt><dd><?php echo $pa['descsolucion']; ?></dd>
				<dt>Responsables :</dt><dd><?php echo $pa['responsables']; ?></dd>
				<dt>Fecha de Cumplimiento</dt><dd class="<?php echo FN_ClassVigente($pa['fechacumplimiento'], $pa['status']); ?>"><?php echo $pa['fechacumplimiento']; ?></dd>
			</dl>
		</div>
		<div id="right-content">
			<dl>
				<dt> Motivo de Reprogramacion :</dt><dd><?php echo $pa['reprogramado'];?></dd>
				<dt> Fecha de Reprogramacion :</dt><dd><?php echo $pa['fechareprog'];?></dd>

				<dt>Eficacia de las acciones tomadas :</dt><dd><?php echo $pa['eficacia']; ?></dpli>
			</dl> 
			<fieldset>
				<legend>Resultado</legend>
					<?php echo FN_GetEficacia($pa['resultado']); ?> 
			</fieldset>
			<dt> Fecha de Cierre :</dt><dd><?php echo $pa['fechacierre'];?></dd>
		</div>
	<!--	</div>  /DIV container -->
	<!-- 	Footer 	-->
	<script>	
		$ = function(id) {
			return document.getElementById(id);
		}
		var show = function(id) {
			$(id).style.display ='block';
		}
		var hide = function(id) {
		$(id).style.display ='none';
		}
	</script>
<div id="footer">
<a href="#" onclick="show('popupcomment')"> Observaciones </a><br />
<div class="popupcom" id="popupcomment">
<form name="frm_addcomment" action="addcomment.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data"><br /><label form="lbladdcomment" for="txtcomment">Observaciones:</label><br /> <textarea name="txtcomentario" rows="5" cols="50"></textarea><br /><input type="submit" name="Submit" Value="agregar"></form>
	<a href"#" onclick="hide('popupcomment')">Cerrar</a></div>
	</div>
	<div id="comment">
	<?php 
	echo  $observaciones = str_replace(";","<br />",$dataset->COMMENT_GETCOMMENTS($_GET['id'])); ?>
		
	</div>
 <!-- /DIV wrapper -->
<?php #print_r($observaciones); ?>
</body>
</html>
