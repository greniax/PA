<?php
/**
* Modulo de Base de Datos
* @file class.db.php
* @author Luis Antonio Abrego Sanchez
* @email labrego at gmail dot com
* @content modulo de base de datos
*	para la aplicacion de Plandes de accion
*	para seguimiento de las  diferentes
*	auditorias
* @date 16/jun/2014
* @version 0.1.1
**/
################################################

################################################
### SE DEFINEN LAS CONSTANTES
################################################

define('DB_PA_HOST','localhost');
define('DB_PA_DATABASE',''); //database name
define('DB_PA_USERNAME',''); //database user
define('DB_PA_PASSWD',''); // database passwd
define('DB_PA_TABLE',''); // data Table

################################################
### INICIA LA CLASE PARA LA BASE DE DATOS
################################################

# Linea 	Funcion		Descripción
# 37		construct	construye la clase
# 45		SIMPLE_QUERY	un simple query a la db
# 52		DB_LIST		genera tabla html, lista dado un sql
# 85		DB_NEWPA	Crea un nuevo PA


	CLASS DBIAV {

		var $DB, $CONN; 
		var $RES; 

		public function __construct($servidor,$database,$dbuser,$dbpasswd){
				$this->CONN = mysql_connect($servidor,$dbuser,$dbpasswd);
				$this->DB = mysql_select_db($database,$this->CONN);
			}

		public function SIMPLE_QUERY ($tabla) {
				$sql = "SELECT * FROM $tabla";
				$result = $this->DB_SQLORDIE($sql);
				return mysql_fetch_array($result);
			}

		public function DB_GetNumRows($sql) {
	      		$result = mysql_query($sql);
			$rowcount = mysql_num_rows($result);
		
			return $rowcount;
		}

		public function DB_RunQuery($sql) {
			$result = mysql_query($sql);
			while ($row= mysql_fetch_assoc($result)) {		
				$set[] = $row;
			}
			if (!empty($set)) 
				return $set;
		}

		public function DB_LIST($sql) {
				$res ='';
				$c = 0;	
				$result = $this->DB_SQLORDIE($sql);
				if (!mysql_num_rows($result)<= 0) {

				$res .='<table cellspacing="0">';
				$res .='<thead><tr><td>Cliente</td><td>OC</td><td>Folio</td><td>Documento</td><td>Fecha Documento</td><td>RFC</td><td>Fecha Carga</td><td></td></tr></thead><tbody>';
				while ($row = mysql_fetch_assoc($result)){
					$vcliente = $row['idcliente'];
					$vocompra = $row['idordencompra'];
					$vxml = $row['ruta_documento'];
					$vpdf = substr_replace($vxml,'pdf',-3,3);
					$res .= '<tr class="'.$this->GetBGColor($c).'">';
					$res .= '<td>'.$row['idcliente'].'</td>';
					$res .= '<td>'.$row['idordencompra'].'</td>';
					$res .= '<td>'.$row['folio'].'</td>';
					$doc = $row['documento'];
					$res .= '<td>'.'<a href="#?'.$row['documento'].'">'. substr(strrchr($doc,"_"),1).'</a></td>';
					$res .= '<td>'.$row['fecha_documento'].'</td>';
					$res .= '<td>'.$row['rfc_proveedor'].'</td>';
					$res .= '<td>'.$row['fecha_carga'].'</td>';
					$res .= '<td><a href="acuse.php?idcliente='.$vcliente.'&OC='.$vocompra.'&xml='.$vxml.'"><img border="0" width="16" height="16" src="img/file.png" alt="Acuse de Carga"></a> <a href="'.$vxml.'"><img border="0" width="16" height="16" src="img/xml.ico" alt="XML"></a> <a href="'.$vpdf.'"><img border="0" width="16" height="16" src="img/pdf.ico" alt="PDF"></a></td>';
					$res .= '</tr>';
					$c++;
				}
				$res .='</tbody></table>';
					}
				else { $res .= '<h2>No se econtraron registros</h2>'; }

				return $res;
		}

		public function DB_GETUSERID ($username) {
			$iduser ='';
			$sql = "Select usr_uuid, usr_usuario FROM TBL_Usuarios LEFT JOIN TBL_paccion ON (TBL_Usuarios.usr_uuid = TBL_paccion.pa_asignado) WHERE TBL_Usuarios.usr_usuario = '".$username."'";
				$res= $this->DB_SQLORDIE($sql);
				$row= mysql_fetch_assoc($res);
				if (!mysql_num_rows($res) <=0) {
					$iduser = $row['usr_uuid'];
				}
				return $iduser;
		}

		public function DB_GetFieldByPAID($id,$field) { //Obtiene el valor del campo en la DB dado el ID como parametro

			$sql ="SELECT * FROM TBL_paccion WHERE pa_id = ".$id;
				$res=$this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($res);
				if (!mysql_num_rows($res) <=0) {
					$fieldvalue = $row[$field];
				}
				return $fieldvalue;
		}


		public function DB_CALGETUSER ($sql) {
				$res = $this->DB_SQLORDIE($sql);
				return $res;
		}

		public function DB_NEWPA ($sql) {

				$res = $this->DB_SQLORDIE($sql);
				return $res;
		}

		public function DB_EDITPA ($sql) {
				$res = $this->DB_SQLORDIE($sql);
				return $res;
		}

		public function DB_REPROGPA($sql) {
				$res= $this->DB_SQLORDIE($sql);
				return $res;
		}
		
		public function DB_CIERRAPA($sql) {
				$res= $this->DB_SQLORDIE($sql);
				return $res;
		}
		
		public function DB_ELIMINAPA($sql) {
				$res= $this->DB_SQLORDIE($sql);
				return $res;
		}

		public function DB_LogIn($username,$passwd){
				
				$sql = 'SELECT usr_usuario, usr_passwd, usr_operador FROM TBL_Usuarios WHERE usr_usuario="'.$username.'" AND usr_passwd="'.$passwd.'" LIMIT 1';
				$res = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($res);
				#$res = mysql_query($sql,$this->CONN);
				if (!mysql_num_rows($res)<=0) {
					return $row['usr_operador'];
				}
				else {
					return null;
				}
		}

		public function DB_GetOrigen($ref) {
			$sql = "SELECT * from TBL_origen WHERE activo = 1 AND id = ".$ref;
				$res = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($res);
				if (!mysql_num_rows($res)<=0) {
					return $row['clave'];
				}
				else {
					return null;
				}
		}
		
		public function DB_GetClaveOrigen($ref) {
			$sql = "SELECT * from TBL_origen WHERE activo = 1 AND id = ".$ref;
				$res = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($res);
				if (!mysql_num_rows($res)<=0) {
					return $row['origen'];
				}
				else {
					return null;
				}
		}
		public function DB_FillOrigen($sql,$selectname) {
		
			$select = '<select name="'.$selectname.'">';
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result)<=0) {
					$res = $select;
					while ($row = mysql_fetch_assoc($result)) {
						$res.= '<option value="'.$row['id'].'">'.$row['origen'].'</option>';
					}
					$res.='</select><br \>';
				}
				return $res;	
		}
		public function DB_FillOrigenSearch($sql,$selectname,$action = null, $u = null) {
			if($action != null){
				$select = '<select name="'.$selectname.'" '.$action .' >';}
			else{
				$select = '<select name="'.$selectname.'">';
				}

				$select .='<option value=" ">-- Origen --</option>';	
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result)<=0) {
					$res = $select;
					while ($row = mysql_fetch_assoc($result)) {
						if($action != null AND $u != null) {
							$res.= '<option value="?u='.$u.'&qry=2&origen='.$row['id'].'">'.$row['origen'].'</option>';}
						else {
							$res.= '<option value="?qry=2&origen='.$row['id'].'">'.$row['origen'].'</option>';}

					#else {
	 				#    $res.= '<option value="'.$row['id'].'">'.$row['origen'].'</option>';}
					}
					$res.='</select><br \>';
				}
				return $res;	
		}

		public function DB_FillStatusSearch($sql,$selectname,$action = null,$u) {
			if($action != null){
				$select = '<select name="'.$selectname.'" '.$action .' ><option value="0">-- Status --</option>';}
			else{
			
			$select = '<select name="'.$selectname.'"><option value="0">-- Status --</option>';}
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result)<=0) {
					$res = $select;
					Do{
					    if($action != null AND $u != null){
						    $res.= '<option value="?u='.$u.'&qry=3&status='.$row['pa_statusgral'].'">'.$row['pa_status'].'</option>';}
					 else {
	 					    $res.= '<option value="?qry=3&status='.$row['pa_statusgral'].'">'.$row['pa_status'].'</option>';}
					} while ($row = mysql_fetch_assoc($result));
					$res.='</select><br \>';
				}
				return $res;	
		}

		public function DB_FillCriterioSearch($sql,$selectname,$action = null,$u) {
			if($action != null){
				$select = '<select name="'.$selectname.'" '.$action .' ><option value="0">-- Criterios --</option>';}
			else{
			
			$select = '<select name="'.$selectname.'"><option value="0">-- Criterios --</option>';}
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result)<=0) {
					$res = $select;
					Do {
					    if($action != null AND $u != null){
						    $res.= '<option value="?u='.$u.'&qry=4&criterio=\''.$row['pa_criterio'].'\'">'.$row['pa_criterio'].'</option>';}
					 else {
	 					    $res.= '<option value="?qry=4&criterio=\''.$row['pa_criterio'].'\'">'.$row['pa_criterio'].'</option>';}
					} while ($row = mysql_fetch_assoc($result)); 
					$res.='</select><br \>';
				}
				return $res;	
		}

		public function DB_FillUsernameSearch($sql,$selectname,$action = null,$selected=null,$numrows=null) {
			
		#if (!empty($numrows)) {
				$numrowsql = "SELECT pa_id FROM TBL_paccion WHERE pa_statusgral <> 2 AND pa_asignado = ";
		#	$totnumrow = $this->DB_GetNumRows($numrowsql);
		#}
		 
			if($action != null){
				$select = '<select name="'.$selectname.'" '.$action .' ><option value="'.$_SERVER['PHP_SELF'].'">-- Usuarios --</option>';}
			else{
			
			$select = '<select name="'.$selectname.'"><option value="'.$_SERVER['PHP_SELF'].'">-- Usuarios --</option>';}
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result)<=0) {
					$res = $select;
					Do {
					    if($action != null){
						    if ($row['usr_uuid'] == $selected){
							    $res.= '<option value="?u='.$row['usr_uuid'].'" selected>'.$row['usr_nombre'].' '.$row['usr_paterno'].' -['.$totnumrow = $this->DB_GetNumRows($numrowsql.$row['usr_uuid']).']-</option>';}
						    else{		 
							  $res.= '<option value="?u='.$row['usr_uuid'].'">'.$row['usr_nombre'].' '.$row['usr_paterno'].' -['.$totnumrow = $this->DB_GetNumRows($numrowsql.$row['usr_uuid']).']-</option>';}
					    }
						    #$res.= '<option value="?u='.$row['usr_uuid'].'">'.$row['usr_nombre'].' '.$row['usr_paterno'].'</option>';}
					 else {
	 					    $res.= '<option value="'.$row['usr_uuid'].'">'.$row['usr_nombre'].' '.$row['usr_paterno'].'</option>';}
					} while ($row = mysql_fetch_assoc($result)); 
					$res.='</select><br \>';
				}
				return $res;	
		}

		public function DB_FillSelect($sql,$selectname) {
				$select = '<select name="'.$selectname.'">';
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result)<=0) {
					$res = $select;
					while ($row = mysql_fetch_assoc($result)) {
						$res.= '<option value="'.$row['usr_uuid'].'">'.$row['usr_puesto'].'</option>';
					}
					$res.='</select><br \>';
				}
				return $res;	
		}

		public function ShowListOP($sql,$op) {
				$res= '';
				$result =$this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result) <= 0){
					do {
						$res.="<div id=\"container_issue\">\n\t<table class=\"issue-table\">\n\t<tbody>\n\t<tr><td>\n";
						$res.="<div class=\"issue-message\">".$row['pa_noconformidad']."</div></td>\n\t<td class=\"issue_top_right\"><ul class=\"list-inline\">\n\t<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$row['pa_creado']."</span></li>\n<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$row['pa_id']."</span></li>\n<li class=\"issue-meta\"><span class=\"issue-meta-label\"> Mail</span></li></ul>\n</td>\n</tr>";
						$res.="\n<tr><td>\n<div class=\"issue_bottom\">\n\t<ul class=\"list-inline\">\n\t";
						$res="<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$row['pa_criterio']."</span></li>\n<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$row['pa_status']."</span></li>\n<li class=\"issue-meta\"><span class=\"issue-meta-label\">".$row['usr_nombre']." ".$row['usr_paterno']." </span></li>\n<li class=\"issue-meta\"><span class=\"issue-meta-label\"> FC: ". date_format(date_create($row['pa_fechacumplimiento']), 'Y-m-d')."</span></li>\n<li class=\"issue-meta\"><span class=\"issue-meta-label\"> FR:". date_format(date_create($row['pa_fechareprog']), 'Y-m-d')." </span></li>\n</ul>\n</div>\n</td>\n<td>\n";
						$res.="	<div class=\"isue_bottom_right\">Ver | Reprogramar | Cerrar | Eliminar</div></td>\n";
						$res.="</tr>\n</tbody>\n</table></div>\n</tbody>\n</table>\n</div>";
					} while ($row = mysql_fetch_assoc($result));
				}
			return $res;
		}

		public function DB_ListViewOpenPA($sql,$op) {
				$result= $this->DB_SQLORDIE($sql);
#				$row = mysql_fetch_assoc($result);
				$i= 0;
			       	$res='';
				if (!mysql_num_rows($result)<= 0){
					$res.= "<table cellspacing=\"0\">\n";
					$res .="<thead><tr><td>id</td><td>No Conformidad / Observaciones</td><td>Criterio</td><td>Audit</td><td>Creado</td><td>Cumplimiento</td><td>Cierre</td><td></td></thead><tbody>\n\t";
					while ($row = mysql_fetch_assoc($result)){
						$res.='<tr class="'.$this->GetBGColor($i).'">';
						
						$res.='<td>'.$row['pa_id'].'</td>';
						#$res.='<td class="centrado">'.$row['pa_norma'].'</td>';	
						#$res.='<td width="350px" class="justificado">'.$row['pa_comentarios'].'</td>';	
						$res.='<td width="350px" class="justificado">'.$row['pa_noconformidad'].'</td>';
						$res.='<td '.$this->GetCSSCriterio($row['pa_criterio']).'>'.$row['pa_criterio'].'</td>';
						$res.='<td '.$this->GetCSSAudit($row['pa_refauditoria']).'</td>';
					#	$res.='<td>'.$row['usr_nombre'].' '.$row['usr_paterno'].'</td>';
					#	$res.='<td>'.$row['pa_creado'].'</td>';
						$res.='<td>'. date_format(date_create($row['pa_creado']), 'Y-m-d').'</td>';
						$res.='<td>'.$row['pa_fechacumplimiento'].'</td>';
						$res.='<td>'.$row['pa_fechacierre'].'</td>';
					if ($op == 0) {
							$res.="<td>".$this->GetStatusGral($row['pa_statusgral'],$row['pa_id'],$op)."</td>\n";												}
						else {
							$res.="<td> | ver</td>\n";	
						}

						$i++;
					}
						
						$res.="</tbody></table>\n";
				}
				return $res;				
				
		}
		
		public function DB_OPViewPA($sql,$op) {  //Lista de PA para Operador
				$result= $this->DB_SQLORDIE($sql);
#				$row = mysql_fetch_assoc($result);
				$i= 0;
			       	$res='';
				if (!mysql_num_rows($result)<= 0){
					$res.= "<div id=\"tbl_list\"><table cellspacing=\"0\">\n";
					$res .="<thead><tr><td>id</td><td>No Conformidad / Observaciones</td><td>C</td><td>S</td><td>Asignado a:</td><td>Creado</td><td>Cumplimiento</td><td>Cerrado</td><td></td></tr></thead><tbody>\n\t";
					while ($row = mysql_fetch_assoc($result)){
						
						$res.='<tr '.$this->GetStyleStatusGral($row['pa_statusgral']) .'class="'.$this->GetBGColor($i).'">';
						$res.='<td '.$this->GetCSSid($row['pa_statusgral'],$row['pa_creado'],$row['pa_fechacumplimiento'],$row['pa_fechareprog']).$row['pa_id'].'</td>';


#						$res.='<td '.$this->GetCSSAudit($row['pa_refauditoria']).$row['pa_id'].'</td>';
					#	$res.='<td '.$this->GetCSSAudit($row['pa_refauditoria']).'</td>';	
						$res.='<td width="450px" class="justificado">'.$row['pa_noconformidad'].'</td>';
						$res.='<td '.$this->GetCSSCriterio($row['pa_criterio']).'>'.$row['pa_criterio'].'</td>';
					#	$res.='<td '.$this->GetCSSAudit($row['pa_refauditoria']).'</td>';
						$res.='<td '.$this->GetCSSStatus($row['pa_statusgral']).'</td>';
						$res.='<td width="120px">'.$row['usr_nombre'].' '.$row['usr_paterno'].'</td>';
						$res.='<td>'. date_format(date_create($row['pa_creado']), 'Y-m-d').'</td>';
						$res.='<td>'.$row['pa_fechacumplimiento'].'</td>';
						$res.='<td>'.$row['pa_fechacierre'].'</td>';
						$res.="<td>".$this->GetStatusGral($row['pa_statusgral'],$row['pa_id'],$op)." </td>\n";
						$i++;
					}
						
						$res.="</tbody></table></div>\n";
				}
				return $res;				
				
		}
	
		public function DB_ListFields($table) {
				$sql = "SHOW COLUMNS FROM ". $table;
				$result = $this->DB_SQLORDIE($sql);
				$row = mysql_fetch_assoc($result);
				if (!mysql_num_rows($result) <= 0){
					while ($row = mysql_fetch_assoc($result)){
						$res[] = $row['Field'];
					}
				}
				return $res;
		}
												
		public function DB_FieldName($array,$i){
			$fieldname = $array[$i];		
			return $fieldname;
		}

		public function DB_GETUSERNAME($uuid) {
			
			$fullname='';
			$sql = "SELECT * FROM TBL_Usuarios WHERE usr_uuid =".$uuid;
			$result = $this->DB_SQLORDIE($sql);
			if (!mysql_num_rows($result) <= 0) {
				while ($row = mysql_fetch_assoc($result)) {
					$fullname = $row['usr_nombre'].' '.$row['usr_paterno'].' '.$row['usr_materno'];
				}
			}
			return $fullname;
		}
	public function DB_GETEMAIL($uuid) {
			
			$email='';
			$sql = "SELECT usr_uuid, usr_email FROM TBL_Usuarios WHERE usr_uuid =".$uuid;
			$result = $this->DB_SQLORDIE($sql);
			if (!mysql_num_rows($result) <= 0) {
				while ($row = mysql_fetch_assoc($result)) {
					$email = $row['usr_email'];
				}
			}
			return $email;
		}

		public function DB_GETAUDIT($pa_refauditoria){ #********* Modificar funcion para considerar futuras referencias *************
			$str='';
			
			switch ($pa_refauditoria){
				case 0 :
				       	$str= 'Interna';
			 		break;
				case 1 :
					$str = 'Integral';
					break;
				case 2 :
					$str = 'Lider';
					break;
				case 3 :
					$str = 'ISO';
					break;
				case 4 :
					$str = "BSC";
					break;
			}
			return $str;
		}


		public function DB_ItemPA($id,$op){
			$item= array();
			$sql = "SELECT * FROM TBL_paccion WHERE pa_id = ".$id;
			$result = $this->DB_SQLORDIE($sql);
			if (!mysql_num_rows($result) <= 0){
				while ($row = mysql_fetch_assoc($result)){
					$item['id']= $row['pa_id'];	
					$item['norma']= $row['pa_norma'];	
					$item['comentarios']= $row['pa_comentarios'];
					$item['noconformidad']= $row['pa_noconformidad'];		
					$item['criterio']= $row['pa_criterio'];
					$item['causaraiz'] = $row['pa_causaraiz'];
					$item['tiposolucion'] = $row['pa_tiposol'];
					$item['descsolucion'] = $row['pa_descsol'];
					$item['responsables'] = $row['pa_responsables'];
					$item['fechacumplimiento'] = $row['pa_fechacumplimiento'];
					$item['status'] = $row['pa_status'];
					$item['reprogramado'] = $row['pa_reprogramado'];
					$item['fechareprog'] = $row['pa_fechareprog'];
$item['statusgral'] = $row['pa_statusgral'];
					$item['fechacierre'] = $row['pa_fechacierre'];
$item['eficacia'] = $row['pa_eficacia'];
					$item['resultado'] = $row['pa_resultado'];
					$item['creado']= $row['pa_creado'];
					$item['refauditoria']= $row['pa_refauditoria'];
					$item['asignado'] = $this->DB_GETUSERNAME($row['pa_asignado']);
#					$item['asignado']= $row['pa_asignado'];
					$item['op'] = $op;
				}
			
			}
		
			return $item;

		}

		public function DB_GETListAuditoria(){
			
		}

		public function DB_GETListResponsables(){		// MUESTRA LISTADO DE RESPONSABLES
			$option ='';
			$sql = "SELECT * FROM TBL_Usuarios";
			$result = $this->DB_SQLORDIE($sql);
			if (!mysql_num_rows($result) <= 0){
				while ($row = mysql_fetch_assoc($result)){
					$option .= "<option value=\"".$row['usr_puesto']."\">".$row['usr_puesto']."</option>\n";
				}
				$option.='<br />';
			}
			return $option;
		}

