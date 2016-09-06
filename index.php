<?php 
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);

$row_articulo = mysql_query("SELECT * FROM articulo ORDER BY fecha_registro DESC LIMIT 1", $conectar);
$articulo = mysql_fetch_assoc($row_articulo);

$row_sitios = mysql_query("SELECT * FROM sitios ORDER BY fecha_registro DESC LIMIT 1", $conectar);
$sitios = mysql_fetch_assoc($row_sitios);

$row_biblioteca = mysql_query("SELECT * FROM biblioteca ORDER BY fecha_registro DESC LIMIT 1", $conectar);
$biblioteca = mysql_fetch_assoc($row_biblioteca);


 ?>
<!-- === BEGIN HEADER === -->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
    <!--<![endif]-->
    <head>
        <!-- Title -->
        <title>México Orgánico - Asesoría y Capacitación</title>
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
            <!--<div id="pre-header" class="background-gray-lighter">
                <div class="container no-padding">
                    <div class="row hidden-xs">
                        <div class="col-sm-6 padding-vert-5">
                            <strong>Telefono:</strong>&nbsp;1-800-123-4567
                        </div>
                        <div class="col-sm-6 text-right padding-vert-5">
                            <strong>Email:</strong>&nbsp;mexico@organico.com
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- End Phone/Email -->
            <!-- Header -->

            <!-- End Header -->
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
                                        <a style="hover:white" href="index.php">Inicio</a>
                                    </li>
                                    <li>
                                        <a href="nosotros.php"><span class="fa-gears ">Nosotros</span></a>
                                    </li>

                                    <li>
                                        <a href="articulos.php"><span class="fa-copy ">Articulos</span></a>
                                    </li>

                                    <li>
                                        <a href="sitios_interes.php"><span class="fa-th ">Sitios de Interes</span></a>
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
            <div id="slideshow" class="bottom-border-shadow">
                <div class="container no-padding background-white bottom-border">
                    <div class="row">
                        <!-- Carousel Slideshow -->
                        <div id="carousel-example" class="carousel slide" data-ride="carousel">
                            <!-- Carousel Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example" data-slide-to="1"></li>
                                <li data-target="#carousel-example" data-slide-to="2"></li>
                            </ol>
                            <div class="clearfix"></div>
                            <!-- End Carousel Indicators -->
                            <!-- Carousel Images -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="assets/img/slideshow/slide1.jpg">
                                    <div class="carousel-caption">
                                        <!--<h3 style="color:white">México Organico</h3>
                                        <p>...</p>-->
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="assets/img/slideshow/organico2.jpg">
                                </div>
                                <div class="item">
                                    <img src="assets/img/slideshow/organico3.jpg">
                                </div>
                                <!--<div class="item">
                                    <img src="assets/img/slideshow/tierra.jpg">
                                </div>-->
                            </div>
                            <!-- End Carousel Images -->
                            <!-- Carousel Controls -->
                            <a class="left carousel-control" href="#carousel-example" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                            <!-- End Carousel Controls -->
                        </div>
                        <!-- End Carousel Slideshow -->
                    </div>
                </div>
            </div>
            <div id="icons" class="bottom-border-shadow">
                <div class="container background-grey bottom-border">
                    <div class="row padding-vert-60">
                        <!-- Icons -->
                        <div class="col-md-4 text-center">
                            <h2 class="padding-top-10 animate fadeIn">Artículos</h2>
                            <a href="articulo.php?articulo=<?php echo $articulo['idarticulo']; ?>"><h4><?php echo $articulo['titulo']; ?></h4></a>
                            <a href="articulo.php?articulo=<?php echo $articulo['idarticulo']; ?>"><img src="system/administrador/<?php echo $articulo['img']; ?>" class="animate fadeIn" style="height:200px;" alt="<?php echo $articulo['descripcion_img']; ?>"></a>
                            <p class="text-justify animate fadeIn"><?php echo substr($articulo['contenido'], 0,200)." ...[<b><a href='articulo.php?articulo=$articulo[idarticulo]'>Leer Más</a></b>]"; ?></p>
                            <a class="btn btn-primary" href="articulos.php">Consultar Más Artículos</a>
                        </div>
                        <div class="col-md-4 text-center">
                            <h2 class="padding-top-10 animate fadeIn">Sitios de Interés</h2>
                            <?php 
                            if(empty($sitios['img'])){
                            ?>
                                <img src="assets/img/logo.png" class="img-thumbnail animate fadeIn" style="height:200px;" alt="">
                            <?php
                            }else{
                            ?>
                                <img src="system/adminitrador/<?php echo $sitios['img']; ?>" class="animate fadeIn" alt="">
                            <?php
                            }
                             ?>
                            <p class="text-justify animate fadeIn"><?php echo substr($sitios['descripcion'], 0,200); ?></p>
                            <div class="col-md-6"><a href="<?php echo $sitios['url']; ?>" target="_blank"><u>Visitar el Sitio Web</u></a></div>
                            <div class="col-md-6"><a class="btn btn-primary" href="sitios_interes.php">Consultar Más Sitios</a></div>
                        </div>
                        <div class="col-md-4 text-center">
                            <h2 class="padding-top-10 animate fadeIn">Biblioteca</h2>
                            <a href="system/administrador/<?php echo $biblioteca['archivo']; ?>"><h4><?php echo $biblioteca['titulo']; ?></h4></a>
                            <img src="assets/img/logo.png" class="img-thumbnail animate fadeIn" style="height:200px;" alt="">
                            <p class="text-justify animate fadeIn"><?php echo $biblioteca['descripcion']; ?></p>
                            <div class="col-md-6"><u><a href="system/administrador/<?php echo $biblioteca['archivo']; ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Descargar</a></u></div>
                            <duv class="col-md-6"><u><a class="btn btn-primary" href="biblioteca.php"><i class="glyphicon glyphicon-book"></i> Consultar Más</a></u></duv>
                        </div>
                        <!-- End Icons -->
                    </div>
                </div>
            </div>
            <div id="content" class="bottom-border-shadow">
                <div class="container background-white bottom-border">
                    <div class="row margin-vert-30">
                        <!-- Main Text -->
                        <div class="col-md-6">
                            <h2>MÉXICO ORGÁNICO S.C.</h2>
                            <p>
                                MEXICO ORGÁNICO, ASESORÍA Y CAPACITACIÓN, es una “SOCIEDAD CIVIL” integrada por profesionistas con una amplia experiencia en los temas de producción orgánica y temas afines, para poder apoyar a cualquier interesado a lograr un desarrollo integral tanto en sus actividades productivas como organizativas y comerciales.
                            </p>
                            <p>
                                <a href="nosotros.html" class="btn btn-warning">SABER MÁS</a>
                            </p>
                        </div>
                        <!-- End Main Text -->
                        <div class="col-md-6">
                            <h3 class="padding-vert-10">Nuestros Servicios</h3>
                            <p>Duis sit amet orci et lectus dictum auctor a nec enim. Donec suscipit fringilla elementum. Suspendisse nec justo ut felis ornare tincidunt vitae et lectus.</p>
                            <ul class="tick animate fadeInRight">
                                <li>Certificación orgánica, comercio justo.</li>
                                <li>Sistema de gestión de calidad.</li>
                                <li>Aprovechamiento de recursos naturales.</li>
                                <li>Desarrollo e implementación de proyectos productivos.</li>
                                <li>Gestión de recursos públicos y privados.</li>
                                <li>Preservación y restauración del equilibrio ecológico</li>
                                <li>Desarrollo sustentable</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Portfolio -->
            <div id="portfolio" class="bottom-border-shadow">
                <div class="row">
                    <div class="col-md-12 text-center margin-top-10 animate fadeInUp">
                        <h2 class="text-center">Nuestros Objetivos</h2>
                    </div>
                </div>

                <div class="container bottom-border">
                    <div class="row padding-top-40">
                        <ul class="portfolio-group">
                            <!-- Portfolio Item -->
                            <li class="portfolio-item col-sm-4 col-xs-6 margin-bottom-40">
                                <a href="#">
                                    <figure class="animate fadeInLeft">
                                        <img alt="asesoria y capacitación" src="assets/img/objetivos/asesoria.jpg">
                                        <figcaption>
                                            
                                            <span>Asesorar y capacitar a productores, comunidades, organizaciones, Instituciones Educativas y empresas que requieran certificar sus productos y procesos orgánicos para el mercado nacional e internacional</span>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                            <!-- //Portfolio Item// -->
                            <!-- Portfolio Item -->
                            <li class="portfolio-item col-sm-4 col-xs-6 margin-bottom-40">
                                <a href="#">
                                    <figure class="animate fadeIn">
                                        <img alt="Formación de Tecnicos" src="assets/img/objetivos/formacion.jpg">
                                        <figcaption>
                                            
                                            <span>Formar cuadros técnicos en las comunidades, organizaciones y empresas que requieran certificar sus productos y procesos orgánicos para el mercado nacional e internacional.</span>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                            <!-- //Portfolio Item// -->
                            <!-- Portfolio Item -->
                            <li class="portfolio-item col-sm-4 col-xs-6 margin-bottom-40">
                                <a href="#">
                                    <figure class="animate fadeInRight">
                                        <img alt="Gestión de recursos" src="assets/img/objetivos/gestion.jpg">
                                        <figcaption>
                                            
                                            <span>Gestionar recursos provenientes del gobierno o de la iniciativa privada Nacional e Internacional para apoyar la asesoría y procesos de capacitación a productores, comunidades, organizaciones y empresas que requieran certificar sus productos y procesos orgánicos para el mercado nacional e internacional.</span>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                            <!-- //Portfolio Item// -->
                            <!-- Portfolio Item -->
                            <li class="portfolio-item col-sm-4 col-xs-6 margin-bottom-40">
                                <a href="#">
                                    <figure class="animate fadeInLeft">
                                        <img alt="image4" src="assets/img/objetivos/sustentabilidad.jpg">
                                        <figcaption>
                                           
                                            <span>Apoyo en el aprovechamiento de los recursos naturales, la protección del ambiente, la flora y la fauna, la preservación y restauración del equilibrio ecológico</span>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                            <!-- //Portfolio Item// -->
                            <!-- Portfolio Item -->
                            <li class="portfolio-item col-sm-4 col-xs-6 margin-bottom-40">
                                <a href="#">
                                    <figure class="animate fadeIn">
                                        <img alt="image5" src="assets/img/objetivos/alianza.jpg">
                                        <figcaption>

                                            <span>Crear alianzas estratégicas con otras organizaciones, instituciones educativas, redes y colectivos; así como ser filiales con otras organizaciones para el cumplimiento de su objetivo.</span>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                            <!-- //Portfolio Item// -->
                            <!-- Portfolio Item -->
                            <li class="portfolio-item col-sm-4 col-xs-6 margin-bottom-40">
                                <a href="#">
                                    <figure class="animate fadeInRight">
                                        <img alt="image6" src="assets/img/objetivos/actos.jpg">
                                        <figcaption>

                                            <span> Celebrar todo tipo de actos y contratos de naturaleza Civil o de cualquier otro permitido por la ley para la consecución de los demás fines sociales.</span>
                                        </figcaption>
                                    </figure>
                                </a>
                            </li>
                            <!-- //Portfolio Item// -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Portfolio -->
            <!-- === END CONTENT === -->
            <!-- === BEGIN FOOTER === -->
            <?php 
            include("footer.php");
             ?>

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