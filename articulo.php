<?php 
if(isset($_GET['articulo']) && !empty($_GET['articulo'])){
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);
    $idarticulo = $_GET['articulo'];
    $query = "SELECT articulo.*, usuario.username FROM articulo INNER JOIN usuario ON articulo.autor = usuario.idusuario WHERE idarticulo = $idarticulo";
    $row_articulo = mysql_query($query,$conectar) or die(mysql_error());
    $articulo = mysql_fetch_assoc($row_articulo);


    $query_tag = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE idarticulo = $articulo[idarticulo]";
    $row_tag = mysql_query($query_tag,$conectar) or die(mysql_error());
    $row_tag2 = mysql_query($query_tag,$conectar) or die(mysql_error());

    $numero_tags = mysql_num_rows($row_tag);
?>
    <!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
    <!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="es">
        <!--<![endif]-->
        <head>
            <!-- Title -->
            <title><?php echo $articulo['titulo'] ?> - México Orgánico</title>
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
                                            <a href="index.php" style="padding-top:0px;padding-bottom:0px;"><img src="assets/img/menu.png" alt=""></a>
                                        </li>
                                        <li class="visible-xs visible-sm">
                                            <a href="index.php">Inicio</a>
                                        </li>
                                        <li>
                                            <a href="nosotros.html"><span class="fa-gears ">Nosotros</span></a>
                                        </li>

                                        <li>
                                            <a class="active" href="articulos.php"><span class="fa-copy ">Articulos</span></a>
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
                <div id="content">
                    <div class="container background-white">
                        <div class="row margin-vert-30">
                            <!-- Main Column -->
                            <div class="col-md-9">
                                <div class="blog-post">
                                    <div class="blog-item-header">
                                        <h2>
                                            <a href="#">
                                                <?php echo $articulo['titulo']; ?>
                                            </a>
                                        </h2>
                                        <!-- Date -->
                                        <div class="blog-post-date">
                                            <a href="#"><?php echo date('d/m/Y', $articulo['fecha_registro']); ?></a>
                                        </div>
                                        <!-- End Date -->
                                    </div>
                                    <div class="blog-post-details">
                                        <!-- Author Name -->
                                        <div class="blog-post-details-item blog-post-details-item-left user-icon">
                                            <i class="fa fa-user color-gray-light"></i>
                                            <a href="#"><?php echo $articulo['username']; ?></a>
                                        </div>
                                        <!-- End Author Name -->
                                        <!-- Tags -->
                                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
                                            <i class="fa fa-tag color-gray-light"></i>
                                            <?php 
                                            $contador = 1;
                                            while($tags = mysql_fetch_assoc($row_tag)){
                                                echo "<a href='#'>$tags[nombre]</a>";
                                                if($contador < $numero_tags){
                                                    echo ",";
                                                }
                                            }

                                             ?>
                                        </div>
                                        <!-- End Tags -->
                                        <!-- # of Comments -->
                                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                            <a href="">
                                                <i class="fa fa-comments color-gray-light"></i>
                                                3 Comentarios
                                            </a>
                                        </div>
                                        <!-- End # of Comments -->
                                    </div>
                                    <div class="blog-item">
                                        <div class="clearfix"></div>
                                        <div class="blog-post-body row margin-top-15">
                                            <div class="col-md-5">
                                                <img class="margin-bottom-20" style="width:300px;" src="system/administrador/<?php echo $articulo['img']; ?>" alt="image1">
                                            </div>
                                            <div class="col-md-7">
                                                <p>
                                                    <?php echo nl2br(substr($articulo['contenido'], 0,300))." ..."; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <p>
                                                    <?php echo nl2br($articulo['contenido']); ?>
                                                </p>
                                                <blockquote class="primary">
                                                    <p>
                                                        <em>"Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat."</em>
                                                    </p>
                                                    <small>
                                                        Someone famous in
                                                        <cite title="Source Title">Source Title</cite>
                                                    </small>
                                                </blockquote>
                                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                                                    Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
                                                    aliquyam erat, sed diam voluptua.</p>
                                                <p>Ut summo deserunt sit, quaeque hendrerit assentior cu mei. Sale electram nam ut. Putent perpetua reformidans ex vix, libris nostrud tractatos cu sit, est porro omnes nominati eu. Cu nullam similique complectitur
                                                    eam. Viris phaedrum ullamcorper id eos.</p>
                                            </div>
                                        </div>
                                        <div class="blog-item-footer">
                                            <!-- About the Author -->
                                            <div class="blog-author panel panel-default margin-bottom-30">
                                                <div class="panel-heading">
                                                    <h3>Acerca del Autor</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img class="pull-left" src="assets/img/profiles/87.jpg" alt="image1">
                                                        </div>
                                                        <div class="col-md-10">
                                                            <label>Persona 1</label>
                                                            <p>Lorem ipsum dolor sit amet, in pri offendit ocurreret. Vix sumo ferri an. pfs adodio fugit delenit ut qui. Omittam suscipiantur ex vel,ex audiam intellegat gfIn labitur discere eos, nam an feugiat
                                                                voluptua.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End About the Author -->
                                            <!-- Comments -->
                                            <div class="blog-recent-comments panel panel-default margin-bottom-30">
                                                <div class="panel-heading">
                                                    <h3>Comentarios</h3>
                                                </div>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-2 profile-thumb">
                                                                <a href="#">
                                                                    <img class="media-object" src="assets/img/profiles/99.jpg" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <h4>LOREM</h4>
                                                                <p>Donec id erum quidem rerumd facilis est et expedita distinctio lorem ipsum dolorlit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
                                                                    fermentum massa justo sit amet risus. Etiam porta sem malesuada magna..</p>
                                                                <span class="date">
                                                                    <i class="fa fa-clock-o color-gray-light"></i>5 hours ago</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-2 profile-thumb">
                                                                <a href="#">
                                                                    <img class="media-object" src="assets/img/profiles/53.jpg" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <h4>VERO EOS ET ACCUSAM</h4>
                                                                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                                                                <p>Donec id erum quidem rerumd facilis est et expedita distinctio lorem ipsum dolorlit non mi portas sats eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
                                                                    fermentum massa justo sit amet risus. Etiam porta sem malesuada magna.</p>
                                                                <span class="date">
                                                                    <i class="fa fa-clock-o color-gray-light"></i>12 May 2013</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-2 profile-thumb">
                                                                <a href="#">
                                                                    <img class="media-object" src="assets/img/profiles/37.jpg" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <h4>AT VERO EOS</h4>
                                                                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                                                    sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                                                                <span class="date">
                                                                    <i class="fa fa-clock-o color-gray-light"></i>10 May 2013</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- Comment Form -->
                                                    <li class="list-group-item">
                                                        <div class="blog-comment-form">
                                                            <div class="row margin-top-20">
                                                                <div class="col-md-12">
                                                                    <div class="pull-left">
                                                                        <h3>Deja un comentario</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row margin-top-20">
                                                                <div class="col-md-12">
                                                                    <form>
                                                                        <label>Nombre</label>
                                                                        <div class="row margin-bottom-20">
                                                                            <div class="col-md-7 col-md-offset-0">
                                                                                <input class="form-control" type="text" placeholder="Escribe tu Nombre">
                                                                            </div>
                                                                        </div>
                                                                        <label>Email
                                                                            <span>*</span>
                                                                        </label>
                                                                        <div class="row margin-bottom-20">
                                                                            <div class="col-md-7 col-md-offset-0">
                                                                                <input class="form-control" type="text" placeholder="Escribe tu Correo">
                                                                            </div>
                                                                        </div>
                                                                        <label>Mensaje</label>
                                                                        <div class="row margin-bottom-20">
                                                                            <div class="col-md-11 col-md-offset-0">
                                                                                <textarea class="form-control" rows="8"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <p>
                                                                            <button class="btn btn-primary" type="submit">Enviar Mensaje</button>
                                                                        </p>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- End Comment Form -->
                                                </ul>
                                            </div>
                                            <!-- End Comments -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End Blog Post -->
                            </div>
                            <!-- End Main Column -->
                            <!-- Side Column -->
                            <div class="col-md-3">
                                <!-- Blog Tags -->
                                <div class="blog-tags">
                                    <h3>Tags</h3>
                                    <ul class="blog-tags">
                                    <?php 
                                    while($tags = mysql_fetch_assoc($row_tag2)){
                                    ?>
                                        <li>
                                            <a href="#" class="blog-tag"><?php echo $tags['nombre']; ?></a>
                                        </li>
                                    <?php
                                    }
                                     ?>

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
                                                <a href="articulo.php?articulo=<?php echo $last_articulos['idarticulo']; ?>">
                                                    <img class="pull-left" style="width:54px;" src="system/administrador/<?php echo $last_articulos['img']; ?>" alt="thumb1">
                                                </a>
                                                <a href="articulo.php?articulo=<?php echo $last_articulos['idarticulo']; ?>" class="posts-list-title"><?php echo $last_articulos['titulo']; ?></a>
                                                <br>
                                                <span class="recent-post-date">
                                                    <?php echo date('d/m/Y', $last_articulos['fecha_registro']); ?>
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    <?
                                        }
                                    ?>
                                        <li>
                                            <div class="recent-post">
                                                <a href="">
                                                    <img class="pull-left" src="assets/img/blog/thumbs/thumb2.jpg" alt="thumb2">
                                                </a>
                                                <a href="#" class="posts-list-title">Título</a>
                                                <br>
                                                <span class="recent-post-date">
                                                    Fecha
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                        <li>
                                            <div class="recent-post">
                                                <a href="">
                                                    <img class="pull-left" src="assets/img/blog/thumbs/thumb3.jpg" alt="thumb3">
                                                </a>
                                                <a href="#" class="posts-list-title">Título</a>
                                                <br>
                                                <span class="recent-post-date">
                                                    Fecha
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                        <li>
                                            <div class="recent-post">
                                                <a href="">
                                                    <img class="pull-left" src="assets/img/blog/thumbs/thumb4.jpg" alt="thumb4">
                                                </a>
                                                <a href="#" class="posts-list-title">Título</a>
                                                <br>
                                                <span class="recent-post-date">
                                                    Fecha
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Recent Posts -->
                                <!-- End Side Column -->
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
                                </p>
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
<?php
}else{
    include('pages-404.html');
}
 ?>
