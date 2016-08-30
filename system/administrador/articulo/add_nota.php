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

	$time_actual = time();
	$fecha = date("d/m/Y",$time_actual);


	if(isset($_POST['agregar_nota']) && $_POST['agregar_nota'] == 1){

		$fecha_nota = $_POST['fecha'];
		$fecha = strtotime($fecha_nota);
		$tipo_nota = $_POST['tipo_nota'];
		$idusuario = $_POST['idusuario'];
		$descripcion_img = $_POST['descripcion_img'];
		$descripcion1 = $_POST['descripcion1'];
		$descripcion2 = $_POST['descripcion2'];
		$descripcion3 = $_POST['descripcion3'];
		$contenido_titulo = $_POST['contenido_titulo'];
		$contenido_descripcion = $_POST['contenido_descripcion'];

		$query = sprintf("INSERT INTO nota (tipo, fecha, idusuario, descripcion_img, descripcion1, descripcion2, descripcion3, contenido_titulo, contenido_descripcion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($tipo_nota, "text"),
           GetSQLValueString($fecha, "int"),
           GetSQLValueString($idusuario, "int"),
           GetSQLValueString($descripcion_img, "text"),
           GetSQLValueString($descripcion1, "text"),
           GetSQLValueString($descripcion2, "text"),
           GetSQLValueString($descripcion3, "text"),
           GetSQLValueString($contenido_titulo, "text"),
           GetSQLValueString($contenido_descripcion, "text"));
		
		//$query = "INSERT INTO nota (tipo, fecha, idusuario, descripcion_img, descripcion1, descripcion2, descripcion3, contenido_titulo, contenido_descripcion) VALUES('$tipo_nota', $fecha, $idusuario, '$descripcion_img', '$descripcion1', '$descripcion2', '$descripcion3', '$contenido_titulo', '$contenido_descripcion')";
		$insertar = mysql_query($query,$kafeprod_bio) or die(mysql_error()); 
		$mensaje = "Se ha agregado una nueva nota";


	}
	if(isset($_POST['actualizar_nota']) && $_POST['actualizar_nota'] == 1){
		$idnota = $_POST['idnota'];

		$fecha = strtotime($_POST['fecha']);
		
		$tipo_nota = $_POST['tipo_nota'];
		$idusuario = $_POST['idusuario'];
		$descripcion_img = $_POST['descripcion_img'];
		$descripcion1 = $_POST['descripcion1'];
		$descripcion2 = $_POST['descripcion2'];
		$descripcion3 = $_POST['descripcion3'];
		$contenido_titulo = $_POST['contenido_titulo'];
		$contenido_descripcion = $_POST['contenido_descripcion'];

		$query = "UPDATE nota SET tipo = '$tipo_nota', fecha = '$fecha', idusuario = '$idusuario', descripcion_img = '$descripcion_img', descripcion1 = '$descripcion1', descripcion2 = '$descripcion2', descripcion3 = '$descripcion3', contenido_titulo = '$contenido_titulo', contenido_descripcion = '$contenido_descripcion' WHERE idnota =  $idnota";
		$actualizar = mysql_query($query,$kafeprod_bio) or die(mysql_error());
		$mensaje = "Nota Actualizada Correctamente";
	}
	if(isset($_POST['eliminar_nota']) && $_POST['eliminar_nota'] == 1){
		$idnota = $_POST['idnota'];
		$query = "DELETE FROM nota WHERE idnota = $idnota";
		$eliminar = mysql_query($query,$kafeprod_bio) or die(mysql_error());
		$mensaje = "Nota Eliminada Correctamente";

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
		$idnota = $_GET['detalle'];
		$query = "SELECT * FROM nota WHERE idnota = $idnota";
		$row_nota = mysql_query($query,$kafeprod_bio) or die(mysql_error());
		$nota = mysql_fetch_assoc($row_nota);

		$fecha = date('Y-m-d', $nota['fecha']);
		//$date = str_replace('/', '-', $fecha);

	?>

		<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-warning">
				  <div class="panel-heading">
				    <h3 class="panel-title">Detalle Nota</h3>
				  </div>
				  <div class="panel-body">
				  	<div class="col-lg-6">
						<div class="col-md-12">
							<p class="alert alert-info" style="padding:7px;">Usuario: <strong style="color:#c0392b"><?php echo $nota['idusuario']; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $nota['idusuario']; ?>">
						</div>	
						<div class="col-md-12">
							<label for="contenido_descripcion">Descripción Nota (contenido_descripcion)</label>
							<textarea class="textarea form-control" id="contenido_descripcion" name="contenido_descripcion" rows="4" ><?php echo $nota['contenido_descripcion']; ?></textarea>
						</div>
						<div class="col-md-12">
							<label for="descripcion_img">Descripción Imagen</label>
							<textarea class="form-control" name="descripcion_img" id="descripcion_img" rows="4"><?php echo $nota['descripcion_img']; ?></textarea>
						</div>

				  	</div>
				  	<div class="col-lg-6">
						<div class="col-md-6">
							<label for="tipo_nota">Tipo Nota</label>
							<select class="form-control" name="tipo_nota" id="tipo_nota">
								<option value="">...</option>
								<option value="encabezado" <?php if($nota['tipo'] == "encabezado"){echo "selected";} ?>>Encabezado</option>
								<option value="cuerpo" <?php if($nota['tipo'] == "cuerpo"){echo "selected";} ?>>Cuerpo</option>
							</select>
						</div>				  		
						<div class="col-md-6">
							<label for="fecha">Fecha</label>
							<input class="form-control" type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">

						</div>
						<div class="col-md-6">
							<label for="contenido_titulo">Titulo Nota (contenido_titulo)</label>
							<input type="text" class="form-control" id="contenido_titulo" name="contenido_titulo" value="<?php echo $nota['contenido_titulo']; ?>">
							<!--<textarea class="textarea form-control" id="contenido_titulo" name="contenido_titulo" rows="4" ><?php echo $nota['contenido_titulo']; ?></textarea>-->
						</div>
						<div class="col-md-6">
							<label for="descripcion1">Descripción 1</label>
							<input type="text" class="form-control" id="descripcion1" name="descripcion1" value="<?php echo $nota['descripcion1']; ?>">
							<!--<textarea class="textarea form-control" id="descripcion1" name="descripcion1" rows="4" ><?php echo $nota['descripcion1']; ?></textarea>-->
						</div>
						
						<div class="col-md-6">
							<label for="descripcion2"> Descripción 2</label>
							<input type="text" class="form-control" id="descripcion2" name="descripcion2" value="<?php echo $nota['descripcion2']; ?>">
							<!--<textarea class="textarea form-control" id="descripcion2" name="descripcion2" rows="4" ><?php echo $nota['descripcion2']; ?></textarea>-->
						</div>

						<div class="col-md-6">
							<label for="descripcion3"> Descripción 3</label>
							<input type="text" class="form-control" id="descripcion3" name="descripcion3" value="<?php echo $nota['descripcion3']; ?>">
							<!--<textarea class="textarea form-control" id="descripcion3" name="descripcion3" rows="4" ><?php echo $nota['descripcion3']; ?></textarea>-->
						</div>
						<div class="col-lg-12">
							<hr>
							<input type="hidden" name="idnota" value="<?php echo $nota['idnota']; ?>">
							<input type="hidden" name="actualizar_nota" value="1">
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
		<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    <h3 class="panel-title">Agregar Nota</h3>
				  </div>
				  <div class="panel-body">

				  	<div class="col-lg-6">
						<div class="col-md-12">
							<p class="alert alert-info" style="padding:7px;">Usuario: <strong style="color:#c0392b"><?php echo $_SESSION['username']; ?></strong></p>
							<input type="hidden" name="idusuario" value="<?php echo $_SESSION['idusuario']; ?>">
						</div>	
						<div class="col-md-12">
							<label for="contenido_descripcion">Descripción Nota (contenido_descripcion)</label>
							<textarea class="textarea form-control" id="contenido_descripcion" name="contenido_descripcion" rows="4" ></textarea>
						</div>
						<div class="col-md-12">
							<label for="descripcion_img">Descripción Imagen</label>
							<textarea class="form-control" name="descripcion_img" id="descripcion_img" rows="4"></textarea>
						</div>

				  	</div>
				  	<div class="col-lg-6">
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
						</div>
						<div class="col-md-6">
							<label for="descripcion1">Descripción 1</label>
							<input type="text" class="form-control" id="descripcion1" name="descripcion1">
							<!--<textarea class="textarea form-control" id="descripcion1" name="descripcion1" rows="4" ></textarea>-->
						</div>
						
						<div class="col-md-6">
							<label for="descripcion2"> Descripción 2</label>
							<input type="text" class="form-control" id="descripcion2" name="descripcion2">
							<!--<textarea class="textarea form-control" id="descripcion2" name="descripcion2" rows="4" ></textarea>-->
						</div>

						<div class="col-md-6">
							<label for="descripcion3"> Descripción 3</label>
							<input type="text" class="form-control" id="descripcion3" name="descripcion3">
							<!--<textarea class="textarea form-control" id="descripcion3" name="descripcion3" rows="4" ></textarea>-->
						</div>

						<div class="col-lg-12">
							<hr>
							<input type="hidden" name="agregar_nota" value="1">
							<input class="btn btn-success" type="submit" value="Agregar Nota">
						</div>
				  	</div>
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
				    <h3 class="panel-title">Listado Notas</h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed table-hover" style="font-size:12px;">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Tipo Nota</th>
								<th class="text-center">Titulo</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$query = "SELECT * FROM nota";
						$row_nota = mysql_query($query,$kafeprod_bio) or die(mysql_error());

						while($nota = mysql_fetch_assoc($row_nota)){
						?>
							<tr>
								<td>
									<?php 
									echo $nota['idnota']; 
									?>
									<input type="hidden" name="idnota" value="<?php echo $nota['idnota']; ?>">
								</td>
								<td><?php echo $nota['tipo']; ?></td>
								<td><?php echo $nota['contenido_titulo']; ?></td>
								<td>
									<!-- AGREGAR SEGMENTO -->
									<a class="btn btn-sm btn-success" data-toggle="tooltip" title="Agregar Segmento" href="?menu=articulo&add_segmento&nota=<?php echo $nota['idnota']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-list-alt"></span></a>
									<!-- EDITAR NOTA -->
									<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=articulo&add_nota&detalle=<?php echo $nota['idnota']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
									<!-- ELIMINAR NOTA -->

									<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar Nota" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_nota" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
									<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
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
