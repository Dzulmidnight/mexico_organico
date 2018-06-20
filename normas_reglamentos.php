<?php 
require_once("system/connections/conexion.php"); 
mysql_select_db($database, $conectar);

$row_biblioteca = mysql_query("SELECT * FROM biblioteca WHERE tipo_documento = 'NORMA' OR tipo_documento = 'REGLAMENTO' ORDER BY fecha_actualizada ASC, fecha_registro DESC", $conectar);
$numero_documentos = mysql_num_rows($row_biblioteca);

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
            <?php include('top_menu.php'); ?>
            <!-- End Top Menu -->
            <!-- === END HEADER === -->
            <!-- === BEGIN CONTENT === -->
            <div id="content">
                <div class="container background-white">
                    <div class="row margin-vert-30">
                    	<div class="col-md-12">
                    		<div class="row">
	                    		<div class="col-sm-9">
		                            <!-- Main Content -->
		                            <div class="headline text-center">
		                                <h2>Normas y Reglamentos</h2>
		                            </div>
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
		                                </ul>
		                            </div>   
	                    		</div>

		                        <!-- Side Column -->
		                        <div class="col-sm-3">
		                            <div class="panel panel-default">
		                                <div class="panel-heading">
		                                    <h3 class="panel-title">Información de Contacto</h3>
		                                </div>
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
		                        </div>
	                        	<!-- End Side Column -->
                    		</div>
                    	</div>
                        <!-- Main Column -->
                        <div class="col-md-12">


                            <!-- Contact Form -->
                            <table class="table table-bordered">
                            	<thead>
                            		<tr>
                                        <th class="text-center">Tipo</th>
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
                                            <td>
                                                <?php echo $documento['tipo_documento']; ?>
                                            </td>
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