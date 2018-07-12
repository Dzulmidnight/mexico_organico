<?php 
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);

$row_sitios = mysql_query("SELECT * FROM sitios ORDER BY fecha_registro DESC", $conectar);

 ?>
<!-- === BEGIN HEADER === -->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->
    <head>
        <!-- Title -->
        <title>Nosotros - México Orgánico</title>
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

            <!-- Top Menu -->
            <?php include('top_menu.php'); ?>
            <!-- End Top Menu -->
            <!-- === END HEADER === -->
            <!-- === BEGIN CONTENT === -->


            <!-- End Top Panels -->
            <hr class="margin-top-3 0">
            <!-- Middle Text -->
            <div class="row">
                <div class="col-md-12 text-center margin-top-10 animate fadeInUp">
                    <h2 class="text-center">Sitio de Interes</h2>
                    
                </div>
            </div>
            <!-- End Middle Text -->
            <hr>

            <div id="content">
                <div class="container background-white">
                    <div class="row margin-vert-30">
                        <div class="col-md-12">
                            <div class="row margin-bottom-30">
                                <!--<div class="col-md-3 animate fadeInLeft">
                                    <p>Commodo id natoque malesuada sollicitudin elit suscipit. Curae suspendisse mauris posuere accumsan massa posuere lacus convallis tellus interdum. Amet nullam fringilla nibh nulla convallis ut venenatis purus lobortis.</p>
                                    <p>Lorem Ipsum is simply dummy text of Lorem the printing and typesettings. Aliquam dictum nulla eu varius porta. Maecenas congue dui id posuere fermentum. Sed fringilla sem sed massa ullamcorper, vitae rutrum justo sodales.
                                        Cras sed iaculis enim. Sed aliquet viverra nisl a tristique. Curabitur vitae mauris sem.</p>
                                </div>
                                <!-- Person Details -->
                                <?php 
                                while($sitio = mysql_fetch_assoc($row_sitios)){
                                ?>
                                <div class="col-md-3 col-sm-3 col-xs-6 person-details margin-bottom-30">
                                    <figure>
                                        <figcaption style="background:#fff;color:#2c3e50;height:400px;overflow:scroll" class="text-justify">
                                            <a href="<?php echo $sitio['url'] ?>" target="_new">
                                                <h3 class="margin-bottom-10"><?php echo $sitio['nombre']; ?>
                                                    <!--<small>- Nombre de la página</small>-->
                                                </h3>
                                            </a>
                                            <a href="<?php echo $sitio['url']; ?>" target="_new"><img src="system/administrador/<?php echo $sitio['img']; ?>" style="height:185px;" alt="<?php echo $sitio['nombre']; ?>"></a>
                                            <div>
                                                <span class="text-justify"><?php echo $sitio['descripcion']; ?></span>    
                                            </div>
                                        </figcaption>
                                        
                                        <!--<ul class="list-inline person-details-icons">
                                            <li>
                                                <a href="#">
                                                    <i class="fa-lg fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa-lg fa-linkedin"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa-lg fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa-lg fa-dribbble"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa-lg fa-google-plus"></i>
                                                </a>
                                            </li>
                                        </ul>-->
                                    </figure>
                                </div>
                                <?php
                                }
                                 ?>
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- === END CONTENT === -->
            <!-- === BEGIN FOOTER === -->
            <div id="base">
                <div class="container bottom-border padding-vert-30">
                    <div class="row">
                        <!-- Disclaimer -->
                        <div class="col-md-4">
                            <h3 class="class margin-bottom-10">Declaración</h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            </p>rstock.com</a>. Links are provided if you wish to purchase them from their copyright owners.</p>
                        </div>
                        <!-- End Disclaimer -->
                        <!-- Contact Details -->
                        <div class="col-md-4 margin-bottom-20">
                            <h3 class="margin-bottom-10">Detalles de Contacto</h3>
                            <p>
                                <span class="fa-phone">Teléfono:</span>1-800-123-4567
                                <br>
                                <span class="fa-envelope">Email:</span>
                                <a href="mailto:info@example.com">info@example.com</a>
                                <br>
                                <span class="fa-link">Sitio Web:</span>
                                <a href="http://mexorganico.com/">www.mexorganico.com</a>
                            </p>
                            <p>The Dunes, Top Road,
                                <br>Strandhill,
                                <br>Co. Sligo,
                                <br>Ireland</p>
                        </div>
                        <!-- End Contact Details -->
                        <!-- Sample Menu -->
                        <div class="col-md-4 margin-bottom-20">
                            <h3 class="margin-bottom-10">Menu</h3>
                            <ul class="menu">
                                <li>
                                    <a class="fa-tasks" href="index.php">Inicio</a>
                                </li>
                                <li>
                                    <a class="fa-users" href="nosotros.html">Nosotros</a>
                                </li>
                                <li>
                                    <a class="fa-comments" href="articulos.php">Articulos</a>
                                </li>
                                <li>
                                    <a class="fa-coffee" href="sitios_interes.html">Sitios de Interes</a>
                                </li>
                                <li>
                                    <a class="fa-cloud" href="biblioteca.html">Biblioteca</a>
                                </li>
                                <li>
                                    <a class="fa-envelope" href="contact.html">Contactanos</a>
                                </li>


                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <!-- End Sample Menu -->
                    </div>
                </div>
            </div>


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