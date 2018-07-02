<?php
$database = "mexorgan_db";
$hostname = "localhost";
//$database = "fa000006_dspp";
//$username = "root";
//$password = "";

$username = "mexorgan_user";
$password = "WZV)gznJFQU7";

$conectar = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 

?>
