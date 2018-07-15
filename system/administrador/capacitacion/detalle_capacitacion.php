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
	/*
	ENCABEZADO: Son notas que se mostraran en el carousel
	CUERPO: Son notas que se mostraran en la sección de noticias
	*/

	$fecha = time();
	$id_usuario = $_SESSION['idusuario'];
	$id_capacitacion = $_GET['detalle_capacitacion'];


	if(isset($_POST['agregar_capacitacion']) && $_POST['agregar_capacitacion'] == 1){

		$fecha_registro = $_POST['fecha'];

		if(!empty($_FILES['img']['name'])){
			$ruta_img = "../img/capacitaciones/";
			$ruta_img = $ruta_img . basename( $_FILES['img']['name']); 
			if(move_uploaded_file($_FILES['img']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}

		//// CREAMOS LA CAPACITACIÓN
		$idusuario = $_POST['idusuario'];
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		$contenido = $_POST['contenido'];
		$correo_capacitacion = $_POST['correo_capacitacion'];
		$telefono_capacitacion = $_POST['telefono_capacitacion'];
		$estatus = 'ACTIVO';

		$query = sprintf("INSERT INTO capacitacion (titulo, descripcion, contenido, img, correo_capacitacion, telefono_capacitacion, fk_id_usuario, fecha_registro, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($titulo, "text"),
           GetSQLValueString($descripcion, "text"),
           GetSQLValueString($contenido, "text"),
           GetSQLValueString($ruta_img, "text"),
           GetSQLValueString($correo_capacitacion, "text"),
           GetSQLValueString($telefono_capacitacion, "text"),
           GetSQLValueString($idusuario, "int"),
           GetSQLValueString($fecha_registro, "int"),
           GetSQLValueString($estatus, "text"));

		
		//$query = "INSERT INTO nota (tipo, fecha, idusuario, descripcion_img, descripcion1, descripcion2, descripcion3, contenido_titulo, contenido_descripcion) VALUES('$tipo_nota', $fecha, $idusuario, '$descripcion_img', '$descripcion1', '$descripcion2', '$descripcion3', '$contenido_titulo', '$contenido_descripcion')";
		$insertar = mysql_query($query,$conectar) or die(mysql_error()); 

		$id_capacitacion = mysql_insert_id($conectar);

		/// CREAMOS EL DETALLE DE LA CAPACITACIÓN
		$fk_id_capacitacion = $id_capacitacion;
		$cupo = $_POST['cupo'];
		$lugar = $_POST['lugar'];
		$fecha_inicio = strtotime($_POST['fecha_inicio']);
		$fecha_fin = strtotime($_POST['fecha_fin']);
		$tipo_curso = $_POST['tipo_curso'];
		$costo = $_POST['costo'];
		$fk_id_usuario = $idusuario;

		$query = sprintf("INSERT INTO detalle_capacitacion (fk_id_capacitacion, cupo, lugar, fecha_inicio, fecha_fin, tipo_curso, costo, fk_id_usuario, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($fk_id_capacitacion, "int"),
           GetSQLValueString($cupo, "int"),
           GetSQLValueString($lugar, "text"),
           GetSQLValueString($fecha_inicio, "int"),
           GetSQLValueString($fecha_fin, "int"),
           GetSQLValueString($tipo_curso, "text"),
           GetSQLValueString($costo, "text"),
           GetSQLValueString($fk_id_usuario, "int"),
           GetSQLValueString($fecha_registro, "int"));
		$insertar = mysql_query($query, $conectar) or die(mysql_error());


		if(!empty($_POST['tag_existente'])){
			foreach($_POST['tag_existente'] as $tag) {
				//$tag_existente .= $array_alcance." - ";
				$insertSQL = sprintf("INSERT INTO articulo_tag (id_capacitacion, idtag) VALUES(%s, %s)",
					GetSQLValueString($id_capacitacion, "int"),
					GetSQLValueString($tag, "int"));

				$insertar = mysql_query($insertSQL,$conectar) or die(mysql_error());
			}
		}


		if(!empty($_POST['nuevo_tag'])){
			$nuevo_tag = $_POST['nuevo_tag'];
		}else{
			$nuevo_tag = NULL;
		}


		for($i=0;$i<count($nuevo_tag);$i++){
			if($nuevo_tag[$i] != NULL){
				$insertSQL = sprintf("INSERT INTO tags(nombre) VALUES(%s)",
					GetSQLValueString($nuevo_tag[$i], "text")); 

				$insertar = mysql_query($insertSQL,$conectar) or die(mysql_error());

				$idtag = mysql_insert_id($conectar);

				$insertSQL = sprintf("INSERT INTO articulo_tag(id_capacitacion, idtag) VALUES (%s, %s)",
					GetSQLValueString($id_capacitacion, "int"),
					GetSQLValueString($idtag, "int"));

				$insertar = mysql_query($insertSQL, $conectar) or die(mysql_error());
				#}
			}
		}




		$mensaje = "Se ha agregado una nueva capacitación";


	}
	if(isset($_POST['actualizar_articulo']) && $_POST['actualizar_articulo'] == 1){
		$idarticulo = $_POST['idarticulo'];

		$titulo = $_POST['titulo'];
		$contenido = $_POST['contenido'];
		$descripcion_img = $_POST['descripcion_img'];
		$idarticulo = $_POST['idarticulo'];


		if(empty($_FILES['nueva_img']['name'])){
			$ruta_img = $_POST['img_actual'];
		}else{		
			$ruta_img = "../img/articulos/";
			$ruta_img = $ruta_img . basename( $_FILES['nueva_img']['name']); 
			if(move_uploaded_file($_FILES['nueva_img']['tmp_name'], $ruta_img)){ 
				unlink($_POST['img_actual']);
			} 
		}

		$updateSQL = sprintf("UPDATE articulo SET titulo = %s, contenido = %s, img = %s, descripcion_img = %s WHERE idarticulo = %s",
			GetSQLValueString($titulo, "text"),
			GetSQLValueString($contenido, "text"),
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($descripcion_img, "text"),
			GetSQLValueString($idarticulo, "int"));

		//$query = "UPDATE nota SET tipo = '$tipo_nota', fecha = '$fecha', idusuario = '$idusuario', descripcion_img = '$descripcion_img', descripcion1 = '$descripcion1', descripcion2 = '$descripcion2', descripcion3 = '$descripcion3', contenido_titulo = '$contenido_titulo', contenido_descripcion = '$contenido_descripcion' WHERE idarticulo =  $idarticulo";
		$actualizar = mysql_query($updateSQL,$conectar) or die(mysql_error());
		$mensaje = "Nota Actualizada Correctamente";
	}

	if(isset($_POST['eliminar_articulo']) && $_POST['eliminar_articulo'] == 1){
		$idarticulo = $_POST['idarticulo'];
		$img = $_POST['img_articulo'];

		unlink($img);
		$deleteSQL = sprintf("DELETE FROM articulo WHERE idarticulo = %s",
			GetSQLValueString($idarticulo, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE idarticulo = %s",
			GetSQLValueString($idarticulo, "int"));
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$mensaje = "Articulo Eliminado Correctamente";

	}
	/// sección para actualizar los datos del curso
	if(isset($_POST['actualizar_capacitacion']) && $_POST['actualizar_capacitacion'] == 1){
		$id_capacitacion = $_POST['id_capacitacion'];
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		$contenido = $_POST['contenido'];
		$correo_capacitacion = $_POST['correo_capacitacion'];
		$telefono_capacitacion = $_POST['telefono_capacitacion'];
		$fecha_modificacion = $_POST['fecha_modificacion'];
		$cupo = $_POST['cupo'];
		$lugar = $_POST['lugar'];
		$fecha_inicio = strtotime($_POST['fecha_inicio']);
		$fecha_fin = strtotime($_POST['fecha_fin']);
		$tipo_curso = $_POST['tipo_curso'];
		$costo = $_POST['costo'];


		$query = sprintf("UPDATE capacitacion SET titulo = %s, descripcion = %s, contenido = %s, correo_capacitacion = %s, telefono_capacitacion = %s, fecha_modificacion = %s, fk_id_usuario_mod = %s WHERE id_capacitacion = %s",
			GetSQLValueString($titulo, 'text'),
			GetSQLValueString($descripcion, 'text'),
			GetSQLValueString($contenido, 'text'),
			GetSQLValueString($correo_capacitacion, 'text'),
			GetSQLValueString($telefono_capacitacion, 'text'),
			GetSQLValueString($fecha_modificacion, 'int'),
			GetSQLValueString($id_usuario, 'int'),
			GetSQLValueString($id_capacitacion, 'int'));
		$actualizar = mysql_query($query, $conectar) or die(mysql_error());

		$query = sprintf("UPDATE detalle_capacitacion SET cupo = %s, lugar = %s, fecha_inicio = %s, fecha_fin = %s, tipo_curso = %s, costo = %s, fk_id_usuario_mod = %s, fecha_modificacion = %s WHERE fk_id_capacitacion = %s",
			GetSQLValueString($cupo, 'int'),
			GetSQLValueString($lugar, 'text'),
			GetSQLValueString($fecha_inicio, 'int'),
			GetSQLValueString($fecha_fin, 'int'),
			GetSQLValueString($tipo_curso, 'text'),
			GetSQLValueString($costo, 'text'),
			GetSQLValueString($id_usuario, 'int'),
			GetSQLValueString($fecha_modificacion, 'int'),
			GetSQLValueString($id_capacitacion, 'int'));
		$actualizar = mysql_query($query, $conectar) or die(mysql_error());

		echo '<script>alert("Datos actualizados")</script>';

	}

	$query = "SELECT capacitacion.*, detalle_capacitacion.*, incluye.descripcion AS 'descripcion_incluye', datos_bancarios.descripcion AS 'descripcion_datos_bancarios', usuario.username FROM capacitacion INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion INNER JOIN usuario ON capacitacion.fk_id_usuario = usuario.idusuario LEFT JOIN incluye ON capacitacion.id_capacitacion = incluye.fk_id_capacitacion LEFT JOIN datos_bancarios ON capacitacion.id_capacitacion = datos_bancarios.fk_id_capacitacion WHERE id_capacitacion = $id_capacitacion";
	$row_capacitacion = mysql_query($query, $conectar) or die(mysql_error());
	$detalle_capacitacion = mysql_fetch_assoc($row_capacitacion);

	$fecha_inicio = date('Y-m-d', $detalle_capacitacion['fecha_inicio']);
	$fecha_fin = date('Y-m-d', $detalle_capacitacion['fecha_fin']);

 ?>
 <style>
	.campoObligatorio{
		border-bottom: 2px solid #c0392b;
	}
 </style>

<div class="row">

	<div class="col-lg-12">
 		<?php 
 		if(isset($mensaje)){
 		?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo $mensaje; ?>
			</div>
		<?php
 		}
 		 ?>
	</div>

		<div class="row" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
			  	<div class="col-lg-12">
			  		<div class="col-md-12">
			  			<h3>Información del curso</h3>
			  		</div>
			  		<!-- creado por -->
					<div class="col-md-6">
						<p class="alert alert-info" style="padding:7px;">Creado por: <strong style="color:#c0392b"><?php echo $detalle_capacitacion['username']; ?></strong></p>
						<input type="hidden" name="idusuario" value="<?php echo $detalle_capacitacion['fk_id_usuario']; ?>">
					</div>

					<!-- fecha de creación -->
					<div class="col-md-6">
						<p class="alert alert-info" style="padding:7px;">Fecha: <strong style="color:#c0392b"><?php echo date('d/m/Y', $detalle_capacitacion['fecha_registro']); ?></strong></p>
					</div>

					<!-- titulo de la capacitación -->
					<div class="col-md-6">
						<div class="">
							<div class="col-sm 12">
								<label for="titulo">* Titulo</label>
								<input type="text" class="form-control campoObligatorio" name="titulo" placeholder="Titulo de la capacitación" value="<?php echo $detalle_capacitacion['titulo']; ?>" required>
							</div>
							<!--<div class="col-sm 12">
								<label for="img">* Imagen</label>
								<input type="text" class="form-control campoObligatorio" name="img" value="<?php echo $detalle_capacitacion['img']; ?>">
							</div>-->
							<div class="col-sm 12">
								<label for="correo_capacitacion">* Correo de contacto</label>
								<input type="text" class="form-control campoObligatorio" name="correo_capacitacion" value="<?php echo $detalle_capacitacion['correo_capacitacion']; ?>" required>
							</div>
							<div class="col-sm 12">
								<label for="telefono_capacitacion">* Telefono de contacto</label>
								<input type="text" class="form-control campoObligatorio" name="telefono_capacitacion" value="<?php echo $detalle_capacitacion['telefono_capacitacion']; ?>" required>
							</div>

						</div>
					</div>

					<!-- listado de tags -->
					<div class="col-md-6">
						<label for="tag_existente">Listado Tags</label>
						<br>
						<?php 
						$query = "SELECT * FROM tags";
						$row_tag = mysql_query($query,$conectar) or die(mysql_error());

						 ?>
						<select class="form-control chosen-select" data-placeholder="Tags Existentes" name="tag_existente[]" id="" multiple>
							<?php 
							while($tag = mysql_fetch_assoc($row_tag)){
							?>
								<option value="<?php echo $tag['idtag']; ?>"><?php echo $tag['nombre']; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<!-- agregar nuevo tag -->
					<div class="col-md-6">
						<label for="tags">Nuevo Tag</label>
						<table class="table table-condensed table-bordered" id="tabla_tags">
							<tr>
								<td>Tag</td>
								<td>
									<button type="button" onclick="tabla_tags()" data-toggle="tooltip" title="Nuevo Tag" class="btn btn-primary" aria-label="Left Align">
									  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									</button>
								</td>
							</tr>
							<tr class="text-center">
								<td><input type="text" class="form-control" name="nuevo_tag[0]" id="exampleInputEmail1" placeholder="Agregar Palabra"></td>
							</tr>
						</table>
					</div>

					<div class="col-sm-12" style="margin-top:20px;">
						<label for="descripcion">* Descripción del Curso / Capacitación</label>
						<textarea class="form-control campoObligatorio" name="descripcion" id="descripcion" rows="3" placeholder="Breve descripción sobre el curso / capacitación" required><?php echo $detalle_capacitacion['descripcion']; ?></textarea>
					</div>

					<div class="col-md-12" style="margin-top:1.5em;">
						<label for="contenido">* Contenido del Curso / Capacitación</label>
						<textarea class="form-control summernote" name="contenido" id="" required><?php echo $detalle_capacitacion['contenido']; ?></textarea>
					</div>
					<div class="col-lg-12">
						<div class="row"><!-- inicia row -->
							<!-- detalle sobre la capacitación -->
							<div class="col-md-6" style="border-top: 3px solid #2980b9;">
								<h4 style="color:#2c3e50">Detalle del Curso / Capacitación</h4>
								<div class="row">
									<div class="col-sm-4" >
										<input type="number" class="form-control campoObligatorio" id="cupo" name="cupo" placeholder="Número maximo de asistentes" value="<?php echo $detalle_capacitacion['cupo']; ?>" required>
									</div>
									<div class="col-sm-4">
										<select class="form-control campoObligatorio" name="tipo_curso" id="tipo_curso" required>
											<option value="">Modo de presentación</option>
											<option <?php if($detalle_capacitacion['tipo_curso'] == 'Presencial'){ echo 'selected'; } ?> value="Presencial">Presencial</option>
											<option <?php if($detalle_capacitacion['tipo_curso'] == 'En linea'){ echo 'selected'; } ?> value="En linea">En línea</option>
										</select>
									</div>
									<div class="col-sm-4">
										<div class="input-group">
											<span class="input-group-addon">$</span>
										  	<input type="number" class="form-control campoObligatorio" name="costo" id="costo" placeholder="Precio por asistente" value="<?php echo $detalle_capacitacion['costo']; ?>" required>
										</div>
									</div>

									<div class="col-sm-6" style="margin-top:20px;">
										<label for="fecha_inicio">* Fecha de inicio del curso</label>
										<input class="form-control campoObligatorio" type="date" name="fecha_inicio" id="fecha_inicio" placeholder="dd/mm/yyyy" value="<?php echo $fecha_inicio; ?>" required>
									</div>
									<div class="col-sm-6" style="margin-top:20px;">
										<label for="fecha_fin">* Fecha final del curso</label>
										<input class="form-control campoObligatorio" type="date" name="fecha_fin" id="fecha_fin" placeholder="dd/mm/yyyy" value="<?php echo $fecha_fin; ?>" required>
									</div>

									<div class="col-sm-12" style="margin-top:20px;">
										<label for="lugar">* Dirección donde se impartira el curso</label>
										<textarea class="form-contro summernote" name="lugar" id="lugar" required><?php echo $detalle_capacitacion['lugar']; ?></textarea>
									</div>

								</div>
							</div>

							<!-- recursos suministrados -->
							<div class="col-md-6 well" style="border-top: 3px solid #d35400;">
								<h4>Incluye</h4>
								<div style="">
									<p>Recursos suministrados (ej: material, traslado, alimentación, constancia)</p>
									<textarea class="form-contro summernote" name="incluye" id="incluye" required><?php echo $detalle_capacitacion['descripcion_incluye']; ?></textarea>
								</div>
							</div>	
						</div><!-- termina row -->


					</div>

					<div class="col-lg-12">
						<div class="row">
							<!-- datos bancarios del curso -->
							<div class="col-md-6 well" style="border-top: 3px solid #d35400;">
								<h4>Datos bancarios</h4>
								<div>
									<textarea class="form-contro summernote" name="datos_bancarios" id="datos_bancarios" required><?php echo $detalle_capacitacion['descripcion_datos_bancarios']; ?></textarea>
								</div>
							</div>

							<!-- documentación necesaria para el curso -->
							<div class="col-md-6 well" style="border-top: 3px solid #2980b9;">
								<h4>Documentación</h4> 
								<p>Formatos suministrados o requeridos a los participantes.</p>
								<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Agregar otro archivo" onclick="tablaDocumentos()"><span class="glyphicon glyphicon-plus"></span></button>
								<table id="tablaDocumentos" class="table table-bordered table-condensed" style="font-size:10px;">
									<thead>
										<tr>
											<th>
												<a href="" data-toggle="tooltip" title="Solicitar comprobante de archivo"><span class="glyphicon glyphicon-info-sign"></span> Contraparte</a>
											</th>
											<th>Nombre del archivo</th>
											<th>Archivo</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label>
													SI <input type="radio" name="cargar_comprobante[0]" value="1">
												</label>
												<label>
													NO <input type="radio" name="cargar_comprobante[0]" value="0" checked>
												</label>
											</td>
											<td>
												<input type="text" class="form-control" name="nombre_documento[0]" placeholder="Nombre del archivo">
											</td>
											<td>
												<input type="file" class="form-control" name="url_documento0">
											</td>
										</tr>
									</tbody>
								</table>

								<table class="table table-bordered table-condensed" style="font-size:12px;">
									<thead>
										<tr>
											<th>
												<a href="" data-toggle="tooltip" title="Solicitar comprobante de archivo"><span class="glyphicon glyphicon-info-sign"></span> Contraparte</a>
											</th>
											<th>Nombre del archivo</th>
											<th>Archivo</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$query_documentacion = mysql_query("SELECT documentacion.* FROM capacitacion_documentacion INNER JOIN documentacion ON capacitacion_documentacion.fk_id_documentacion = documentacion.id_documentacion WHERE capacitacion_documentacion.fk_id_capacitacion = $detalle_capacitacion[id_capacitacion]", $conectar) or die(mysql_error());
										while($documentacion = mysql_fetch_assoc($query_documentacion)){
										?>
											<tr>
												<td>
													<label>
														SI <input type="radio" name="cargar_comprobante[0]" value="1" <?php if($documentacion['cargar_comprobante'] == 1){ echo 'checked'; } ?>>
													</label>
													<label>
														NO <input type="radio" name="cargar_comprobante[0]" value="0" <?php if($documentacion['cargar_comprobante'] == 0){ echo 'checked'; } ?>>
													</label>
												</td>
												<td>
													<?php echo $documentacion['nombre_documento']; ?>
												</td>
												<td>
													<?php echo $documentacion['url_documento']; ?>
												</td>
											</tr>
										<?php
										}
										 ?>
									</tbody>
								</table>

							</div>

						</div>
					</div>



					<div style="position:fixed;z-index:1;right:0px;">
						<input type="hidden" name="fecha_modificacion" value="<?php echo time(); ?>">
						<input type="hidden" name="id_capacitacion" value="<?php echo $_GET['detalle_capacitacion']; ?>">
						<button class="btn btn-warning" type="submit" name="actualizar_capacitacion" value="1">
							Actualizar datos de capacitación
						</button>
					</div>



			  	</div>

			  	<!--29/08 <div class="col-lg-6">
					<div class="col-md-6">
						<label for="tipo_nota">Tipo Nota</label>
						<select class="form-control" name="tipo_nota" id="tipo_nota">
							<option value="">...</option>
							<option value="encabezado">Encabezado</option>
							<option value="cuerpo">Cuerpo</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="fecha">Fecha</label>
						<input class="form-control" type="date" id="fecha" name="fecha" required>
					</div>
					<div class="col-md-6">
						<label for="contenido_titulo">Titulo Nota (contenido_titulo)</label>
						<input type="text" class="form-control" id="contenido_titulo" name="contenido_titulo">
						<!--<textarea class="textarea form-control" id="contenido_titulo" name="contenido_titulo" rows="4" ></textarea>-->
				<!--29/08	</div>
					<div class="col-md-6">
						<label for="descripcion1">Descripción 1</label>
						<input type="text" class="form-control" id="descripcion1" name="descripcion1">
						<!--<textarea class="textarea form-control" id="descripcion1" name="descripcion1" rows="4" ></textarea>-->
				<!--29/08	</div>
					
					<div class="col-md-6">
						<label for="descripcion2"> Descripción 2</label>
						<input type="text" class="form-control" id="descripcion2" name="descripcion2">
						<!--<textarea class="textarea form-control" id="descripcion2" name="descripcion2" rows="4" ></textarea>-->
				<!--29/08	</div>

					<div class="col-md-6">
						<label for="descripcion3"> Descripción 3</label>
						<input type="text" class="form-control" id="descripcion3" name="descripcion3">
						<!--<textarea class="textarea form-control" id="descripcion3" name="descripcion3" rows="4" ></textarea>-->
				<!--29/08	</div>

					<div class="col-lg-12">
						<hr>
						<input type="hidden" name="agregar_capacitacion" value="1">
						<input class="btn btn-success" type="submit" value="Agregar Articulo">
					</div>
			  	</div> 29/08-->
			</form>
		</div>

</div>
<script>
var contador=0;
	function tabla_tags()
	{
		contador++;
	var table = document.getElementById("tabla_tags");
	  {
	  var row = table.insertRow(2);
	  var cell1 = row.insertCell(0);

	  cell1.innerHTML = '<input type="text" class="form-control" name="nuevo_tag['+contador+']" id="exampleInputEmail1" placeholder="Agregar Palabra">';

	  }
	}

</script>