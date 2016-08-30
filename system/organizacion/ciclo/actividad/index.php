<?php
if (isset($_GET['recordID'])) {
  $_GET['idciclo'] = $_GET['recordID'];
}
?>
<?php require_once('../../Connections/organizacion.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add_actividad")) {

  if(!empty($_FILES['fotografia']['name'])){
    $ruta_img = "../img/img_actividad/";
    $ruta_img = $ruta_img . basename( $_FILES['fotografia']['name']); 
    if(move_uploaded_file($_FILES['fotografia']['tmp_name'], $ruta_img)){ 
      //echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
    } /*else{
      echo "Ha ocurrido un error, trate de nuevo!";
    }*/
  }else{
    $ruta_img = '';
  }

  $insertSQL = sprintf("INSERT INTO actividad (idciclo, actividad, descripcion, fecha_inicio, fecha_fin, beneficio_biodiversidad, fotografia) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idciclo'], "int"),
                       GetSQLValueString($_POST['actividad'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['fecha_inicio'], "text"),
                       GetSQLValueString($_POST['fecha_fin'], "text"),
                       GetSQLValueString($_POST['beneficio_biodiversidad'], "text"),
                       GetSQLValueString($ruta_img, "text"));

  mysql_select_db($database_organizacion, $organizacion);
  $Result1 = mysql_query($insertSQL, $organizacion) or die(mysql_error());
}

$colname_actividad_list = "-1";
if (isset($_GET['idciclo'])) {
  $colname_actividad_list = $_GET['idciclo'];
}
mysql_select_db($database_organizacion, $organizacion);
$query_actividad_list = sprintf("SELECT * FROM actividad WHERE idciclo = %s ORDER BY fecha_inicio ASC", GetSQLValueString($colname_actividad_list, "int"));
$actividad_list = mysql_query($query_actividad_list, $organizacion) or die(mysql_error());



?>

<div class="col-lg-6 col-md-6 col-lg-push-6">
  <div class="row">
    <?php if(isset($_POST['add_actividad'])){?>
    <div class="col-md-12">
      <b>Agregar actividad</b>
    </div>
    <div class="col-md-12">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2" enctype="multipart/form-data">
        <table class="table table-bordered table-condensed" style="font-size:12px;">
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Actividad:</td>
            <td><input class="form-control" type="text" name="actividad" value="" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right" valign="top">Descripción:</td>
            <td><textarea class="form-control" name="descripcion" cols="50" rows="5"></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Fecha Inicio:</td>
            <td><input type="date" class="form-control" name="fecha_inicio" value=""/></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Fecha Fin:</td>
            <td><input type="date" class="form-control" name="fecha_fin" value=""/></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right" valign="top">Beneficio<br>Biodiversidad:</td>
            <td><textarea class="form-control" name="beneficio_biodiversidad" ></textarea></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Fotografía:</td>
            <td><input type="file" name="fotografia" value=""  /></td>
          </tr>
          <tr valign="baseline">
            <td colspan="2"><input class="btn btn-success" type="submit" value="Insertar Actividad" /></td>
          </tr>
        </table>
        <input type="hidden" name="idciclo" value="<?php echo $_GET['idciclo']; ?>" />
        <input type="hidden" name="MM_insert" value="add_actividad" />
      </form>
    </div>
    <?php }?>
  </div>
</div>

<div class="col-lg-6 col-md-6 col-lg-pull-6" style="padding:0px;">
  <div class="row">
    <div class="col-md-6">
      <b>Actividades agregadas a este ciclo</b>
    </div>
    <div class="col-md-6">
      <form id="form1" name="form1" method="post" action="">
        <input class="btn btn-primary form-control" type="submit" name="button" id="button" value="Nueva actividad" />
        <input name="add_actividad" type="hidden" value="1" />
      </form>
    </div>
    <div class="col-md-12">
      <div class="table-responsive">
        <table  class="table table-bordered table-condensed" style="font-size:12px;">
          <tr>
            <td>Actividad</td>
            <td>Descripción</td>
            <td>Fecha Inicio</td>
            <td>Fecha Fin</td>
            <td>Beneficio Biodiversidad</td>
            <td>Fotografía</td>
          </tr>
          <?php 
          while($row_actividad_list = mysql_fetch_assoc($actividad_list)){
          ?>
            <tr>
              <td><?php echo $row_actividad_list['actividad']; ?></td>
              <td><?php echo $row_actividad_list['descripcion']; ?></td>
              <td><?php echo $row_actividad_list['fecha_inicio']; ?></td>
              <td><?php echo $row_actividad_list['fecha_fin']; ?></td>
              <td><?php echo $row_actividad_list['beneficio_biodiversidad']; ?></td>
              <td><a href="<?php echo $row_actividad_list['fotografia']; ?>" target="_new"><img width="100px;" class="img-thumbnail" src="<?php echo $row_actividad_list['fotografia']; ?>" alt=""></a></td>
            </tr>
          <?php
          }
           ?>
        </table>
      </div>
    </div>
  </div>
</div>


<?php
mysql_free_result($actividad_list);
?>
