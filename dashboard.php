<?php	

	/* ******************* Config.inc.php **********************/

	define ('PA_APPNAME','WPA');
	define ('PA_APPDESCRIPTION','Plan de Correcciones, Acciones Correctivas y Preventivas');
	define ('PA_APPVERSION','0.0.1');


	define ('PA_WEBDENEGADO','login.php');
	define ('PA_WEBLOGIN','login.php');
	define ('PA_WEBLOGOUT','logout.php');
	define ('PA_WEBCHECKLOGIN','checklogin.php');
	define ('PA_WEBLISTPA','consulta.php');
	define ('PA_WEBPA','pa.php');
	define ('PA_WEBVIEWPA','viewpa.php');
	define ('PA_WEBINICIO','listpa.php');

	/******************************* session.php *****************************/

#  include ('config.inc.php');

	session_start();
	if (!isset($_SESSION['id'])) {
		header ('Location: '.PA_WEBDENEGADO); 
	}




	$APPPAGE = 'DASHBOARD';
	$APPDESC = 'Pagina de Inicio';

	/* ******************************** topmenu.php ******************************/

#	define ('PA_APPNAME','WPA');
	define ('PA_APPDESC','Plan de Correcciones, Acciones Correctivas y Preventivas');

	$fecha = date('D M Y');
	
	if ($_SESSION['op'] == 1) {
	
		$menu='';
		$menu.= "<div id=\"topline\"><span>".$fecha."</span></div>\n";
		$menu.= "<div id=\"appline\">\n\t";
		$menu.= "<span id=\"appname\" class=\"appname\">".PA_APPNAME." ::</span><span id=\"appdesc\" class=\"appdesc\"> ".PA_APPDESC."</span>\n";
		$menu.= "<span id=\"bienvenido\" class=\"bienvenido\"><em>Bienvenido </em><strong>".$_SESSION['username']."</strong><i class=\"fa fa-user fa-fw\"></i></span>\n";
		$menu.= "</div>\n";
		$menu.= "<div id=\"menuline\">\n\t";
		$menu.= "<span id=\"UrlMenu\"><i class=\"fa fa-home fa-2x fa-fw\"></i><a href=\"listpa.php\"> Inicio</a></span>\n";
		$menu.= "<span id=\"UrlHome\" class=\"urlmenu\"><a href=\"dashboard.php\"> Dashboard <i class=\"fa fa-dashboard fa-2x fa-fw\"></i></a></span>\n";
		$menu.= "<span id=\"UrlLista\" class=\"urlmenu\"><i class=\"fa fa-search fa-2x fa-fw\"></i><a href=\"consulta.php\"> Consulta</a></span>\n";
		$menu.= "<span id=\"UrlNew\" class=\"urlmenu\"><i class=\"fa fa-edit fa-2x fa-fw\"></i><a href=\"pa.php?new\"> Nueva</a></span>\n";
		$menu.= "<span id=\"UrlCal\" class=\"urlmenu\"><i class=\"fa fa-calendar fa-2x fa-fw\"></i><a href=\"calendar.php\"> Calendario</a></span>\n";
		$menu.= "<span id=\"UrlLogOut\" class=\"urlmenu\"><i class=\"fa fa-power-off fa-fw fa-2x\"></i><a href=\"logout.php\"> Salir</a></span>\n";
	$menu.= "</div>\n";

	}
	else {
		$menu='';
		$menu.= "<div id=\"topline\"><span>".$fecha."</span></div>\n";
		$menu.= "<div id=\"appline\">\n\t";
		$menu.= "<span id=\"appname\" class=\"appname\">".PA_APPNAME." ::</span><span id=\"appdesc\" class=\"appdesc\"> ".PA_APPDESC."</span>\n";
		$menu.= "<span id=\"bienvenido\" class=\"bienvenido\"><em>Bienvenido </em><strong>".$_SESSION['username']."</strong></span>\n";
		$menu.= "</div>\n";
		$menu.= "<div id=\"menuline\">\n\t";
		$menu.= "<span id=\"UrlMenu\">####</span>\n";
		#$menu.= "<span id=\"UrlHome\" class=\"urlmenu\"><a href=\"#\">home</a></span>\n";
		$menu.= "<span id=\"UrlLista\" class=\"urlmenu\"><a href=\"listpa.php\">Lista PA</a></span>\n";
		#$menu.= "<span id=\"UrlNew\" class=\"urlmenu\"><a href=\"pa.php?new\">Nueva PA</a></span>\n";
		$menu.= "<span id=\"UrlCal\" class=\"urlmenu\"><a href=\"calendar.php\">Calendario</a></span>\n";
		$menu.= "<span id=\"UrlLogOut\" class=\"urlmenu\"><a href=\"logout.php\">Salir</a></span>\n";
	$menu.= "</div>\n";

	}
		$separador =" / ";
		$menudesc ='';
		$menudesc.= "<div id=\"DescMenu\">\n";
		$menudesc.= "<span id=\"DescMenu-appname\">".PA_APPNAME."</span><span class=\"menu-separador\">".$separador."</span><span id=\"DescMenu-apppage\">".$APPPAGE."</span><span class=\"menu-separador\">".$separador."</span><span id=\"DescMenu-appdesc\">".$APPDESC."</span>\n\t";
		$menudesc.= "</div>\n";



	/* ************************ meta.php ***************************/ 

	$htmltag = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML+RDFa 1.0//EN\" \"http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd\">";

	$metatag = "<meta charset=\"UTF-8\"> \n\t<meta name=\"description\" content=\" Web Plan de Accion\">\n\t<meta name=\"keywords\" content=\"ISO, certificacion, lider,division automotriz,iav, imperio, nissan\"> \n\t<meta name=\"author\" content=\"Luis Antonio Abrego Sanchez, sistemas.iav at grupoautofin dot com, labrego at gmail dot com\">\n\t<meta name=\"application-name\" content=\"WPA - Web Plan de Accion\">\n";

	$css = "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/showpa.css\">\n<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css\">";


	

	$footer = "<div id=\"footer\">\n\t<p> copyleft &copy;2014 Depto Sistemas - <a href=\"http://10.7.18.5\">Imperio Automotriz de Veracruz </a></p>\n</div>";


