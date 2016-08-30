<a class="<?php if(isset($_GET['listado_organizacion'])){ echo 'btn btn-primary'; }else{ echo 'btn btn-default'; } ?>" href="?menu=organizacion&listado_organizacion">Listado Organizaciones</a>
<a class="<?php if(isset($_GET['add_organizacion'])){ echo 'btn btn-primary'; }else{ echo 'btn btn-default'; } ?>" href="?menu=organizacion&add_organizacion">Agregar Organización</a>
<?php 
if(isset($_GET['detail_organizacion'])){
?>
	<a class="btn btn-primary" href="#">Detalle Organización</a>
<?php
}
 ?>

<?php 
if(isset($_GET['add_organizacion'])){
	include('add_organizacion.php');
}else if(isset($_GET['detail_organizacion'])){
	include('detail_organizacion.php');
}else{
	include('listado_organizacion.php');
}
 ?>