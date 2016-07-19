<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>WPA :: Sube tu archivo</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="css/upload.css" type="text/css" media="all" />
<script>
function closeWin() {
    OpenWin.close();   // Closes the new window
}
</script>
</head>

<body>

<h2>Sube tu archivo</h2>

<?php

# index.php
# #######################################
# # Basic Uploader © 2012 Scott Connell
# # Created: 2012/09/11 (year/month/day)
# # Updated: 2015/06/21
# # License: Free for personal and commercial use.
# # Source: http://programs.orgfree.com
# #######################################
#
# # SET VARIABLES ##########################
#
# # Set the full path to this directory with trailing slash /.
#
 $full_path = "/var/www/PA/";
#
# # Set how many simultaneous uploads to allow.
#
 $number_of_uploads = 1;
#
# # Set allowed file types, lowercase without period (.)
#
 $allowed_file_types = array("doc","xls","xml","pdf","docx","xlsx");
#
# # Change the upload_folder path, with trailing slash, 
# # to your full directory path if neccessary, and set 
# # permissions (chmod) to 777.
#

 $upload_folder = "./uploads/";
 if (!is_dir($upload_folder.$_GET['id'])) {
	 $upload_folder =  mkdir($upload_folder.$_GET['id'],0775);
 }
 else {
	 $upload_folder = $upload_folder.$_GET['id']."/";
 }
#
# # Set maximum file upload size in kilobytes.
#
 $max_size_in_kb = 1024;
#
# # Set 1 to rename files, 0 to keep original file names.
#
 $rename_files = 0;
#
# # END SETTING VARIABLES #################
 #
 $id = $_GET['id'];

 function printForm($id)
 {
 global $allowed_file_types,$number_of_uploads,$max_size_in_kb;

 print "<form action=\"". htmlspecialchars($_SERVER["PHP_SELF"]."?id=".$id, ENT_QUOTES) ."\" method=\"post\" enctype=\"multipart/form-data\">\n";

 	for($i=0;$i<$number_of_uploads;$i++)
 		{
 			print "<p><input type=\"file\" name=\"file[]\" /></p>\n";
 				}

 				print "<p><input type=\"hidden\" name=\"upload\" value=\"1\" /><input type=\"submit\" value=\"Subir\" /></p>\n</form>\n";

			print "<p>Archivos permitidos:<br \> ." . implode($allowed_file_types, " ."). "</p>\n";
 				}

 				$fileNAMES = array();

 				if(isset($_POST['upload']))
 				{
 					for($i=0;$i<$number_of_uploads;$i++)
 						{
				if(strlen($_FILES['file']['name'][$i]) > 0)
 				{
 			$filearray = explode(".", $_FILES['file']['name'][$i]);
 			$ext = end($filearray);

		if($rename_files == 1)
		{
 			#list($usec, $sec) = explode(" ", microtime());
 			$fileNAMES[$i] = $id."_"; #.$sec."_".$usec;
 		}
 		else
 			{
 			$xperiods = str_replace("." . $ext, "", $_FILES['file']['name'][$i]);
 			$fileNAMES[$i] = str_replace(".", "", $xperiods);
 			}

													if(!in_array(strtolower($ext), $allowed_file_types))
 			{
				print "<p class=\"error\">FAILED: ". htmlspecialchars($_FILES['file']['name'][$i]) ."<br />ERROR: Tipo de archivo no permitido.</p>\n";
 			}
 			elseif($_FILES['file']['size'][$i] > ($max_size_in_kb*1024))
 			{
 			print "<p class=\"error\">FAILED: ". htmlspecialchars($_FILES['file']['name'][$i]) ."<br />ERROR: el tamaño del archivo excede el permitido.</p>\n";
 			}
 			elseif(file_exists($upload_folder.$fileNAMES[$i] .".". $ext))
 												{
 		print "<p class=\"error\">FAILED: ". htmlspecialchars($fileNAMES[$i]) .".". $ext ."<br />ERROR: El archvo ya existe.</p>\n";
 		}
 		else
 		{
 		if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $upload_folder.$fileNAMES[$i] .".". $ext))
 		{
 		print "<p class=\"upload\">Carga Satisfactoria:<br \> ". htmlspecialchars($fileNAMES[$i]) .".". $ext ."</p>\n";
 		}
 		else
 		{
	print "<p class=\"error\">FAILED: ". htmlspecialchars($_FILES['file']['name'][$i]) ."<br />ERROR: Undetermined.</p>\n";
 												}
 		}
 			}
 				}
 		printForm($id);
 		}
 		else
 		{
 		printForm($id);
 		}
	
	echo "<a href=\"#\" OnClick=\"window.opener.location.reload(true);self.close()\">Cerrar Ventana</a>";
?>

</body>
</html>

