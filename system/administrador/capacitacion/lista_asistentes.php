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
		$fk_id_participante = $_POST['fk_id_participante'];

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

		/// ENVIAMOS UN CORREO AL PARTICIPANTE, SE HA APROBADO SU COMPROBANTE DE PAGO
		$query = "SELECT contacto_participante.correo_electronico, capacitacion.titulo, capacitacion.telefono_capacitacion, capacitacion.correo_capacitacion FROM capacitacion_participante INNER JOIN contacto_participante ON capacitacion_participante.fk_id_participante = contacto_participante.fk_id_participante INNER JOIN capacitacion ON capacitacion_participante.fk_id_capacitacion = capacitacion.id_capacitacion WHERE capacitacion_participante.id_capacitacion_participante = $id_capacitacion_participante";
		$consultar = mysql_query($query, $conectar) or die(mysql_error());
		$participante = mysql_fetch_assoc($consultar);


        $asunto = 'Pago de curso verificado'; 

        $cuerpo = '
        <html>
        <head>
        <meta charset="utf-8">

        <style>
          table, td, th {    
              border: 1px solid #ddd;
              text-align: left;
          }

          table {
              border-collapse: collapse;
              width: 100%;
          }

          th, td {
              padding: 15px;
          }
        </style>

        </head>
        <body>

            <table style="font-family: Tahoma, Geneva, sans-serif; font-size: 13px; color: #2c3e50">
              <thead>
                <tr>
                  <th rowspan="7" scope="col" align="center" valign="middle" height="100%">
                    <img src="http://mexorganico.com/assets/img/menu.png" alt="Mexico Organico" width="120" height="120" />
                  </th>
                  <th>
                    <h3>
                      Pago de curso verfificado
                    </h3>
                  </th>
                </tr>
              </thead>
              <tbody>
                    <tr>
                      <td colspan="2" style="text-align:justify;padding-top:30px;">
                        El comprobante de pago del curso ha sido verfificado, queda formalmente registrado al curso: "<span style="color:#e74c3c">'.$participante['titulo'].'</span>""
                      </td>
                    </tr>
	                <tr>
	                  <td colspan="2">
	                    Cualquier duda o pregunta puede ponerse en contacto al correo: <b>'.$participante['correo_capacitacion'].'</b> o al Telefono: <b>'.$participante['telefono_capacitacion'].'</b>
	                  </td>
	                </tr>
              </tbody>
            </table>

        </body>
        </html>
    ';
      $mail->AddAddress($participante['correo_capacitacion']);
      $mail->AddAttachment($archivo);
      //$mail->AddBCC($administrador);
      //$mail->Username = "soporte@d-spp.org";
      //$mail->Password = "/aung5l6tZ";
      $mail->Subject = utf8_decode($asunto);
      $mail->Body = utf8_decode($cuerpo);
      $mail->MsgHTML(utf8_decode($cuerpo));
      $mail->Send();
      $mail->ClearAddresses();

	}

	/// SE CREA UN NUEVO ASISTENTE
	if(isset($_POST['agregar_asistente']) && $_POST['agregar_asistente'] == 1){
		$nombre = $_POST['nombre'];
		$correo_electronico = $_POST['correo_electronico'];
		$id_capacitacion = $_POST['id_capacitacion'];
	 
	 	$query = "SELECT contacto_participante.correo_electronico FROM contacto_participante INNER JOIN participante ON contacto_participante.fk_id_participante = participante.id_participante INNER JOIN capacitacion_participante ON contacto_participante.fk_id_participante = capacitacion_participante.fk_id_participante WHERE correo_electronico = '$correo_electronico' AND capacitacion_participante.fk_id_capacitacion = '$id_capacitacion'";
	 	$resultado = mysql_query($query, $conectar) or die(mysql_error());
	 	$fila = mysql_num_rows($resultado);

	    if($fila == 0){

			if(isset($_POST['fecha_registro'])){
				$fecha_registro = $_POST['fecha_registro'];
			}else{
				$fecha_registro = '';
			}
			if(isset($_POST['id_capacitacion'])){
				$id_capacitacion = $_POST['id_capacitacion'];
			}else{
				$id_capacitacion = '';
			}
			if(isset($_POST['titulo'])){
				$titulo = $_POST['titulo'];
			}else{
				$titulo = '';
			}
			if(isset($_POST['lada'])){
				$lada = $_POST['lada'];
			}else{
				$lada = '';
			}
			if(isset($_POST['telefono'])){
				$telefono = $_POST['telefono'];
			}else{
				$telefono = '';
			}
			if(isset($_POST['nombre'])){
				$nombre = $_POST['nombre'];
			}else{
				$nombre = '';
			}
			if(isset($_POST['apellido_paterno'])){
				$apellido_paterno = $_POST['apellido_paterno'];
			}else{
				$apellido_paterno = '';
			}
			if(isset($_POST['apellido_materno'])){
				$apellido_materno = $_POST['apellido_materno'];
			}else{
				$apellido_materno = '';
			}
			if(isset($_POST['empresa'])){
				$empresa = $_POST['empresa'];
			}else{
				$empresa = '';
			}
			if(isset($_POST['comentario'])){
				$comentario = $_POST['comentario'];
			}else{
				$comentario = '';
			}

	        $telefono_completo = $lada.' '.$telefono;
	        $estatus = 'EN ESPERA';

	        //// ENVIAMOS CORREO DE REGISTRO AL CURSO
	        function codigo($length = 8) {
	            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	            $charactersLength = strlen($characters);
	            $randomString = '';
	            for ($i = 0; $i < $length; $i++) {
	                $randomString .= $characters[rand(0, $charactersLength - 1)];
	            }
	            return $randomString;
	        }

	        $elcodigo = codigo();

	        $query = sprintf("INSERT INTO participante (codigo, nombre, apellido_paterno, apellido_materno, empresa, comentario, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s, %s)", 
	           GetSQLValueString($elcodigo, "text"),
	           GetSQLValueString($nombre, "text"),
	           GetSQLValueString($apellido_paterno, "text"),
	           GetSQLValueString($apellido_materno, "text"),
	           GetSQLValueString($empresa, "text"),
	           GetSQLValueString($comentario, "text"),
	           GetSQLValueString($fecha_registro, "int"));

	        $insertar = mysql_query($query, $conectar) or die(mysql_error());

	        $id_participante = mysql_insert_id($conectar);
	        /// creamos los datos de contacto del participante
	        $query = sprintf("INSERT INTO contacto_participante (fk_id_participante, correo_electronico, lada, telefono, fecha_registro) VALUES (%s, %s, %s, %s, %s)", 
	           GetSQLValueString($id_participante, "int"),
	           GetSQLValueString($correo_electronico, "text"),
	           GetSQLValueString($lada, "text"),
	           GetSQLValueString($telefono, "text"),
	           GetSQLValueString($fecha_registro, "int"));
	        $insertar = mysql_query($query, $conectar) or die(mysql_error());
	        /// creamos la relacion entre la capacitacion y el participante
	        $query = sprintf("INSERT INTO capacitacion_participante (fk_id_capacitacion, fk_id_participante, estatus) VALUES (%s, %s, %s)", 
	           GetSQLValueString($id_capacitacion, "int"),
	           GetSQLValueString($id_participante, "int"),
	           GetSQLValueString($estatus, "text"));
	        $insertar = mysql_query($query, $conectar) or die(mysql_error());
	    }else{
	    	echo "<script>alert('Este asistente ya se encuentra registrado.')</script>";
	    }


	}

	/// actualizar la información del asistente
	if(isset($_POST['actualizar_registro']) && $_POST['actualizar_registro'] == 1){
		$id_participante = $_POST['id_participante'];
		$correo_electronico = $_POST['correo_electronico'];
		$telefono = $_POST['telefono'];
		$lada = $_POST['lada'];
		$nombre = $_POST['nombre'];
		$apellido_paterno = $_POST['apellido_paterno'];
		$apellido_materno = $_POST['apellido_materno'];
		$empresa = $_POST['empresa'];
		$comentario = $_POST['comentario'];
		$fecha_modificacion = $_POST['fecha_modificacion'];


		$query = sprintf("UPDATE participante SET nombre = %s, apellido_paterno = %s, apellido_paterno = %s, empresa = %s, comentario = %s, fecha_modificacion = %s WHERE id_participante = %s",
			GetSQLValueString($nombre, "text"),
			GetSQLValueString($apellido_paterno, "text"),
			GetSQLValueString($apellido_materno, "text"),
			GetSQLValueString($empresa, "text"),
			GetSQLValueString($comentario, "text"),
			GetSQLValueString($fecha_modificacion, "int"),
			GetSQLValueString($id_participante, "int"));
		$actualizar = mysql_query($query, $conectar) or die(mysql_error());

		$query = sprintf("UPDATE contacto_participante SET correo_electronico = %s, lada = %s, telefono = %s, fecha_modificacion = %s WHERE fk_id_participante = %s",
			GetSQLValueString($correo_electronico, "text"),
			GetSQLValueString($lada, "text"),
			GetSQLValueString($telefono, "text"),
			GetSQLValueString($fecha_modificacion, "int"),
			GetSQLValueString($id_participante, "int"));
		$actualizar = mysql_query($query, $conectar) or die(mysql_error());


	}

	//// eliminamos el asistente

	if(isset($_POST['eliminar_asistente']) && $_POST['eliminar_asistente'] == 1){
		$id_capacitacion = $_GET['lista_asistentes'];
		$id_participante = $_POST['id_participante'];

		$query = sprintf("DELETE FROM capacitacion_participante WHERE fk_id_capacitacion = %s AND fk_id_participante = %s",
			GetSQLValueString($id_capacitacion, "int"),
			GetSQLValueString($id_participante, "int"));
		$eliminar = mysql_query($query, $conectar) or die(mysql_error());

		$query = sprintf("DELETE FROM participante WHERE id_participante = %s",
			GetSQLValueString($id_participante, "int"));
		$eliminar = mysql_query($query, $conectar) or die(mysql_error());

		$query = sprintf("DELETE FROM contacto_participante WHERE fk_id_participante = %s",
			GetSQLValueString($id_participante, "int"));
		$eliminar = mysql_query($query, $conectar) or die(mysql_error());

		echo '<script>alert("Se ha eliminado un asistente")</script>';

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
	$query = "SELECT capacitacion_participante.id_capacitacion_participante, capacitacion_participante.fk_id_participante, capacitacion_participante.fk_id_comprobante_pago, capacitacion_participante.estatus, detalle_capacitacion.costo, participante.nombre, participante.apellido_paterno, participante.apellido_materno, participante.empresa, participante.comentario, contacto_participante.correo_electronico, contacto_participante.lada, contacto_participante.telefono, comprobante_pago.estatus AS 'estatus_comprobante', comprobante_pago.archivo FROM capacitacion_participante INNER JOIN detalle_capacitacion ON capacitacion_participante.fk_id_capacitacion = detalle_capacitacion.fk_id_capacitacion INNER JOIN participante ON capacitacion_participante.fk_id_participante = participante.id_participante INNER JOIN contacto_participante ON capacitacion_participante.fk_id_participante = contacto_participante.fk_id_participante LEFT JOIN comprobante_pago ON capacitacion_participante.fk_id_comprobante_pago = comprobante_pago.id_comprobante_pago WHERE capacitacion_participante.fk_id_capacitacion = $id_capacitacion";
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
	<div class="col-md-2">
		Estatus: <span class="verificado glyphicon glyphicon-ok" data-toggle="tooltip" title="VERIFICADO"></span> <span class="enEspera glyphicon glyphicon-time" data-toggle="tooltip" title="EN ESPERA"></span> <span class="cancelado glyphicon glyphicon-ban-circle" data-toggle="tooltip" title="CANCELADO"></span>
	</div>
	<div class="col-md-2 col-md-push-8 text-right">
		<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAgregarAsistente">
			<span class="glyphicon glyphicon-plus"></span> Agregar asistente
		</button>
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
												<a href="../../<?php echo $lista['archivo']; ?>" target="_blank" class="btn btn-primary">Consultar comprobante</a>
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
										<input type="hidden" name="id_capacitacion_participante" value="<?php echo $lista['id_capacitacion_participante']; ?>">
										<input type="hidden" name="fk_id_participante" value="<?php echo $lista['fk_id_participante']; ?>">
										<input type="hidden" name="id_comprobante_pago" value="<?php echo $lista['fk_id_comprobante_pago']; ?>">
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
					<a href="../../<?php echo $lista['archivo']; ?>" target="_blank" class="btn btn-xs btn-success" style="width:100%">Autorizado</a>
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
												<input type="file" class="form-control" name="comprobante_pago" id="comprobante_pago" required>
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
					<?php echo '<span style="color:red">('.$lista['lada'].')</span> '.$lista['telefono']; ?>
				</td>

				<!-- acciones -->
				<td>
					<div class="dropdown">
						<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Acciones <span class="caret"></span>
						</button>
							<ul class="dropdown-menu" aria-labelledby="dLabel">
								<li>
									<a href="#" data-toggle="modal" data-target="#modalEditarAsistente<?php echo $lista['fk_id_participante']; ?>">Editar</a>
								</li>
								<form action="" method="POST">
									<li style="margin-left:12px;">
										<input type="hidden" name="id_participante" value="<?php echo $lista['fk_id_participante']; ?>">
										<button class="btn-link" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_asistente" value="1">
											Eliminar
										</button>
									</li>
								</form>
							</ul>
					</div>
				</td>
	        </tr>

			<!--- MODAL EDITAR ASISTENTE -->

			<div class="modal fade" id="<?php echo 'modalEditarAsistente'.$lista['fk_id_participante']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditarAsistente">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <form id="miForm" action="" method="POST">
			                <div class="modal-header">
			                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                    <h4 class="modal-title" id="asd">Editar Información del asistente: <span style="color:red"><?php echo $lista['nombre']; ?></span></h4>
			                </div>
			                <div class="modal-body">
			                    <div class="row">
			                      <div class="col-md-12" id="divMostrar"></div>
			                        <div class="col-md-12">
			                            <label for="correo_electronico">* Correo Electronico</label>
			                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?php echo $lista['correo_electronico']; ?>" required>
			                        </div>
			                        <div class="col-md-12">
			                            <label for="correo">* Telefono</label>
			                            <div class="row">
			                                <div class="col-sm-4">
			                                    <input type="text" class="form-control" name="lada" placeholder="lada" value="<?php echo $lista['lada']; ?>">
			                                </div>
			                                <div class="col-sm-8">
			                                   <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono" value="<?php echo $lista['telefono'] ?>" required> 
			                                </div>
			                            </div>
			                        </div>
			                        <div class="col-md-12">
			                            <label for="nombre">* Nombre</label>
			                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $lista['nombre']; ?>" required>
			                        </div>
			                        <div class="col-md-6">
			                            <label for="apellido_paterno">* Apellido Paterno</label>
			                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?php echo $lista['apellido_paterno'] ?>" required>
			                        </div>
			                        <div class="col-md-6">
			                            <label for="apellido_materno">Apellido Materno</label>
			                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?php echo $lista['apellido_materno']; ?>">
			                        </div>
			                        <div class="col-md-12">
			                            <label for="empresa">Empresa</label>
			                            <input type="text" class="form-control" id="empresa" name="empresa" value="<?php echo $lista['empresa']; ?>">
			                        </div>
			                        <div class="col-md-12">
			                            <label for="comentario">Comentario</label>
			                            <textarea class="form-control" name="comentario" id="comentario" rows="3"><?php echo $lista['comentario']; ?></textarea>
			                        </div>

			                    </div>
			                </div>
			                <div class="modal-footer">

			                    <input type="hidden" id="fecha_modificacion" name="fecha_modificacion" value="<?php echo time() ?>">
			                    <input type="hidden" id="id_participante" name="id_participante" value="<?php echo $lista['fk_id_participante']; ?>">
			                    <input type="hidden" id="titulo" name="titulo" value="<?php echo $capacitacion['titulo']; ?>">
			                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			                    <button type="submit" id="actualizar_registro" name="actualizar_registro" value="1" class="btn btn-warning">Actualizar datos</button>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>


    	<?php
    	}
    	 ?>
    </tbody>
</table>

<!--- SECCIÓN DE MODALES -->

<div class="modal fade" id="modalAgregarAsistente" tabindex="-1" role="dialog" aria-labelledby="modalAgregarAsistente">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="miForm" action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="asd">Registro de participante</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12" id="divMostrar"></div>
                        <div class="col-md-12">
                            <label for="correo_electronico">* Correo Electronico</label>
                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                        </div>
                        <div class="col-md-12">
                            <label for="correo">* Telefono</label>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="lada" placeholder="lada">
                                </div>
                                <div class="col-sm-8">
                                   <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono" required> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="nombre">* Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido_paterno">* Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido_materno">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno">
                        </div>
                        <div class="col-md-12">
                            <label for="empresa">Empresa</label>
                            <input type="text" class="form-control" id="empresa" name="empresa">
                        </div>
                        <div class="col-md-12">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="3"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">

                    <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo time() ?>">
                    <input type="hidden" id="id_capacitacion" name="id_capacitacion" value="<?php echo $_GET['lista_asistentes']; ?>">
                    <input type="hidden" id="titulo" name="titulo" value="<?php echo $capacitacion['titulo']; ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="agregar_asistente" name="agregar_asistente" value="1" class="btn btn-success">Crear registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

