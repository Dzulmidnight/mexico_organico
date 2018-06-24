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

	$id_administrador = $_SESSION['idusuario'];
	$id_capacitacion = $_GET['lista_asistentes'];

	/// SE CARGA EL COMPROBANTE POR UN ADMINISTRADOR
	if(isset($_POST['cargar_comprobante']) && $_POST['cargar_comprobante'] == 1){
		/// INSERTAMOS EL COMPROBANTE DE PAGO

		if(!empty($_FILES['comprobante_pago']['name'])){
			$ruta_img = "../img/comprobantes/";
			$ruta_img = $ruta_img . basename( $_FILES['comprobante_pago']['name']); 
			if(move_uploaded_file($_FILES['comprobante_pago']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}
		$fk_id_participante = $_POST['fk_id_participante'];
		$archivo = $ruta_img;
		$estatus = 'AUTORIZADO';
		$aprobado_por = $id_administrador;
		$fecha_registro = $_POST['fecha_registro'];
		$id_capacitacion_participante = $_POST['id_capacitacion_participante'];


		$query = sprintf("INSERT INTO comprobante_pago(fk_id_participante, archivo, estatus, aprobado_por, fecha_registro, fecha_aprobacion) VALUES (%s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($fk_id_participante, "text"),
           GetSQLValueString($archivo, "text"),
           GetSQLValueString($estatus, "text"),
           GetSQLValueString($aprobado_por, "int"),
           GetSQLValueString($fecha_registro, "int"),
           GetSQLValueString($fecha_registro, "text"));

		$insertar = mysql_query($query,$conectar) or die(mysql_error()); 

		$id_comprobante_pago = mysql_insert_id($conectar);
		$estatus = 'VERIFICADO';

		/// ACTUALIZAMOS LA TABLA capacitacion_participante
		$query = sprintf("UPDATE capacitacion_participante SET fk_id_comprobante_pago = %s, estatus = %s WHERE id_capacitacion_participante = %s",
			GetSQLValueString($id_comprobante_pago, "int"),
			GetSQLValueString($estatus, "text"),
			GetSQLValueString($id_capacitacion_participante, "int"));
		$actualizar = mysql_query($query, $conectar) or die(mysql_error());

	}

	// SE APRUEBA UN COMPROBANTE CARGADO
	if(isset($_POST['aprobar_comprobante']) && $_POST['aprobar_comprobante'] == 1){
		/// INSERTAMOS EL COMPROBANTE DE PAGO

		$id_capacitacion_participante = $_POST['id_capacitacion_participante'];
		$id_comprobante_pago = $_POST['id_comprobante_pago'];
		$estatus = 'AUTORIZADO';
		$aprobado_por = $id_administrador;
		$fecha_aprobacion = $_POST['fecha_aprobacion'];
		$id_capacitacion_participante = $_POST['id_capacitacion_participante'];
		$monto_depositado = $_POST['monto_depositado'];

		$query = sprintf("UPDATE comprobante_pago SET estatus = %s, monto_depositado = %s, aprobado_por = %s, fecha_aprobacion = %s WHERE id_comprobante_pago = %s", 
           GetSQLValueString($estatus, "text"),
           GetSQLValueString($monto_depositado, "int"),
           GetSQLValueString($aprobado_por, "int"),
           GetSQLValueString($fecha_aprobacion, "int"),
           GetSQLValueString($id_comprobante_pago, "text"));

		$actualizar = mysql_query($query,$conectar) or die(mysql_error()); 

		$estatus = 'VERIFICADO';

		/// ACTUALIZAMOS LA TABLA capacitacion_participante
		$query = sprintf("UPDATE capacitacion_participante SET estatus = %s WHERE id_capacitacion_participante = %s",
			GetSQLValueString($estatus, "text"),
			GetSQLValueString($id_capacitacion_participante, "int"));
		$actualizar = mysql_query($query, $conectar) or die(mysql_error());

	}


	$query = "SELECT capacitacion.titulo, detalle_capacitacion.cupo FROM capacitacion INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion WHERE capacitacion.id_capacitacion = $id_capacitacion";

	$row_capacitacion = mysql_query($query,$conectar) or die(mysql_error());
	$capacitacion = mysql_fetch_assoc($row_capacitacion);

	/// consultamos el cupo de participantes al curso
	$limite_participantes = '';

	$query = "SELECT COUNT(fk_id_participante) AS 'total_participantes' FROM capacitacion_participante WHERE fk_id_capacitacion = $id_capacitacion AND estatus = 'VERIFICADO'";
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
	$query = "SELECT capacitacion_participante.id_capacitacion_participante, capacitacion_participante.fk_id_participante, capacitacion_participante.fk_id_comprobante_pago, capacitacion_participante.estatus, detalle_capacitacion.costo, participante.nombre, participante.apellido_paterno, participante.apellido_materno, participante.empresa, participante.comentario, contacto_participante.correo_electronico, contacto_participante.telefono, comprobante_pago.estatus AS 'estatus_comprobante', comprobante_pago.archivo FROM capacitacion_participante INNER JOIN detalle_capacitacion ON capacitacion_participante.fk_id_capacitacion = detalle_capacitacion.fk_id_capacitacion INNER JOIN participante ON capacitacion_participante.fk_id_participante = participante.id_participante INNER JOIN contacto_participante ON capacitacion_participante.fk_id_participante = contacto_participante.fk_id_participante LEFT JOIN comprobante_pago ON capacitacion_participante.fk_id_comprobante_pago = comprobante_pago.id_comprobante_pago WHERE capacitacion_participante.fk_id_capacitacion = $id_capacitacion";
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
				if(!empty($lista['fk_id_comprobante_pago']) && $lista['estatus_comprobante'] != 'AUTORIZADO'){
				?>
	            	<button class="btn btn-xs btn-info" style="width: 100%" data-toggle="modal" data-target="<?php echo '#modalComprobantePago'.$lista['fk_id_participante']; ?>">
	            		En espera
	            	</button>

					<div class="modal fade" id="<?php echo 'modalComprobantePago'.$lista['fk_id_participante']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form action="" method="post" enctype="multipart/form-data">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Comprobante de pago: <span style="color:red"><?php echo $lista['nombre']; ?></span></h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<p>Archivo comprobante</p>
												<a href="../../<?php echo $lista['archivo']; ?>" target="_new" class="btn btn-primary">Consultar comprobante</a>
											</div>
											<div class="col-md-3">
												<p>Precio por persona</p>
												<p class="alert alert-success" style="padding:7px;">
													$ <?php echo number_format($lista['costo']); ?>
												</p>
											</div>
											<div class="col-md-3">
												<p>Cantidad depositada</p>
												<div class="input-group">
													<span class="input-group-addon">$</span>
												  	<input type="number" class="form-control" name="monto_depositado" id="monto_depositado" placeholder="Cantidad depositada" required>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="fecha_aprobacion" value="<?php echo time(); ?>">
										<input type="text" name="id_capacitacion_participante" value="<?php echo $lista['id_capacitacion_participante']; ?>">
										<input type="hidden" name="fk_id_participante" value="<?php echo $lista['fk_id_participante']; ?>">
										<input type="text" name="id_comprobante_pago" value="<?php echo $lista['fk_id_comprobante_pago']; ?>">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
										<button type="submit" name="aprobar_comprobante" value="1" class="btn btn-success">Aprobar comprobante</button>
									</div>
								</form>
							</div>
						</div>
					</div>

				<?php
				}else if($lista['estatus_comprobante'] == 'AUTORIZADO'){
				?>
					<a href="<?php echo $lista['archivo']; ?>" target="_new" class="btn btn-xs btn-success" style="width:100%">Autorizado</a>
				<?php
				}else{
				?>
	            	<button class="btn btn-xs btn-default" style="width: 100%" data-toggle="modal" data-target="<?php echo '#comprobantePago'.$lista['fk_id_participante']; ?>">
	            		Consultar
	            	</button>

					<div class="modal fade" id="<?php echo 'comprobantePago'.$lista['fk_id_participante']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form action="" method="post" enctype="multipart/form-data">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Comprobante de pago: <span style="color:red"><?php echo $lista['nombre']; ?></span></h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<label for="comprobante_pago">Cargar Comprobante</label>
												<input type="file" class="form-control" name="comprobante_pago" id="comprobante_pago">
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="fecha_registro" value="<?php echo time(); ?>">
										<input type="hidden" name="fk_id_participante" value="<?php echo $lista['fk_id_participante']; ?>">
										<input type="hidden" name="id_capacitacion_participante" value="<?php echo $lista['id_capacitacion_participante']; ?>">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
										<button type="submit" name="cargar_comprobante" value="1" class="btn btn-success">Aprobar comprobante</button>
									</div>
								</form>
							</div>
						</div>
					</div>

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


