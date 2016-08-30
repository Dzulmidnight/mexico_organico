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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  if(isset($_GET['id_org']) && $_GET['id_org'] != ''){
    $idorganizacion = $_GET['id_org'];
  }else{
    $idorganizacion = $_POST['select_idorganizacion'];
  }
  $insertSQL = sprintf("INSERT INTO ciclo (idorganizacion, ciclo, fecha, descripcion, produccion_volumen, produccion_superficie, numero_productores, hombres, mujeres) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($idorganizacion, "int"),
                       GetSQLValueString($_POST['ciclo'], "text"),
                       GetSQLValueString($_POST['fecha'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['produccion_volumen'], "text"),
                       GetSQLValueString($_POST['produccion_superficie'], "text"),
                       GetSQLValueString($_POST['numero_productores'], "int"),
                       GetSQLValueString($_POST['hombres'], "int"),
                       GetSQLValueString($_POST['mujeres'], "int"));

  //mysql_select_db($database_organizacion, $kafeprod_bio);
  $Result1 = mysql_query($insertSQL, $kafeprod_bio) or die(mysql_error());
  $mensaje = "Ciclo Agregado Correctamente";
}

//mysql_select_db($database_organizacion, $kafeprod_bio);
if(isset($_GET['id_org']) && $_GET['id_org'] != ''){
  $query_ciclo = "SELECT ciclo.*, ciclo.descripcion AS 'descripcion_ciclo', organizacion.* FROM ciclo LEFT JOIN organizacion ON ciclo.idorganizacion = organizacion.idorganizacion WHERE organizacion.idorganizacion = $_GET[id_org]";
  //$query_ciclo = "SELECT * FROM ciclo WHERE idorganizacion = $_GET[id_org] ORDER BY ciclo ASC";
}else{
  $query_ciclo = "SELECT ciclo.*, ciclo.descripcion AS 'descripcion_ciclo', organizacion.* FROM ciclo LEFT JOIN organizacion ON ciclo.idorganizacion = organizacion.idorganizacion";
  //$query_ciclo = "SELECT * FROM ciclo ORDER BY ciclo ASC";
}

$ciclo = mysql_query($query_ciclo, $kafeprod_bio) or die(mysql_error());
//$row_ciclo = mysql_fetch_assoc($ciclo);
$totalRows_ciclo = mysql_num_rows($ciclo);
?>

<body>
    <div class="col-lg-12">
      <div class="row">
        <a class="btn <?php if(isset($_GET['listado_ciclo'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default';} ?>" href="?menu=organizacion&listado_ciclo">Listado Ciclos</a>
        <?php 
        if(isset($_GET['id_org']) && $_GET['id_org'] != ''){
        ?>
        <a class="btn <?php if(isset($_GET['add_ciclo'])){ echo 'btn btn-primary';}else{ echo 'btn btn-default';} ?>" href="?menu=organizacion&add_ciclo&id_org=<?php echo $_GET['id_org']; ?>">Agregar Ciclo</a> 
        <?php
        }
         ?>     
      </div>
      <!--<form id="form1" name="form1" method="post" action="">
        <input class="btn btn-primary" type="submit" name="button" id="button" value="Agregar ciclo" />
        <input name="add_ciclo" type="hidden" value="1" />
      </form>-->
    </div>


