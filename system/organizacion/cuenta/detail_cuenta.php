<?php require_once('../../Connections/organizacion.php'); 
mysql_select_db($database_organizacion, $organizacion);

?>
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
if(isset($_POST['update_organizacion']) && $_POST['update_organizacion'] == 1){
  $updateSQL = sprintf("UPDATE organizacion SET organizacion=%s, username=%s, password=%s, ubicacion=%s, descripcion=%s WHERE idorganizacion=%s",
                       GetSQLValueString($_POST['organizacion'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['ubicacion'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['idorganizacion'], "int"));


  $Result1 = mysql_query($updateSQL, $organizacion) or die(mysql_error());
  $mensaje = "Datos Actualizados Correctamente";
}
$query_detail = sprintf("SELECT * FROM organizacion WHERE idorganizacion = %s", GetSQLValueString($idorganizacion, "int"));
$detail_organizacion = mysql_query($query_detail, $organizacion) or die(mysql_error());
$row_organizacion = mysql_fetch_assoc($detail_organizacion);
$totalRows_detail_organizacion = mysql_num_rows($detail_organizacion);

 ?>

<h2>Mi Cuenta</h2>
    <?php 
    if(isset($mensaje)){
    ?>
      <div class="alert alert-success alert-dismissible col-lg-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $mensaje; ?>
      </div>
    <?php
    }
     ?>
<div class="col-lg-12">
	<div class="row">
		<table class="table table-bordered">
			<form action="" method="POST">
			<tr>
				<td>Organización</td>
				<td>
					<input class="form-control" type="text" name="organizacion" value="<?php echo $row_organizacion['organizacion']; ?>">
				</td>
			</tr>

			<tr>
				<td>Username</td>
				<td>
					<input class="form-control" type="text" name="username" value="<?php echo $row_organizacion['username']; ?>">
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>
					<input class="form-control" type="text" name="password" value="<?php echo $row_organizacion['password']; ?>">
				</td>
			</tr>
			<tr>
				<td>Ubicación</td>
				<td>
					<input class="form-control" type="text" name="ubicacion" value="<?php echo $row_organizacion['ubicacion']; ?>">
				</td>
			</tr>
			<tr>
				<td>Descripción</td>
				<td>
					<textarea class="form-control" name="descripcion" ><?php echo $row_organizacion['descripcion']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="border:hidden;border-top:solid;"><input class="btn btn-success" type="submit" value="Actualizar Informacion"></td>
				<input type="hidden" name="idorganizacion" value="<?php echo $row_organizacion['idorganizacion']; ?>">
				<input type="hidden" name="update_organizacion" value="1">
			</tr>
			</form>
		</table>
	</div>
</div>