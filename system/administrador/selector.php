<?php 
if(isset($_GET['menu'])){
	$menu = $_GET['menu'];
}
switch ($menu) {
	case 'cuenta':
		include('cuenta/detalle.php');
		break;
	case 'usuarios':
		include("users/users.php");
		break;
	case 'articulo':
		include("articulo/articulo.php");
		break;
	case 'biblioteca':
		include("biblioteca/biblioteca.php");
		break;
	case 'sitios':
		include("sitios/sitios.php");
		break;
	case 'organizacion':
		include("organizacion/index.php");
		break;

	default:

		break;
}
 ?>