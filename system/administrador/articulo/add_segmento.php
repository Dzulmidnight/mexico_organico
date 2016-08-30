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

if(isset($_GET['nota'])){
	$idnota = $_GET['nota'];
}
if(isset($_POST['agregar_segmento']) && $_POST['agregar_segmento'] == 1){

		$idnota = $idnota;
		$tipo_segmento = $_POST['tipo_segmento'];
		$texto1 = $_POST['texto1'];
		$texto2 = $_POST['texto2'];

		
		if(!empty($_FILES['img']['name'])){
			$ruta_img = "../img/notas/";
			$ruta_img = $ruta_img . basename( $_FILES['img']['name']); 
			if(move_uploaded_file($_FILES['img']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}

		/*$query = sprintf("INSERT INTO nota (tipo, fecha, idusuario, descripcion_img, descripcion1, descripcion2, descripcion3, contenido_titulo, contenido_descripcion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($tipo_nota, "text"),
           GetSQLValueString($fecha, "int"),
           GetSQLValueString($idusuario, "int"),
           GetSQLValueString($descripcion_img, "text"),
           GetSQLValueString($descripcion1, "text"),
           GetSQLValueString($descripcion2, "text"),
           GetSQLValueString($descripcion3, "text"),
           GetSQLValueString($contenido_titulo, "text"),
           GetSQLValueString($contenido_descripcion, "text"));
*/

		$query = sprintf("INSERT INTO nota_segmento (idnota, tipo, texto1, texto2, img) VALUES(%s, %s, %s, %s, %s)",
           GetSQLValueString($idnota, "int"),
           GetSQLValueString($tipo_segmento, "int"),
           GetSQLValueString($texto1, "text"),
           GetSQLValueString($texto2, "text"),
           GetSQLValueString($ruta_img, "text"));
		$insertar = mysql_query($query,$kafeprod_bio) or die(mysql_error());

		$mensaje = "Segmento Agregado Correctamente";
}
if(isset($_POST['eliminar_segmento']) && $_POST['eliminar_segmento'] == 1){
	$idnota_segmento = $_POST['idnota_segmento'];
	$query = "DELETE FROM nota_segmento WHERE idnota_segmento = $idnota_segmento";
	$eliminar = mysql_query($query,$kafeprod_bio) or die(mysql_error());

	$mensaje = "Segmento Eliminado Correctamente";

}
if(isset($_POST['actualizar_segmento']) && $_POST['actualizar_segmento'] == 1){

	$idnota_segmento = $_POST['idnota_segmento'];
	$tipo_segmento = $_POST['tipo_segmento'];
	$ruta_img = '';
	$texto1 = '';
	$texto2 = '';



	switch ($tipo_segmento) {
		case '1':
			if(empty($_FILES['nueva_img']['name'])){
				$ruta_img = $_POST['img_actual'];
			}else{		
				$ruta_img = "../img/notas/";
				$ruta_img = $ruta_img . basename( $_FILES['nueva_img']['name']); 
				if(move_uploaded_file($_FILES['nueva_img']['tmp_name'], $ruta_img)){ 
					//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
				} 
			}

			$texto2 = $_POST['texto2'];

			break;
		case '2':

			if(empty($_FILES['nueva_img']['name'])){
				$ruta_img = $_POST['img_actual'];
			}else{		
				$ruta_img = "../img/notas/";
				$ruta_img = $ruta_img . basename( $_FILES['nueva_img']['name']); 
				if(move_uploaded_file($_FILES['nueva_img']['tmp_name'], $ruta_img)){ 
					//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
				} 
			}
			break;
		case '3':
			$texto1 = $_POST['texto1'];
			$texto2 = $_POST['texto2'];
			break;
		case '4':
			$texto2 = $_POST['texto2'];
			break;
		default:
			# code...
			break;
	}


	$query = sprintf("UPDATE nota_segmento SET texto1 = %s, texto2 = %s, img = %s WHERE idnota_segmento = %s",
           GetSQLValueString($texto1, "text"),
           GetSQLValueString($texto2, "text"),
           GetSQLValueString($ruta_img, "text"),
           GetSQLValueString($idnota_segmento, "int"));
	$update = mysql_query($query,$kafeprod_bio) or die(mysql_error());

	$mensaje = "Segmento Actualizado Correctamente";

}


	$query = "SELECT nota.*, usuario.username FROM nota LEFT JOIN usuario ON nota.idusuario = usuario.idusuario";
	$row_nota = mysql_query($query,$kafeprod_bio) or die(mysql_errno());
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
	<!--- INICIA SECCION LISTADO NOTAS ---->
	<div class="col-lg-4" style="padding:0px;">
		<div class="col-md-12" style="padding:0px;">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Listado Notas</h3>
			  </div>
				  <table class="table table-hover" style="font-size:12px;">
				  	<thead>
				  		<tr>
				  			<th>Id</th>
				  			<th>Titulo</th>
				  			<th>Username</th>
				  			<th>Segmento(s)</th>
				  		</tr>
				  	</thead>
				  	<tbody>
				  	<?php 
				  	while($nota = mysql_fetch_assoc($row_nota)){
				  		$query = "SELECT idnota_segmento FROM nota_segmento WHERE idnota = $nota[idnota]";
				  		$row_nota_segmento = mysql_query($query,$kafeprod_bio) or die(mysql_error());
				  		$total_segmentos = mysql_num_rows($row_nota_segmento);
				  	?>
				  		<tr <?php if((isset($idnota) && $idnota == $nota['idnota']) || (isset($_GET['detail']) && $_GET['detail'] == $nota['idnota']) ){echo 'class="alert alert-info"';} ?> >
				  			<td><?php echo $nota['idnota']; ?></td>
				  			<td><?php echo $nota['contenido_titulo']; ?></td>
				  			<td><?php echo $nota['username']; ?></td>
				  			<td>
				  				<?php 
				  				if($total_segmentos == 0){
				  					echo 0;
				  				}else{
				  				?>
					  				<a class="btn btn-sm btn-success" data-toggle="tooltip" title="Visualizar Segmento(s)" href="?menu=articulo&add_segmento&detail=<?php echo $nota['idnota']; ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="badge"><?php echo $total_segmentos; ?></span></a>

				  				<?php
				  				}
				  				 ?>
				  			</td>
				  			<td>
				  				<a class="btn btn-xs btn-success" href="?menu=articulo&add_segmento&nota=<?php echo $nota['idnota']; ?>">Añadir<br> Segmento</a>
				  			</td>
				  		</tr>
					<?php
				  	}
				  	 ?>
				  	</tbody>
				  </table>
			</div>
		</div>

		<div class="col-md-12" style="padding:0px;">
		<?php 
		if(isset($_GET['segmento']) && $_GET['segmento'] != 0){
			$idnota = $_GET['detail'];
			$idnota_segmento = $_GET['segmento'];
			$query_segmento = "SELECT * FROM nota_segmento WHERE idnota = $idnota";
			$row_nota_segmento = mysql_query($query_segmento,$kafeprod_bio) or die(mysql_error());


		?>
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Listado Notas</h3>
			  </div>
				  <table class="table table-hover" style="font-size:12px;">
				  	<thead>
				  		<tr>
				  			<th>Idnota_segmento</th>
				  			<th>Tipo segmento</th>
				  		</tr>
				  	</thead>
				  	<tbody>
				  	<?php 
				  	while($segmento = mysql_fetch_assoc($row_nota_segmento)){
				  	?>
				  		<tr <?php if($segmento['idnota_segmento'] == $idnota_segmento){ echo 'class="alert alert-info"'; } ?> >
				  			<td><?php echo $segmento['idnota_segmento']; ?></td>
				  			<td><?php echo $segmento['tipo']; ?></td>
				  			<td>
				  				<a class="btn btn-sm btn-warning" href="?menu=articulo&add_segmento&detail=<?php echo $idnota; ?>&segmento=<?php echo $segmento['idnota_segmento']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
				  			</td>
				  		</tr>
					<?php
				  	}
				  	 ?>
				  	</tbody>
				  </table>
			</div>
		<?php
		}
		 ?>
		</div>
	</div>
	<!--- INICIA SECCION LISTADO NOTAS ---->
	<?php 
	if(isset($_GET['nota']) && $_GET['nota'] != ''){
	?>
		<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-primary">
					<div class="panel-heading">
					    <h3 class="panel-title">Agregar Segmento</h3>
					</div>
					<div class="panel-body">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-md-4">
							
									<p>Tipo Segmento</p>	
									
										<button style="padding:0px; margin:0px;" type="button" class="btn btn-default" onclick="segmento_tipo1()">
											<img style="width:80px;" src="../../images/segmento_tipo1.png" alt="">
										</button>
										<button style="padding:0px; margin:0px;" type="button" class="btn btn-default" onclick="segmento_tipo2()"> 
											<img style="width:80px;" src="../../images/segmento_tipo2.png" alt="">	
										</button>
										<button style="padding:0px; margin:0px;" type="button" class="btn btn-default" onclick="segmento_tipo3()">
											<img style="width:80px;" src="../../images/segmento_tipo3.png" alt="">									
										</button>
										<button style="padding:0px; margin:0px;" type="button" class="btn btn-default" onclick="segmento_tipo4()">
											<img style="width:80px;" src="../../images/segmento_tipo4.png" alt="">										
										</button>
									<!--<label for="tipo_segmento">Tipo Segmento</label>-->

									<!--<select class="form-control" name="tipo_segmento" id="tipo_segmento" onchange="funcion_segmentos()">
										<option value="">...</option>
										<option value="1">Tipo 1</option>
										<option value="2">Tipo 2</option>
										<option value="3">Tipo 3</option>
										<option value="4">Tipo 4</option>
									</select>-->
									<input type="hidden" id="tipo_segmento" name="tipo_segmento" value="">
								</div>

								<div id="img_segmento" class="col-md-8" style="display:none">
									<div class="row">
										<label for="img">Imagen</label>
										<input class="form-control" type="file" id="img" name="img">	
									</div>		
								</div>
								<div id="texto1_segmento" class="col-md-8" style="display:none">
									<div class="row">
										<label for="texto1">Subtitulo (Texto 1)</label>
										<textarea class="textarea form-control" id="texto1" name="texto1" cols="30" rows="2"></textarea>	
									</div>					
								</div>
								<div id="texto2_segmento" class="col-md-8" style="display:none">
									<div class="row">
										<label for="texto2">Contenido (Texto 2)</label>
										<textarea class="textarea form-control" id="texto2" name="texto2" cols="30" rows="10"></textarea>	
									</div>
								</div>
								<div id="btn_agregar_segmento" class="col-md-12" style="display:none">
									<div class="row">
										<input type="hidden" name="agregar_segmento" value="1">
										<input class="btn btn-success" type="submit" value="Agregar Segmento"> 	
									</div>	
								</div>

							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php
	}
	/******************************  INICIA DETALLE SEGMENTO  *******************************************/
	if(isset($_GET['detail'])){
		$idnota = $_GET['detail'];
		$query = "SELECT nota_segmento.*, nota.fecha, nota.contenido_titulo FROM nota_segmento INNER JOIN nota ON nota_segmento.idnota = nota.idnota WHERE nota_segmento.idnota = $idnota";
		$row_nota_segmento = mysql_query($query,$kafeprod_bio) or die(mysql_error());

		$query = "SELECT nota.contenido_titulo FROM nota WHERE idnota = $idnota";
		$row_nota = mysql_query($query,$kafeprod_bio) or die(mysql_error());
		$nota = mysql_fetch_assoc($row_nota);
	?>
		<div class="col-md-8" style="padding:0px;">
			<?php 
			if(isset($_GET['segmento']) && $_GET['segmento'] != 0){
				$idnota_segmento = $_GET['segmento'];
				$query = "SELECT * FROM nota_segmento WHERE idnota_segmento = $idnota_segmento";
				$consultar = mysql_query($query,$kafeprod_bio) or die(mysql_error());
				$datos_segmento = mysql_fetch_assoc($consultar);
			?>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Agregar Segmento2</h3>
					  </div>
					  <div class="panel-body">
						<div class="col-md-12">
							<label for="tipo_segmento">Tipo Segmento</label>
							<?php 
							switch ($datos_segmento['tipo']) {
								case '1':

									echo '<img style="width:80px;" src="../../images/segmento_tipo1.png" alt="">';
								?>
									<hr>
									<div class="col-md-12">
										<?php 
										if(!empty($datos_segmento['img'])){
										?>
											<div class="col-xs-6">
												<label for="img_actual">Imagen Actual</label>
												<img id="img_actual" width="100" height="100" src="<?php echo $datos_segmento['img']; ?>" alt="">
											</div>
											<div class="col-xs-6">
												<label for="img">Reemplazar</label>
												<input class="form-control" type="file" id="img" name="img">	
											</div>
											
										<?php
										}else{
										?>
											<input class="form-control" type="file" id="img" name="img">
										<?php
										} 
										?>
									</div>
									<div class="col-md-12">
										<label for="texto2">Contenido (Texto 2)</label>
										<textarea class="textarea form-control" id="texto2" name="texto2" cols="30" rows="10"><?php echo $datos_segmento['texto2']; ?></textarea>
									</div>
								<?php
									break;
								case '2':
									echo '<img style="width:80px;" src="../../images/segmento_tipo2.png" alt="">';
								?>
									<div class="col-md-12">
										<?php 
										if(!empty($datos_segmento['img'])){
										?>
											<div class="col-xs-6">
												<label for="img_actual">Imagen Actual</label>
												<img id="img_actual" width="100" height="100" src="<?php echo $datos_segmento['img']; ?>" alt="">
												
											</div>
											<div class="col-xs-6">
												<label for="img">Reemplazar</label>
												<input class="form-control" type="file" id="img" name="nueva_img">	
											</div>
											
										<?php
										}else{
										?>
											<input class="form-control" type="file" id="img" name="img">
										<?php
										} 
										?>
									</div>
								<?php
									break;
								case '3':
									echo '<img style="width:80px;" src="../../images/segmento_tipo3.png" alt="">';
								?>
									<div class="col-md-12">
										<label for="texto1">Subtitulo (Texto 1)</label>
										<textarea class="textarea form-control" id="texto1" name="texto1" cols="30" rows="2"><?php echo $datos_segmento['texto1']; ?></textarea>
										
										<label for="texto2">Contenido (Texto 2)</label>
										<textarea class="textarea form-control" id="texto2" name="texto2" cols="30" rows="10"><?php echo $datos_segmento['texto2']; ?></textarea>
									</div>
								<?php
									break;
								case '4':
									echo '<img style="width:80px;" src="../../images/segmento_tipo4.png" alt="">';
								?>
									<div class="col-md-12">
										<label for="texto2">Contenido (Texto 2)</label>
										<textarea class="textarea form-control" id="texto2" name="texto2" cols="30" rows="10"><?php echo $datos_segmento['texto2']; ?></textarea>
									</div>
								<?php
									break;

								default:
									# code...
									break;
							}
							 ?>
							 <input type="hidden" name="idnota_segmento" value="<?php echo $datos_segmento['idnota_segmento']; ?>">
						</div>
						<div class="col-md-12">
							<input type="hidden" name="img_actual" value="<?php echo $datos_segmento['img']; ?>">
							<input type="hidden" name="tipo_segmento" value="<?php echo $datos_segmento['tipo']; ?>">
							
							<input type="hidden" name="actualizar_segmento" value="1">
							<input class="btn btn-success" type="submit" value="Actualizar Segmento">
						</div>
					  </div>
					</div>
				</form>
			<?php
	/******************************  TERMINA DETALLE SEGMENTO  *******************************************/

			/*******************************  INICIA SECCIÓN "LISTADO SEGMENTOS" **********************************************/
			}else{
			?>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title"><?php echo "Listado Segmento(s): ".$nota['contenido_titulo']; ?> </h3>
					  </div>
					  <table class="table" style="font-size:12px;">
					  	<thead>
					  		<tr>
					  			<th>Id</th>
					  			<th>Nota</th>
					  			<th>Tipo</th>
					  			<th>Subtitulo (Texto1)</th>
					  			<th>Contenido (Texto2)</th>
					  			<th>Imagen</th>
					  		</tr>
					  	</thead>
					  	<tbody>
					  		<?php 
					  		while($nota_segmento = mysql_fetch_assoc($row_nota_segmento)){
					  		?>
					  			<tr>
					  				<td><?php echo $nota_segmento['idnota_segmento']; ?></td>
					  				<td><?php echo $nota_segmento['idnota']; ?></td>
					  				<td><?php echo $nota_segmento['tipo']; ?></td>
					  				<td><?php echo $nota_segmento['texto1']; ?></td>
					  				<td><?php echo $nota_segmento['texto2']; ?></td>
					  				<td>
					  					<?php 
					  					if(empty($nota_segmento['img'])){
					  					?>
											No Disponible
										<?php
					  					}else{
					  					?>
											<a href="<?php echo $nota_segmento['img']; ?>" target="_blank"><img  class="img-thumbnail" style="width:80px;height:80px;" src="<?php echo $nota_segmento['img']; ?>" alt=""></a>
					  					<?php
					  					}
					  					 ?>
					  				</td>
					  				<td>
					  					<input type="hidden" name="idnota_segmento" value="<?php echo $nota_segmento['idnota_segmento']; ?>">
					  					<a class="btn btn-warning" data-toggle="tooltip" title="Editar Segmento" href="?menu=articulo&add_segmento&detail=<?php echo $nota_segmento['idnota']; ?>&segmento=<?php echo $nota_segmento['idnota_segmento']; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					  					<button class="btn btn-danger" name="eliminar_segmento" value="1" data-toggle="tooltip" title="Eliminar Segmento" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
					  				</td>
					  			</tr>
					  		<?php
					  		}
					  		 ?>
					  	</tbody>
					  </table>
					</div>
					<!--<input type="hidden" name="agregar_segmento" value="1">
					<input class="btn btn-success" type="submit" value="Agregar Segmento">-->
				</form>
			<?php
			}
			/*******************************  TERMINA SECCIÓN "LISTADO SEGMENTOS" **********************************************/
			 ?>
		</div>
	<?php
	}
	?>
</div>

<script>
	function segmento_tipo1(){
			document.getElementById('img_segmento').style.display = 'block';
			document.getElementById('texto1_segmento').style.display = 'none';
			document.getElementById('texto2_segmento').style.display = 'block';
			document.getElementById('tipo_segmento').value=1;
			document.getElementById('btn_agregar_segmento').style.display = 'block';
	}
	function segmento_tipo2(){
			document.getElementById('img_segmento').style.display = 'block';
			document.getElementById('texto1_segmento').style.display = 'none';
			document.getElementById('texto2_segmento').style.display = 'none';	
			document.getElementById("tipo_segmento").value=2;
			document.getElementById('btn_agregar_segmento').style.display = 'block';

	}
	function segmento_tipo3(){
			document.getElementById('img_segmento').style.display = 'none';
			document.getElementById('texto1_segmento').style.display = 'block';
			document.getElementById('texto2_segmento').style.display = 'block';	
			document.getElementById("tipo_segmento").value=3;
			document.getElementById('btn_agregar_segmento').style.display = 'block';
	}
	function segmento_tipo4(){
			document.getElementById('img_segmento').style.display = 'none';
			document.getElementById('texto1_segmento').style.display = 'none';
			document.getElementById('texto2_segmento').style.display = 'block';	
			document.getElementById("tipo_segmento").value=4;
			document.getElementById('btn_agregar_segmento').style.display = 'block';
	}




function myFunction() {
    
}


	/*function funcion_segmentos() {
	    var x = document.getElementById("tipo_segmento").value;
	    if(x == 1){
			document.getElementById('img_segmento').style.display = 'block';
			document.getElementById('texto1_segmento').style.display = 'none';
			document.getElementById('texto2_segmento').style.display = 'block';
			
	    }
	    if(x == 2){
			document.getElementById('img_segmento').style.display = 'block';
			document.getElementById('texto1_segmento').style.display = 'none';
			document.getElementById('texto2_segmento').style.display = 'none';
	    }

	    if(x == 3){
			document.getElementById('img_segmento').style.display = 'none';
			document.getElementById('texto1_segmento').style.display = 'block';
			document.getElementById('texto2_segmento').style.display = 'block';
	    }
	    if(x == 4){
			document.getElementById('img_segmento').style.display = 'none';
			document.getElementById('texto1_segmento').style.display = 'none';
			document.getElementById('texto2_segmento').style.display = 'block';
	    }
	    
	}*/
</script>
