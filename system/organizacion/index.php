<?php
// *** Validate request to login to this site.
	require_once("../../connections/sesion.php");
  require_once("../../connections/mail.php");
  require_once("../../connections/kafeprod_bio.php");

    mysql_select_db($database_kafeprod_bio, $kafeprod_bio);
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

    <title>KafeProdyser</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

    <!-- Custom styles for this template -->
    <link href="../dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'.textarea' });</script>

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
  $idorganizacion = $_SESSION['idorganizacion'];
  $query = "SELECT * FROM organizacion WHERE idorganizacion = $idorganizacion";
  $ejecutar = mysql_query($query,$kafeprod_bio) or die(mysql_error());
  $datos_organizacion = mysql_fetch_assoc($ejecutar);
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
          <a class="navbar-brand" href="index.php">KafeProdyser</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="visible-xs nav navbar-nav navbar-right">
            <li><p style="color:#fff">Organización: <strong style="color:#c0392b"><?php echo $_SESSION['username'];?></strong></p></li>
            <li <?php if(empty($menu)){ echo 'class="active"';} ?>><a href="index.php">Ciclos</span></a></li>
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
        <div class="col-sm-2 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><p>Organización: <strong style="color:#c0392b"><?php echo $_SESSION['username'];?></strong></p></li>
            <li <?php if(empty($menu)){ echo 'class="active"';}else if($menu == 'ciclo'){ echo 'class="active"';} ?>><a href="?menu=ciclo">Ciclos</span></a></li>
            <li <?php if($menu == "cuenta"){ echo 'class="active"';} ?>><a href="?menu=cuenta">Mi Cuenta</a></li>
            <li><a href="../../connections/salir.php">Cerrar Sesión</a></li>
          </ul>

        </div>
      	<!------------------------ TERMINA SECCIÓN MENÚ OPCIONES ------------------------------>

      	<!------------------------ INICIA SELECTOR CICLOS ------------------------------>
        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 main" style="padding-left:10px;padding-right:0px;">
          <?php 
            include("selector_primario.php");
           ?>
        </div>
      	<!------------------------ TERMINA SELECTOR CICLOS ------------------------------>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
