<?php
// *** Validate request to login to this site.
	require_once("../connections/sesion.php");
  require_once("../connections/mail.php");
  require_once("../connections/conexion.php");

    mysql_select_db($database, $conectar);
?>

<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="../../favicon.ico">-->

    <title>México Orgánico</title>



    <!-- Bootstrap core CSS -->
   <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!--<script src="../js/fileinput.min.js" type="text/javascript"></script>
    <script src="../js/fileinput_locale_es.js"></script>-->


     <!---LIBRERIAS DE Bootstrap File Input-->

    
    <link rel="stylesheet" href="../chosen/chosen.css">


    



    <script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>

  </head>

  <?php 
  if(isset($_GET['menu'])){
    $menu = $_GET['menu']; 
  }else{
    $menu = "";
  }
  
  ?>
<?php 
  $idusuario = $_SESSION['idusuario'];
  $query = "SELECT * FROM usuario WHERE idusuario = $idusuario";
  $ejecutar = mysql_query($query,$conectar) or die(mysql_error());
  $datos_usuario = mysql_fetch_assoc($ejecutar);
  $clase_usuario = $datos_usuario['clase'];
 ?>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">México Orgánico</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="visible-xs nav navbar-nav navbar-right">
            <li><a href="#">Usuario: <strong style="color:#c0392b"><?php echo $_SESSION['username'];?></strong></a></li>
            <li <?php if(empty($menu)){ echo 'class="active"';} ?>><a href="index.php">Inicio</span></a></li>
            <li <?php if($menu == "articulo"){ echo 'class="active"';} ?>><a href="?menu=articulo&listado">Articulos</a></li>
            <?php if($clase_usuario == 'adm'){ ?><li <?php if($menu == "usuarios"){ echo 'class="active"';}?> ><a href="?menu=usuarios">Usuarios</a></li><?php } ?>
            <li <?php if($menu == "cuenta"){ echo 'class="active"';} ?>><a href="?menu=cuenta">Mi Cuenta</a></li>
            <li><a href="../../connections/salir.php">Cerrar Sesión</a></li>
          </ul>
          <!--<form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
      	<!------------------------ INICIA SECCIÓN MENÚ OPCIONES ------------------------------>
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="disabled"><a href="#">Usuario: <strong style="color:#c0392b"><?php echo $_SESSION['username'];?></strong></a></li>
            <li <?php if(empty($menu)){ echo 'class="active"';} ?>><a href="index.php">Inicio</span></a></li>
            <li <?php if($menu == "articulo"){ echo 'class="active"';} ?>><a href="?menu=articulo&listado">Articulos</a></li>
            <?php if($clase_usuario == 'adm'){ ?><li <?php if($menu == "usuarios"){ echo 'class="active"';}?> ><a href="?menu=usuarios">Usuarios</a></li><?php } ?>
            <li <?php if($menu == "cuenta"){ echo 'class="active"';} ?>><a href="?menu=cuenta">Mi Cuenta</a></li>
            <li><a href="../../connections/salir.php">Cerrar Sesión</a></li>
          </ul>

        </div>
      	<!------------------------ TERMINA SECCIÓN MENÚ OPCIONES ------------------------------>

      	<!------------------------ INICIA SECCIÓN MENÚ SISTEMA ------------------------------>
        <div style="padding:10px;" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?php 
          include("selector.php");
         ?>
        </div>
      	<!------------------------ TERMINA SECCIÓN MENÚ SISTEMA ------------------------------>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

<!--  <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js" type="text/javascript"></script>-->
  <script src="../chosen/chosen.jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"100%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>


  </body>
</html>
