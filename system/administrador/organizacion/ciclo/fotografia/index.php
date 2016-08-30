<?php
if (isset($_GET['recordID'])) {
  $_GET['idciclo'] = $_GET['recordID'];
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add_fotografia")) {

  if(!empty($_FILES['url']['name'])){
    $ruta_img = "../img/img_actividad/";
    $ruta_img = $ruta_img . basename( $_FILES['url']['name']); 
    if(move_uploaded_file($_FILES['url']['tmp_name'], $ruta_img)){ 
      //echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
    } /*else{
      echo "Ha ocurrido un error, trate de nuevo!";
    }*/
  }else{
    $ruta_img = '';
  }

  $insertSQL = sprintf("INSERT INTO fotografia (idciclo, url, titulo, descripcion, fecha) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idciclo'], "int"),
                       GetSQLValueString($ruta_img, "text"),
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"));


  $Result1 = mysql_query($insertSQL, $kafeprod_bio) or die(mysql_error());
}

$colname_fotografia_list = "-1";
if (isset($_GET['idciclo'])) {
  $colname_fotografia_list = $_GET['idciclo'];
}
$query_fotografia_list = sprintf("SELECT * FROM fotografia WHERE idciclo = %s ORDER BY fecha ASC", GetSQLValueString($colname_fotografia_list, "int"));
$fotografia_list = mysql_query($query_fotografia_list, $kafeprod_bio) or die(mysql_error());



?>
<div class="col-lg-6 col-md-6 col-lg-push-6">
  <div class="row">
    <?php if(isset($_POST['add_fotografia'])){?>
      <div class="col-md-12">
        <b>Agregar fotografia</b>  
      </div>
      <div class="col-md-12">
        <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2" enctype="multipart/form-data">
          <table class="table table-bordered table-condensed" style="font-size:12px;">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Url:</td>
              <td><input type="file" name="url" value="" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Titulo:</td>
              <td><input class="form-control" type="text" name="titulo" value="" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right" valign="top">Descripcion:</td>
              <td><textarea class="form-control" name="descripcion" cols="50" rows="5"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Fecha:</td>
              <td><input type="date" class="form-control" name="fecha" value=""/></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2"><input type="submit" class="form-control btn btn-success" value="Insertar Fotografia" /></td>
            </tr>
          </table>
          <input type="hidden" name="idciclo" value="<?php echo $_GET['idciclo']; ?>" />
          <input type="hidden" name="MM_insert" value="add_fotografia" />
        </form>
      </div>
    <?php }?>
  </div>
</div>

<div class="col-lg-6 col-md-6 col-lg-pull-6" style="padding:0px;">
  <div class="row">
    <div class="col-md-6">
      <b>Fotografias agregadas a este ciclo</b>
    </div>
    <div class="col-md-6">
      <form id="form1" name="form1" method="post" action="">
        <input class="btn btn-primary form-control" type="submit" name="button" id="button" value="Nueva fotografia" />
        <input name="add_fotografia" type="hidden" value="1" />
      </form>
    </div>
    <div class="col-md-12">
      <table  class="table table-bordered table-condensed" style="font-size:12px;">
        <?php 
        while($row_fotografia_list = mysql_fetch_assoc($fotografia_list)){
        ?>
          <tr >
            <td rowspan="4" style="width:120px;border:hidden;border-right:solid;"><a href="<?php echo $row_fotografia_list['url']; ?>" target="_new"><img width="100px;" class="img-thumbnail" src="<?php echo $row_fotografia_list['url'];?>"></a></td>
          </tr>
          <tr>
            <td><?php echo $row_fotografia_list['fecha']; ?></td>
          </tr>
          <tr>
            <td><h5><?php echo $row_fotografia_list['titulo']; ?></h5></td>
          </tr>
          <tr>
            <td><?php echo $row_fotografia_list['descripcion']; ?></td>
          </tr>
        <?php
        }
         ?>
  
      </table>
    </div>
  </div>
</div>


<?php
mysql_free_result($fotografia_list);
?>
