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
	$id_capacitacion = $_GET['lista_asistentes'];

	$query = "SELECT capacitacion.titulo, detalle_capacitacion.cupo FROM capacitacion INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion WHERE capacitacion.id_capacitacion = $id_capacitacion";

	$row_capacitacion = mysql_query($query,$conectar) or die(mysql_error());
	$capacitacion = mysql_fetch_assoc($row_capacitacion);

	/// consultamos el cupo de participantes al curso
	$limite_participantes = '';

	$query = "SELECT COUNT(fk_id_participante) AS 'total_participantes' FROM capacitacion_participante WHERE fk_id_capacitacion = $id_capacitacion";
	$consultar = mysql_query($query, $conectar) or die(mysql_error());
	$total = mysql_fetch_assoc($consultar);


	$limite_participantes = $total['total_participantes'].' / '.$capacitacion['cupo'];

?>
<style>
	.informacion{
		color: #d35400;
	}
	.activo{
		color: #2ecc71;
	}
	.cancelado{
		color: #e74c3c;
	}
	.Suspendido{
		color: #e67e22;
	}
</style>



<h3>
	<a href="?menu=capacitacion&listado">Curso</a>: <span style="color: #2980b9"><?php echo $capacitacion['titulo']; ?></span> > <span style="color: #7f8c8d">Lista de asistentes</span> (<?php echo $limite_participantes; ?>)
</h3>

<?php 
	function consultarEstatus($tipo_curso,$estatus,$id){
		$color = '';
		if($estatus == 'ACTIVO'){
			$color = 'activo';
		}else if($estatus == 'SUSPENDIDO'){
			$color = 'suspendido';
		}else if($estatus == 'CANCELADO'){
			$color = 'cancelado';
		}
		echo "
			<span class='".$color." glyphicon glyphicon-bookmark'></span>
			<b>
				".$tipo_curso." (id: ".$id.")
			</b>
			";

	}
 
	/// CONSULTAR LISTADO DE ASISTENTES
	$query = "SELECT capacitacion_participante.fk_id_participante, participante.nombre, participante.apellido_paterno, participante.apellido_materno, participante.empresa, participante.comentario, contacto_participante.correo_electronico, contacto_participante.telefono FROM capacitacion_participante INNER JOIN participante ON capacitacion_participante.fk_id_participante = participante.id_participante INNER JOIN contacto_participante ON capacitacion_participante.fk_id_participante = contacto_participante.fk_id_participante WHERE capacitacion_participante.fk_id_capacitacion = $id_capacitacion";
	$row_lista = mysql_query($query, $conectar) or die(mysql_error());

 ?>


 <table id="my_table" class="table table-bordered table-condensed" style="font-size:12px;">
    <thead>
        <tr>
            <!-- id participante -->
            <th>
            	Id
            </th>

            <!-- nombre -->
            <th>
            	Nombre
            </th>

            <!-- apellido paterno -->
            <th>
            	Ap. Paterno
            </th>

			<!-- apellido materno -->
            <th>
            	Ap. Materno
            </th>

			<!-- empresa -->
            <th>
            	Empresa
            </th>

			<!-- comentario -->
            <th>
            	Comentario
            </th>
			<!-- correo -->
			<th>
				Email
			</th>

			<!-- telefono -->
			<th>
				Telefono
			</th>
        </tr>
    </thead>
    <tbody>
    	<?php 
    	while($lista = mysql_fetch_assoc($row_lista)){
    	?>
	        <tr>
	            <!-- id participante -->
	            <td>
	            	<?php echo $lista['fk_id_participante']; ?>
	            </td>

	            <!-- nombre -->
	            <td>
	            	<?php echo $lista['nombre']; ?>
	            </td>

	            <!-- apellido paterno -->
	            <td>
	            	<?php echo $lista['apellido_paterno']; ?>
	            </td>

				<!-- apellido materno -->
	            <td>
	            	<?php echo $lista['apellido_materno']; ?>
	            </td>

				<!-- empresa -->
	            <td>
	            	<?php echo $lista['empresa']; ?>
	            </td>

				<!-- comentario -->
	            <td>
	            	<?php echo $lista['comentario']; ?>
	            </td>
				<!-- correo -->
				<td>
					<?php echo $lista['correo_electronico']; ?>
				</td>

				<!-- telefono -->
				<td>
					<?php echo $lista['telefono']; ?>
				</td>
	        </tr>
    	<?php
    	}
    	 ?>
    </tbody>
</table>
