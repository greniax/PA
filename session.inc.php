<?php
  include ('config.inc.php');

	session_start();
	if (!isset($_SESSION['id'])) {
		header ('Location: '.PA_WEBDENEGADO); 
	}

?>
