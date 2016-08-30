<?php
ob_start(); 
	session_start();
	#evaluo que la sesion continue verificando una de las variables creadas en control.php, cuando esta ya no coincida con el valor incial se redirige al archivo de salir.php
	if($_SESSION["autentificado"] == false){
		header("Location: ../login.php");
	}
ob_end_flush();	
 ?>