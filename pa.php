<?php
	$APPDESC = 'Registro y programación de los planes de acción';
	$APPPAGE = 'Plan de Acción';
	define ('CC_PATH_UPLOAD_DIR','uploads/');

include ('session.inc.php');
include ('topmenu.php');
include ('class.db.php');

	$JSCRIPT='<script>
function OpenWin() {
	var OpenWin = window.open("uploadpa.php?id=<?php echo $_GET[\'edit\']; ?>", "MsgWindow", "width=430, height=400");
}
function closeWin() {
	    OpenWin.close();   // Closes the new window
	    }
</script>';


	#########################################################
	######  CONDICIONES PARA DETERMINAR EL TIPO DE     ######
	######  OPERACION QUE SE VA A RELIZAR		   ######
	######  NUEVO - ACEPTAR - REPROGRAMAR		   ######	
	#########################################################

	if ((isset($_GET['new'])) AND ($_SESSION['op'] == 1)) {					# CONDICION PARA CREAR UN NUEVO PA
			$obj_form = FN_EDIT_PA1();
	}

	if ((isset($_GET['edit'])) AND ($_SESSION['op'] == 0)){					# CONDICION PARA ACEPTAR UN PA ASIGNADO
		$obj_form = FN_EDIT_PA2($_GET['edit']);
		$obj_win = $JSCRIPT;
	}

	if ((isset($_GET['prog'])) AND ($_SESSION['op'] == 1)) {				# CONDICION PARA REPROGRAMAR UN PA
		$obj_form = FN_PROG_PA($_GET['prog']);
		$obj_win = $JSCRIPT;
	}
	if ((isset($_GET['cerrar'])) AND ($_SESSION['op'] == 1)) {				# CONDICION PARA CERRAR UN PA
		$obj_form = FN_CIERRA_PA($_GET['cerrar']);
	}
#	else { $forbidden = true; }

#	if (isset($forbidden)) {								# EN CASO DE NO CUMPLIR 
#		header ('Location: '.PA_WEBDENEGADO);
#	}
	
	#########################################################
	######  ESTA FUNCIÓN CREA EL HTML PARA CREAR UN    ######
	######  NUEVO PLAN DE ACCION 			   ######
	#########################################################
	
	function FN_EDIT_PA1() {
		
		$dataset = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);

		$sql = "SELECT usr_uuid, usr_puesto FROM TBL_Usuarios";
		$sql_origen = "SELECT id, origen, clave FROM TBL_origen WHERE activo = 1";
		$htmlform=' ';
		$htmlform.= '<form name="frm_planaccion" action="newpa.php" method="POST" enctype="multipart/form-data">

		<fieldset>
		<legend>Se asigna a: </legend>'. $dataset->DB_FillSelect($sql,'optasignado').'
	</fieldset><br \>
	<label form="frm_PlanAccion" for="txtrefauditoria">Origen</label>'. $dataset->DB_FillOrigen($sql_origen,'optrefauditoria').'

	<br \>
	<label form="frm_PlanAccion" for="txtobservaciones">Descripción del Incumplimiento</label> 
	<textarea name="txtnoconformidad" rows="5" cols="50"></textarea><br />
	<label form="frm_PlanAccion" for="optcriterio">Criterio</label> 
	<fieldset>
		<legend>Criterio</legend>
		NC- <input type="radio" name="criterio" value="NC-" checked="checked" /> 
		NC+ <input type="radio" name="criterio" value="NC+" checked="checked" /> 

			OB <input type="radio" name="criterio" value="OB" />
			NA <input type="radio" name="criterio" value="NA" />