/*		public function DB_GET_LIST_REPROGRAMADOS (){		//MUESTRA LISTADO DE PA VENCIDOS
			
			$htmlOutPut ='';
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechacumplimiento FROM TBL_paccion WHERE pa_statusgral = '3'";
			$result = $this->DB_SQLORDIE($sql);
			$htmlOutPut ='<table>';
			 if(!mysql_num_rows($result) <= 0){
				while ($row = mysql_fetch_assoc($result)){
					$htmlOutPut.='<tr><td class="TabRepro">'.$row['pa_id'].' '.$row['pa_creado'].' '.$this->DB_GETUSERNAME($row['pa_asignado']).' '.$row['pa_status'].' '.$row['pa_fechacumplimiento']."</td></tr>\n";
				}
				$htmlOutPut.='</table>';
			 }
			 else {
				 $htmlOutPut = '<span> No se encontraron resultados</span>';
			 }
			 
			return $htmlOutPut;
} */

		public function DB_GET_LIST_REPROGRAMADOS (){		//MUESTRA LISTADO DE PA REPROGRAMADOS 
			
			$htmlOutPut ='';
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechacumplimiento FROM TBL_paccion WHERE pa_statusgral = '3'";
			$cssOutPut = '<style type="text/css">';
			$htmlOutPut .= '<table>';
			$result = $this->DB_SQLORDIE($sql);
			    if(!mysql_num_rows($result) <= 0){
				    while ($row = mysql_fetch_assoc($result)){
					$cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.7);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n";
					$htmlOutPut.='<tr><td class="TabRepro"><a href="#" onclick ="show(\'PA'.$row['pa_id'].'\')">'.$row['pa_id'].'</a> '.$row['pa_creado'].' '.$this->DB_GETUSERNAME($row['pa_asignado']).' '.$row['pa_status'].' '.$row['pa_fechacumplimiento']."</td></tr>\n<div class=\"popup\" id=\"PA".$row['pa_id']."\"><div id=\"header_showpa\"><a style=\"float:right\" href=\"#\" onclick=\"hide('PA".$row['pa_id']."')\"><i class=\"fa fa-times-circle fa-2x fa-fw\"></i></a><div id=\"id\">".$row['pa_id']."</div><div id=\"asignado\">".$this->DB_GETUSERNAME($row['pa_asignado'])." - ".$row['pa_status']."</div></div>".$this->DB_GET_HTML_SHOWPA($row['pa_id']) ."</div>";

				    }
				$cssOutPut.='</style>';    
				$htmlOutPut.='</table>';
			 }
			 else {
				$cssOutPut.= '</style>';
				 $htmlOutPut = '<span> No se encontraron resultados</span>';
			 }
	
			$htmlOutPut = ($cssOutPut ."\n". $htmlOutPut); 
			return $htmlOutPut;
		}


		public function DB_GET_LIST_REPROGRAMADOS_ (){		//MUESTRA LISTADO DE PA REPROGRAMADOS VENCIDOS
			$ahora = date('Y-m-d');
			$htmlOutPut = "<table id=\"ShowTableV\" cellspacing=\"0\"><thead><tr><td>id</td><td>Creado</td><td>Asignado a</td><td>Status</td><td>F. Cumplimiento</td><td>F. Reprogramacion</td></tr></thead>\n<tbody>";
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechacumplimiento, pa_fechareprog FROM TBL_paccion WHERE pa_statusgral = '3' AND pa_fechareprog < '".$ahora."'";
			$cssOutPut = '<style type="text/css">';
			$result = $this->DB_SQLORDIE($sql);
			    if(!mysql_num_rows($result) <= 0){
				    while ($row = mysql_fetch_assoc($result)){
					    if ($row['pa_fechareprog'] < $ahora) {
					$cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.7);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n";
					$htmlOutPut.='<tr><td><a href="#" onclick ="show(\'PA'.$row['pa_id'].'\')">'.$row['pa_id'].'</a></td><td> '.date_format(date_create($row['pa_creado']),'Y-m-d').'</td><td>'.$this->DB_GETUSERNAME($row['pa_asignado']).'</td><td>'.$row['pa_status'].'</td><td>'.$row['pa_fechacumplimiento']."</td><td>".$row['pa_fechareprog']."</td></tr>\n<div class=\"popup\" id=\"PA".$row['pa_id']."\"><div id=\"header_showpa\"><a style=\"float:right;\" href=\"#\" onclick=\"hide('PA".$row['pa_id']."')\"><i class=\"fa fa-time-close fa-2x fa-fw\"><i></a><div id=\"id\">".$row['pa_id']."</div><div id=\"asignado\">".$this->DB_GETUSERNAME($row['pa_asignado'])." - ".$row['pa_status']."</div></div>".$this->DB_GET_HTML_SHOWPA($row['pa_id']) ."</div>";
					    }
				    }
				$cssOutPut.='</style>';    
				$htmlOutPut.='</table>';
			 }
			 else {
				 $cssOutPut .='</style>';
				 $htmlOutPut .= '</tbody></table><span> No se encontraron resultados</span>';
			 }
	
			$htmlOutPut = ($cssOutPut ."\n". $htmlOutPut); 
			return $htmlOutPut;
		}

		public function DB_GET_LIST_VENCIDO (){		//MUESTRA LISTADO DE PA VENCIDOS
			$ahora = date("Y-m-d");
			$cssOutPut = '';
			$htmlOutPut = "<table id=\"ShowTableV\" cellspacing=\"0\"><thead><tr><td>id</td><td>Creado</td><td>Asignado a</td><td>Status</td><td>F. Cumplimiento</td><td>F. Reprogramacion</td></tr></thead>\n<tbody>";
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechacumplimiento, pa_fechareprog FROM TBL_paccion WHERE pa_statusgral = 0 AND pa_fechacumplimiento <= '".$ahora."'";
			$result = $this->DB_SQLORDIE($sql);
			$row = mysql_fetch_assoc($result);
			if (mysql_num_rows($result) == 0){
				$htmlOutPut .= '</tbody></table><span> No se encontraron resultados</span></table>';
				}
			else {
				$cssOutPut = '<style type="text/css">';
	  		  Do {					
				if($row['pa_fechareprog'] == NULL){
					$cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.7);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n";
				$htmlOutPut.='<tr><td><a href="#" onclick ="show(\'PA'.$row['pa_id'].'\')"> '.$row['pa_id'].'</a></td><td>'.date_format(date_create($row['pa_creado']),'Y-m-d').'</td><td>'.$this->DB_GETUSERNAME($row['pa_asignado']).'</td><td><b>'.$row['pa_status'].'</b></td><td>'.$row['pa_fechacumplimiento']."</td><td></td></tr>\n<div class=\"popup\" id=\"PA".$row['pa_id']."\"><div id=\"header_showpa\"><a style=\"float:right;\" href=\"#\" onclick=\"hide('PA".$row['pa_id']."')\"><i class=\"fa fa-times-circle fa-2x fa-fw\"></i></a><div id=\"id\">".$row['pa_id']."</div><div id=\"asignado\">".$this->DB_GETUSERNAME($row['pa_asignado'])." - ".$row['pa_status']."</div></div>".$this->DB_GET_HTML_SHOWPA($row['pa_id']) ."</div>";
				}
				if ($row['pa_fechareprog'] <> NULL){
					$htmlMsg = $htmlOutPut.'<span> El resultado no cumple con los criterios seleccionados</span>';
				}
			    }  while ($row = mysql_fetch_assoc($result));			
				$cssOutPut .='</style>';
				$htmlOutPut.='</table>';
			 
 
#				# $cssOutPut = '</style>';
				# $htmlOutPut = '<span> No se encontraron resultados</span></table>';
			 }
			$htmlOutPut = ($cssOutPut ."\n". $htmlOutPut);
			if (isset($htmlMsg)){ return $htmlMsg; }
			else { return $htmlOutPut; }
		}

		public function DB_GET_LIST_XVENCER (){		//MUESTRA LISTADO DE PA POR VENCER
			
			$ahora = date("Y-m-d");
			$cssOutPut = '<style type="text/css">';
			$htmlOutPut = "<table id=\"ShowTableP\" cellspacing=\"0\"><thead><tr><td>id</td><td>Creado</td><td>Asignado a</td><td>Status</td><td>F. Cumplimiento</td><td>F. Reprogramacion</td></tr></thead>\n<tbody>";
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechacumplimiento, pa_fechareprog, DATEDIFF(pa_fechacumplimiento,CURDATE()) DIAS FROM TBL_paccion WHERE pa_statusgral <> 2  AND DATEDIFF(pa_fechacumplimiento,CURDATE()) BETWEEN 1 AND 15";
			$result = $this->DB_SQLORDIE($sql);
			 if(!mysql_num_rows($result) <= 0){
				while ($row = mysql_fetch_assoc($result)){
				$cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.7);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n";
				$htmlOutPut.='<tr><td><a href="#" onclick ="show(\'PA'.$row['pa_id'].'\')"> '.$row['pa_id'].'</a></td><td> '.date_format(date_create($row['pa_creado']),'Y-m-d').'</td><td>'.$this->DB_GETUSERNAME($row['pa_asignado']).'</td><td><b>  '.$row['pa_status'].'</b></td><td>'.$row['pa_fechacumplimiento']. ' <b>[-'.$row['DIAS'].'-]</b>'."</td><td>".$row['pa_fechareprog']."</td></tr>\n<div class=\"popup\" id=\"PA".$row['pa_id']."\"><div id=\"header_showpa\"><a style=\"float:right;\" href=\"#\" onclick=\"hide('PA".$row['pa_id']."')\"><i class=\"fa fa-times-circle fa-2x fa-fw\"></i></a><div id=\"id\">".$row['pa_id']."</div><div id=\"asignado\">".$this->DB_GETUSERNAME($row['pa_asignado'])." - ".$row['pa_status']."</div></div>".$this->DB_GET_HTML_SHOWPA($row['pa_id']) ."</div>";

				}
				$cssOutPut.='</style>';
				$htmlOutPut.='</table>';
			 }
			 else {
				 $cssOutPut.='</style>';
				 $htmlOutPut = '</tbody></table><span> No se encontraron resultados </span>';
			 }
			 $htmlOutPut = ($cssOutPut."\n".$htmlOutPut);
			return $htmlOutPut;
		}

		public function DB_GET_CSS_XSTATUS ($status){		//MUESTRA LISTADO POR STATUS
			$htmlOutPut ='';
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_statusgral, pa_status, pa_fechacumplimiento FROM TBL_paccion WHERE pa_statusgral = '".$status." ORDER BY pa_id'";
			$cssOutPut = '<style type="text/css">';
		#	$htmlOutPut = '<table>';
			$result = $this->DB_SQLORDIE($sql);
			 if(!mysql_num_rows($result) <= 0){
				 while ($row = mysql_fetch_assoc($result)){
					$cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.5);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n"; 
		#			$htmlOutPut.='<tr><td class="TabStatus'.$row['pa_statusgral'].'"><a href="#" onclick ="show(\''.$row['pa_id'].'\')">'.$row['pa_id'].'</a>  '.$row['pa_creado'].' '.$this->DB_GETUSERNAME($row['pa_asignado']).' '.$row['pa_status'].' '.$row['pa_fechacumplimiento']."</td></tr>\n<div class=\"popup\" id=\"".$row['pa_id']."\"><a href=\"#\" onclick=\"hide('".$row['pa_id']."')\">html del Plan de accion</a></div>";
				 }
				$cssOutPut.= '</style>'; 
		#		$htmlOutPut.='</table>';
			 }
			 else {
				 $htmlOutPut = '<span> No se encontraron resultados</span>';
			 }
		#	$htmlOutPut = ($cssOutPut ."\n". $htmlOutPut); 
			return $cssOutPut;
		}	

		public function DB_GET_LIST_XSTATUS ($status){		//MUESTRA LISTADO POR STATUS
			$htmlOutPut ='';
			$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_statusgral, pa_status, pa_fechacumplimiento, pa_fechareprog FROM TBL_paccion WHERE pa_statusgral = '".$status." ORDER BY pa_id'";
			$cssOutPut = '<style type="text/css">';
			$htmlOutPut = "<table id=\"ShowTable".$status."\" cellspacing=\"0\"><thead><tr><td>id</td><td>Creado</td><td>Asignado a</td><td>Status</td><td>F. Cumplimiento</td><td>F. Reprogramacion</td></tr></thead>\n<tbody>";
			$result = $this->DB_SQLORDIE($sql);
			 if(!mysql_num_rows($result) <= 0){
				 while ($row = mysql_fetch_assoc($result)){
					$cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.7);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n"; 
					$htmlOutPut.='<tr><td><a href="#" onclick ="show(\'PA'.$row['pa_id'].'\')">'.$row['pa_id'].'</a></td><td> '. date_format(date_create($row['pa_creado']),'Y-m-d').'</td><td> '.$this->DB_GETUSERNAME($row['pa_asignado']).'</td><td><b>'.$row['pa_status'].'</b></td><td> '.$row['pa_fechacumplimiento']."</td><td>".$row['pa_fechareprog']."</td></tr>\n<div class=\"popup\" id=\"PA".$row['pa_id']."\"><div id=\"header_showpa\"><a style=\"float:right;\" href=\"#\" onclick=\"hide('PA".$row['pa_id']."')\"><i class=\"fa fa-times-circle fa-2x fa-fw\"></i></a><div id=\"id\">".$row['pa_id']."</div><div id=\"asignado\">".$this->DB_GETUSERNAME($row['pa_asignado'])." - ".$row['pa_status']."</div></div>".$this->DB_GET_HTML_SHOWPA($row['pa_id']) ."</div>";
				 }
				$cssOutPut.= '</style>'; 
				$htmlOutPut.='</tbody></table>';
			 }
			 else {
				 $cssOutPut.='</style>';
				 $htmlOutPut .= '</tbody></table><span> No se encontraron resultados</span>';
			 }
			$htmlOutPut = ($cssOutPut ."\n". $htmlOutPut); 
			return $htmlOutPut;
		}	
		
		public function DB_GET_LIST_XSOL($tipo){		// MUESTRA LISTADO POR TIPO DE SOLUCION
			$htmlOutPut = "<table id=\"ShowTable".$tipo."\" cellspacing=\"0\"><thead><tr><td>id</td><td>Creado</td><td>Asignado a</td><td>Status</td><td>F. Cumplimiento</td><td>F. Reprogramacion</td></tr></thead>\n<tbody>";
			$cssOutPut = '<style type="text/css">';
			$sql= "SELECT pa_id, pa_creado, pa_tiposol, pa_asignado, pa_status, pa_fechacumplimiento, pa_fechareprog FROM TBL_paccion WHERE pa_statusgral <> 2 AND pa_tiposol = '".$tipo."'";
			$result = $this->DB_SQLORDIE($sql);
			 if(!mysql_num_rows($result) <= 0){
				 while ($row = mysql_fetch_assoc($result)){
				 	 $cssOutPut.="\n #PA".$row['pa_id'].":after {position:fixed;content:\" \";top:0;left:0;bottom:0;right:0;background:rgba(0, 0, 0, 0.7);z-index:-2;} \n #PA".$row['pa_id'].":before {position:absolute;content:\" \";top:0;left:0;bottom:0;right:0;background:#FFF;z-index:-1;}\n"; 

					$htmlOutPut.='<tr><td><a href="#" onclick ="show(\'PA'.$row['pa_id'].'\')">'.$row['pa_id'].'</a></td><td>'.date_format(date_create($row['pa_creado']),'Y-m-d').'</td><td>'.$this->DB_GETUSERNAME($row['pa_asignado']).'</td><td><b>'.$row['pa_status'].'</b></td><td>'.$row['pa_fechacumplimiento']."</td><td>".$row['pa_fechareprog']."</td></tr>\n<div class=\"popup\" id=\"PA".$row['pa_id']."\"><div id=\"header_showpa\"><a style=\"float:right;\" href=\"#\" onclick=\"hide('PA".$row['pa_id']."')\"><i class=\"fa fa-times-circle fa-2x fa-fw\"></i></a><div id=\"id\">".$row['pa_id']."</div><div id=\"asignado\">".$this->DB_GETUSERNAME($row['pa_asignado'])." - ".$row['pa_status']."</div></div>".$this->DB_GET_HTML_SHOWPA($row['pa_id']) ."</div>";
;
				 }
				$cssOutPut.='</style>';
				$htmlOutPut.='</tbody></table>';
			 }
			 else {
				$cssOutPut.='</style>';
				$htmlOutPut.= '</tbody></table><span> No se encontraron resultados</span>';
			 }
			 $htmlOutPut= ($cssOutPut ."\n".$htmlOutPut);
			return $htmlOutPut;
		}

		public function DB_GET_HTML_SHOWPA($id){
				$htmlOutPut='';
				$sql="SELECT * FROM TBL_paccion WHERE pa_id =". $id;
				$result = $this->DB_SQLORDIE($sql);
				if(!mysql_num_rows($result) <= 0){
				while ($row = mysql_fetch_assoc($result)){	 
				#	$htmlOutPut.= $row['pa_id'].'-'.$row['pa_criterio'];
	 				$origen = $this->DB_GetOrigen($row['pa_refauditoria']);
					$claveorigen = $this->DB_GetClaveOrigen($row['pa_refauditoria']);
					$TipoSolucion = $this->GetTipoSol($row['pa_tiposol']);
					$ClassVigente = $this->GetClassVigente($row['pa_fechacumplimiento'], $row['pa_status']);
					$resultado = $this->GetEficacia($row['pa_resultado']);
					$htmlOutPut.="<div id=\"left-content_showpa\">\n<dl>\n\t<dt>Origen :</dt><dd>". $origen .' - ' .$claveorigen ."</dd>\n<dt>No Conformidad / Observaciones :</dt>\n<dd>". $row['pa_noconformidad']."</dd>\n\t<fieldset>\n<legend>Criterio</legend>\n".$row['pa_criterio']."\n</fieldset>\n\t<dt>Creado</dt>\n<dd class=\"creado\">". date_format(date_create($row['pa_creado']), 'Y-m-d')."</dd>\n</dl>\n</div>";
					$htmlOutPut.="<div id=\"center-content_showpa\">\n<dl><dt> Causa Raiz :</dt><dd>". $row['pa_causaraiz']."</dd><dt>Tipo de Solucion :</dt><dd class=\"solucion\">". $TipoSolucion ."</dd>\n<dt>Descripcion :</dt><dd>". $row['pa_descsol']."</dd>\n<dt>Responsables :</dt><dd>". $row['pa_responsables']."</dd>\n<dt>Fecha de Cumplimiento</dt><dd class=".$ClassVigente.">". $row['pa_fechacumplimiento']." </dd></dl></div>";
					$htmlOutPut.="<div id=\"right-content_showpa\">\n<dl><dt> Motivo de Reprogramacion :</dt><dd>". $row['pa_reprogramado']."</dd>\n<dt> Fecha de Reprogramacion :</dt><dd>". $row['pa_fechareprog']."</dd>	<dt>Eficacia de las acciones tomadas :</dt><dd>". $row['pa_eficacia']."</dt></dl> \n<fieldset><legend>Resultado</legend>". $resultado."	</fieldset>\n<dt> Fecha de Cierre :</dt><dd>". $row['pa_fechacierre']."</dd>\n</div>";

				}
				 }
				
				return $htmlOutPut;
		}

		public function DB_GET_LIST_PA ($referencia,$status){
			$htmlOutPut[] = array();
			$sql = "SELECT * FROM TBL_paccion WHERE pa_statusgral = '".$status."' AND pa_refauditoria ='".$referencia."'";
			$result = $this->DB_SQLORDIE($sql);
			 if(!mysql_num_rows($result) <= 0){
				 while ($row = mysql_fetch_assoc($result)){
					 $htmlOutPut[$i] = $row['pa_id'];
					 $i++; 
				 }
			 }
			return $htmlOutPut;
		}

		public function DB_GET_ID_NUM_PA ($status,$referencia){
			
			$htmlOutPut = '';
			$sql = "SELECT pa_id FROM TBL_paccion WHERE pa_statusgral ='".$status."' AND pa_refauditoria ='".$referencia."'";	
			$result = $this->DB_SQLORDIE($sql);
			
			 if (!mysql_num_rows($result) <= 0){
				 while ($row = mysql_fetch_assoc($result)){
					 $htmlOutPut .= '<a href="viewpa.php?id="'.$row['pa_id'].'">'.$row['pa_id'].'</a>, ';
				 }
			 }

			return $htmlOutPut;

		}
	
		public function DB_GET_NUMTOT_XVENCER (){ //MUESTRA LISTADO DE PA X VENCER
				$ahora = date("Y-m-d");
							$numtot = 0; 
				$sql= "SELECT  pa_fechacumplimiento, pa_fechareprog, DATEDIFF(pa_fechacumplimiento,CURDATE()) DIAS FROM TBL_paccion WHERE pa_statusgral <> 2  AND DATEDIFF(pa_fechacumplimiento,CURDATE()) BETWEEN 1 AND 15";

				$result = $this->DB_SQLORDIE($sql); 
				$row=mysql_fetch_assoc($result);

			if (!mysql_num_rows($result) <= 0){
				Do {
					if ($row['pa_fechareprog'] < $ahora){
						$numtot++;
					}
				} while ($row = mysql_fetch_assoc($result));

				#$numtot = mysql_num_rows($result);
			return $numtot;
			}
			}
			public function DB_GET_NUMTOT_VENCIDO (){		//MUESTRA LISTADO DE PA VENCIDOS
				$ahora = date("Y-m-d");
				$numtot = 0;
				$sql= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechacumplimiento, pa_fechareprog FROM TBL_paccion WHERE pa_statusgral = 0 AND pa_fechacumplimiento <= '".$ahora."'";
				$sqlrepro= "SELECT pa_id, pa_creado, pa_asignado, pa_status, pa_fechareprog FROM TBL_paccion WHERE pa_statusgral = 3 AND pa_fechareprog <= '".$ahora."'";

				$cumplidos = $this->DB_SQLORDIE($sql); 
				$reprog = $this->DB_SQLORDIE($sqlrepro);
				$totcumplidos= mysql_num_rows($cumplidos);
				$totreprog = mysql_num_rows($reprog);
				$numtot = $totcumplidos + $totreprog;
			return $numtot;
			}
	
			public function DB_GET_NUMTOT_XSTATUS($status){			// OBTIENE EL NUMERO TOTAL DE REGISTROS POR STATUS (ABIERTAS / CERRADAS)

			$htmlOutPut='';
				$sql = " SELECT pa_statusgral FROM TBL_paccion WHERE pa_statusgral != '".$status."'";
				$result = $this->DB_SQLORDIE($sql);
				$numtot = mysql_num_rows($result);
			return $numtot;
		}
	
		public function DB_GET_NUMTOT_XSTATUSsn($status){			// OBTIENE EL NUMERO TOTAL DE REGISTROS POR STATUS 

			$htmlOutPut='';
				$sql = " SELECT pa_statusgral FROM TBL_paccion WHERE pa_statusgral = '".$status."'";
				$result = $this->DB_SQLORDIE($sql);
				$numtot = mysql_num_rows($result);
			return $numtot;
		}

		public function DB_GET_NUMTOT_XCRITERIO($criterio){			// OBTIENE EL NUMERO TOTAL DE REGISTROS POR CRITERIO 

			$htmlOutPut='';
				$sql = " SELECT pa_criterio FROM TBL_paccion WHERE pa_criterio = '".$criterio."'";
				$result = $this->DB_SQLORDIE($sql);
				$numtot = mysql_num_rows($result);
			return $numtot;
		}
	
		public function DB_GET_NUMTOT_XTIPOSOLUCION($tipo){			// OBTIENE EL NUMERO TOTAL DE REGISTROS POR CRITERIO 

			$htmlOutPut='';
				$sql = " SELECT pa_tiposol FROM TBL_paccion WHERE pa_tiposol = '".$tipo."'";# AND pa_tiposol =! 'NULL'";
				$result = $this->DB_SQLORDIE($sql);
				$numtot = mysql_num_rows($result);
			return $numtot;
		}
	
		public function DB_GET_NUMTOT_XEFICACIA($param){
			$sql="SELECT pa_statusgral, pa_resultado from TBL_paccion WHERE pa_statusgral = 2 AND pa_resultado = '".$param. "'";
				$result = $this->DB_SQLORDIE($sql);
				$numtot = mysql_num_rows($result);
		    	return $numtot;
		}

		public function DB_GET_NUMTOT_PA(){			// OBTIENE EL NUMERO TOTAL DE REGISTROS POR CRITERIO 

			$htmlOutPut='';
				$sql = " SELECT pa_id FROM TBL_paccion";
				$result = $this->DB_SQLORDIE($sql);
				$numtot = mysql_num_rows($result);
			return $numtot;
		}



		public function DB_SHOW_NUM_PA ($referencia,$status){  // 0 gral, 1 asig, 2 abie, 3 reprog, 4 term--Referencia (tipo auditoria=SAI,NISSAN,LIDER,etc)
				switch ($status){
				case 0:
					$sql ="SELECT * FROM TBL_paccion WHERE pa_statusgral= '0' AND pa_refauditoria= '".$referencia."'";	// 0 total de registros con status de ASIGNADO
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 1: 
					$sql ="SELECT * FROM TBL_paccion WHERE pa_statusgral ='1' AND pa_refauditoria= '".$referencia."'";	//total de registros con status de ABIERTO
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 2:
					$sql ="SELECT * FROM TBL_paccion WHERE pa_statusgral = '2' AND pa_refauditoria= '".$referencia."'";	//total de registros con status de CERRADO
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 3:
					$sql ="SELECT * FROM TBL_paccion WHERE pa_statusgral = '3' AND pa_refauditoria= '".$referencia."'";	//total de registros con status de REPROGRAMADO
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 9:
					$sql ="SELECT * FROM TBL_paccion'";	//total de registros 
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				}
				return $res;
		}


		public function DB_SHOW_PA_TIPO ($tipo){
				switch ($tipo){
				case 0:
					$sql ="SELECT * FROM TBL_paccion WHERE pa_refauditoria = '0'";	// 0 total de registros de auditoria INTERNA
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 1: 
					$sql ="SELECT * FROM TBL_paccion WHERE pa_refauditoria ='1'";	//total de registros de auditoria NISSAN INTEGRAL
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 2:
					$sql ="SELECT * FROM TBL_paccion WHERE pa_refauditoria = '2'";	//total de registros de auditoria LIDER
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				case 3:
					$sql ="SELECT * FROM TBL_paccion WHERE pa_refauditoria = '3'";	//total de registros de auditoria ISO GLOBAL SAI
					$result = $this->DB_SQLORDIE($sql);
					$res = mysql_num_rows($result);
					break;
				}
			return $res;	
				
		}

 ##################################### 
 #
 # CALENDARIO
 #
 ##################################### 
		
		public function CAL_GetUsuariosUUID() {
			$idarray[] = array();
			$i = 0;
			$sql = "Select usr_uuid FROM TBL_Usuarios WHERE usr_operador = 0";
			$result = $this->DB_SQLORDIE($sql);
			if (!mysql_num_rows($result) <= 0) {
				while ($row = mysql_fetch_assoc($result)){
					$sql2 = "Select pa_id FROM TBL_paccion WHERE pa_asignado = ".$row['usr_uuid'];
					$res = $this->DB_SQLORDIE($sql2);

					if (!mysql_num_rows($res) == 0) {
					$idarray[$i] = $row['usr_uuid'];
					$i++;
				} }
			}
			return $idarray;
		}

		public function CAL_GetEventListXid($id_user) {
			$idarray[] = array();
			$i = 0;
			$sql = "Select pa_id from TBL_paccion where pa_asignado = ".$id_user;

			$result = $this->DB_SQLORDIE($sql);
			if (!mysql_num_rows($result) <= 0) {
		 		while ($row = mysql_fetch_assoc($result)){
					$idarray[$i]=$row['pa_id'];
					$i++;
				}
			}
			return $idarray;

		}
		
		public function CAL_GetEventXid($id) {

			$paevent='';$paeventstart='';$paeventend='';
			$sql = "Select * from TBL_paccion where pa_id = ".$id;
				$result = $this->DB_SQLORDIE($sql);
				if (!mysql_num_rows($result) <=0) {
					$row = mysql_fetch_assoc($result);
					#$paevent = '<a href=\"#\" alt=\"'.>'.$row['pa_id'];
					$paeventstart = date('Y-m-d',strtotime($row['pa_creado']));
					$paeventend = $row['pa_fechacumplimiento'];
					$usrname = $this->DB_GETUSERNAME($row['pa_asignado']);
					$paevent = '<a href="viewpa.php?id='.$row['pa_id'].'" title="'.$usrname.' '.$paeventstart.'-'.$paeventend.'">'.$row['pa_id'];

				}
				return array($paevent,$paeventstart,$paeventend);

		}
		
		public function CAL_DOiCAL_CAL($pa_id){ //Genera string para .ical de PA
		
			$sql = "SELECT * from TBL_paccion WHERE pa_id =".$pa_id;
				$result = $this->DB_SQLORDIE($sql);
				if (!mysql_num_rows($result) <=0) {
					$row = mysql_fetch_assoc($result);
					$icalDesc = '[PA #'.$row['pa_id'].'] '.$row['pa_noconformidad'];
					$mailto = $this->DB_GETEMAIL($row['pa_asignado']);
						#$summary = $this->CAL_DOiCAL_SUMMARY($row);
			       			$summary  = "id ".$row['pa_id']."  Asignado a: ".$this->DB_GETUSERNAME($row['pa_asignado'])."\n\t";
						$summary .= "Origen: ".$this->DB_GetOrigen($row['pa_refauditoria'])." - ".$this->DB_GetClaveOrigen($row['pa_refauditoria'])."\r\n\t";
						$summary .= "No conformidad: ".$row['pa_noconformidad']."\r\n\t";
						$summary .= "Descripción: ".$row['pa_descsol'];					
						$tstart = date('Ymd\THis',strtotime($row['pa_creado']));
						if ($row['pa_statusgral'] == 3) { $tend = date("Ymd\THis", strtotime($row['pa_fechareprog']));}
						if ($row['pa_statusgral'] == 0) { $tend = date("Ymd\THis",strtotime($row['pa_fechacumplimiento']));}
						$tstamp = gmdate("Ymd\THis");
						$uid = ICAL_UID.gmdate("Ym")."-".$row['pa_asignado'].$row['pa_id'];
	
						$icshtml ='<BR><a href="http//10.7.18.8/PA/login.php"><FONT SIZE="3" COLOR="#00AFF9" FACE="Arial"> WPA </FONT></a> <table><tr><td><FONT SIZE="2" COLOR="#666666" FACE="arial">ID:</FONT></td> <td><FONT SIZE="2" COLOR="#666666" FACE="arial">'.$row['pa_id'].'</FONT></td></tr> </table> <table><tr><td><FONT SIZE="2" COLOR="#666666" FACE="arial">No conformidad:</FONT></td><td>\n<FONT SIZE="2"  COLOR="#666666" FACE="arial">'.$row['pa_noconformidad'].'</FONT></td></tr></table> <table><tr><td>	<FONT SIZE="2" COLOR="#666666" FACE="arial">Causa Raiz:</FONT></td><td>	<FONT SIZE="2"  COLOR="#666666" FACE="arial">'.str_replace("\r\n", "\\n",$row['pa_causaraiz']).'</FONT></td></tr></table> <table><tr><td><FONT SIZE="2" COLOR="#666666" FACE="arial">Descripción:</FONT></td><td><FONT SIZE="2"  COLOR="#666666" FACE="arial">'.str_replace("\r\n", "\\n",$row['pa_descsol']).'\n<p> Para consultar el detalle de la solución haz click <a href="http://10.7.18.8/PA/viewpa.php?id='.$row['pa_id'].'"> aqui </a></p> </FONT></td></tr></table></FONT> <FONT SIZE="1" FACE="ARIAL">&nbsp;<BR>&nbsp;<BR></FONT> &nbsp; <BR><FONT SIZE="2" COLOR="#666666" FACE="arial"><strong>Creado: </strong>&nbsp;'.$row['pa_creado'].'</FONT>&nbsp; <BR><FONT SIZE="2" COLOR="#666666" FACE="arial"><strong>Cumplimiento</strong>&nbsp;'.$row['pa_fechacumplimiento'].'</FONT>&nbsp; <BR><FONT SIZE="2" COLOR="#666666" FACE="arial">'.$row['pa_responsables'].'</FONT>&nbsp; <BR><a href="http://10.7.18.8/PA"><FONT SIZE="1" COLOR="#00AFF9" FACE="arial">Plan de Accion</FONT></a><FONT SIZE="1" FACE="ARIAL">&nbsp;&nbsp;|&nbsp;&nbsp;</FONT><a href="http://10.7.18.8/PA/viewpa.php?id='.$row['pa_id'].'"><FONT SIZE="1" COLOR="#00AFF9" FACE="arial">Ver el Plan de Acción</FONT></a> &nbsp; <BR></FONT><BR>	&nbsp;<BR>	<FONT SIZE="1" COLOR="#666666" FACE="arial">¿Requieres soporte?</FONT>	<a href="http://10.7.18.5/soporte"><FONT SIZE="1" COLOR="#00AFF9" FACE="Arial">Levanta tu Ticket</a></FONT>&nbsp;<BR>&nbsp;<BR><FONT COLOR="#A0A0A0" size="1" FACE="arial">AVISO IMPORTANTE:</FONT><br />';
					
$str_event="BEGIN:VCALENDAR\r
PRODID:-//TAP/NONSGML Tiny Action Plan V0.1//ES\r
VERSION:2.0\r
METHOD:PUBLISH\r
X-WR-CALNAME=WPA\r
BEGIN:VTIMEZONE\r
TZID:America/Mexico_City\r
BEGIN:DAYLIGHT\r
TZOFFSETFROM:-0600\r
TZOFFSETTO:-0500\r
TZNAME:CDT\r
DTSTART:19700405T020000\r
RRULE:FREQ=YEARLY;BYDAY=1SU;BYMONTH=4\r
END:DAYLIGHT\r
BEGIN:STANDARD\r
TZOFFSETFROM:-0500\r
TZOFFSETTO:-0600\r
TZNAME:CST\r
DTSTART:19701025T020000\r
RRULE:FREQ=YEARLY;BYDAY=-1SU;BYMONTH=10\r
END:STANDARD\r
END:VTIMEZONE\r
BEGIN:VEVENT\r
CREATED:".$tstart."\r
DTSTAMP:".$tstamp."\r
UID:".$uid."\r
SUMMARY:".$icalDesc."\r
DTSTART;VALUE=DATE:".date('Ymd',strtotime($tend))."\r
DTEND;VALUE=DATE:".date('Ymd',strtotime($tend))."\r
TRANSP:TRANSPARENT\r
LOCATION:[ WPA ]\r
DESCRIPTION:".$row['pa_noconformidad']."\r
X-ALT-DESC;FMTTYPE=text/html:".$icshtml."
PRIORITY:5\r
CLASS:PUBLIC\r
BEGIN:VALARM\r
TRIGGER:-P1D\r
ACTION:DISPLAY\r
DESCRIPTION:Seguimiento de [PA #".$row['pa_id']."]\r
END:VALARM\r
END:VEVENT\r
END:VCALENDAR\r";

					return $str_event;
				}
				else { $row = 'No hay registros para generar evento';
					
					return $row;
				}
		}

		public function CAL_ADDEVENT($pa_id,$str_event){

				$sql = "UPDATE iavdb.TBL_paccion SET pa_event ='".$str_event."' WHERE TBL_paccion.pa_id = ".$pa_id;
				$res = $this->DB_SQLORDIE($sql);
		}

		public function CAL_DOiCAL_EVENT($pa_id){
			$sql = "SELECT * from TBL_paccion WHERE pa_id =".$pa_id;
			#$sql = "SELECT * FROM TBL_paccion WHERE pa_statusgral != 1 AND pa_statusgral != 2";

				$result = $this->DB_SQLORDIE($sql);
				if (!mysql_num_rows($result) <=0) {
					$row = mysql_fetch_assoc($result);
						$icalDesc = $row['pa_noconformidad'];
						#$summary = $this->CAL_DOiCAL_SUMMARY($row);
			       			$summary  = "id ".$row['pa_id']."  Asignado a: ".$this->DB_GETUSERNAME($row['pa_asignado'])."\n\t";
						$summary .= "Norma: ".$row['pa_norma']."  Ref: ".$this->DB_GETAUDIT($row['pa_refauditoria'])."\n\t";
						$summary .= "Comentarios: ".$row['pa_comentarios']."\n\t";
						$summary .= "No conformidad: ".$row['pa_noconformidad']."\n\t";

						$tstart = date('Ymd\THis\Z',strtotime($row['pa_fechacumplimiento']));
						$tend = date("Ymd\THis\Z",strtotime($row['pa_fechacumplimiento']));
						$tstamp = gmdate("Ymd\THis\Z");
						$uid = "IAV".gmdate("Ym")."-".$row['pa_asignado'].$row['pa_id'];
						
						$str_event="BEGIN:VEVENT\n";
						$str_event.="DTSTAMP:".$tstamp."\n";
						$str_event.="DTSTART:".$tstart."\n";
						$str_event.="DTEND:".$tend."\n";
						$str_event.="UID:".$uid."\n";
						$str_event.="DESCRIPTION:".$icalDesc."\n";
						$str_event.="SUMMARY:".$summary."\n";
						$str_event.="END:VEVENT\n";

					return $str_event;
				}
				else { $row = 'No hay registros para generar evento';
					
					return $row;
				}
		}

	public function CAL_iCALDO(){

		$StriCal = '';
		$sql = "SELECT * FROM TBL_paccion WHERE pa_statusgral != 1 AND pa_statusgral != 2";

				$result = $this->DB_SQLORDIE($sql);
				if (!mysql_num_rows($result) <=0) {
					while ($row = mysql_fetch_assoc($result)){
						$icalDesc = $row['pa_noconformidad'];
						#$summary = $this->CAL_DOiCAL_SUMMARY($row);
			       			$summary  = "id ".$row['pa_id']."  Asignado a: ".$this->DB_GETUSERNAME($row['pa_asignado'])."\n\t";
						$summary .= "  Ref: ".$this->DB_GETAUDIT($row['pa_refauditoria'])."\n\t";
						$summary .= "No conformidad: ".$row['pa_noconformidad']."\n\t";

						$tstart = date('Ymd\THis\Z',strtotime($row['pa_fechacumplimiento']));
						$tend = date("Ymd\THis\Z",strtotime($row['pa_fechacumplimiento']));
						$tstamp = gmdate("Ymd\THis\Z");
						$uid = "IAV".gmdate("Ym")."-".$row['pa_asignado'].$row['pa_id'];
						
						$str_event="BEGIN:VEVENT\n";
						$str_event.="DTSTAMP:".$tstamp."\n";
						$str_event.="DTSTART:".$tstart."\n";
						$str_event.="SEQUENCE:1\n";
						$str_event.="ORGANIZER:".$this->DB_GETUSERNAME($row['pa_asignado'])."\n";
						$str_event.="CATEGORIES:".$this->DB_GETAUDIT($row['pa_refauditoria'])."\n";
						$str_event.="DTEND:".$tend."\n";
						$str_event.="UID:".$uid."\n";
						$str_event.="SUMMARY:".$icalDesc."\n";
						$str_event.="DESCRIPTION:".$summary."\n";
						$str_event.="BEGIN:VALARM\n";
						$str_event.="TRIGGER:-PT15M\n";
						$str_event.="ACTION:DISPLAY\n";
						$str_event.="DESCRIPTION:REVISA TUS PLANES DE ACCION\n";
						$str_event.="END:VALARM\n";
						$str_event.="END:VEVENT\n";
						$StriCal.= $str_event;
					}

					return $StriCal;
				
				}
				else { $row = 'No hay registros para generar evento';
					
					return $row;
				}
		}

		public function DB_EDITCOMMENT($paid, $pa_comentario){
				$sql ="UPDATE iavdb.TBL_paccion SET pa_comentarios ='".$pa_comentario."' WHERE TBL_paccion.pa_id= ".$paid;

				$res= $this->DB_SQLORDIE($sql);
				return $res;
		}

		public function COMMENT_GETCOMMENTS($id){
			$pastcomments ='';
			$sql="SELECT pa_comentarios FROM TBL_paccion WHERE pa_id = ".$id;
				$result =$this->DB_SQLORDIE($sql);
				if (!mysql_num_rows($result) <=0) {
					while ($row = mysql_fetch_assoc($result)){
					$pastcomments = $row['pa_comentarios'];
					}
				}
			return $pastcomments;
		}
			
	

		private function CAL_DOiCAL_SUMMARY($array){
			
				$summary = '';
				$c = count($array);
				   while ($array <= $c){
					 $summary .= "id ".$array['pa_id']."\n";
					 $summary .= "Norma ".$array['pa_norma']."\n";
					 $summary .= "Comentarios: ".$array['pa_comentarios']."\n";
					 $summary .= "No conformidad: ".$array['pa_noconformidad']."\n";
				   }
				return $summary;
		}

#############################################
#
# Finaliza funciones de EVENTO
# 
#############################################
 

#############################################
#	GENERA XML para RSS
#############################################

		public function RSS_DO() { //Genera el RSS formato XML
			$rssOutPut="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<?xml-stylesheet type=\"text/css\" href=\"../css/style-xml.css\"?>\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n<channel>\n\t<title>WPA</title>\n<description>Planes de Accion</description>\n<link>http://10.7.18.8</link>\n";

			$sql = "SELECT * FROM TBL_paccion WHERE pa_statusgral != 1 AND pa_statusgral != 2";
			$result = $this->DB_SQLORDIE($sql);
			if(!mysql_num_rows($result)<=0) {
				while ($row = mysql_fetch_assoc($result)){
					$rssOutPut.="<item>\n\t";
					$rssOutPut.="<category>".$row['pa_status']."</category>\n";
					$rssOutPut.="<title><![CDATA[ id ".$row['pa_id']." ".$this->DB_GETUSERNAME($row['pa_asignado'])." ".$row['pa_criterio']."]]></title>\n\t";
					$rssOutPut.="<description><![CDATA[ <h3>".$row['pa_fechacumplimiento']."</h3>\n<h4>Observaciones/No Conformidad:</h4>".$row['pa_noconformidad']."<br /><p>".$row['pa_causaraiz']."</p><p>".$row['pa_descsol']."</p>]]></description>\n";
					$rssOutPut.="<link>http://10.7.18.8/PA/viewpa.php?id=".$row['pa_id']."</link>\n";
					$rssOutPut.="<pubDate>".$row['pa_creado']."</pubDate>\n";
					$rssOutPut.= "</item>\n";
				}
				$rssOutPut.="</channel>\n </rss>\n";
			}
			return $rssOutPut;
		}

		public function RSS_DOFILE($rssOutPut){ }

		public function DB_UpdateComment($paid,$sql) {

		}
			
		private function DB_SQLORDIE($sql) {
				$return_result = mysql_query($sql,$this->CONN);
				if ($return_result) {
					$res = $return_result;
				} else {
					$res = $this->DB_SQLERROR($sql);
				}
				return $res;
		}
		
		private function DB_SQLERROR($sql) {
				$res = mysql_error($this->CONN) . '<br />';
				$res.= ':: SQL -->'.$sql;
				die('ERROR : '. $res);
				
		}

		private function GetClassVigente($fecha, $status){
			$v='';
			$actual = DATE("Y-m-d");
		#	if ($actual < $fecha) { $v = 'vigente';}
			if ($actual > $fecha && $status != 'CERRADO'){ $v = 'caduco';}
			if ($actual > $fecha && $status == 'CERRADO'){ $v = 'vigente';}

				return $v;
	}

		private function GetTipoSol($tipo) {
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
		private function GetEficacia($eficacia) {
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

		public function GetStatusSearchPA ($status,$id,$op) {
			$sg ='';
			switch ($status) {
					case 0:
						if ($op == 0) {
							$sg = '<span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span>';}
						else {  $sg = '<span title="Reprogramacion" class="fa-stack fa-1x"><a href="'.PA_WEBPA.'?prog='.$id.'"><i class="fa fa-refresh"></i></a></span><span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span><span title="Cerrar" class="fa-stack fa-1x"><a href="pa.php?cerrar='.$id.'"><i class="fa fa-close"></i></a></span><span title="Eliminar" onclick="JS_msgbox(\''.ltrim($id).'\')" class="fa-stack fa-1x"><i class="fa fa-trash-o" ></i></span>';}
						break;
					case 1:
						if ($op == 0) {
							$sg = '<span title="Aceptar" class="fa-stack fa-1x"><a href="'.PA_WEBPA.'?edit='.$id.'"><i class="fa fa-edit"></i></a></span>';}
						else {  $sg = '<span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span><span title="Cerrar" class="fa-stack fa-1x"><a href="pa.php?cerrar='.$id.'"><i class="fa fa-close"></i></a></span><span title="Eliminar" onclick="JS_msgbox(\''.ltrim($id).'\')" class="fa-stack fa-1x"><i class="fa fa-trash-o" ></i></span>';}
						break;
					case 3:
						if ($op == 0) {
							$sg = '<span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span>';}
						else {  $sg = '<span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span><span title="Cerrar" class="fa-stack fa-1x"><a href="pa.php?cerrar='.$id.'"><i class="fa fa-close"></i></a></span><span title="Eliminar" onclick="JS_msgbox(\''.ltrim($id).'\')" class="fa-stack fa-1x"><i class="fa fa-trash-o" ></i></span>';}
						break;
					case 2:
						if ($op == 0) {
							$sg = '<span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span>';}
						else {  $sg = '<span title="Ver"class="fa-stack fa-1x"><a href="'.PA_WEBVIEWPA.'?id='.$id.'"><i class="fa fa-search"></i></a></span><span title="Eliminar" onclick="JS_msgbox(\''.ltrim($id).'\')" class="fa-stack fa-1x"><i class="fa fa-trash-o" ></i></span>';}
						break;
				}
				return $sg;
		}

			
		private function GetStatusGral($status,$id,$op){
				$sg ='';
				switch ($status) {
						case 0:
							if ($op == 0) {
								$sg = '<a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0"></a>';}
							else {  $sg = '<a href="'.PA_WEBPA.'?prog='.$id.'">reprog</a> | <a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0"></a>|<a href="pa.php?cerrar='.$id.'">cerrar</a> | <img border="0" src="images/cancel.png" onclick="JS_msgbox(\''.ltrim($id).'\')">';}
							break;
						case 1:
							if ($op == 0) {
								$sg = '<a href="'.PA_WEBPA.'?edit='.$id.'">aceptar</a>';}
							else {  $sg = '<a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0"></a>|<a href="pa.php?cerrar='.$id.'">cerrar</a> | </a><img border="0" src="images/cancel.png" onclick="JS_msgbox(\''.ltrim($id).'\')">';}
							break;
						case 3:
							if ($op == 0) {
								$sg = '<a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0></a>';}
							else {  $sg = '<a href="'.PA_WEBPA.'?cerrar='.$id.'">cerrar</a> | <a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0"></a>|<a href="pa.php?cerrar='.$id.'">cerrar</a> | </a><img border="0" src="images/cancel.png" onclick="JS_msgbox(\''.ltrim($id).'\')">';}
							break;
						case 2:
							if ($op == 0) {
								$sg = '<a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0"></a>';}
							else {  $sg = '<a href="'.PA_WEBVIEWPA.'?id='.$id.'"><img src="images/search.png" border="0"></a></a><img border="0" src="images/cancel.png" onclick="JS_msgbox(\''.ltrim($id).'\')">';}
							break;
				}
				return $sg;
		}

#				if ($status == 1) { $sg ='<a href=".php?edit='.$id.'">aceptar</a>'; }
#				if ($status == 0) { $sg ='<a href="#">reprog</a>'; }
#				return $sg;
#		}
		private function GetStyleStatusGral($status) {
			$style = '';
			if ($status == 2) {
				$style = 'style="text-decoration:line-through;" ';
			}
				return $style;
		}

		private function GetCSSid($status,$FM,$FC,$FR){
			$hoy = DATE('Y-m-d');
			$class='';
			switch ($status)
			{
				case 0:
					$class ='class="asignado">';
					break;
				case 1:
					if($FC <= $hoy){
						$class ='class="vigente">';
						break;}
					else
						{$class ='class="vencido">';							break;}
				case 2:
					$class ='class="cerrado">';
					break;
				case 3:
					if($FR <= $hoy) {
						$class ='class="vencido">';
						break;}
					else {
						$class ='class="vigente">';
						break;}
			}
			return $class;
		}


		private function GetCSSAudit($audit) {

			$class='';
			switch ($audit)
				{
					case 0:
						$class ='class="A_interna">';
						break;
					case 1:
						$class ='class="A_integral">';
						break;
					case 2:
						$class ='class="A_lider">';
						break;
					case 3:
						$class ='class="A_iso">';
						break;
					case 4:
						$class ='class="A_bsc">';
						break;
					default: 
						$class ='>';
						break;
				}
				return $class;
		}
		public function GetCSSStatus_($status) {
				switch ($status)
				{
					case 0:
						$class ='#00BB53';
						break;
					case 1:
						$class ='#2196F3';
						break;
					case 2:
						$class ='#000000';
						break;
					case 3:
						$class ='#007E38';
						break;
				}
				return $class;
		}

		private function GetCSSStatus($status) {
				switch ($status)
				{
					case 0:
						$class ='class="S_asignada">S';
						break;
					case 1:
						$class ='class="S_abierta">A';
						break;
					case 2:
						$class ='class="A_cerrada">C';
						break;
					case 3:
						$class ='class="A_reprog">R';
						break;
				}
				return $class;
		}
	
		public function GetCSSCriterio_($criterio){

				switch ($criterio)
				{
					case 'NC-':
						   $class = 'CriterioNC-';
						   break;
					case 'NC+':
						   $class = 'CriterioNC';
						   break;
					case 'OB':
						   $class = 'CriterioOB';
						   break;
					case 'NA':
						   $class = 'CriterioNA';
						   break;
				}
				return $class;
		}

		private function GetCSSCriterio($criterio){

				switch ($criterio)
				{
					case 'NC-':
						   $class = 'class="CriterioNC-"';
						   break;
					case 'NC+':
						   $class = 'class="CriterioNC"';
						   break;
					case 'OB':
						   $class = 'class="CriterioOB"';
						   break;
					case 'NA':
						   $class = 'class="CriterioNA"';
						   break;
				}
				return $class;
		}

		private function GetBGColor($count) {
						
				$odd= $count%2;
					if ($odd==1) {return 'tr0'; }
					else { return 'tr1';}
		}


				
	}

	 $dataset = new DBIAV(DB_PA_HOST,DB_PA_DATABASE,DB_PA_USERNAME,DB_PA_PASSWD);

?>
