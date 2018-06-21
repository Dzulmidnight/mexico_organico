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
		$contenido = $_POST['contenido'];
		$correo_capacitacion = $_POST['correo_capacitacion'];
		$telefono_capacitacion = $_POST['telefono_capacitacion'];
		$estatus = 'ACTIVA';

		$query = sprintf("INSERT INTO capacitacion (titulo, contenido, img, correo_capacitacion, telefono_capacitacion, fk_id_usuario, fecha_registro, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($titulo, "text"),
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

	<?php 
	if(isset($_GET['detalle'])){
		$idarticulo = $_GET['detalle'];
		$query = "SELECT articulo.*, usuario.username FROM articulo INNER JOIN usuario ON articulo.autor = usuario.idusuario WHERE idarticulo = $idarticulo";
		$row_articulo = mysql_query($query,$conectar) or die(mysql_error());
		$articulo = mysql_fetch_assoc($row_articulo);

		$fecha = date('Y-m-d', $articulo['fecha_registro']);
		//$date = str_replace('/', '-', $fecha);

	?>

		<div class="col-lg-12" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-warning">
				  <div class="panel-heading">
				    <h3 class="panel-title">Detalle Articulo</h3>
				  </div>
				  <div class="panel-body">
				  	<div class="col-lg-12">
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Usuario: <strong style="color:#c0392b"><?php echo $articulo['username']; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $articulo['idusuario']; ?>">
						</div>	
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Fecha: <strong style="color:#c0392b"><?php echo $fecha; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $articulo['idusuario']; ?>">
						</div>	

						<div class="col-md-12">
							<label for="">Tags: </label>
							<?php 
							$query_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE articulo_tag.idarticulo = $articulo[idarticulo]";
							$row_articulo_tag = mysql_query($query_tags,$conectar) or die(mysql_error());
							while($tags = mysql_fetch_assoc($row_articulo_tag)){
								echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
							}
							?>
						</div>

						<div class="col-md-12">
							<label for="titulo">Titulo Articulo</label>
							<input type="text" class="form-control" name="titulo" placeholder="Titulo Articulo" value="<?php echo $articulo['titulo']; ?>">
						</div>
						
						<div class="col-md-2">
							<p><b>Imagen Actual</b></p>
							<img style="width:100px;" src="<?php echo $articulo['img']; ?>" alt="" class="img-thumbnail">
						</div>
						<div class="col-md-10">
							<label for="descripcion_img">Descripción Imagen</label>
							<input type="text" class="form-control" name="descripcion_img" placeholder="Descripción Imagen" value="<?php echo $articulo['descripcion_img']; ?>">
						</div>
						<div class="col-md-12">
							<label for="nueva_img">Cambiar Imagen</label>
							<input type="file" class="form-control" name="nueva_img">
						</div>

						<div class="col-md-12">
							<label for="contenido">Contenido Artículo</label>
							<textarea class="form-control" name="contenido" id="" rows="10"><?php echo $articulo['contenido']; ?></textarea>
						</div>
						<div class="col-md-12">
							<label for="fuente">Fuente</label>
							<input type="text" class="form-control" name="fuente" value="<?php echo $articulo['fuente']; ?>" placeholder="Fuente">
						</div>

						<div class="col-lg-12">
							<hr>
							<input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">
							<input type="hidden" name="actualizar_articulo" value="1">
							<input type="hidden" name="img_actual" value="<?php echo $articulo['img']; ?>">
							<input class="btn btn-success" type="submit" value="Actualizar Nota">
						</div>

				  	</div>
				  </div>
				</div>
			</form>
		</div>
	<?php
	}else{
	?>
		<div class="row" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="">
				  <div class="">

				  	<div class="col-lg-12">
				  		<!-- creado por -->
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Creado por: <strong style="color:#c0392b"><?php echo $_SESSION['username']; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $_SESSION['idusuario']; ?>">
						</div>

						<!-- fecha de creación -->
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Fecha: <strong style="color:#c0392b"><?php echo date('d/m/Y', time()); ?></strong></p>
						</div>

						<!-- titulo de la capacitación -->
						<div class="col-md-6">
							<div class="">
								<div class="col-sm 12">
									<label for="titulo">* Titulo</label>
									<input type="text" class="form-control campoObligatorio" name="titulo" placeholder="Titulo de la capacitación" required>
								</div>
								<div class="col-sm 12">
									<label for="img">* Imagen</label>
									<input type="file" class="form-control campoObligatorio" name="img" required>
								</div>
								<div class="col-sm 12">
									<label for="correo_capacitacion">* Correo de contacto</label>
									<input type="text" class="form-control campoObligatorio" name="correo_capacitacion" value="" required>
								</div>
								<div class="col-sm 12">
									<label for="telefono_capacitacion">* Telefono de contacto</label>
									<input type="text" class="form-control campoObligatorio" name="telefono_capacitacion" value="" required>
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

						<div class="col-md-12" style="margin-top:1.5em;">
							<label for="contenido">* Contenido del Curso / Capacitación</label>
							<textarea class="form-control summernote" name="contenido" id="" required></textarea>
						</div>
						
						<div class="col-md-12" style="border-top: 3px solid #2980b9;">
							<h4 style="color:#2c3e50">Detalle del Curso / Capacitación</h4>
						</div>

						<!-- detalle sobre la capacitación -->
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-4" >
									<input type="number" class="form-control campoObligatorio" id="cupo" name="cupo" placeholder="Número maximo de asistentes" required>
								</div>
								<div class="col-sm-4">
									<select class="form-control campoObligatorio" name="tipo_curso" id="tipo_curso" required>
										<option value="">Modo de presentación</option>
										<option value="Presencial">Presencial</option>
										<option value="En linea">En linea</option>
									</select>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<span class="input-group-addon">$</span>
									  	<input type="text" class="form-control campoObligatorio" name="costo" id="costo" placeholder="Precio por asistente" required>
									</div>
								</div>

								<div class="col-sm-6" style="margin-top:20px;">
									<label for="fecha_inicio">* Fecha de inicio del curso</label>
									<input class="form-control campoObligatorio" type="date" name="fecha_inicio" id="fecha_inicio" placeholder="dd/mm/yyyy" required>
								</div>
								<div class="col-sm-6" style="margin-top:20px;">
									<label for="fecha_fin">* Fecha final del curso</label>
									<input class="form-control campoObligatorio" type="date" name="fecha_fin" id="fecha_fin" placeholder="dd/mm/yyyy" required>
								</div>

								<div class="col-sm-12" style="margin-top:20px;">
									<label for="lugar">* Dirección donde se impartira el curso</label>
									<textarea class="form-contro summernote" name="lugar" id="lugar" required></textarea>
								</div>

							</div>
						</div>


						<div style="position:fixed;z-index:1;right:0px;">
							<input type="hidden" name="fecha" value="<?php echo time(); ?>">
							<input type="hidden" name="agregar_capacitacion" value="1">
							<input class="btn btn-danger" type="submit" value="Crear nueva capacitación">
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
				  </div>
				</div>
			</form>
		</div>
	<?php
	}
	 ?>
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