@require("tools/xajax/xajax_core/xajax.inc.php");
#include ('config.inc.php');
#include ('session.inc.php');
#include ('topmenu.php');
include ('class.db.php');

	$xajax = new xajax();
		$xajax->configure('debug', False);
		$xajax->configure('Javascript URI', '../');


	/* ******************* Declaracion de Funciones ************************ */
/*		function FN_CSSxStatus($status){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$cssOutPut=" ";
				$cssOutPut.=$dataquery->DB_GET_CSS_XSTATUS($status);
				#$htmlOutPut.="</div> \n";
				#$objResponse = new xajaxResponse();
				#$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
				#return $objResponse;
				return $cssOutPut;
		}
 */
		function FN_BuscaxStatus($status){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$htmlOutPut="<div id=\"ShowXStatus\">\n\t";
				$htmlOutPut.=$dataquery->DB_GET_LIST_XSTATUS($status);
				$htmlOutPut.="</div> \n";
				$objResponse = new xajaxResponse();
				$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
			return $objResponse;
		}

		function FN_BuscaxTipo($tipo){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$htmlOutPut="<div id=\"ShowXStatus\">\n\t";
				$htmlOutPut.=$dataquery->DB_GET_LIST_XSOL($tipo);
				$htmlOutPut.="</div> \n";
				$objResponse = new xajaxResponse();
				$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
			return $objResponse;
		}

		function FN_BuscaVencido(){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$htmlOutPut="<div id=\"ShowXStatus\">\n\t";
				$htmlOutPut.=$dataquery->DB_GET_LIST_VENCIDO();
				$htmlOutPut.="</div> \n";
				$objResponse = new xajaxResponse();
				$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
			return $objResponse;
		}

		function FN_BuscaXVencer(){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$htmlOutPut="<div id=\"ShowXStatus\">\n\t";
				$htmlOutPut.=$dataquery->DB_GET_LIST_XVENCER();
				$htmlOutPut.="</div> \n";
				$objResponse = new xajaxResponse();
				$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
			return $objResponse;
		}

		function FN_BuscaReprogramados(){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$htmlOutPut="<div id=\"ShowXStatus\">\n\t";
				$htmlOutPut.=$dataquery->DB_GET_LIST_REPROGRAMADOS();
				$htmlOutPut.="</div> \n";
				$objResponse = new xajaxResponse();
				$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
			return $objResponse;
		}
		function FN_BuscaReprogramadosVencidos(){
			
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
			
				$htmlOutPut="<div id=\"ShowXStatus\">\n\t";
				$htmlOutPut.=$dataquery->DB_GET_LIST_REPROGRAMADOS_();
				$htmlOutPut.="</div> \n";
				$objResponse = new xajaxResponse();
				$objResponse->assign('ShowElementX', 'innerHTML', $htmlOutPut);
		
			return $objResponse;
		}

		function FN_RegistroTotal($status){
	
			$dataquery = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);
				#$sql = "SELECT pa_statusgral FROM TBL_paccion WHERE pa_statusgral != '".$status."'";
				$numtot = $dataquery->DB_GET_NUMTOT_XSTATUS($status);
			return $numtot;
		}
				


		$XFN_BuscaxStatus =& $xajax->registerFunction("FN_BuscaxStatus");
		$XFN_BuscaxTipo =& $xajax->registerFunction("FN_BuscaxTipo");
		$XFN_BuscaVencido =& $xajax->registerFunction("FN_BuscaVencido");
		$XFN_BuscaXVencer =& $xajax->registerFunction("FN_BuscaXVencer");
		$XFN_BuscarReprogramados =& $xajax->registerFunction("FN_BuscaReprogramados");
		$XFN_BuscarReprogramadosVencidos =& $xajax->registerFunction("FN_BuscaReprogramadosVencidos");