</fieldset><br />';
		$htmlform.= FN_SubmitForm(0);

 	return $htmlform;
	}
	#########################################################
	######  ESTA FUNCIÓN CREA EL HTML ESTARA BLOQUEADO ######
	######  YA QUE SOLO SE MUESTRA COMO REFERENCIA     ######
	#########################################################

	function FN_EDIT_PA2($id){
		$htmlock =' ';
		$htmlock.= FN_LOCK_PA1($id);
		$htmlock.= FN_EDIT_PA3($id);
		return $htmlock;
	}

	function FN_LOCK_PA1($id) {
		
		$dataset = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
		$sql = "SELECT * FROM TBL_paccion WHERE pa_id =".$id;
		$a= $dataset->DB_ItemPA($id,$_SESSION['op']);
		$htmlock="\n\n<!-- Inicia formulario Bloqueado para el usuario -->\n\n";
   		$htmlock.= '<form> <label form="frm_PlanAccion" for="txtrefauditoria">Origen</label><select name="optrefauditoria" disabled><option value="0">'.$dataset->DB_GetClaveOrigen($a['refauditoria']).'</option>
	</select><br \>
	<label form="frm_PlanAccion" for="txtobservaciones">No Conformidad/Observaciones</label> 
	<textarea name="txtnoconformidad" rows="5" cols="50" disabled/>'.$a['noconformidad'].'</textarea><br />
	<label form="frm_PlanAccion" for="optcriterio">Criterio</label> 
	<fieldset disabled>
		<legend>Criterio</legend>
		NC- <input type="radio" name="criterio" value="NC-" checked="checked" readonly/> 
		NC+ <input type="radio" name="criterio" value="NC+" checked="checked" /> 

			OB <input type="radio" name="criterio" value="OB" />
			NA <input type="radio" name="criterio" value="NA" />
</fieldset></form><br />';
		$htmlock.="\n\n<!-- finaliza formulario bloqueado -->\n\n";

 	return $htmlock;
	}
	#########################################################
	######  ESTA FUNCIÓN CREA EL HTML PARA GENERAR EL  ######
	######  FORMULARIO UNA VEZ ACEPTADO EL PA	   ######
	#########################################################

	function FN_EDIT_PA3($id){
	
		$dataset = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
	$a= $dataset->DB_GETListResponsables();

	$htmlpa3= '';
	$htmlpa3.= "<form name=\"frm_planaccion\" action=\"editpa.php?id=$id\" method=\"POST\" enctype=\"multipart/form-data\">\n";
	
	$htmlpa3.= '<label form="frm_PlanAccion" for="txtcausaraiz">Causa Raiz de la debilidad</label>
      <textarea name="txtcausaraiz" rows="5" cols="50">Causa raiz de la
        debilidad</textarea><br />
      <label form="frm_PlanAccion" for="optsolucion">Tipo de Solución</label>
      <select name="optsolucion">
        <option value="AP">Accion Preventiva</option>
        <option value="AC">Accion Correctiva</option>
        <option value="CI">Corrección</option>
      </select>
      <br />
      <label class="textarea" form="frm_PlanAccion" for="txtsolucion">Descripción de la Solución</label><textarea

      name="txtsolucion" rows="5" cols="50">Descripción de la Solución</textarea><br />
      <label form="frm_PlanAccion" for="optresponsables">Responsables</label><br \>
 	<select size="10" name="optresponsables[]" multiple>'.$a.'
        </select><br \><label form="frm_PlanAccion" for="txteficacia">Eficacia de las acciones tomadas</label><textarea name="txteficacia" rows="5" cols="50"></textarea><br \>
	<label form="frm_PlanAccion" for="txtfecha">Fecha <input type="date" size="10" name="txtfecha" value="" /></label><br \>
	<p> <a href="#" OnClick="OpenWin()" >Cargar Archivos</a><p \><br \>';
		$htmlpa3.= FN_SubmitForm(1);
	 return $htmlpa3;
	}

	function FN_PROG_PA($id) {
		$htmlprog ='';
		$htmlprog.= "<form name=\"frm_planaccion\" action=\"reprogpa.php?id=$id\" method=\"POST\" enctype=\"multipart/form-data\">\n";
		$htmlprog.='<label form="frm_PlanAccion" for="txtfecha">Fecha <input type="date" size="10" name="txtfecha" value="" /></label><br \>
<br \><label form="frm_PlanAccion" for="txtreprogramado">Motivo de la Reprogramacion</label><textarea name="txtreprogramado" rows="5" cols="50">Motivo de la Reprogramacion</textarea><br />';
	$htmlprog.= FN_SubmitForm(2);
		return $htmlprog;
	}

	function FN_CIERRA_PA($id) {
		$htmlprog ='';
		$htmlprog.= "<form name=\"frm_planaccion\" action=\"cierrapa.php?id=$id\" method=\"POST\" enctype=\"multipart/form-data\">\n";
		$htmlprog.='<label form="frm_PlanAccion" for="txtfecha">Fecha <input type="date" size="10" name="txtfecha" value="" /></label><br \>
<br \><legend>Resultado</legend>
			Eficaz <input type="radio" name="resultado" value="E"/> 
			No Eficaz <input type="radio" name="resultado" value="NE" />
<br />';
	$htmlprog.= FN_SubmitForm(3);
		return $htmlprog;
	}

	#########################################################
	######  FUNCION CREA EL OBJETO SELECT EN HTML      ######
	######  CORRESPONDIENTE AL REF AUDITORIA	   ######
	#########################################################

