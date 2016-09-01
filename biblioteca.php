<?php 
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);

$row_biblioteca = mysql_query("SELECT * FROM biblioteca", $conectar);
$numero_documentos = mysql_num_rows($row_biblioteca);

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
                                        <a href="articulos.php"><span class="fa-copy ">Articulos</span></a>
                                    </li>

                                    <li>
                                        <a href="sitios_interes.php"><span class="fa-th ">Sitios de Interes</span></a>
                                    </li>

                                    <li>
                                        <a class="active" href="biblioteca.php"><span class="fa-font ">Biblioteca</span></a>
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
                            <!-- Main Content -->
                            <div class="headline">
                                <h2>Biblioteca México Orgánico</h2>
                            </div>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas feugiat. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor
                                sit amet, consectetur adipiscing elit landitiis.</p>
                            <br>
                            <?php 
                            $query = "SELECT tags.*, articulo_tag.idtag FROM tags INNER JOIN articulo_tag ON tags.idtag = articulo_tag.idtag WHERE idbiblioteca IS NOT NULL";
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

                            <!-- Contact Form -->
                            <table class="table table-bordered">
                            	<thead>
                            		<tr>
                            			<th class="text-center">Titulo</th>
                            			<th class="text-center">Descripción</th>
                            			<th class="text-center">Archivo</th>
                            			<th class="text-center">Tags</th>
                            			<th class="text-center">Fecha</th>
                            		</tr>
                            	</thead>
                            	<tbody>
                            		<?php 
                            		if($numero_documentos == 0){
                            			echo "<tr class='warning'><td colspan='5'>NO SE ENCONTRARON DOCUMENTOS</td></tr>";
                            		}else{
	                            		while($documento = mysql_fetch_assoc($row_biblioteca)){
	                            		?>
	                            		<tr>
	                            			<td><b style="color:#c0392b"><?php echo $documento['titulo']; ?></b></td>
	                            			<td><?php echo $documento['descripcion']; ?></td>
	                            			<td>
												<a class="btn btn-primary" href="system/administrador/<?php echo $documento['archivo']; ?>"><span class="fa-book" aria-hidden="true" style="display:inline"></span> Descargar</a>
	                            			</td>
	                            			<td>
		                                        <div class="blog-post-details-item blog-post-details-item-left blog-post-details-tags">
		                                            <i class="fa fa-tag color-gray-light"></i>
		                                            <?php 
		                                            $tags_documento = mysql_query("SELECT tags.*, articulo_tag.idtag FROM tags INNER JOIN articulo_tag ON tags.idtag = articulo_tag.idtag WHERE idbiblioteca = $documento[idbiblioteca]",$conectar);
		                                            $numero = mysql_num_rows($tags_documento);
		                                            $contador = 1;

		                                            while($tag = mysql_fetch_assoc($tags_documento)){
		                                                echo "<a href='#'>$tag[nombre]</a>";
		                                                if($contador < $numero){
		                                                    echo ",";
		                                                }
		                                                $contador++;
		                                            }
		                                             ?>
		                                        </div>

	                            			</td>
	                            			<td><?php echo date('d/m/Y', $documento['fecha_registro']); ?></td>
	                            		</tr>
	                            		<?php
	                            		}
                            		}
                            		 ?>
                            	</tbody>
                            </table>
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
                                <div class="panel-body">
                                    <p>Lorem ipsum dolor sit amet, no cetero voluptatum est, audire sensibus maiestatis vis et. Vitae audire prodesset an his. Nulla ubique omnesque in sit.</p>
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
                                </div>
                            </div>
                            <!-- End recent Posts -->
                            <!-- About -->
                            <div class="panel panel-default">
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