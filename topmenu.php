<?php

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
		$menu.= "<span id=\"UrlMenu\"><i class=\"fa fa-home fa-2x fa-fw\"></i><a href=\"listpa.php\">Inicio</a></span>\n";
		$menu.= "<span id=\"UrlHome\" class=\"urlmenu\"><a href=\"dashboard.php\"> Dashboard <i class=\"fa fa-dashboard fa-2x fa-fw\"></i></a></span>\n";
		$menu.= "<span id=\"UrlLista\" class=\"urlmenu\"><i class=\"fa fa-search fa-2x fa-fw\"></i><a href=\"consulta.php\"> Consulta</a></span>\n";
		$menu.= "<span id=\"UrlNew\" class=\"urlmenu\"><i class=\"fa fa-edit fa-2x fa-fw\"></i><a href=\"pa.php?new\"> Nuevo </a></span>\n";
	#	$menu.= "<span id=\"UrlCal\" class=\"urlmenu\"><i class=\"fa fa-calendar fa-2x fa-fw\"></i><a href=\"calendar.php\"> Calendario</a></span>\n";
		$menu.= "<span id=\"UrlLogOut\" class=\"urlmenu\"><i class=\"fa fa-power-off fa-fw fa-2x\"></i><a href=\"logout.php\"> Salir</a></span>\n";
	$menu.= "</div>\n";


	}
	else {
		$menu='';
		$menu.= "<div id=\"topline\"><span>".$fecha."</span></div>\n";
		$menu.= "<div id=\"appline\">\n\t";
		$menu.= "<span id=\"appname\" class=\"appname\">".PA_APPNAME." ::</span><span id=\"appdesc\" class=\"appdesc\"> ".PA_APPDESC."</span>\n";
		$menu.= "<span id=\"bienvenido\" class=\"bienvenido\"><em>Bienvenido </em><strong>".$_SESSION['username']."</strong><i class=\"fa fa-user fa-fw\"></i></span>\n";
		$menu.= "</div>\n";
		$menu.= "<div id=\"menuline\">\n\t";
		$menu.= "<span id=\"UrlMenu\"><i class=\"fa fa-home fa-2x fa-fw\"></i> Inicio </span>\n";
		$menu.= "<span id=\"UrlLista\" class=\"urlmenu\"><i class=\"fa fa-list fa-2x fa-fw\"></i><a href=\"".PA_WEBLISTPA."\"> Lista </a></span>\n";
	#	$menu.= "<span id=\"UrlCal\" class=\"urlmenu\"><i class=\"fa fa-calendar fa-2x fa-fw\"></i><a href=\"calendar.php\"> Calendario </a></span>\n";
		$menu.= "<span id=\"UrlLogOut\" class=\"urlmenu\"><i class=\"fa fa-power-off fa-fw fa-2x\"></i><a href=\"logout.php\"> Salir </a></span>\n";
	$menu.= "</div>\n";
	}
		$separador =" / ";
		$menudesc ='';
		$menudesc.= "<div id=\"DescMenu\">\n";
		$menudesc.= "<span id=\"DescMenu-appname\">".PA_APPNAME."</span><span class=\"menu-separador\">".$separador."</span><span id=\"DescMenu-apppage\">".$APPPAGE."</span><span class=\"menu-separador\">".$separador."</span><span id=\"DescMenu-appdesc\">".$APPDESC."</span>\n\t";
		$menudesc.= "</div>\n";

?>
