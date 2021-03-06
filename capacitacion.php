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
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.0';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div id="body-bg">
            <!-- Phone/Email -->

            <!-- End Header -->
            <!-- Top Menu -->
            <?php include('top_menu.php'); ?>
            <!-- End Top Menu -->
            <!-- === END HEADER === -->
            <!-- === BEGIN CONTENT === -->
            <?php 
            $query = "SELECT capacitacion.id_capacitacion, capacitacion.titulo, capacitacion.descripcion, capacitacion.contenido, capacitacion.img, capacitacion.fecha_registro, detalle_capacitacion.costo, detalle_capacitacion.cupo, detalle_capacitacion.fecha_inicio, detalle_capacitacion.fecha_fin, usuario.username FROM capacitacion INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion INNER JOIN usuario ON capacitacion.fk_id_usuario = usuario.idusuario WHERE capacitacion.estatus = 'ACTIVO' GROUP BY detalle_capacitacion.fecha_inicio DESC";
            $row_capacitacion = mysql_query($query,$conectar) or die(mysql_error());
            $total_capacitaciones = mysql_num_rows($row_capacitacion);
             ?>
            <!-- End Top Panels -->
            <hr class="margin-top-3 0">
            <!-- Middle Text -->
            <div class="row">
                <div class="col-md-12 text-center margin-top-10 animate fadeInUp">
                    <h2 class="text-center">Capacitaciones y Cursos</h2>
                    
                </div>
            </div>
            <!-- End Middle Text -->
            <hr>
                <div id="content">
                    <div class="container background-white">
                        <div class="row margin-vert-30">
                            <?php 
                            if($total_capacitaciones > 0){
                            ?>
                                <!-- Main Column -->
                                <div class="col-md-9">
                                    <!--------------------- INICIA ARTICULO  ----------------------------->
                                    <!-- Blog Post -->
                                    <?php 
                                    while($capacitacion = mysql_fetch_assoc($row_capacitacion)){
                                        $fecha_inicio = date('d/m/Y',$capacitacion['fecha_inicio']);
                                        $fecha_fin = date('d/m/Y',$capacitacion['fecha_fin']);
                                    ?>
                                        <div class="blog-post padding-bottom-20">

                                            <div class="row"><!-- inicia row -->

                                                <div class="col-lg-4"><!-- inicia col-lg-4 -->
                                                    <!-- Inician Tags -->
                                                    <div class="col-md-12 blog-post-details">
                                                        <!-- Tags -->
                                                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
                                                            <i class="fa fa-tag color-gray-light"></i>
                                                            <?php 
                                                            $query_tag = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE articulo_tag.id_capacitacion = $capacitacion[id_capacitacion]";
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

                                                    </div>
                                                    <div class="col-md-12">
                                                        <img class="margin-bottom-20" style="height:240px;widht:100%;"  src="system/administrador/<?php echo $capacitacion['img']; ?>" alt="thumb1">    
                                                    </div>
                                                    <!-- Terminan Tags -->
                                                </div><!-- termina col-lg-4 -->

                                                <div class="col-lg-8"><!-- inicia col-lg-8 -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="fb-share-button" data-href="http://mexorganico.com/curso_capacitacion.php?curso=<?php echo $capacitacion['id_capacitacion']; ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fmexorganico.com%2Fcapacitacion.php&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>
                                                                </div>
                                                                <div class="col-sm-6 blog-post-date" style="color:#d35400">
                                                                    <span>FECHA(S):</span>
                                                                    <?php 
                                                                    if(isset($capacitacion['fecha_inicio']) && $capacitacion['fecha_fin']){
                                                                        echo '<span>'.$fecha_inicio.' al '.$fecha_fin.'</span>';
                                                                    }else{
                                                                        echo "<span>$fecha_inicio</span>";
                                                                        echo "<span>$fecha_fin</span>";
                                                                    }
                                                                     ?>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h2>
                                                                <a href="curso_capacitacion.php?curso=<?php echo $capacitacion['id_capacitacion']; ?>"><?php echo $capacitacion['titulo']; ?></a>
                                                            </h2>
                                                        </div>
                                                        <!-- inicia cupo del curso -->
                                                        <div class="col-md-12">
                                                            <?php 
                                                            /// consultamos el numero de asistentes
                                                            $query_asistentes = "SELECT COUNT(fk_id_participante) AS 'num_asistentes' FROM capacitacion_participante WHERE fk_id_capacitacion = $capacitacion[id_capacitacion] AND estatus = 'VERIFICADO'";
                                                            $row_asistentes = mysql_query($query_asistentes, $conectar) or die(mysql_error());
                                                            $asistentes = mysql_fetch_assoc($row_asistentes);
                                                            
                                                            if($asistentes['num_asistentes'] < $capacitacion['cupo']){
                                                            ?>
                                                                <div class="blog-post-details-item blog-post-details-item-left">
                                                                    <i class="fa fa-user " style="color: #d35400"></i>
                                                                    <!--<a href="#"><?php echo $capacitacion['username']; ?></a>-->
                                                                    <b style="color: #d35400">Cupo: <?php echo $capacitacion['cupo']; ?></b>
                                                                </div>
                                                            <?php
                                                            }else{
                                                            ?>
                                                                <div class="blog-post-details-item blog-post-details-item-left" style="background:#e74c3c;color:white">
                                                                    <!--<a href="#"><?php echo $capacitacion['username']; ?></a>-->
                                                                    <b style="color:#fff">CUPO AGOTADO</b>
                                                                </div>
                                                            <?php
                                                            }
                                                             ?>
                                                        </div>
                                                        <!-- termina cupo del curso -->

                                                        <!-- inicia descripción contenido del curso -->
                                                        <div class="col-md-12">
                                                            <p class="text-justify">
                                                                <?php echo substr($capacitacion['descripcion'], 0,300)." ..."; ?>
                                                            </p>
                                                            <!-- Read More -->
                                                            <a href="curso_capacitacion.php?curso=<?php echo $capacitacion['id_capacitacion']; ?>" class="btn btn-primary">
                                                                Leer Más
                                                                <i class="icon-chevron-right readmore-icon"></i>
                                                            </a>
                                                        </div>
                                                        <!-- termina descripción contenido del curso -->

                                                    </div>

                                      
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
                                    $query = "SELECT tags.*, articulo_tag.idtag FROM tags INNER JOIN articulo_tag ON tags.idtag = articulo_tag.idtag WHERE id_capacitacion IS NOT NULL";
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
                                        <h3>Recientes</h3>
                                        <ul class="posts-list margin-top-10">
                                            <?php 
                                            $query = "SELECT id_capacitacion, titulo, img, fecha_registro FROM capacitacion ORDER BY fecha_registro DESC LIMIT 5";
                                            $row_ultimos = mysql_query($query,$conectar) or die(mysql_error());
                                            while($last_capacitacion = mysql_fetch_assoc($row_ultimos)){
                                            ?>
                                                <li>
                                                    <div class="recent-post">
                                                        <a href="curso_capacitacion.php?curso=<?php echo $last_capacitacion['id_capacitacion']; ?>">
                                                            <img class="pull-left" style="width:54px;" src="system/administrador/<?php echo $last_capacitacion['img']; ?>" alt="thumb1">
                                                        </a>
                                                        <a href="curso_capacitacion.php?curso=<?php echo $last_capacitacion['id_capacitacion']; ?>" class="posts-list-title"><?php echo $last_capacitacion['titulo']; ?></a>
                                                        <br>
                                                        <span class="recent-post-date">
                                                            <?php echo date('d/m/Y', $last_capacitacion['fecha_registro']); ?>
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
                            <?php
                            }else{
                            ?>
                                <div id="content">
                                    <div class="col-md-12 text-center">
                                        <h4 class="alert alert-warning"> No hay cursos disponibles</h4>
                                    </div>
                                </div>
                            <?php
                            }
                             ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12 margin-bottom-30">
                                <div class="fb-comments" data-href="http://mexorganico.com/capacitacion.php" data-width="100%" data-numposts="6"></div>
                            </div>
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