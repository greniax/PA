<?php 
	include ('config.inc.php');

	if(isset($_GET['fail'])){
		$LoginFail = "<p class=\"loginfail\">Usuario y/o Contraseña no válidos, Intente nuevamente</p>";
	}

	echo $htmltag."\n";
?>
<html>
<head>
	<title>LogIn :: <?php echo PA_APPNAME; ?></title>
	<?php echo $metatag."\n"; ?>
	<?php echo $css."\n"; ?>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <div id="LogIn-Wrap">
	<div id="Login-img"><img src="images/login.jpg" border="0" /></div>
	<div id="Login-Form">
	<h3><?php echo PA_APPDESCRIPTION; ?></h3>
   		<form name="frmlogin" method="post" action="checklogin.php">
			<fieldset class="login">
				<legend>Login</legend>
				<input type="text" onblur="if(this.value =='')this.value='Usuario';" onfocus="if(this.value =='Usuario') this.value ='';" value="Usuario" name="txtlogin" class="login user"><br />
				<input type="text" onfocus="if(this.value =='' || this.value =='Password'){this.value='';this.type='password'}" onblur="if(this.value == ''){this.type='text'; this.value=this.defaultValue}" value="Password" name="txtpasswd" class="login passwd"><br />
	<?php if(isset($LoginFail)){ echo $LoginFail;} ?>
					<input type="submit" name="submit" Value="Ingresar" ><br />
			</fieldset>
    		</form>
	</div>
	</div>
</body>
</html>
