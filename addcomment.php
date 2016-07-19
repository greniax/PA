<?php
	include ('session.inc.php');
	include ('class.db.php');


	if (($_SERVER["REQUEST_METHOD"] == 'POST') AND (isset($_GET['id']))) {
		$id = $_GET['id'];
		$hoy = date('d/m/Y h:m:s');	
		$usuario = $_SESSION['username'];
  	        $pa_comentario = '<span>[ '.$hoy.' ] '.$usuario. ': '.$_POST['txtcomentario'].'</span>;';
		$PastComment = $dataset->COMMENT_GETCOMMENTS($id);
		$pa_comentario.= $PastComment;

		$dataset->DB_EDITCOMMENT($id, $pa_comentario);

	
	header ('Location: '.PA_WEBVIEWPA.'?id='.$id);
		}
?>	

