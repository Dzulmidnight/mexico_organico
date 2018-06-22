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


	if(isset($_POST['cargar_comprobante']) && $_POST['cargar_comprobante'] == 1){
		if(!empty($_FILES['img']['name'])){
			$ruta_img = "../img/comprobantes/";
			$ruta_img = $ruta_img . basename( $_FILES['img']['name']); 
			if(move_uploaded_file($_FILES['img']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}

	}

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
	$query = "SELECT capacitacion_participante.id_capacitacion_participante, capacitacion_participante.fk_id_participante, capacitacion_participante.fk_id_comprobante_pago, capacitacion_participante.estatus, participante.nombre, participante.apellido_paterno, participante.apellido_materno, participante.empresa, participante.comentario, contacto_participante.correo_electronico, contacto_participante.telefono FROM capacitacion_participante INNER JOIN participante ON capacitacion_participante.fk_id_participante = participante.id_participante INNER JOIN contacto_participante ON capacitacion_participante.fk_id_participante = contacto_participante.fk_id_participante WHERE capacitacion_participante.fk_id_capacitacion = $id_capacitacion";
	$row_lista = mysql_query($query, $conectar) or die(mysql_error());

 ?>
<style>
	.verificado{
		color: #27ae60;
	}
	.enEspera{
		color: #f39c12;
	}
	.cancelado{
		color: #e74c3c;
	}
</style>

<?php 
	function estatus($estatus){
		$estatus_participante = '';

		if($estatus == 'VERIFICADO'){
			$estatus_participante = '<span class="verificado glyphicon glyphicon-ok"></span>';
		}else if($estatus == 'EN ESPERA'){
			$estatus_participante = '<span class="enEspera glyphicon glyphicon-time"></span>';
		}else{
			$estatus_participante = '<span class="cancelado glyphicon glyphicon-ban-circle"></span>';
		}
		echo $estatus_participante;
	}
 ?>
<div class="row">
	<div class="col-md-12">
		Estatus: <span class="verificado glyphicon glyphicon-ok" data-toggle="tooltip" title="VERIFICADO"></span> <span class="enEspera glyphicon glyphicon-time" data-toggle="tooltip" title="EN ESPERA"></span> <span class="cancelado glyphicon glyphicon-ban-circle" data-toggle="tooltip" title="CANCELADO"></span>
	</div>
</div>

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
            <!-- comprobante de pago -->
            <th>
            	Comprobante
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
			<!-- acciones -->
			<th>
			
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
					<?php estatus($lista['estatus']) ?>
	            	<?php echo $lista['fk_id_participante']; ?>
	            </td>

	            <!-- nombre -->
	            <td>
	            	<?php echo $lista['nombre']; ?>
	            </td>
	            <!-- comprobante de pago -->
	            <td>
				<?php 
				if(!empty($lista['fk_id_comprobante_pago'])){
				?>
	            	<button class="btn btn-xs btn-info" style="width: 100%" data-toggle="modal" data-target="#modalComprobantePago">
	            		En espera
	            	</button>
				<?php
				}else{
				?>
	            	<button class="btn btn-xs btn-default" style="width: 100%" data-toggle="modal" data-target="#modalComprobantePago" <?php echo 'onclick="llamarModal('.$lista['id_capacitacion_participante'].')"' ?>>
	            		Consultar
	            	</button>
				<?php
				}
				 ?>
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

				<!-- acciones -->
				<td>
					<button class="btn btn-sm btn-danger">
						<span class="glyphicon glyphicon-remove"></span>
					</button>
				</td>
	        </tr>
    	<?php
    	}
    	 ?>
    </tbody>
</table>


<!-- Modal -->
<?php 
echo '<script>';
	echo 'var id;';
	echo 'var id2;';
	echo 'function llamarModal(id){';
		echo 'var id2 = id';
		echo 'return id2';
	echo '}';

echo '</script>';
$variablePHP = "<script> document.write(id2) </script>";
 ?>

	<div class="modal fade" id="modalComprobantePago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Comprobante de pago</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<?php echo $variablePHP; ?>
								<label for="comprobante_pago">Cargar Comprobante</label>
								<input type="file" class="form-control" name="comprobante_pago" id="comprobante_pago">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="text" name="fecha_registro" value="<?php echo time(); ?>">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
