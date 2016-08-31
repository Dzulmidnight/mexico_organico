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
<h3>Listado Documentos</h3>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Titulo</th>
			<th>Descripción</th>
			<th>Archivo</th>
			<th>Usuario</th>
			<th>Fecha</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="border:hidden">
				<!-- EDITAR ARTICULO -->
				<a class="btn btn-sm btn-warning" style="display:inline" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=articulo&add_articulo&detalle=<?php echo $articulo['idarticulo']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
				<!-- ELIMINAR NOTA -->
				<form action="" method="POST" style="display:inline">
					<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Articulo" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_articulo" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
					<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
					<input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">
					<input type="hidden" name="img_articulo" value="<?php echo $articulo['img']; ?>">
				</form>
			</td>
		</tr>
	</tbody>
</table>