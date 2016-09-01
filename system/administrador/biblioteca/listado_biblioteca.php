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

	if(isset($_POST['eliminar_documento']) && $_POST['eliminar_documento'] == 1){
		$idbiblioteca = $_POST['idbiblioteca'];
		$archivo = $_POST['archivo'];

		unlink($archivo);
		$deleteSQL = sprintf("DELETE FROM biblioteca WHERE idbiblioteca = %s",
			GetSQLValueString($idbiblioteca, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE idbiblioteca = %s",
			GetSQLValueString($idbiblioteca, "int"));
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$mensaje = "Articulo Eliminado Correctamente";

	}

$query  = "SELECT biblioteca.*, usuario.username FROM biblioteca INNER JOIN usuario ON biblioteca.idusuario = usuario.idusuario";
$row_biblioteca = mysql_query($query,$conectar) or die(mysql_error());
$total_biblioteca = mysql_num_rows($row_biblioteca);

?>
<h3>Listado Documentos</h3>
<table class="table table-bordered" style="font-size:12px;">
	<thead>
		<tr class="success">
			<th class="text-center">ID</th>
			<th class="text-center">Titulo</th>
			<th class="text-center">Descripción</th>
			<th class="text-center">Archivo</th>
			<th class="text-center">Usuario</th>
			<th class="text-center">Fecha</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if($total_biblioteca == 0){
			echo "
				<tr class='text-center info'>
					<td colspan='6'>No se encontraron registros</td>
				</tr>
			";
		}else{
			while($biblioteca = mysql_fetch_assoc($row_biblioteca)){
			?>
				<tr>
					<td><?php echo $biblioteca['idbiblioteca']; ?></td>
					<td><?php echo $biblioteca['titulo']; ?></td>
					<td><?php echo $biblioteca['descripcion']; ?></td>
					<td><a class="btn btn-primary" href="<?php echo $biblioteca['archivo']; ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Descargar</a></td>
					<td><?php echo $biblioteca['username']; ?></td>
					<td><?php echo date('d/m/Y', $biblioteca['fecha_registro']); ?></td>
					<td>
						<!-- EDITAR ARTICULO -->
						<a class="btn btn-sm btn-warning"  data-toggle="tooltip" title="Visualizar | Editar" href="?menu=biblioteca&add_documento&detalle=<?php echo $biblioteca['idbiblioteca']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
						<!-- ELIMINAR NOTA -->
						<form action="" method="POST" >
							<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Documento" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_documento" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
							<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
							<input type="hidden" name="idbiblioteca" value="<?php echo $biblioteca['idbiblioteca']; ?>">
							<input type="hidden" name="archivo" value="<?php echo $biblioteca['archivo']; ?>">
						</form>
					</td>
				</tr>
			<?php
			}
		}
		 ?>
	</tbody>
</table>