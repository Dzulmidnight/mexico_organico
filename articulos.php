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
            <?php include('top_menu.php'); ?>
            <!-- End Top Menu -->
            <!-- === END HEADER === -->
            <!-- === BEGIN CONTENT === -->
            <?php 
            $query = "SELECT articulo.*, usuario.username FROM articulo INNER JOIN usuario ON articulo.autor = usuario.idusuario";
            $row_articulo = mysql_query($query,$conectar) or die(mysql_error());
             ?>
            <!-- End Top Panels -->
            <hr class="margin-top-3 0">
            <!-- Middle Text -->
            <div class="row">
                <div class="col-md-12 text-center margin-top-10 animate fadeInUp">
                    <h2 class="text-center">Artículos</h2>
                    
                </div>
            </div>
            <!-- End Middle Text -->
            <hr>

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

                                    <div class="row"><!-- inicia row -->

                                        <div class="col-lg-4"><!-- inicia col-lg-4 -->
                                            <!-- Inician Tags -->
                                            <div class="blog-post-details">
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
                                                <!-- Terminan Tags -->
                                                <!-- # de comentarios -->
                                                <!--<div class="blog-post-details-item blog-post-details-item-left blog-post-details-item-last">
                                                    <a href="">
                                                        <i class="fa fa-comments color-gray-light"></i>
                                                        2 Comentarios
                                                    </a>
                                                </div>-->
                                                <!-- Termina # de comentarios -->
                                            </div>
                                            <img class="margin-bottom-20" style="width:300px;" src="system/administrador/<?php echo $articulo['img']; ?>" alt="thumb1">
                                            <!-- Terminan Tags -->
                                        </div><!-- termina col-lg-4 -->

                                        <div class="col-lg-8"><!-- inicia col-lg-8 -->
                                            <!-- INICIA TITULO DEL ARTICULO -->
                                            <div class="blog-item-header">
                                                <div class="row">
                                                    <!-- titulo -->
                                                    <div class="col-md-10">
                                                        <h2>
                                                            <a href="articulo.php?articulo=<?php echo $articulo['idarticulo']; ?>"><?php echo $articulo['titulo']; ?></a>
                                                        </h2>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <!-- Termina titulo -->
                                                </div>
                                                <!-- fecha -->
                                                <div class="blog-post-date">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <a href="#"><?php echo date('d/m/Y', $articulo['fecha_registro']); ?></a>    
                                                        </div>  
                                                    </div>              
                                                </div>

                                                <!-- Nombre del admin -->
                                                <div class="blog-post-details-item blog-post-details-item-left">
                                                    <i class="fa fa-user color-gray-light"></i>
                                                    <a href="#"><?php echo $articulo['username']; ?></a>
                                                </div>
                                                <!-- Termina nombre admin -->

                                                <!-- Termina fecha -->
                                            </div>
                                            <!-- TERMINA TITULO DEL ARTICULO -->
                                            <!-- INICIA CUERPO DEL ARTICULO -->
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <p>
                                                        <?php echo substr($articulo['contenido'], 0,300)." ..."; ?>
                                                    </p>
                                                    <!-- Read More -->
                                                    <a href="articulo.php?articulo=<?php echo $articulo['idarticulo']; ?>" class="btn btn-primary">
                                                        Leer Más
                                                        <i class="icon-chevron-right readmore-icon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- TERMINA CUERPO DEL ARTICULO -->                                        
                                        </div><!-- termina col-lg-8 -->

                                    </div><!-- termina row -->




                                    <!-- End Blog Item Body -->
                                </div>
                            <?php
                            }
                             ?>
                            <!----------------------- TERMINA ARTICULO  --------------------------->


                            <!-- End Blog Item -->
                            <!-- Pagination -->
                            <ul class="pagination">
                                <li>
                                    <a href="#">&laquo;</a>
                                </li>
                                <li class="active">
                                    <a href="#">1</a>
                                </li>
                                <!--<li>
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
                                </li>-->
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
                            $query = "SELECT tags.*, articulo_tag.idtag FROM tags INNER JOIN articulo_tag ON tags.idtag = articulo_tag.idtag WHERE idarticulo IS NOT NULL";
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
                                    <?php
                                    }
                                     ?>

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