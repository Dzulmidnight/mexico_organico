<?php 
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);
?>
<html lang="es">
    <!--<![endif]-->
    <head>
        <!-- Title -->
        <title>Articulos - México Orgánico</title>
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
                                        <a class="active" href="articulos.php"><span class="fa-copy ">Articulos</span></a>
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
            <?php 
            $query = "SELECT articulo.*, usuario.username FROM articulo INNER JOIN usuario ON articulo.autor = usuario.idusuario";
            $row_articulo = mysql_query($query,$conectar) or die(mysql_error());
             ?>
            <div id="content">
                <div class="container background-white">
                    <div class="row margin-vert-30">
                        <!-- Main Column -->
                        <div class="col-md-9">
                            <!--------------------- INICIA ARTICULO  ----------------------------->
                            <!-- Blog Post -->
                            <?php 
                            while($articulo = mysql_fetch_assoc($row_articulo)){
                            ?>
                                <div class="blog-post padding-bottom-20">
                                
                                    <!-- Blog Item Header -->
                                    <div class="blog-item-header">
                                        <!-- Title -->
                                        <h2>
                                            <a href="#"><?php echo $articulo['titulo']; ?></a>
                                        </h2>
                                        <div class="clearfix"></div>
                                        <!-- End Title -->
                                        <!-- Date -->
                                        <div class="blog-post-date">
                                            <a href="#"><?php echo date('d/m/Y', $articulo['fecha_registro']); ?></a>
                                        </div>
                                        <!-- End Date -->
                                    </div>
                                    <!-- End Blog Item Header -->
                                    <!-- Blog Item Details -->
                                    <div class="blog-post-details">
                                        <!-- Author Name -->
                                        <div class="blog-post-details-item blog-post-details-item-left">
                                            <i class="fa fa-user color-gray-light"></i>
                                            <a href="#"><?php echo $articulo['username']; ?></a>
                                        </div>
                                        <!-- End Author Name -->
                                        <!-- Tags -->
                                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
                                            <i class="fa fa-tag color-gray-light"></i>
                                            <?php 
                                            $query_tag = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE articulo_tag.idarticulo = $articulo[idarticulo]";
                                            $row_tag = mysql_query($query_tag,$conectar) or die(mysql_error());
                                            $numero = mysql_num_rows($row_tag);
                                            $contador = 1;

                                            while($tag = mysql_fetch_assoc($row_tag)){
                                                echo "<a href='#'>$tag[nombre]</a>";
                                                if($contador < $numero){
                                                    echo ",";
                                                }
                                                $contador++;
                                            }
                                             ?>
                                        </div>
                                        <!-- End Tags -->
                                        <!-- # of Comments -->
                                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                            <a href="">
                                                <i class="fa fa-comments color-gray-light"></i>
                                                2 Comentarios
                                            </a>
                                        </div>
                                        <!-- End # of Comments -->
                                    </div>
                                    <!-- End Blog Item Details -->
                                    <!-- Blog Item Body -->
                                    <div class="blog">
                                        <div class="clearfix"></div>
                                        <div class="blog-post-body row margin-top-15">
                                            <div class="col-md-5">
                                                <img class="margin-bottom-20" style="width:300px;" src="system/administrador/<?php echo $articulo['img']; ?>" alt="thumb1">
                                            </div>
                                            <div class="col-md-7">
                                                <p>
                                                    <?php echo substr($articulo['contenido'], 0,300)." ..."; ?>
                                                </p>
                                                <!-- Read More -->
                                                <a href="#" class="btn btn-primary">
                                                    Leer Más
                                                    <i class="icon-chevron-right readmore-icon"></i>
                                                </a>
                                                <!-- End Read More -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Blog Item Body -->
                                </div>
                            <?php
                            }
                             ?>
                            <!----------------------- TERMINA ARTICULO  --------------------------->


                            <!-- End Blog Item -->
                            <!-- Blog Post -->
                            <div class="blog-post padding-bottom-20">
                                <!-- Blog Item Header -->
                                <div class="blog-item-header">
                                    <!-- Title -->
                                    <h2>
                                        <a href="#">
                                            Another Sample Blog</a>
                                    </h2>
                                    <div class="clearfix"></div>
                                    <!-- End Title -->
                                    <!-- Date -->
                                    <div class="blog-post-date">
                                        <a href="#">22nd Apr, 2014</a>
                                    </div>
                                    <!-- End Date -->
                                </div>
                                <!-- End Blog Item Header -->
                                <!-- Blog Item Details -->
                                <div class="blog-post-details">
                                    <!-- Author Name -->
                                    <div class="blog-post-details-item blog-post-details-item-left">
                                        <i class="fa fa-user color-gray-light"></i>
                                        <a href="#">Admin</a>
                                    </div>
                                    <!-- End Author Name -->
                                    <!-- Tags -->
                                    <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
                                        <i class="fa fa-tag color-gray-light"></i>
                                        <a href="#">PHP</a>,
                                        <a href="#">Ruby</a>,
                                        <a href="#">Javascript</a>
                                    </div>
                                    <!-- End Tags -->
                                    <!-- # of Comments -->
                                    <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                        <a href="">
                                            <i class="fa fa-comments color-gray-light"></i>
                                            3 Comments
                                        </a>
                                    </div>
                                    <!-- End # of Comments -->
                                </div>
                                <!-- End Blog Item Details -->
                                <!-- Blog Item Body -->
                                <div class="blog">
                                    <div class="clearfix"></div>
                                    <div class="blog-post-body row margin-top-15">
                                        <div class="col-md-5">
                                            <img class="margin-bottom-20" src="assets/img/blog/image2.jpg" alt="thumb2">
                                        </div>
                                        <div class="col-md-7">
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                                                Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>
                                            <!-- Read More -->
                                            <a href="#" class="btn btn-primary">
                                                Read More
                                                <i class="icon-chevron-right readmore-icon"></i>
                                            </a>
                                            <!-- End Read More -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End Blog Item Body -->
                            </div>
                            <!-- End Blog Item -->
                            <!-- Blog Post -->
                            <div class="blog-post padding-bottom-20">
                                <!-- Blog Item Header -->
                                <div class="blog-item-header">
                                    <!-- Title -->
                                    <h2>
                                        <a href="#">
                                            Yet Another Sample Blog Title</a>
                                    </h2>
                                    <div class="clearfix"></div>
                                    <!-- End Title -->
                                    <!-- Date -->
                                    <div class="blog-post-date">
                                        <a href="#">22nd Apr, 2014</a>
                                    </div>
                                    <!-- End Date -->
                                </div>
                                <!-- End Blog Item Header -->
                                <!-- Blog Item Details -->
                                <div class="blog-post-details">
                                    <!-- Author Name -->
                                    <div class="blog-post-details-item blog-post-details-item-left">
                                        <i class="fa fa-user color-gray-light"></i>
                                        <a href="#">Admin</a>
                                    </div>
                                    <!-- End Author Name -->
                                    <!-- Tags -->
                                    <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
                                        <i class="fa fa-tag color-gray-light"></i>
                                        <a href="#">jQuery</a>,
                                        <a href="#">HTML</a>,
                                        <a href="#">Grunt</a>
                                    </div>
                                    <!-- End Tags -->
                                    <!-- # of Comments -->
                                    <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                        <a href="">
                                            <i class="fa fa-comments color-gray-light"></i>
                                            1 Comments
                                        </a>
                                    </div>
                                    <!-- End # of Comments -->
                                </div>
                                <!-- End Blog Item Details -->
                                <!-- Blog Item Body -->
                                <div class="blog">
                                    <div class="clearfix"></div>
                                    <div class="blog-post-body row margin-top-15">
                                        <div class="col-md-5">
                                            <img class="margin-bottom-20" src="assets/img/blog/image3.jpg" alt="thumb3">
                                        </div>
                                        <div class="col-md-7">
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                                                Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>
                                            <!-- Read More -->
                                            <a href="#" class="btn btn-primary">
                                                Read More
                                                <i class="icon-chevron-right readmore-icon"></i>
                                            </a>
                                            <!-- End Read More -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End Blog Item Body -->
                            </div>
                            <!-- End Blog Item -->
                            <!-- Blog Post -->
                            <div class="blog-post padding-bottom-20">
                                <!-- Blog Item Header -->
                                <div class="blog-item-header">
                                    <!-- Title -->
                                    <h2>
                                        <a href="#">
                                            And One More Sample Blog Title</a>
                                    </h2>
                                    <div class="clearfix"></div>
                                    <!-- End Title -->
                                    <!-- Date -->
                                    <div class="blog-post-date">
                                        <a href="#">22nd Apr, 2014</a>
                                    </div>
                                    <!-- End Date -->
                                </div>
                                <!-- End Blog Item Header -->
                                <!-- Blog Item Details -->
                                <div class="blog-post-details">
                                    <!-- Author Name -->
                                    <div class="blog-post-details-item blog-post-details-item-left">
                                        <i class="fa fa-user color-gray-light"></i>
                                        <a href="#">Admin</a>
                                    </div>
                                    <!-- End Author Name -->
                                    <!-- Tags -->
                                    <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
                                        <i class="fa fa-tag color-gray-light"></i>
                                        <a href="#">HTML</a>,
                                        <a href="#">HTML5</a>,
                                        <a href="#">CSS3</a>
                                    </div>
                                    <!-- End Tags -->
                                    <!-- # of Comments -->
                                    <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                        <a href="">
                                            <i class="fa fa-comments color-gray-light"></i>
                                            5 Comments
                                        </a>
                                    </div>
                                    <!-- End # of Comments -->
                                </div>
                                <!-- End Blog Item Details -->
                                <!-- Blog Item Body -->
                                <div class="blog">
                                    <div class="clearfix"></div>
                                    <div class="blog-post-body row margin-top-15">
                                        <div class="col-md-5">
                                            <img class="margin-bottom-20" src="assets/img/blog/image4.jpg" alt="thumb4">
                                        </div>
                                        <div class="col-md-7">
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                                                Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>
                                            <!-- Read More -->
                                            <a href="#" class="btn btn-primary">
                                                Read More
                                                <i class="icon-chevron-right readmore-icon"></i>
                                            </a>
                                            <!-- End Read More -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End Blog Item Body -->
                            </div>
                            <!-- End Blog Item -->
                            <!-- Pagination -->
                            <ul class="pagination">
                                <li>
                                    <a href="#">&laquo;</a>
                                </li>
                                <li class="active">
                                    <a href="#">1</a>
                                </li>
                                <li>
                                    <a href="#">2</a>
                                </li>
                                <li>
                                    <a href="#">3</a>
                                </li>
                                <li class="disabled">
                                    <a href="#">4</a>
                                </li>
                                <li>
                                    <a href="#">5</a>
                                </li>
                                <li>
                                    <a href="#">&raquo;</a>
                                </li>
                            </ul>
                            <!-- End Pagination -->
                        </div>
                        <!-- End Main Column -->
                        <!-- Side Column -->
                        <div class="col-md-3">
                            <!-- Blog Tags -->
                            <?php 
                            $query = "SELECT tags.* FROM tags";
                            $row_tag = mysql_query($query,$conectar) or die(mysql_error());
                             ?>
                            <div class="blog-tags">
                                <h3>Tags</h3>
                                <ul class="blog-tags">
                                    <?php 
                                    while($tags = mysql_fetch_assoc($row_tag)){
                                    ?>
                                        <li>
                                            <a href="#" class="blog-tag"><?php echo $tags['nombre']; ?></a>
                                        </li>
                                    <?php
                                    }
                                     ?>

                                    <!--<li>
                                        <a href="#" class="blog-tag">CSS</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">JavaScript</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">jQuery</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">PHP</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">Ruby</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">CoffeeScript</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">Grunt</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">Bootstrap</a>
                                    </li>
                                    <li>
                                        <a href="#" class="blog-tag">HTML5</a>
                                    </li>-->
                                </ul>
                            </div>
                            <!-- End Blog Tags -->
                            <!-- Recent Posts -->
                            <div class="recent-posts">
                                <h3>Artículos Recientes</h3>
                                <ul class="posts-list margin-top-10">
                                    <?php 
                                    $query = "SELECT idarticulo, titulo, img, fecha_registro FROM articulo ORDER BY fecha_registro DESC LIMIT 5";
                                    $row_ultimos = mysql_query($query,$conectar) or die(mysql_error());
                                    while($last_articulos = mysql_fetch_assoc($row_ultimos)){
                                    ?>
                                        <li>
                                            <div class="recent-post">
                                                <a href="">
                                                    <img class="pull-left" style="width:54px;" src="system/administrador/<?php echo $last_articulos['img']; ?>" alt="thumb1">
                                                </a>
                                                <a href="#" class="posts-list-title"><?php echo $last_articulos['titulo']; ?></a>
                                                <br>
                                                <span class="recent-post-date">
                                                    <?php echo date('d/m/Y', $last_articulos['fecha_registro']); ?>
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    <?php
                                    }
                                     ?>

                                    <li>
                                        <div class="recent-post">
                                            <a href="">
                                                <img class="pull-left" src="assets/img/blog/thumbs/thumb2.jpg" alt="thumb2">
                                            </a>
                                            <a href="#" class="posts-list-title">Sidebar post example</a>
                                            <br>
                                            <span class="recent-post-date">
                                                July 30, 2013
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li>
                                        <div class="recent-post">
                                            <a href="">
                                                <img class="pull-left" src="assets/img/blog/thumbs/thumb3.jpg" alt="thumb3">
                                            </a>
                                            <a href="#" class="posts-list-title">Sidebar post example</a>
                                            <br>
                                            <span class="recent-post-date">
                                                July 30, 2013
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li>
                                        <div class="recent-post">
                                            <a href="">
                                                <img class="pull-left" src="assets/img/blog/thumbs/thumb4.jpg" alt="thumb4">
                                            </a>
                                            <a href="#" class="posts-list-title">Sidebar post example</a>
                                            <br>
                                            <span class="recent-post-date">
                                                July 30, 2013
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Recent Posts -->
                        </div>
                        <!-- End Side Column -->
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