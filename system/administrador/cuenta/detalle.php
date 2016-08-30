<!DOCTYPE php>
<?php
// *** Validate request to login to this site.
	if($_SESSION["autentificado"] == false){
		header("Location: ../../../login.php");
	}
	mysql_select_db($database, $conectar);
	


	if(isset($_POST['actualizar_cuenta']) && $_POST['actualizar_cuenta'] == 1){
		$idusuario = $_SESSION['idusuario'];
		$clase = $_POST['clase'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$query = "UPDATE usuario SET clase = '$clase', username = '$username', password = '$password', nombre = '$nombre', email = '$email' WHERE idusuario = $idusuario";
		$actualizar = mysql_query($query,$conectar) or die(mysql_error());
		$mensaje = "Datos Actualizados Correctamente";

	}

	$query = "SELECT * FROM usuario WHERE idusuario = ".$_SESSION['idusuario']."";
	$row_usuario = mysql_query($query,$conectar) or die(mysql_error());
	$usuario = mysql_fetch_assoc($row_usuario);

?>
<h3>Mi Cuenta</h3>
<hr>

<div class="row">
	<div class="col-xs-12">
		<form action="" method="POST">
			<?php 
			if(isset($mensaje) && $mensaje){
			?>
				<div class="alert alert-success alert-dismissible" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  					<?php echo $mensaje ?>
				</div>
			<?php	
			}
			 ?>
			<label for="clase">Clase</label>

			<input type="text" class="form-control" id="clase" name="clase" value="<?php echo $usuario['clase']; ?>" readonly>
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" value="<?php echo $usuario['username']; ?>">
			<label for="password">Password</label>
			<input type="text" class="form-control" id="password" name="password" value="<?php echo $usuario['password']; ?>">
			<label for="nombre">Nombre</label>
			<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>">
			<input type="hidden" name="actualizar_cuenta" value="1">
			<input type="submit" class="btn btn-success" value="Actualizar">
		</form>
	</div>
</div>