#		$XFN_RegistroTotal =& $xajax->registerfunction("FN_RegistroTotal");

#	$XFN_BuscaxStatus->setParameter(0,XAJAX_JS_VALUE,1);


	$xajax->processRequest();
/*
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; */ 
	echo $htmltag."\n";

?>

<!------------------ HTML ------------------>

<HTML>
   <HEAD>
	<title>- WPA - </title>	
<?php	

	echo $metatag."\n";
	echo $css."\n";
	
	$xajax->printJavascript('tools/xajax/'); ?>

	<script>
		function textResponse(objRequest){
			xajax.$('ShowElementX').innerHTML = objRequest.Request.responseText;
			xajax.completeResponse(objRequest);
		}
		function xmlResponse(objRequest){
			alert(objRequest.Request.responseXML.documentElement.nodeName);
			xajax.$('ShowElementX').innerHTML = 'non ajax: XML Response';
			xajax.comlpeteResponse(objRequest);
		}
	</script>
	<script type='text/javascript' src='js/loader.js'></script>
<?php 
	/* ****************** Declaración de Variables para las graficas ****************** */
	
	$ncm = $dataset->DB_GET_NUMTOT_XCRITERIO('NC-'); 	//@char No Conformidad Menor
	$ncM = $dataset->DB_GET_NUMTOT_XCRITERIO('NC+'); 	//@char No Conformidad Mayor
	$ob = $dataset->DB_GET_NUMTOT_XCRITERIO('OB'); 		//@char Observacion
	$na = $dataset->DB_GET_NUMTOT_XCRITERIO('NA'); 		//@char No Aplica
	$ci = $dataset->DB_GET_NUMTOT_XTIPOSOLUCION('CI'); 	//@char Correccion Inmediata
	$ac = $dataset->DB_GET_NUMTOT_XTIPOSOLUCION('AC'); 	//@char Accion Correctiva 
	$ap = $dataset->DB_GET_NUMTOT_XTIPOSOLUCION('AP'); 	//@char Accion Preventiva 
	$totvencidos = $dataset->DB_GET_NUMTOT_VENCIDO(); 	//@Int Número total de PA Vencidos 
	$totxvencer = $dataset->DB_GET_NUMTOT_XVENCER(); 	//@Int Número total de PA por Vencer 
	$tot = $dataset->DB_GET_NUMTOT_PA(); 			//@Int Número total de PA 	
	$abierta = $dataset->DB_GET_NUMTOT_XSTATUSsn(1); 	//@Int Número total de PA con status 1 = ABIERTA 
	$proceso = $dataset->DB_GET_NUMTOT_XSTATUSsn(0); 	//@Int Número total de PA con status 0 = PROCESO
	$reprog = $dataset->DB_GET_NUMTOT_XSTATUSsn(3); 	//@Int Número total de PA con status 3 = REPROGRAMADO
	$cerrada = $dataset->DB_GET_NUMTOT_XSTATUSsn(2); 	//@Int Número total de PA con status 2 = CERRADA
	$eficaz = $dataset->DB_GET_NUMTOT_XEFICACIA('E'); 	//@Int Número total de PA EFICAZ 
	$neficaz = $dataset->DB_GET_NUMTOT_XEFICACIA('NE'); 	//@Int Número total de PA NO EFICAZ
	$nul = ($tot - ($ap + $ac + $ci));	
	$jscript=' ';

	# google.charts.load("current", {packages:["corechart"]}); se modificó esta linea por problemas con la api de google

	$jscript.='<script type=\'text/javascript\'>
		google.charts.load("44", {packages:["corechart"]});

		google.charts.setOnLoadCallback(drawChart);
		google.charts.setOnLoadCallback(drawChart2);
		google.charts.setOnLoadCallback(drawChart3);
		google.charts.setOnLoadCallback(drawChart4);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				[\'Tipo\', \'Numero total\'],
				[\'NC-\','. $ncm .'],
				[\'NC+\','. $ncM .'],
			        [\'OB\','. $ob .'],
				[\'NA\','. $na .']
				]);
			var options = {
				title: \'Por Tipo\',
					pieHole: 0.4,
			};

			var chart = new google.visualization.PieChart(document.getElementById(\'donutchart\'));
			chart.draw(data, options);
		}
			function drawChart2() {
			var data = google.visualization.arrayToDataTable([
				[\'solucion\', \'Numero total\'],
				[\'CI\','. $ci .'],
			        [\'AC\','. $ac .'],
				[\'AP\','. $ap .'],
				[\'S/A\','. $nul .']
				]);
			var options = {
				title: \'Por Solución\',
					pieHole: 0.4,
			};

			var chart = new google.visualization.PieChart(document.getElementById(\'donutchart2\'));
			chart.draw(data, options);
		}
			function drawChart3() {
			var data = google.visualization.arrayToDataTable([
				[\'status\', \'Numero total\'],
				[\'Abierta\','. $abierta .'],
			        [\'Proceso\','. $proceso .'],
				[\'Reprog\','. $reprog .'],
				[\'Cerrada\','. $cerrada .']
				]);
			var options = {
				title: \'Por Status\',
					pieHole: 0.4,
			};

			var chart = new google.visualization.PieChart(document.getElementById(\'donutchart3\'));
			chart.draw(data, options);
		}

		function drawChart4() {
			var data = google.visualization.arrayToDataTable([
				[\'Eficacia\', \'Numero total\'],
				[\'Eficaz\','. $eficaz .'],
			        [\'No Eficaz\','. $neficaz .']
				]);
			var options = {
				title: \'Por Eficacia\',
					pieHole: 0.4,
			};

			var chart = new google.visualization.PieChart(document.getElementById(\'donutchart4\'));
			chart.draw(data, options);
		}

		</script>';
     echo $jscript;
?>
  </HEAD>
<BODY>
	<?php echo $menu."\n".$menudesc."\n"; ?>
<?php if ($totxvencer <> 0) { ?>
<!-- Div Cuadro de Advertencia Por Vencer -->
	<div class="Dash_WarningMenuV" style="top:100px; z-index:899;">
	<ul class="Dash_WarningUL">
		<li id="Dash_WarningBox"> - <?php echo $totxvencer; ?> - Por Vencer</li>
	</ul>
	</div>

<!-- /Div Cuadro de Advertencia Por Vencer -->
<? } ?>

<?php if ($totvencidos <> 0) { ?>
<!-- Div Cuadro de Advertencia de Vencimientos -->
	<div class="Dash_WarningMenu" style="top:100px; z-index:900;">
	<ul class="Dash_WarningUL">
		<li id="Dash_WarningBox"> - <?php echo $totvencidos; ?> - Vencidos</li>
	</ul>
	</div>

<!-- /Div Cuadro de Advertencia de vencimientos -->
<? } ?>
		<h4>Total de Registros Abiertos: <?php echo FN_RegistroTotal(2); /* donde 2 = status cerrado */ ?></h4>
	<div id="graficas" style="display: inline-flex;">
	<span id="donutchart" style="width: 256px; height: 150px;"></span>
	<span id="donutchart2" style="width: 256px; height: 150px;"></span>
	<span id="donutchart3" style="width: 256px; height: 150px;"></span>
	<span id="donutchart4" style="width: 256px; height: 150px;"></span>
</div>
	<hr />
	<div id="Dash_Criterios" style="display: flex;">
	<fieldset>
		<legend> Status </legend>
		<input type="radio" name="bquery" value="1" onclick='xajax_FN_BuscaxStatus(this.value);'>Sin Aceptar<input type="radio" name="bquery" value="0" onclick='xajax_FN_BuscaxStatus(this.value);'>En Proceso  <input type="radio" name="bquery" value="3"  onclick='xajax_FN_BuscaxStatus(this.value);'>Reprogramado
	</fieldset>
	<fieldset>
		<legend>Tipo de Solución</legend>
			<input type="radio" name="btsol" value="AC" onclick='xajax_FN_BuscaxTipo(this.value);'>Acc Correctiva  <input type="radio" name="btsol" value="AP" onclick='xajax_FN_BuscaxTipo(this.value);'>Acc Preventiva  <input type="radio" name="btsol" value="CI" onclick='xajax_FN_BuscaxTipo(this.value);'>Correcc Inmediata  
	</fieldset>
	<fieldset>
		<legend>Vencimientos</legend>
			<input type="radio" name="btven" value="vencido" onclick='xajax_FN_BuscaVencido();'>Vencidos  <input type="radio" name="btven" value="xvencer" onclick='xajax_FN_BuscaXVencer();'>Por Vencer  <input type="radio" name="btven" value="rerpogramado" onclick='xajax_FN_BuscaReprogramadosVencidos();'>Reprogramados  
	</fieldset>
</div>
	<div id="Container_ShowElementX">
		<div id="ShowElementX"></div>
	</div>
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
<?php /*
<a href="#" onclick="show('popup1')">popup</a>
	<div class="popup" id="popup1"> <a href="#" onclick="hide('popup1')">cerrar</a></div>
 */ ?>
 
<?php echo $footer; ?>

</BODY>
</HTML>
