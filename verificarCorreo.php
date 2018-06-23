<?php 
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}



require_once("system/connections/conexion.php"); 
require_once("system/connections/mail.php");

$correo = $_GET['correo'];
//$id_capacitacion = $_GET['id_capacitacion'];

/*$consultar = mysql_query("SELECT contacto_participante.correo_electronico FROM contacto_participante INNER JOIN capacitacion_participante ON contacto_participante.fk_id_participante = capacitacion_participante.fk_id_participante WHERE contacto_participante.correo_electronico = '$correo' AND capacitacion_participante.fk_id_capacitacion = $id_capacitacion", $conectar) or die(mysql_error());*/
$consultar = mysql_query("SELECT correo_electronico FROM contacto_participante WHERE correo_electronico = '$correo'",$conectar) or die(mysql_error());

$total = mysql_num_rows($consultar);
if($total > 0){
  echo '1';
}else{
  echo '0';
}

?>