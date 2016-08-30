<?php 
if(isset($_POST['add_organizacion']) && $_POST['add_organizacion'] == 1){
  $insertSQL = sprintf("INSERT INTO organizacion (organizacion, username, password, ubicacion, descripcion) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['organizacion'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['ubicacion'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"));
  $ejecutar = mysql_query($insertSQL,$kafeprod_bio) or die(mysql_error());
  $mensaje = "Organizacion Agregada Correctamente";

}
?>

<h3>Agregar Organizacion</h3>
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
	<div class="col-lg-12">
		<div class="row">
			<form action="" method="POST">
				<table class="table table-bordered">
					<tr>
						<td>Organización</td>
						<td><input type="text" class="form-control" name="organizacion" required></td>
					</tr>
					<tr>
						<td>Username</td>
						<td><input type="text" class="form-control" name="username" required></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="text" class="form-control" name="password" required></td>
					</tr>
					<tr>
						<td>Ubicación</td>
						<td><input type="text" class="form-control" name="ubicacion" ></td>
					</tr>
					<tr>
						<td>Descripción</td>
						<td><textarea class="form-control" name="descripcion" id="" ></textarea></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="add_organizacion" value="1">
							<input type="submit" class="btn btn-success" value="Agregar Organización">
						</td>
					</tr>
				</table>
			</form>
		</div>		
	</div>