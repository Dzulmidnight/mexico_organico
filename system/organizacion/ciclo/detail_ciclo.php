<?php require_once('../../Connections/organizacion.php'); ?><?php
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE ciclo SET ciclo=%s, fecha=%s, descripcion=%s, produccion_volumen=%s, produccion_superficie=%s, numero_productores=%s, hombres=%s, mujeres=%s WHERE idciclo=%s",
                       GetSQLValueString($_POST['ciclo'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['produccion_volumen'], "text"),
                       GetSQLValueString($_POST['produccion_superficie'], "text"),
                       GetSQLValueString($_POST['numero_productores'], "int"),
                       GetSQLValueString($_POST['hombres'], "int"),
                       GetSQLValueString($_POST['mujeres'], "int"),
                       GetSQLValueString($_POST['idciclo'], "int"));

  mysql_select_db($database_organizacion, $organizacion);
  $Result1 = mysql_query($updateSQL, $organizacion) or die(mysql_error());
  $mensaje = "Ciclo Actualizado Correctamente";
}

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_organizacion, $organizacion);
$query_DetailRS1 = sprintf("SELECT * FROM ciclo WHERE idciclo = %s ORDER BY ciclo ASC", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $organizacion) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
?>

<div class="col-lg-12">
  <a class="btn <?php if(isset($_GET['ciclo'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default'; } ?>" href="?menu=ciclo&recordID=<?php echo $_GET['recordID']; ?>&ciclo">Ciclo</a>
  <a class="btn <?php if(isset($_GET['padron'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default'; } ?>" href="?menu=ciclo&recordID=<?php echo $_GET['recordID']; ?>&padron">Padron</a>
  <a class="btn <?php if(isset($_GET['actividades'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default'; } ?>" href="?menu=ciclo&recordID=<?php echo $_GET['recordID']; ?>&actividades">Actividades</a>
  <a class="btn <?php if(isset($_GET['fotografias'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default'; } ?>" href="?menu=ciclo&recordID=<?php echo $_GET['recordID']; ?>&fotografias">Fotografías</a>
  <hr>
</div>
<!--<ul>
  <li>
    <div>
      <form id="form1" name="form1" method="post" action="?recordID=<? echo $_GET['recordID'];?>&padron=true">
        <input type="submit" name="button" id="button" value="Padron" />
        <input name="add_ciclo" type="hidden" value="1" />
      </form>
    </div>
  </li>
  <li>
    <div>
      <form id="form1" name="form1" method="post" action="?recordID=<? echo $_GET['recordID'];?>&actividad=true">
        <input type="submit" name="button" id="button" value="Actividades" />
        <input name="add_ciclo" type="hidden" value="1" />
      </form>
    </div>
  </li>
  <li>
    <div>
      <form id="form1" name="form1" method="post" action="?recordID=<? echo $_GET['recordID'];?>&fotografia=true">
        <input type="submit" name="button" id="button" value="Fotografias" />
        <input name="add_ciclo" type="hidden" value="1" />
      </form>
    </div>
  </li>
</ul>-->
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
    <div class="col-lg-3" style="padding:0px;">

      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table class="table table-bordered table-condensed" style="font-size:12px;" >
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Ciclo:</td>
            <td><input class="form-control" type="text" name="ciclo" value="<?php echo htmlentities($row_DetailRS1['ciclo'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Fecha:</td>
            <td><input class="form-control" type="text" name="fecha" value="<?php echo htmlentities($row_DetailRS1['fecha'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Descripcion:</td>
            <td><input class="form-control" type="text" name="descripcion" value="<?php echo htmlentities($row_DetailRS1['descripcion'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Producción Volumen:</td>
            <td><input class="form-control" type="text" name="produccion_volumen" value="<?php echo htmlentities($row_DetailRS1['produccion_volumen'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Producción Superficie:</td>
            <td><input class="form-control" type="text" name="produccion_superficie" value="<?php echo htmlentities($row_DetailRS1['produccion_superficie'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Número Productores:</td>
            <td><input class="form-control" type="text" name="numero_productores" value="<?php echo htmlentities($row_DetailRS1['numero_productores'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Hombres:</td>
            <td><input class="form-control" type="text" name="hombres" value="<?php echo htmlentities($row_DetailRS1['hombres'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Mujeres:</td>
            <td><input class="form-control" type="text" name="mujeres" value="<?php echo htmlentities($row_DetailRS1['mujeres'], ENT_COMPAT, 'UTF-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td colspan="2" style="border:hidden;border-top:solid;"><input class="btn btn-success" type="submit" value="Actualizar Ciclo" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form2" />
        <input type="hidden" name="idciclo" value="<?php echo $row_DetailRS1['idciclo']; ?>" />
      </form>
    </div>


    <div class="col-lg-9" style="padding-right:0px;">
    <?php 
      include("selector.php");
    ?>
    </div>    
  </div>
</div>



<?php
mysql_free_result($DetailRS1);
?>