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

if(isset($_POST['actualizar_pagina']) && $_POST['actualizar_pagina'] == 1){
	$insertSQL = sprintf("UPDATE informacion_web SET telefono = %s, email = %s, direccion_oficina = %s, informacion_adicional = %s WHERE idinformacion_web = 1",
		GetSQLValueString($_POST['telefono'], "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($_POST['direccion_oficina'], "text"),
		GetSQLValueString($_POST['informacion_adicional'], "text"));
	$ejecutar = mysql_query($insertSQL,$conectar) or die(mysql_error());

	$mensaje = "Información Actualizada Correctamente";

}
if(isset($_POST['agregar_img']) && $_POST['agregar_img'] == 1){

		if(!empty($_FILES['img_slide']['name'])){
			$ruta_img = "../img/slide/";
			$ruta_img = $ruta_img . basename( $_FILES['img_slide']['name']); 
			if(move_uploaded_file($_FILES['img_slide']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}
		$detalle = "";

		$insertSQL = sprintf("INSERT INTO slide (img, detalle) VALUES (%s, %s)",
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($detalle, "text"));
		$ejecutar = mysql_query($insertSQL, $conectar) or die(mysql_error());
		$mensaje = "Imagen Agregada Correctamente";

}

$consultar = mysql_query("SELECT * FROM informacion_web",$conectar) or die(mysql_error());
$informacion_web = mysql_fetch_assoc($consultar);
 ?>
<div class="row">

 	<div class="col-md-12">
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
 		<!--<button class="btn btn-default">Listado</button>
 		<button class="btn btn-default">Agregar Usuario</button>-->
 	</div>

	<div class="col-md-12">
		<h3>Información Sitio Web</h3>

		<form action="" method="POST">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Detalles de Contacto</h3>
			  </div>
			  <table class="table">
			  	<tr>
			  		<td>Teléfono</td>
			  		<td><input type="text" class="form-control" name="telefono" placeholder="Teléfono" value="<?php echo $informacion_web['telefono']; ?>"></td>
			  	</tr>
			  	<tr>
			  		<td>Email</td>
			  		<td><input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $informacion_web['email']; ?>"></td>
			  	</tr>
			  	<tr>
			  		<td>Dirección Oficinas</td>
			  		<td><textarea name="direccion_oficina" class="form-control" id="" rows="3"><?php echo $informacion_web['direccion_oficina']; ?></textarea></td>
			  	</tr>
			  	<tr>
			  		<td>Información Adicional</td>
			  		<td><textarea name="informacion_adicional" id="" class="form-control" rows="3"><?php echo $informacion_web['informacion_adicional']; ?></textarea></td>
			  	</tr>
				<tr>
					<td colspan="2"><button type="submit" class="btn btn-success">Actualizar</button></td>
					<input type="hidden" name="actualizar_pagina" value="1">
				</tr>
			  </table>
			</div>
		</form>

		<form action="" method="POST" enctype="multipart/form-data">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Slide Imagenes</h3>
			  </div>
			  <table class="table">
			  	<tr>
			  		<td>
			  			Imagenes Agregadas<br>
			  			<img src="" alt="" width="100px;">
			  		</td>


			  		<td>
			  			Nueva Imagen
			  			<input type="file" class="form-control" name="img_slide">
			  		</td>
			  	</tr>
				<tr>
					<td colspan="2"><button type="submit" class="btn btn-success">Agregar</button></td>
					<input type="text" name="agregar_img" value="1">
				</tr>
			  </table>
			</div>
		</form>

	</div>
</div>