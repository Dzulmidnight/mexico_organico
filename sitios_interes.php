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
            <div id="hornav" class="bottom-border-shadow">
                <div class="container no-padding border-bottom">
                    <div class="row">
                        <div class="col-md-9 no-padding">
                            <div class="visible-lg">
                                <ul id="hornavmenu" class="nav navbar-nav" >
                                    <li class="hidden-xs hidden-sm">
                                        <a href="index.php" style="padding-top:0px;padding-bottom:0px;"><img src="assets/img/menu.png" alt=""></a>
                                    </li>
                                    <li class="visible-xs visible-sm">
                                        <a href="index.php">Inicio</a>
                                    </li>
                                    <li>
                                        <a href="nosotros.html"><span class="fa-gears ">Nosotros</span></a>
                                    </li>

                                    <li>
                                        <a href="articulos.php"><span class="fa-copy ">Articulos</span></a>
                                    </li>

                                    <li>
                                        <a href="sitios_interes.php" class="active"><span class="fa-th ">Sitios de Interes</span></a>
                                    </li>

                                    <li>
                                        <a href="biblioteca.php"><span class="fa-font ">Biblioteca</span></a>
                                    </li>
                                    <li>
                                        <a href="contact.php" class="fa-comment ">Contactanos</a>
                                    </li>
                                    <li>
                                        <a href="login.php" class="fa-comment ">Login</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 no-padding">
                            <ul class="social-icons rounded color pull-right">
                                <li class="social-rss">
                                    <a href="#" target="_blank" title="RSS"></a>
                                </li>
                                <li class="social-twitter">
                                    <a href="#" target="_blank" title="Twitter"></a>
                                </li>
                                <li class="social-facebook">
                                    <a href="https://www.facebook.com/MexicOrganico" target="_blank" title="Facebook"></a>
                                </li>
                                <li class="social-googleplus">
                                    <a href="#" target="_blank" title="Google+"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Top Menu -->
            <!-- === END HEADER === -->
            <!-- === BEGIN CONTENT === -->
            <div id="content">
                <div class="container background-white">
                    <div class="row margin-vert-30">
                        <div class="col-md-12">
                            <h2 class="margin-bottom-10">Sitios de Interes</h2>
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
                                        <figcaption>
                                            <a href="<?php echo $sitio['url'] ?>" target="_new">
                                                <h3 class="margin-bottom-10"><?php echo $sitio['nombre']; ?>
                                                    <!--<small>- Nombre de la página</small>-->
                                                </h3>
                                            </a>
                                            <span class="text-justify"><?php echo $sitio['descripcion']; ?></span>
                                        </figcaption>
                                        <a href="<?php echo $sitio['url']; ?>" target="_new"><img src="system/administrador/<?php echo $sitio['img']; ?>" style="height:185px;" alt="<?php echo $sitio['nombre']; ?>"></a>
                                        <ul class="list-inline person-details-icons">
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
                                        </ul>
                                    </figure>
                                </div>
                                <?php
                                }
                                 ?>
                                <!-- //Portfolio Item// -->
                                <!-- Person Details -->
                                <div class="col-md-3 col-sm-3 col-xs-6 person-details margin-bottom-30">
                                    <figure>
                                        <figcaption>
                                            <h3 class="margin-bottom-10">Sitio 2
                                                <small>- Nombre de la página</small>
                                            </h3>
                                            <span>Sed fringilla sem sed massa ullamcorper, vitae rutrum justo sodales. Cras sed iaculis enim. Sed aliquet viverra nisl a tristique.</span>
                                        </figcaption>
                                        <img src="assets/img/theteam/image2.jpg" alt="image2">
                                        <ul class="list-inline person-details-icons">
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
                                        </ul>
                                    </figure>
                                </div>
                                <!-- //Portfolio Item// -->
                                <!-- Person Details -->
                                <div class="col-md-3 col-sm-3 col-xs-6 person-details margin-bottom-30">
                                    <figure>
                                        <figcaption>
                                            <h3 class="margin-bottom-10">Sitio 3
                                                <small>- Nombre de la página</small>
                                            </h3>
                                            <span>Sed fringilla sem sed massa ullamcorper, vitae rutrum justo sodales. Cras sed iaculis enim. Sed aliquet viverra nisl a tristique.</span>
                                        </figcaption>
                                        <img src="assets/img/theteam/image3.jpg" alt="image3">
                                        <ul class="list-inline person-details-icons">
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
                                        </ul>
                                    </figure>
                                </div>
                                <!-- //Portfolio Item// -->
                            </div>
                            <hr class="margin-bottom-50">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="margin-bottom-10">Maecenas congue dui</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo, laboriosam, quod odit quo quos itaque repellat quaerat a ad alias. Vel, nostrum id ab velit veritatis consequatur fugit sequi esse. Maecenas congue dui
                                        id posuere fermentum.</p>
                                    <p>Sed fringilla sem sed massa ullamcorper, vitae rutrum justo sodales. Cras sed iaculis enim. Sed aliquet viverra nisl a tristique. Curabitur vitae mauris sem.</p>
                                </div>
                                <div class="col-md-6">
                                    <!-- Progress Bars -->
                                    <h3 class="progress-label">Graphic Design
                                        <span class="pull-right">92%</span>
                                    </h3>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" style="width: 90%">
                                        </div>
                                    </div>
                                    <h3 class="progress-label">Marketing
                                        <span class="pull-right">82%</span>
                                    </h3>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" style="width: 82%">
                                        </div>
                                    </div>
                                    <h3 class="progress-label">SEO
                                        <span class="pull-right">74%</span>
                                    </h3>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" style="width: 74%">
                                        </div>
                                    </div>
                                    <!-- End Progress Bars -->
                                </div>
                            </div>
                            <hr class="margin-bottom-30">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="fa-stack fa-2x margin-vert-30 margin-horiz-40 hidden-xs animate fadeInLeft">
                                                <i class="fa fa-circle fa-stack-2x color-gray"></i>
                                                <i class="fa fa-cogs fa-stack-1x fa-inverse color-white"></i>
                                            </span>
                                        </div>
                                        <div class="col-sm-8">
                                            <h3 class="margin-vert-10">Pellentesque iaculis</h3>
                                            <p>Lorem Ipsum is simply dummy text of Lorem the printing and typesettings.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="fa-stack fa-2x margin-vert-30 margin-horiz-40 hidden-xs animate fadeInLeft">
                                                <i class="fa fa-circle fa-stack-2x color-gray"></i>
                                                <i class="fa fa-cloud-download fa-stack-1x fa-inverse color-white"></i>
                                            </span>
                                        </div>
                                        <div class="col-sm-8">
                                            <h3 class="margin-vert-10">Aliquam dictum nulla</h3>
                                            <p>Lorem Ipsum is simply dummy text of Lorem the printing and typesettings.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="fa-stack fa-2x margin-vert-30 margin-horiz-40 hidden-xs animate fadeInLeft">
                                                <i class="fa fa-circle fa-stack-2x color-gray"></i>
                                                <i class="fa fa-cogs fa-stack-1x fa-inverse color-white"></i>
                                            </span>
                                        </div>
                                        <div class="col-sm-8">
                                            <h3 class="margin-vert-10">Pellentesque iaculis</h3>
                                            <p>Lorem Ipsum is simply dummy text of Lorem the printing and typesettings.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="margin-top-40">
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
            <!-- Footer -->
            <div id="footer" class="background-grey">
                <div class="container">
                    <div class="row">
                        <!-- Footer Menu -->
                        <div id="footermenu" class="col-md-8">
                            <ul class="list-unstyled list-inline">
                                <li>
                                    <a href="#" target="_blank">Link</a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">Link</a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">Link</a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">Link</a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Footer Menu -->
                        <!-- Copyright -->
                        <div id="copyright" class="col-md-4">
                            <p class="pull-right">Copyright © MÉXICO ORGÁNICO, ASESORÍA Y CAPACITACIÓN S.C | Design by <a href="http://inforganic.net/">Inforganic.net</a></p>
                        </div>
                        <!-- End Copyright -->
                    </div>
                </div>
            </div>
            <!-- End Footer -->


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