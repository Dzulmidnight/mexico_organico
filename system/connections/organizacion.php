<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_organizacion = "localhost";
$database_organizacion = "kafeprod_bio";
$username_organizacion = "root";
$password_organizacion = "";
$organizacion = mysql_pconnect($hostname_organizacion, $username_organizacion, $password_organizacion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>