<?php 
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);

$row_informacion = mysql_query("SELECT * FROM informacion_web", $conectar) or die(mysql_error());
$informacion_web = mysql_fetch_assoc($row_informacion);
 ?>

<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->
    <head>
        <!-- Title -->
        <title>Contactanos - México Orgánico</title>
        <!-- Meta -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!-- Favicon -->
        <link href="assets/img/ico.png" rel="shortcut icon">
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" rel="stylesheet">
        <!-- Template CSS -->
        <link rel="stylesheet" href="assets/css/animate.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/nexus.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/custom.css" rel="stylesheet">
        <!-- Google Fonts-->
        <link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="body-bg">
            <!-- Phone/Email -->

            <!-- End Header -->
            <!-- Top Menu -->
            <?php include('top_menu.php'); ?>
            <!-- End Top Menu -->
            <!-- === END HEADER === -->
            <!-- === BEGIN CONTENT === -->
            <div id="content">
                <div class="container background-white">
                    <div class="row margin-vert-30">
                        <!-- Main Column -->
                        <div class="col-md-9">
                            <!-- Main Content -->
                            <div class="headline">
                                <h2>Contactanos</h2>
                            </div>
                            <!-- Contact Form -->
                            <form>
                                <label>Nombre</label>
                                <div class="row margin-bottom-20">
                                    <div class="col-md-6 col-md-offset-0">
                                        <input class="form-control" type="text" placeholder="Escribe tu Nombre">
                                    </div>
                                </div>
                                <label>Email
                                    <span class="color-red">*</span>
                                </label>
                                <div class="row margin-bottom-20">
                                    <div class="col-md-6 col-md-offset-0">
                                        <input class="form-control" type="text" placeholder="Escribe tu Correo">
                                    </div>
                                </div>
                                <label>Mensaje</label>
                                <div class="row margin-bottom-20">
                                    <div class="col-md-8 col-md-offset-0">
                                        <textarea rows="8" class="form-control"></textarea>
                                    </div>
                                </div>
                                <p>
                                    <button type="submit" class="btn btn-primary">Envíar Mensaje</button>
                                </p>
                            </form>
                            <!-- End Contact Form -->
                            <!-- End Main Content -->
                        </div>
                        <!-- End Main Column -->
                        <!-- Side Column -->
                        <div class="col-md-3">
                            <!-- Recent Posts -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Información de Contacto</h3>
                                </div>
                                <!--<div class="panel-body">
                                    <ul class="list-unstyled">
                                        <li>
                                            <i class="fa-phone color-primary"></i>+353-44-55-66</li>
                                        <li>
                                            <i class="fa-envelope color-primary"></i>info@example.com</li>
                                        <li>
                                            <i class="fa-home color-primary"></i>http://www.example.com</li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li>
                                            <strong class="color-primary">Lunes-Viernes:</strong>9am to 6pm</li>
                                        <li>
                                            <strong class="color-primary">Sabados:</strong>10am to 3pm</li>
                                        <li>
                                            <strong class="color-primary">Domingos:</strong>Cerrado</li>
                                    </ul>
                                </div>-->
                                <div class="panel-body">
                                    <p>
                                        <span class="fa-phone">Teléfono:</span> <?php echo $informacion_web['telefono']; ?>
                                        <br>
                                        <span class="fa-envelope">Email:</span>
                                        <a href="mailto:<?php echo $informacion_web['email']; ?>"><?php echo $informacion_web['email']; ?></a>
                                        <br>
                                        <span class="fa-link">Sitio Web:</span>
                                        <a href="http://mexorganico.com/">www.mexorganico.com</a>
                                    </p>
                                    <p>
                                        <?php
                                        echo nl2br($informacion_web['direccion_oficina']);
                                         ?>
                                    </p>
                                </div>
                            </div>
                            <!-- End recent Posts -->
                            <!-- About -->
                            <!--<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Acerca de</h3>
                                </div>
                                <div class="panel-body">
                                    Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.
                                </div>
                            </div>
                            <!-- End About -->
                        </div>
                        <!-- End Side Column -->
                    </div>
                </div>
            </div>
            <!-- === END CONTENT === -->
            <!-- === BEGIN FOOTER === -->
            <?php 
            include("footer.php");
             ?>

            <!-- JS -->
            <script type="text/javascript" src="assets/js/jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="assets/js/bootstrap.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="assets/js/scripts.js"></script>
            <!-- Isotope - Portfolio Sorting -->
            <script type="text/javascript" src="assets/js/jquery.isotope.js" type="text/javascript"></script>
            <!-- Mobile Menu - Slicknav -->
            <script type="text/javascript" src="assets/js/jquery.slicknav.js" type="text/javascript"></script>
            <!-- Animate on Scroll-->
            <script type="text/javascript" src="assets/js/jquery.visible.js" charset="utf-8"></script>
            <!-- Sticky Div -->
            <script type="text/javascript" src="assets/js/jquery.sticky.js" charset="utf-8"></script>
            <!-- Slimbox2-->
            <script type="text/javascript" src="assets/js/slimbox2.js" charset="utf-8"></script>
            <!-- Modernizr -->
            <script src="assets/js/modernizr.custom.js" type="text/javascript"></script>
            <!-- End JS -->
    </body>
</html>
<!-- === END FOOTER === -->