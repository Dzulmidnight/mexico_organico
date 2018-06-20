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


	if(isset($_POST['agregar_documento']) && $_POST['agregar_documento'] == 1){

		$tipo_documento = $_POST['tipo_documento'];

		if(!empty($_FILES['archivo']['name'])){
			$ruta_documento = "../img/biblioteca/";
			$ruta_documento = $ruta_documento . basename( $_FILES['archivo']['name']); 
			if(move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_documento)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_documento = '';
		}


		//$fecha_registro = $_POST['fecha'];
		//$fecha = strtotime($fecha_registro);
		$idusuario = $_POST['idusuario'];
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		$idusuario = $_POST['idusuario'];

		$query = sprintf("INSERT INTO biblioteca (titulo, descripcion, archivo, tipo_documento, idusuario, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($titulo, "text"),
			GetSQLValueString($descripcion, "text"),
			GetSQLValueString($ruta_documento, "text"),
			GetSQLValueString($tipo_documento, "text"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($fecha, "int"));

		
		//$query = "INSERT INTO nota (tipo, fecha, idusuario, descripcion_img, descripcion1, descripcion2, descripcion3, contenido_titulo, contenido_descripcion) VALUES('$tipo_nota', $fecha, $idusuario, '$descripcion_img', '$descripcion1', '$descripcion2', '$descripcion3', '$contenido_titulo', '$contenido_descripcion')";
		$insertar = mysql_query($query,$conectar) or die(mysql_error()); 
		$idbiblioteca = mysql_insert_id($conectar);



		if(!empty($_POST['tag_existente'])){
			foreach($_POST['tag_existente'] as $tag) {
				//$tag_existente .= $array_alcance." - ";
				$insertSQL = sprintf("INSERT INTO articulo_tag (idbiblioteca, idtag) VALUES(%s, %s)",
					GetSQLValueString($idbiblioteca, "int"),
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

				$insertSQL = sprintf("INSERT INTO articulo_tag(idbiblioteca, idtag) VALUES (%s, %s)",
					GetSQLValueString($idbiblioteca, "int"),
					GetSQLValueString($idtag, "int"));

				$insertar = mysql_query($insertSQL, $conectar) or die(mysql_error());
				#}
			}
		}



		$mensaje = "Se ha agregado un Nuevo Documento";


	}

	if(isset($_POST['actualizar_documento']) && $_POST['actualizar_documento'] == 1){
		$fecha_actualizada = time();
		$idbiblioteca = $_POST['idbiblioteca'];
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];
		$tipo_documento = $_POST['tipo_documento'];

		if(empty($_FILES['nuevo_archivo']['name'])){
			$ruta_documento = $_POST['archivo_actual'];
		}else{
			$ruta_documento = "../img/biblioteca/";
			$ruta_documento = $ruta_documento . basename( $_FILES['nuevo_archivo']['name']); 
			if(move_uploaded_file($_FILES['nuevo_archivo']['tmp_name'], $ruta_documento)){ 
				unlink($_POST['archivo_actual']);
			} 
		}

		$updateSQL = sprintf("UPDATE biblioteca SET titulo = %s, tipo_documento = %s, descripcion = %s, archivo = %s, fecha_actualizada = %s WHERE idbiblioteca = %s",
			GetSQLValueString($titulo, "text"),
			GetSQLValueString($tipo_documento, "text"),
			GetSQLValueString($descripcion, "text"),
			GetSQLValueString($ruta_documento, "text"),
			GetSQLValueString($fecha_actualizada, "int"),
			GetSQLValueString($idbiblioteca, "int"));


		//$query = "UPDATE nota SET tipo = '$tipo_nota', fecha = '$fecha', idusuario = '$idusuario', descripcion_img = '$descripcion_img', descripcion1 = '$descripcion1', descripcion2 = '$descripcion2', descripcion3 = '$descripcion3', contenido_titulo = '$contenido_titulo', contenido_descripcion = '$contenido_descripcion' WHERE idbiblioteca =  $idbiblioteca";
		$actualizar = mysql_query($updateSQL,$conectar) or die(mysql_error());
		$mensaje = "Documento Actualizado Correctamente";

	}
	if(isset($_POST['eliminar_documento']) && $_POST['eliminar_documento'] == 1){
		$idbiblioteca = $_POST['idbiblioteca'];
		$archivo = $_POST['archivo_biblioteca'];

		unlink($archivo);
		$deleteSQL = sprintf("DELETE FROM biblioteca WHERE idbiblioteca = %s",
			GetSQLValueString($idbiblioteca, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE idbiblioteca = %s",
			GetSQLValueString($idbiblioteca, "int"));
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
		$idbiblioteca = $_GET['detalle'];
		$query = "SELECT biblioteca.*, usuario.username FROM biblioteca INNER JOIN usuario ON biblioteca.idusuario = usuario.idusuario WHERE idbiblioteca = $idbiblioteca";
		$row_biblioteca = mysql_query($query,$conectar) or die(mysql_error());
		$biblioteca = mysql_fetch_assoc($row_biblioteca);

		$fecha = date('Y-m-d', $biblioteca['fecha_registro']);
		//$date = str_replace('/', '-', $fecha);

		include('editar.php');
	}else{
	?>
		<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    <h3 class="panel-title">Agregar Documento</h3>
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

						<div class="col-md-8">
							<label for="titulo">Titulo Documento</label>
							<input type="text" class="form-control" name="titulo" placeholder="Titulo Documento" required>
						</div>
						<div class="col-md-4">
							<label for="tipo_documento">Tipo</label>
							<select class="form-control" name="tipo_documento" id="tipo_documento" required>
								<option value="">Tipo de documento</option>
								<option value="BIBLIOTECA">BIBLIOTECA</option>
								<option value="NORMA">NORMA</option>
								<option value="REGLAMENTO">REGLAMENTO</option>
							</select>
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
							<label for="descripcion">Descripción</label>
							<textarea class="form-control" name="descripcion" id=""  rows="5" required></textarea>
						</div>
						<div class="col-md-12">
							<label for="archivo">Archivo</label>
							<input type="file" class="form-control" name="archivo" required>
						</div>

						<div class="col-lg-12">
							<hr>
							<input type="hidden" name="agregar_documento" value="1">
							<input class="btn btn-success" type="submit" value="Agregar biblioteca">
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
							<input type="hidden" name="agregar_documento" value="1">
							<input class="btn btn-success" type="submit" value="Agregar biblioteca">
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
				    <h3 class="panel-title">Listado Documentos</h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed table-hover" style="font-size:12px;">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Titulo</th>
								<th class="text-center">Tags</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$query = "SELECT * FROM biblioteca";
						$row_biblioteca = mysql_query($query,$conectar) or die(mysql_error());

						while($biblioteca = mysql_fetch_assoc($row_biblioteca)){
						?>
							<tr <?php if($biblioteca['idbiblioteca'] == isset($_GET['detalle'])){ echo "class='info'"; } ?>>
								<td>
									<?php 
									echo $biblioteca['idbiblioteca']; 
									?>
									<input type="hidden" name="idbiblioteca" value="<?php echo $biblioteca['idbiblioteca']; ?>">
								</td>
								<td><?php echo $biblioteca['titulo']; ?></td>
								<td>
								<?php 
								$consultar_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE idbiblioteca = $biblioteca[idbiblioteca]";
								$row_tag = mysql_query($consultar_tags,$conectar) or die(mysql_error());
								while($tags = mysql_fetch_assoc($row_tag)){
									echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
								}
								?>
								</td>	
								<td>
									<!-- EDITAR biblioteca -->
									<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=biblioteca&add_documento&detalle=<?php echo $biblioteca['idbiblioteca']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
									<!-- ELIMINAR NOTA -->

									<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Documento" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_documento" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
									<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
									<input type="hidden" name="archivo_biblioteca" value="<?php echo $biblioteca['archivo']; ?>">
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