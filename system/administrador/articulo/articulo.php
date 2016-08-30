<?php 
	if($_SESSION["autentificado"] == false){
		header("Location: ../../login.php");
	}
	mysql_select_db($database, $conectar);

 ?>

<div class="row">
	<div class="col-md-12">
		<?php 

		if(isset($_GET['listado'])){
			$clase1 = "btn btn-primary";
		}else{
			$clase1 = "btn btn-default";
		}
		if(isset($_GET['add_articulo'])){
			$clase2 = "btn btn-primary";
		}else{
			$clase2 = "btn btn-default";
		}
		if(isset($_GET['add_segmento'])){
			$clase3 = "btn btn-primary";
		}else{
			$clase3 = "btn btn-default";
		}
		 ?>
		<a class="<?php echo $clase1; ?>" href="?menu=articulo&listado">Listado</a>
		<a class="<?php echo $clase2; ?>" href="?menu=articulo&add_articulo">Agregar Articulo</a>
		<!--<a class="<?php echo $clase3; ?>" href="?menu=articulo&add_segmento">Agregar Segmento</a>-->
	</div>

	<div class="col-md-12">
		<?php 
		if(isset($_GET['add_articulo'])){
			include("add_articulo.php");
		}else if(isset($_GET['add_segmento'])){
			include("add_segmento.php");
		}else{
			include("listado_articulo.php");
		}
		 ?>
	</div>
</div>