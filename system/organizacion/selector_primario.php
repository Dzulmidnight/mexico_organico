<?php 

if(isset($_GET['menu'])){
	$menu = $_GET['menu'];
}
switch ($menu) {
	case 'ciclo':
		include('ciclo/listado_ciclo.php');
		break;
	case 'cuenta':
		include("cuenta/detail_cuenta.php");
		break;
	case 'articulo':
		include("articulo/articulo.php");
		break;
	
	default:
		include('ciclo/listado_ciclo.php');
		break;
}



 ?>


