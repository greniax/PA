<?php
include ('config.inc.php');
include ('class.db.php');

session_start();

	if (isset($_POST['txtlogin']) AND ($_POST['txtpasswd'])) {
		$passwd = MD5($_POST['txtpasswd']);
		$username = $_POST['txtlogin'];
		$session= ($dataset->DB_LogIn($_POST['txtlogin'],$passwd)); 	//DB_LogIn @Int op = 1, 0 operador

	    if (isset($session)){
		    $_SESSION['username'] = $username;
		    $_SESSION['name'] = session_name();
		    $_SESSION['id'] = session_id();
		    $_SESSION['op'] = $session;
#		    echo ('usuario: '.$_SESSION['username'].' '.$_SESSION['name'].'='.$_SESSION['id'].' op='.$_SESSION['op']);
#		    echo ('<br \> <a href="'.PA_WEBPA.'?new">formulario</a> & <a href="'.PA_WEBLISTPA.'">view</a> & <a href="'.PA_WEBLOGOUT.'">Logout</a>');
		
		    header ('Location: '.PA_WEBLISTPA); 

	    } 
	  else {
		   header('Location: '.PA_WEBLOGIN.'?fail');
		  
	  }
	}
	else {
		   header('Location: '.PA_WEBLOGIN.'?');
		  
	  }

?>		
