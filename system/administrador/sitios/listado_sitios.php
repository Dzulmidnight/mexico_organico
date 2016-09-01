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

	if(isset($_POST['eliminar_sitio']) && $_POST['eliminar_sitio'] == 1){
		$idsitio = $_POST['idsitio'];
		$img = $_POST['img'];

		unlink($img);
		$deleteSQL = sprintf("DELETE FROM sitios WHERE idsitio = %s",
			GetSQLValueString($idsitio, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE idsitio = %s",
			GetSQLValueString($idsitio, "int"));
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$mensaje = "Sitio Eliminado Correctamente";

	}

$query  = "SELECT sitios.*, usuario.username FROM sitios INNER JOIN usuario ON sitios.idusuario = usuario.idusuario";
$row_sitios = mysql_query($query,$conectar) or die(mysql_error());
$total_sitios = mysql_num_rows($row_sitios);

?>
<h3>Listado Sitios</h3>
<table class="table table-bordered" style="font-size:12px;">
	<thead>
		<tr class="success">
			<th class="text-center">ID</th>
			<th class="text-center">Nombre</th>
			<th class="text-center">Descripción</th>
			<th class="text-center">Img</th>
			<th class="text-center">URL</th>
			<th class="text-center">Usuario</th>
			<th class="text-center">Fecha</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if($total_sitios == 0){
			echo "
				<tr class='text-center info'>
					<td colspan='7'>No se encontraron registros</td>
				</tr>
			";
		}else{
			while($sitios = mysql_fetch_assoc($row_sitios)){
			?>
				<tr>
					<td><?php echo $sitios['idsitio']; ?></td>
					<td><?php echo $sitios['nombre']; ?></td>
					<td><?php echo $sitios['descripcion']; ?></td>
					<td><img src="<?php echo $sitios['img']; ?>" class="img-thumbnail" style="width:100px;" alt=""></td>
					<td><a href="<?php echo $sitios['url']; ?>" target="_new"><?php echo $sitios['url']; ?></a></td>
					<td><?php echo $sitios['username']; ?></td>
					<td><?php echo date('d/m/Y', $sitios['fecha_registro']); ?></td>
					<td>
						<!-- EDITAR ARTICULO -->
						<a class="btn btn-sm btn-warning"  data-toggle="tooltip" title="Visualizar | Editar" href="?menu=sitios&add_sitio&detalle=<?php echo $sitios['idsitio']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
						<!-- ELIMINAR NOTA -->
						<form action="" method="POST" >
							<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Documento" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_sitio" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
							<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
							<input type="hidden" name="idsitio" value="<?php echo $sitios['idsitio']; ?>">
							<input type="hidden" name="img" value="<?php echo $sitios['img']; ?>">
						</form>
					</td>
				</tr>
			<?php
			}
		}
		 ?>
	</tbody>
</table>