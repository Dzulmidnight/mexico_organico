<!-- === BEGIN HEADER === -->
<!DOCTYPE html>
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
                            <strong>Phone:</strong>&nbsp;1-800-123-4567
                        </div>
                        <div class="col-sm-6 text-right padding-vert-5">
                            <strong>Email:</strong>&nbsp;info@joomla51.com
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Phone/Email -->
            <!-- Header -->
            <!--<div id="header">
                <div class="container">
                    <div class="row">
                        <!-- Logo -->
                        <!--<div class="logo">
                            <a href="index.html" title="">
                                <img src="assets/img/logo.png" alt="Logo" />
                            </a>
                        </div>
                        <!-- End Logo -->
                   <!-- </div>
                </div>
            </div>
            <!-- End Header -->
            <!-- Top Menu -->
            <div id="hornav" class="bottom-border-shadow">
                <div class="container no-padding border-bottom">
                    <div class="row">
                        <div class="col-md-9 no-padding">
                            <div class="visible-lg">
                                <ul id="hornavmenu" class="nav navbar-nav" >
                                    <li class="hidden-xs hidden-sm">
                                        <a href="index.html" style="padding-top:0px;padding-bottom:0px;"><img src="assets/img/menu.png" alt=""></a>
                                    </li>
                                    <li class="visible-xs visible-sm">
                                        <a href="index.html">Inicio</a>
                                    </li>
                                    <li>
                                        <a href="nosotros.html"><span class="fa-gears ">Nosotros</span></a>
                                    </li>

                                    <li>
                                        <a href="articulos.php"><span class="fa-copy ">Articulos</span></a>
                                    </li>

                                    <li>
                                        <a href="sitios_interes.html"><span class="fa-th ">Sitios de Interes</span></a>
                                    </li>

                                    <li>
                                        <a href="biblioteca.html"><span class="fa-font ">Biblioteca</span></a>
                                    </li>
                                    <li>
                                        <a href="contact.html" class="fa-comment ">Contactanos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 no-padding">
                            <ul class="social-icons pull-right">
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
                    <div class="container">
                        <div class="row margin-vert-30">
                            <!-- Login Box -->
                            <div class="col-md-6 col-md-offset-3 col-sm-offset-3">
                                <form class="login-page" action="system/connections/autentificar.php" method="POST">
                                    <div class="login-header margin-bottom-30">
                                        <h2>Iniciar Sesión</h2>
                                    </div>
                                    <?php 
                                    if(isset($_GET['error']) && $_GET['error'] == 'si'){
                                    ?>
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <strong>Datos de accesso incorrectos</strong>
                                        </div>
                                    <?php
                                    }
                                     ?>
                                    <div class="input-group margin-bottom-20">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input name="username" placeholder="Usuario" class="form-control" type="text" autofocus required>
                                    </div>
                                    <div class="input-group margin-bottom-20">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <input name="password" placeholder="Contraseña" class="form-control" type="password" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                           <!-- <label class="checkbox">
                                                <input type="checkbox">Stay signed in</label>-->
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary pull-right" type="submit">Ingresar</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4><a href="#">¿Olvidaste tu contraseña ?</a></h4>
                                   
                                </form>
                            </div>
                            <!-- End Login Box -->
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
                            <p>All stock images on this template demo are for presentation purposes only, intended to represent a live site and are not included with the template or in any of the Joomla51 club membership plans.</p>
                            <p>Most of the images used here are available from
                                <a href="http://www.shutterstock.com/" target="_blank">shutterstock.com</a>. Links are provided if you wish to purchase them from their copyright owners.</p>
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
                                    <a class="fa-tasks" href="index.html">Inicio</a>
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