/*	function FN_GetAudit($id){
		switch ($id) {

		case 0:
			$option = '<option value="0">INTERNA</option>';
			break;
		case 1:
			$option = '<option value="1">NISSAN Integral</option>';
			break;
		case 2:
			$option = '<option value="2">LIDER</option>';
			break;
		case 3:
			$option = '<option value="3">SAI GLOBAL</option>';
			break;
		case 4:
			$option = '<option value="4">BSC</option>';
			break;
}
	  	return $option;
	}
 */
	#########################################################
	######  ESTA FUNCIÓN CREA EL HTML PARA ENVIAR EL   ######
	######  FORMULARIO ASI COMO VALIDA LOS CAMPOS      ######
	#########################################################

	function FN_SubmitForm($PAn) {
		switch ($PAn)
		     {
			case 0:
				$frmsubmit= '<input type="button" name="Submit" value="Enviar" OnClick="checkForm(\'frm_planaccion\', \'txtnoconformidad:NoConformidad/Observaciones::5\', \'criterio:Criterio::1\')" ><br \>';
				break;
			case 1:
				$frmsubmit= '<input type="button" name="Submit" value="Enviar" OnClick="checkForm(\'frm_planaccion\', \'txtsolucion:Descripcion de la Solucion::5\', \'optresponsables[]:Responsables::1\', \'txtcausaraiz:Causa Raiz::5\', \'optsolucion:Solucion::1\', \'txteficacia:Eficacia::5\', \'txtfecha:Fecha::1\')" ><br \>';
				break;
			case 2:
				$frmsubmit= '<input type="button" name="Submit" value="Enviar" OnClick="checkForm(\'frm_planaccion\', \'txtreprogramado:Motivo::5\')" ><br \>';
				break;
			case 3:
				$frmsubmit= '<input type="button" name="Submit" value="Enviar" OnClick="checkForm(\'frm_planaccion\', \'resultado:Resultado::1\')" ><br \>';
				break;
	     }
		return $frmsubmit;

	}

# echo '<br \> <a href="logout.php">Logout</a> | <a href="listpa.php">ver PA</a><br \>';
# echo $_SESSION['username'] . '-'.$_SESSION['id'].' op= '.$_SESSION['op']; 


?>

<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>FRM Plan de accion</title>
	 <script type="text/javascript" src="js/calendar.js"></script>
	 <script type="text/javascript" src="js/checkform.js"></script>

    <link type="text/css" rel="stylesheet" href="css/calendar.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
 

  </head>
  <body>

<script>
function OpenWin() {
	var OpenWin = window.open("uploadpa.php?id=<?php echo $_GET['edit']; ?>", "MsgWindow", "width=430, height=400");
//    myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
}
function closeWin() {
	    OpenWin.close();   // Closes the new window
	    }
</script>
    <?php echo $menu; ?>
<div id="container">

<?php echo $obj_form; ?>
    <br />
</div>
  </body>
</html>
