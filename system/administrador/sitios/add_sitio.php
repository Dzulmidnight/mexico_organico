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


	if(isset($_POST['agregar_sitio']) && $_POST['agregar_sitio'] == 1){


		if(!empty($_FILES['img_sitio']['name'])){
			$ruta_img = "../img/sitios/";
			$ruta_img = $ruta_img . basename( $_FILES['img_sitio']['name']); 
			if(move_uploaded_file($_FILES['img_sitio']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}


		//$fecha_registro = $_POST['fecha'];
		//$fecha = strtotime($fecha_registro);
		$idusuario = $_POST['idusuario'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$url = $_POST['url'];

		$query = sprintf("INSERT INTO sitios (nombre, descripcion, img, url, idusuario, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($nombre, "text"),
			GetSQLValueString($descripcion, "text"),
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($url, "text"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($fecha, "int"));
		
		//$query = "INSERT INTO nota (tipo, fecha, idusuario, descripcion_img, descripcion1, descripcion2, descripcion3, contenido_titulo, contenido_descripcion) VALUES('$tipo_nota', $fecha, $idusuario, '$descripcion_img', '$descripcion1', '$descripcion2', '$descripcion3', '$contenido_titulo', '$contenido_descripcion')";
		$insertar = mysql_query($query,$conectar) or die(mysql_error()); 
		$idsitio = mysql_insert_id($conectar);



		if(!empty($_POST['tag_existente'])){
			foreach($_POST['tag_existente'] as $tag) {
				//$tag_existente .= $array_alcance." - ";
				$insertSQL = sprintf("INSERT INTO articulo_tag (idsitio, idtag) VALUES(%s, %s)",
					GetSQLValueString($idsitio, "int"),
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
				#for($i=0;$i<count($certificacion);$i++){
				/*$insertSQL = sprintf("INSERT INTO certificaciones (idsolicitud_certificacion, certificacion, certificadora, ano_inicial, interrumpida) VALUES (%s, %s, %s, %s, %s)",
				    GetSQLValueString($idsolicitud_certificacion, "int"),
				    GetSQLValueString(strtoupper($certificacion[$i]), "text"),
				    GetSQLValueString(strtoupper($certificadora[$i]), "text"),
				    GetSQLValueString($ano_inicial[$i], "text"),
				    GetSQLValueString($interrumpida[$i], "text"));
*/
				$insertSQL = sprintf("INSERT INTO tags(nombre) VALUES(%s)",
					GetSQLValueString($nuevo_tag[$i], "text")); 

				$insertar = mysql_query($insertSQL,$conectar) or die(mysql_error());

				$idtag = mysql_insert_id($conectar);

				$insertSQL = sprintf("INSERT INTO articulo_tag(idsitio, idtag) VALUES (%s, %s)",
					GetSQLValueString($idsitio, "int"),
					GetSQLValueString($idtag, "int"));

				$insertar = mysql_query($insertSQL, $conectar) or die(mysql_error());
				#}
			}
		}


		$mensaje = "Se ha agregado un Nuevo Documento";


	}
	if(isset($_POST['actualizar_sitio']) && $_POST['actualizar_sitio'] == 1){
		$idsitio = $_POST['idsitio'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$url = $_POST['url'];

		if(empty($_FILES['nueva_img']['name'])){
			$ruta_img = $_POST['img_actual'];
		}else{		
			$ruta_img = "../img/sitios/";
			$ruta_img = $ruta_img . basename( $_FILES['nueva_img']['name']); 
			if(move_uploaded_file($_FILES['nueva_img']['tmp_name'], $ruta_img)){ 
				unlink($_POST['img_actual']);
			} 
		}
		$updateSQL = sprintf("UPDATE sitios SET nombre = %s, descripcion = %s, img = %s, url = %s WHERE idsitio = %s",
			GetSQLValueString($nombre, "text"),
			GetSQLValueString($descripcion, "text"),
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($url, "text"),
			GetSQLValueString($idsitio, "int"));


		//$query = "UPDATE nota SET tipo = '$tipo_nota', fecha = '$fecha', idusuario = '$idusuario', descripcion_img = '$descripcion_img', descripcion1 = '$descripcion1', descripcion2 = '$descripcion2', descripcion3 = '$descripcion3', contenido_titulo = '$contenido_titulo', contenido_descripcion = '$contenido_descripcion' WHERE idsitio =  $idsitio";
		$actualizar = mysql_query($updateSQL,$conectar) or die(mysql_error());
		$mensaje = "Sitio Actualizado Correctamente";

	}
	if(isset($_POST['eliminar_sitio']) && $_POST['eliminar_sitio'] == 1){
		$idsitio = $_POST['idsitio'];
		$img = $_POST['img_sitio'];

		unlink($img);
		$deleteSQL = sprintf("DELETE FROM sitios WHERE idsitio = %s",
			GetSQLValueString($idsitio, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE idsitio = %s",
			GetSQLValueString($idsitio, "int"));
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$mensaje = "Documento Eliminado Correctamente";

	}

 ?>
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
		$idsitio = $_GET['detalle'];
		$query = "SELECT sitios.*, usuario.username FROM sitios INNER JOIN usuario ON sitios.idusuario = usuario.idusuario WHERE idsitio = $idsitio";
		$row_sitios = mysql_query($query,$conectar) or die(mysql_error());
		$sitios = mysql_fetch_assoc($row_sitios);

		$fecha = date('Y-m-d', $sitios['fecha_registro']);
		//$date = str_replace('/', '-', $fecha);

	?>

		<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-warning">
				  <div class="panel-heading">
				    <h3 class="panel-title">Detalle Sitio</h3>
				  </div>
				  <div class="panel-body">
				  	<div class="col-lg-12">
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Usuario: <strong style="color:#c0392b"><?php echo $sitios['username']; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $sitios['idusuario']; ?>">
						</div>	
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Fecha: <strong style="color:#c0392b"><?php echo $fecha; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $sitios['idusuario']; ?>">
						</div>	

						<div class="col-md-12">
							<label for="">Tags: </label>
							<?php 
							$query_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE articulo_tag.idsitio = $sitios[idsitio]";
							$row_articulo_tag = mysql_query($query_tags,$conectar) or die(mysql_error());
							while($tags = mysql_fetch_assoc($row_articulo_tag)){
								echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
							}
							?>
						</div>

						<div class="col-md-12">
							<label for="nombre">Nombre del Sitio</label>
							<input type="text" class="form-control" name="nombre" placeholder="Nombre del Sitio" value="<?php echo $sitios['nombre']; ?>">
						</div>
						<div class="col-md-12">
							<label for="url">URL del Sitio</label>
							<input type="text" class="form-control" name="url" placeholder="URL del Sitio" value="<?php echo $sitios['url']; ?>">
						</div>
						<div class="col-md-12">
							<label for="descripcion">Descripción</label>
							<textarea class="form-control" name="descripcion" id="" cols="30" rows="10"><?php echo $sitios['descripcion']; ?></textarea>
							
						</div>
						
						<div class="col-md-6">
							<p><b>Imagen Actual</b></p>
							<img class="img-thumbnail" style="width:100px;" src="<?php echo $sitios['img']; ?>" alt="">
						</div>
						<div class="col-md-6">
							<label for="nueva_img">Cambiar Imagen</label>
							<input type="file" class="form-control" name="nueva_img">
						</div>


						<div class="col-lg-12">
							<hr>
							<input type="hidden" name="idsitio" value="<?php echo $sitios['idsitio']; ?>">
							<input type="hidden" name="actualizar_sitio" value="1">
							<input type="hidden" name="img_actual" value="<?php echo $sitios['img']; ?>">
							<input class="btn btn-success" type="submit" value="Actualizar Sitio">
						</div>

				  	</div>
				  </div>
				</div>
			</form>
		</div>
	<?php
	}else{
	?>
		<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    <h3 class="panel-title">Agregar Nuevo Sitio</h3>
				  </div>
				  <div class="panel-body">

				  	<div class="col-lg-12">
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Publicado Por: <strong style="color:#c0392b"><?php echo $_SESSION['username']; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $_SESSION['idusuario']; ?>">
						</div>	
						<div class="col-md-6">
							<p class="alert alert-info" style="padding:7px;">Fecha: <strong style="color:#c0392b"><?php echo date('d/m/Y', time()); ?></strong></p>
						</div>	

						<div class="col-md-12">
							<label for="nombre">Nombre del Sitio <span style="color:#e74c3c">*</span></label>
							<input type="text" class="form-control" name="nombre" placeholder="Titulo Documento" required>
						</div>
						<div class="col-md-12">
							<label for="url">URL del Sitio <span style="color:#e74c3c">*</span></label>
							<input type="text" class="form-control" name="url" placeholder="Ej: http://mexorganico.com" required>
						</div>
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
						<div class="col-md-12">
							<label for="descripcion">Descripción del Sitio <span style="color:#e74c3c">*</span></label>
							<textarea class="form-control" name="descripcion" id=""  rows="10" required></textarea>
						</div>
						<div class="col-md-12">
							<label for="img_sitio">Imagen</label>
							<input type="file" class="form-control" name="img_sitio">
						</div>

						<div class="col-lg-12">
							<hr>
							<input type="hidden" name="agregar_sitio" value="1">
							<input class="btn btn-success" type="submit" value="Agregar Sitio">
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
							<input type="hidden" name="agregar_sitio" value="1">
							<input class="btn btn-success" type="submit" value="Agregar sitios">
						</div>
				  	</div> 29/08-->
				  </div>
				</div>
			</form>
		</div>
	<?php
	}
	 ?>
	<div class="col-lg-4" style="padding:0px;">
		<form action="" method="POST">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">Listado Sitios</h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed table-hover" style="font-size:12px;">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Tags</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$query = "SELECT * FROM sitios";
						$row_sitios = mysql_query($query,$conectar) or die(mysql_error());

						while($sitios = mysql_fetch_assoc($row_sitios)){
						?>
							<tr <?php if($sitios['idsitio'] == isset($_GET['detalle'])){ echo "class='info'"; } ?>>
								<td>
									<?php 
									echo $sitios['idsitio']; 
									?>
									<input type="hidden" name="idsitio" value="<?php echo $sitios['idsitio']; ?>">
								</td>
								<td><?php echo $sitios['nombre']; ?></td>
								<td>
								<?php 
								$consultar_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE idsitio = $sitios[idsitio]";
								$row_tag = mysql_query($consultar_tags,$conectar) or die(mysql_error());
								while($tags = mysql_fetch_assoc($row_tag)){
									echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
								}
								?>
								</td>	
								<td>
									<!-- EDITAR sitios -->
									<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=sitios&add_sitio&detalle=<?php echo $sitios['idsitio']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
									<!-- ELIMINAR NOTA -->

									<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Sitio" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_sitio" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
									<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
									<input type="hidden" name="img_sitio" value="<?php echo $sitios['img']; ?>">
								</td>
							</tr>
						<?php
						}
						 ?>
						</tbody>
					</table>
				</div>
			</div>
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