<div class="col-lg-12">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <h2>Listado de ciclos</h2> 
        <?php 
        if(isset($_GET['id_org']) && $_GET['id_org'] != ''){
          $organizacion = mysql_query("SELECT idorganizacion, organizacion FROM organizacion WHERE idorganizacion = $_GET[id_org]",$kafeprod_bio) or die(mysql_error()); 
          $detail_organizacion = mysql_fetch_assoc($organizacion);
           ?>
          <p class="alert alert-info" style="padding:7px;">Organización: <b><?php echo $detail_organizacion['organizacion']; ?></b></p>
        <?php
        } 
        ?>
      </div>
      
    </div>

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

    <?php if(isset($_GET['add_ciclo'])){ ?>

      <?php 
      if(!isset($_GET['id_org']) || $_GET['id_org'] == ''){
      ?>
        <div class="col-lg-12">
          <div class="row">
            <hr>
            <select class="" name="select_idorganizacion">
              <option>...</option>
              <?php 
              $query = "SELECT * FROM organizacion";
              $row_organizacion = mysql_query($query,$kafeprod_bio) or die(mysql_error());
              while($datos_organizacion = mysql_fetch_assoc($row_organizacion)){
              ?>
                <option value="<?php echo $datos_organizacion['idorganizacion']; ?>">
                  <?php echo $datos_organizacion['organizacion']; ?>
                </option>
              <?php
              }
               ?>
            </select>
          </div>

        </div>
      <?php
      }
      ?>

      <div class="col-lg-3">
        <div class="row">
          <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
            <table class="table table-bordered" style="font-size:12px;">
              <thead>
                <tr>
                  <th colspan="2">Agregar Ciclo</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Ciclo:</td>
                  <td><input class="form-control" type="text" name="ciclo" value=""></td>
                </tr>
                <tr>
                  <td>Fecha:</td>
                  <td><input class="form-control" type="date" name="fecha" value=""></td>
                </tr>
                <tr>
                  <td>Descripción:</td>
                  <td><textarea class="form-control" name="descripcion" ></textarea></td>
                </tr>
                <tr>
                  <td>Producción Volumen:</td>
                  <td><input class="form-control" type="text" name="produccion_volumen" value=""></td>
                </tr>
                <tr>
                  <td>Producción Superficie:</td>
                  <td><input class="form-control" type="text" name="produccion_superficie" value=""></td>
                </tr>
                <tr>
                  <td>Número Productores:</td>
                  <td><input class="form-control" type="number" name="numero_productores" value=""></td>
                </tr>
                <tr>
                  <td>Hombre:</td>
                  <td><input class="form-control" type="number" name="hombres" value=""></td>
                </tr>
                <tr>
                  <td>Mujeres:</td>
                  <td><input class="form-control" type="number" name="mujeres" value=""></td>
                </tr>
                <tr style="border:hidden;border-top:solid">
                  <td colspan="2"><input class="btn btn-success" type="submit" value="Agregar Ciclo"></td>
                </tr>
              </tbody>
            </table>
            <input type="hidden" name="idorganizacion" value="session_idorganizacion" />
            <input type="hidden" name="MM_insert" value="form2" />
          </form>
        </div>
      </div>
    <?php } ?>
    <?php
    if(!empty($_GET['recordID'])){
      include('detail_ciclo.php');
    }else{
    ?>
      <div class="<?php if(isset($_GET['add_ciclo'])){ echo 'col-lg-9'; }else{ echo 'col-lg-12';} ?>">
        <div class="row">
          <table class="table table-bordered table-condensed" style="font-size:12px;">
             <tr>
                <!--<td>Id<br>Ciclo</td>-->
                <td>Organizacion</td>
                <td>Ciclo</td>
                <td>Fecha</td>
                <td>Descripción</td>
                <td>Producción Volumen</td>
                <td>Producción Superficie</td>
                <td>Número Productores</td>
                <td>Hombres</td>
                <td>Mujeres</td>
            </tr>
            <?php while($row_ciclo = mysql_fetch_assoc($ciclo)){ ?>
              <tr>
                <!--<td><a class="btn btn-sm btn-info" href="?menu=organizacion&listado_ciclo&recordID=<?php echo $row_ciclo['idciclo']; ?>"><?php echo $row_ciclo['idciclo']; ?> Consultar</a></td>-->
                <td>
                  <a class="" href="?menu=organizacion&detail_organizacion=<?php echo $row_ciclo['idorganizacion']; ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> | <?php echo $row_ciclo['organizacion']; ?></a>
                  
                </td>
                <td><a href="?menu=organizacion&listado_ciclo&recordID=<?php echo $row_ciclo['idciclo']; ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> | <?php echo $row_ciclo['ciclo']; ?></a></td>
                <td><?php echo $row_ciclo['fecha']; ?></td>
                <td><?php echo $row_ciclo['descripcion_ciclo']; ?></td>
                <td><?php echo $row_ciclo['produccion_volumen']; ?></td>
                <td><?php echo $row_ciclo['produccion_superficie']; ?></td>
                <td><?php echo $row_ciclo['numero_productores']; ?></td>
                <td><?php echo $row_ciclo['hombres']; ?></td>
                <td><?php echo $row_ciclo['mujeres']; ?></td>
              </tr>
            <?php } 

            ?>
          </table>
        </div>
      </div>
    <?php
    }
     ?>
  </div>
</div>




<?php
mysql_free_result($ciclo);
?>
