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
 ?>

<a class="<?php if(isset($_GET['listado_organizacion']) || isset($_GET['add_organizacion']) || isset($_GET['detail_organizacion'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default'; } ?>" href="?menu=organizacion&listado_organizacion">Organizaciones</a>
<a class="<?php if(isset($_GET['listado_ciclo']) || isset($_GET['add_ciclo'])){ echo 'btn btn-primary'; }else{ echo 'btn btn-default'; } ?>" href="?menu=organizacion&listado_ciclo">Ciclos</a>
<hr>

<?php 
	if(isset($_GET['listado_organizacion']) || isset($_GET['add_organizacion']) || isset($_GET['detail_organizacion'])){
		//include('listado_organizaciones.php');
		include('selector_organizacion.php');
	}
	if(isset($_GET['listado_ciclo']) || isset($_GET['add_ciclo'])){
		include('ciclo/listado_ciclo.php');

	}
 ?>		
