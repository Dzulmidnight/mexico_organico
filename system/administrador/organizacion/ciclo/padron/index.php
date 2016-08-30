<?php
if (isset($_GET['recordID'])) {
  $idciclo = $_GET['recordID'];
}
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add_padron")) {

  if(!empty($_FILES['url']['name'])){
    $ruta_img = "../img/img_padron/";
    $ruta_img = $ruta_img . basename( $_FILES['url']['name']); 
    if(move_uploaded_file($_FILES['url']['tmp_name'], $ruta_img)){ 
      //echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
    } /*else{
      echo "Ha ocurrido un error, trate de nuevo!";
    }*/
  }else{
    $ruta_img = '';
  }


  $insertSQL = sprintf("INSERT INTO padron (idciclo, url, fecha, descripcion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idciclo'], "int"),
                       GetSQLValueString($ruta_img, "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"));


  $Result1 = mysql_query($insertSQL, $kafeprod_bio) or die(mysql_error());
}

$colname_padron_list = "-1";
if (isset($idciclo)) {
  $colname_padron_list = $idciclo;
}
$query_padron_list = sprintf("SELECT * FROM padron WHERE idciclo = %s", GetSQLValueString($colname_padron_list, "int"));
$padron_list = mysql_query($query_padron_list, $kafeprod_bio) or die(mysql_error());

?>


<div class="col-lg-6 col-md-6 col-lg-push-6">
  <div class="row">
    <?php if(isset($_POST['add_padron'])){?>
    <div class="col-md-12">
      <b>Agregar padron</b>
    </div>
    <form method="post" name="form2" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
      <table class="table table-bordered">
        <tr valign="baseline">
          <td nowrap align="right">Url:</td>
          <td><input class="form-control" type="file" name="url" value=""></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Fecha:</td>
          <td><input class="form-control" type="date" name="fecha" value="" ></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Descripción:</td>
          <td><textarea class="form-control" name="descripcion"></textarea></td>
        </tr>
        <tr valign="baseline">
          <td colspan="2"><input class="btn btn-success" type="submit" value="Insertar Padron"></td>
        </tr>
      </table>
      <input type="hidden" name="idciclo" value="<?php echo $idciclo; ?>">
      <input type="hidden" name="MM_insert" value="add_padron">
    </form>
    <?php }?>
  </div>
</div>

<div class="col-lg-6 col-md-6 col-lg-pull-6" >
  <div class="row">
    <div class="col-md-6">
      <b>Padrones agregados a este ciclo</b>
    </div>
    <div class="col-md-6">
      <form id="form1" name="form1" method="post" action="">
        <input class="btn btn-primary form-control" type="submit" name="button" id="button" value="Nuevo Padron" />
        <input name="add_padron" type="hidden" value="1" />
      </form>
    </div>
    <div class="col-md-12">
      <table class="table table-bordered" style="font-size:12px;">
        <tr>
          <td style="width:80px">Descargar</td>
          <td>Fecha</td>
          <td>Descripción</td>
        </tr>
        <?php 
        while($row_padron_list = mysql_fetch_assoc($padron_list)){
        ?>
          <tr>
            <td><a class="btn btn-sm btn-primary" href="<?php echo $row_padron_list['url']; ?>" target="_new"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></td>
            <td><?php echo $row_padron_list['fecha']; ?></td>
            <td><?php echo $row_padron_list['descripcion']; ?></td>
          </tr>
        <?php
        }
         ?>
      </table>    
    </div>
  </div>
</div>

<?php
mysql_free_result($padron_list);
?>