<?php 
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}

if(isset($_GET['curso']) && !empty($_GET['curso'])){

require_once("system/connections/conexion.php"); 
require_once("system/connections/mail.php"); 

mysql_select_db($database, $conectar);
    $id_capacitacion = $_GET['curso'];

    /// CREAMOS EL REGISTRO DEL PARTICIPANTE 
    if(isset($_POST['asdf']) && $_POST['asdf'] == 1){
        $fecha_registro = $_POST['fecha_registro'];
        $id_capacitacion = $_POST['id_capacitacion'];
        $titulo = $_POST['titulo'];

        $correo_electronico = $_POST['correo_electronico'];
        $lada = $_POST['lada'];
        $telefono = $_POST['telefono'];
        $nombre = $_POST['nombre'];
        $apellido_paterno = $_POST['apellido_paterno'];
        $apellido_materno = $_POST['apellido_materno'];
        $empresa = $_POST['empresa'];
        $comentario = $_POST['comentario'];
        $telefono_completo = $lada.' '.$telefono;
        $estatus = 'EN ESPERA';

        $query = sprintf("INSERT INTO participante (nombre, apellido_paterno, apellido_materno, empresa, comentario, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($nombre, "text"),
           GetSQLValueString($apellido_paterno, "text"),
           GetSQLValueString($apellido_materno, "text"),
           GetSQLValueString($empresa, "text"),
           GetSQLValueString($comentario, "text"),
           GetSQLValueString($fecha_registro, "int"));

        $insertar = mysql_query($query, $conectar) or die(mysql_error());

        $id_participante = mysql_insert_id($conectar);
        /// creamos los datos de contacto del participante
        $query = sprintf("INSERT INTO contacto_participante (fk_id_participante, correo_electronico, telefono, fecha_registro) VALUES (%s, %s, %s, %s)", 
           GetSQLValueString($id_participante, "int"),
           GetSQLValueString($correo_electronico, "text"),
           GetSQLValueString($telefono_completo, "text"),
           GetSQLValueString($fecha_registro, "int"));
        $insertar = mysql_query($query, $conectar) or die(mysql_error());
        /// creamos la relacion entre la capacitacion y el participante
        $query = sprintf("INSERT INTO capacitacion_participante (fk_id_capacitacion, fk_id_participante, estatus) VALUES (%s, %s, %s)", 
           GetSQLValueString($id_capacitacion, "int"),
           GetSQLValueString($id_participante, "int"),
           GetSQLValueString($estatus, "text"));
        $insertar = mysql_query($query, $conectar) or die(mysql_error());

        //// ENVIAMOS CORREO DE REGISTRO AL CURSO
        function codigo($length = 8) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $elcodigo = codigo();

        $destinatario = $_POST['correo_electronico'];
        $correo_capacitacion = $_POST['correo_capacitacion'];
        $telefono_capacitacion = $_POST['telefono_capacitacion'];

        $asunto = 'Información del Curso: '.$titulo; 

        $cuerpo = '
        <html>
        <head>
        <meta charset="utf-8">

        <style>
          table, td, th {    
              border: 1px solid #ddd;
              text-align: left;
          }

          table {
              border-collapse: collapse;
              width: 100%;
          }

          th, td {
              padding: 15px;
          }
        </style>

        </head>
        <body>

            <table style="font-family: Tahoma, Geneva, sans-serif; font-size: 13px; color: #797979;" border="0" width="650px">
              <thead>
                <tr>
                  <th rowspan="7" scope="col" align="center" valign="middle" height="100%">
                    <img src="http://mexorganico.com/assets/img/menu.png" alt="Simbolo de Pequeños Productores." width="120" height="120" />
                  </th>
                  <th>
                    <h3>
                      Datos de registro al Curso: <span style="color: #27ae60">'.$titulo.'</span>
                    </h3>
                  </th>
                </tr>
              </thead>
              <tbody>
                    <tr>
                      <td colspan="2" style="text-align:justify;padding-top:30px;">
                        Felicidades, se han registrado sus datos correctamente. A continuación se muestra su <b>Codigo de usuario</b> y las instrucciones para poder cargar el comprobante de pago del curso.
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <h4 style="color:red">
                          Instrucciones para cargar el comprobante de pago
                        </h4>
                        <ol>
                          <li>#Codigo: <b>'.$elcodigo.'</b></li>
                          <li>Debe ingresar a la dirección: </li>
                          <li>Seleccionar el idioma en el que desea utilizar el sistema.</li>
                        </ol>
                      </td>
                    </tr>
                <tr>
                  <td colspan="2">
                    Cualquier duda o pregunta puede ponerse en contacto al correo: <b>'.$correo_capacitacion.'</b> o Telefono: <b>'.$telefono_capacitacion.'</b>
                  </td>
                </tr>
              </tbody>
            </table>

        </body>
        </html>
    ';
      $mail->AddAddress($destinatario);
      //$mail->AddBCC($administrador);
      //$mail->Username = "soporte@d-spp.org";
      //$mail->Password = "/aung5l6tZ";
      $mail->Subject = utf8_decode($asunto);
      $mail->Body = utf8_decode($cuerpo);
      $mail->MsgHTML(utf8_decode($cuerpo));
      $mail->Send();
      $mail->ClearAddresses();
      //$mensaje = "<strong>Datos Registrados Correctamente, por favor revisa tu bandeja de correo electronico, si no encuentras tus datos revisa tu bandeja de spam</strong>";


    }

    if(isset($_POST['cargar_comprobante']) && $_POST['cargar_comprobante'] == 1){
      $id_capacitacion = $_POST['id_capacitacion'];
      $codigo = $_POST['codigo'];
      $correo_electronico = $_POST['correo_electronico'];
      $titulo = $_POST['titulo'];

      //verificamos la información
      $query = "SELECT participante.id_participante FROM participante INNER JOIN contacto_participante ON participante.id_participante = contacto_participante.fk_id_participante WHERE participante.codigo = '$codigo' && contacto_participante.correo_electronico = '$correo_electronico'";
      $consultar = mysql_query($query, $conectar) or die(mysql_error());
      $participante = mysql_fetch_assoc($consultar);
      $total = mysql_num_rows($consultar);

      // consultamos el id_capacitacion_participante
      $row_capacitacion = mysql_query("SELECT capacitacion_participante.id_capacitacion_participante FROM capacitacion_participante WHERE fk_id_participante = '$participante[id_participante]' AND fk_id_capacitacion = $id_capacitacion", $conectar) or die(mysql_error());
      $capacitacion = mysql_fetch_assoc($row_capacitacion);

      if($total > 0){
        /// INSERTAMOS EL COMPROBANTE DE PAGO

        if(!empty($_FILES['comprobante_pago']['name'])){
          $ruta_img = "system/img/comprobantes/";
          $ruta_img = $ruta_img . basename( $_FILES['comprobante_pago']['name']); 
          if(move_uploaded_file($_FILES['comprobante_pago']['tmp_name'], $ruta_img)){ 
            //echo "El archivo ". basename( $_FILES['img']['name']). " ha sido subido";
          } /*else{
            echo "Ha ocurrido un error, trate de nuevo!";
          }*/
        }else{
          $ruta_img = '';
        }

        /// creamos la información del comprobante
        $fk_id_participante = $participante['id_participante'];
        $archivo = $ruta_img;
        $estatus = 'EN ESPERA';
        //$aprobado_por = $id_administrador;
        $fecha_registro = $_POST['fecha_registro'];
        $id_capacitacion_participante = $capacitacion['id_capacitacion_participante'];


        $query = sprintf("INSERT INTO comprobante_pago(fk_id_participante, archivo, estatus, fecha_registro) VALUES (%s, %s, %s, %s)", 
               GetSQLValueString($fk_id_participante, "text"),
               GetSQLValueString($archivo, "text"),
               GetSQLValueString($estatus, "text"),
               GetSQLValueString($fecha_registro, "text"));

        $insertar = mysql_query($query,$conectar) or die(mysql_error()); 

        $id_comprobante_pago = mysql_insert_id($conectar);
        $estatus = 'EN ESPERA';

        /// ACTUALIZAMOS LA TABLA capacitacion_participante
        $query = sprintf("UPDATE capacitacion_participante SET fk_id_comprobante_pago = %s, estatus = %s WHERE id_capacitacion_participante = %s",
          GetSQLValueString($id_comprobante_pago, "int"),
          GetSQLValueString($estatus, "text"),
          GetSQLValueString($id_capacitacion_participante, "int"));
        $actualizar = mysql_query($query, $conectar) or die(mysql_error());

        //// enviamos correo para notificar que se ha cargado un comprobante de pago
        // consultamos la información del participante
          $query = "SELECT participante.nombre, participante.apellido_paterno, participante.apellido_materno, contacto_participante.correo_electronico, contacto_participante.telefono, capacitacion.correo_capacitacion FROM capacitacion_participante INNER JOIN participante ON capacitacion_participante.fk_id_participante = participante.id_participante INNER JOIN contacto_participante ON capacitacion_participante.fk_id_participante = contacto_participante.fk_id_participante INNER JOIN capacitacion ON capacitacion_participante.fk_id_capacitacion = capacitacion.id_capacitacion WHERE capacitacion_participante.fk_id_participante = $fk_id_participante AND capacitacion_participante.fk_id_capacitacion = $id_capacitacion";
          $row_participante = mysql_query($query, $conectar) or die(mysql_error());
          $participante = mysql_fetch_assoc($row_participante);

          $nombre = $participante['nombre'];
          $apellidos = $participante['apellido_paterno'].' '.$participante['apellido_materno'];
          $correo = $participante['correo_electronico'];
          $telefono = $participante['telefono'];

        $asunto = 'Comprobante de pago del Curso: '.$titulo; 

        $cuerpo = '
        <html>
        <head>
        <meta charset="utf-8">

        <style>
          table, td, th {    
              border: 1px solid #ddd;
              text-align: left;
          }

          table {
              border-collapse: collapse;
              width: 100%;
          }

          th, td {
              padding: 15px;
          }
        </style>

        </head>
        <body>

            <table style="font-family: Tahoma, Geneva, sans-serif; font-size: 13px; color: #2c3e50">
              <thead>
                <tr>
                  <th rowspan="7" scope="col" align="center" valign="middle" height="100%">
                    <img src="http://mexorganico.com/assets/img/menu.png" alt="Simbolo de Pequeños Productores." width="120" height="120" />
                  </th>
                  <th>
                    <h3>
                      Comprobante de pago del Curso: <span style="color: #27ae60">'.$titulo.'</span>
                    </h3>
                  </th>
                </tr>
              </thead>
              <tbody>
                  <td colspan="2">
                    <h4>
                      Se ha cargado un comprobante de pago de curso: '.$titulo.'
                    </h4>
                    <h4 style="color:red">
                      Información acerca del participante:
                    </h4>
                    <ul>
                      <li>
                        <b>Nombre:</b> '.$nombre.'
                      </li>
                      <li>
                        <b>Apellidos:</b> '.$apellidos.'
                      </li>
                      <li>
                        <b>Correo Electrónico:</b> '.$correo_electronico.'
                      </li>
                      <li>
                        <b>Teléfono:</b> '.$telefono.'
                      </li>
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>

        </body>
        </html>
    ';
      $mail->AddAddress($participante['correo_capacitacion']);
      $mail->AddAttachment($archivo);
      //$mail->AddBCC($administrador);
      //$mail->Username = "soporte@d-spp.org";
      //$mail->Password = "/aung5l6tZ";
      $mail->Subject = utf8_decode($asunto);
      $mail->Body = utf8_decode($cuerpo);
      $mail->MsgHTML(utf8_decode($cuerpo));
      $mail->Send();
      $mail->ClearAddresses();

      echo '<script>alert("Comprobante de pago enviado");</script>';

      }else{
        echo '<script>alert("Datos incorrectos")</script>';
      }

    }


    $query = "SELECT capacitacion.*, detalle_capacitacion.cupo, detalle_capacitacion.lugar, detalle_capacitacion.tipo_curso, detalle_capacitacion.costo, detalle_capacitacion.fecha_inicio, detalle_capacitacion.fecha_fin, usuario.username FROM capacitacion INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion INNER JOIN usuario ON capacitacion.fk_id_usuario = usuario.idusuario WHERE id_capacitacion = $id_capacitacion";
    $row_capacitacion = mysql_query($query,$conectar) or die(mysql_error());
    $capacitacion = mysql_fetch_assoc($row_capacitacion);


    $query_tag = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE id_capacitacion = $capacitacion[id_capacitacion]";
    $row_tag = mysql_query($query_tag,$conectar) or die(mysql_error());
    $row_tag2 = mysql_query($query_tag,$conectar) or die(mysql_error());

    $numero_tags = mysql_num_rows($row_tag);

    $fechas = '';
    if(!empty($capacitacion['fecha_inicio']) && !empty($capacitacion['fecha_fin'])){
        $fechas = date('d/m/Y', $capacitacion['fecha_inicio']).' al '.date('d/m/Y', $capacitacion['fecha_fin']);
    }else{
        if(!empty($capacitacion['fecha_inicio'])){
            $fechas = date('d/m/Y', $capacitacion['fecha_inicio']);
        }else{
            $fechas = date('d/m/Y', $capacitacion['fecha_fin']);
        }
    }

    /// consultamos el numero de asistentes
    $query_asistentes = "SELECT COUNT(fk_id_participante) AS 'num_asistentes' FROM capacitacion_participante WHERE fk_id_capacitacion = $id_capacitacion AND estatus = 'VALIDADO'";
    $row_asistentes = mysql_query($query_asistentes, $conectar) or die(mysql_error());
    $asistentes = mysql_fetch_assoc($row_asistentes);
?>
    <!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
    <!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="es">
        <!--<![endif]-->
        <head>
            <!-- Title -->
            <title><?php echo $capacitacion['titulo'] ?> - México Orgánico</title>
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

<style>    
    .bio-row{
        width: 50%;
        float: left;
        margin-bottom: 10px;
        padding: 0 15px;

    }
    .bio-row span{
        color: #89817e;;
    }
    .bio-row p span{
        width: 100px;
        display: inline-block;
    }
    .informacion{
        color: #27ae60;
    }
</style>

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
                            <!-- Main Column -->
                            <div class="col-md-9">
                                <div class="blog-post">
                                    <div class="blog-item-header">
                                        <h2>
                                            <a href="#">
                                                <?php echo $capacitacion['titulo']; ?>
                                            </a>
                                        </h2>
                                        <!-- Date -->
                                        <div class="blog-post-date">
                                            <?php 
                                            echo '<span>'.$fechas.'</span>';
                                             ?>
                                        </div>
                                        <!-- End Date -->
                                    </div>
                                    <div class="blog-post-details">
                                        <!-- Author Name -->
                                        <div class="blog-post-details-item blog-post-details-item-left user-icon">
                                            <i class="fa fa-user color-gray-light"></i>
                                            <a href="#"><?php echo $capacitacion['username']; ?></a>
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

                                    </div>
                                    <div class="blog-item">
                                        <div class="clearfix"></div>
                                        <div class="blog-post-body row margin-top-15">
                                            <div class="col-md-12 text-center">
                                                <img class="margin-bottom-20"  src="system/administrador/<?php echo $capacitacion['img']; ?>" alt="image1">
                                            </div>
                                            <!--<div class="col-md-7">
                                                <p>
                                                    <?php echo nl2br(substr($capacitacion['descripcion'], 0,300))." ..."; ?>
                                                </p>
                                            </div>-->
                                            <div class="col-md-12" style="border-bottom: 3px solid #27ae60">
                                                <h4 style="color: #2c3e50">
                                                    Detalles del Curso / Capacitación
                                                </h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        Fecha: <span class="informacion"><?php echo $fechas; ?></span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Costo: $ <span class="informacion"><?php echo number_format($capacitacion['costo']); ?></span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Cupo: <span class="informacion"><?php echo $capacitacion['cupo']; ?></span>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        Tipo de curso: <span class="informacion"><?php echo $capacitacion['tipo_curso']; ?></span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Correo electronico: <span class="informacion"><?php echo $capacitacion['correo_capacitacion']; ?></span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Telefono: <span class="informacion"><?php echo $capacitacion['telefono_capacitacion']; ?></span>
                                                    </div>
                                                    <div class="col-sm-6" style="margin-top:20px;">
                                                        Dirección: <span><?php echo $capacitacion['lugar']; ?></span>
                                                    </div>
                                                    <div class="col-sm-6" style="margin-top:3em;">
                                                      <?php 
                                                      if($asistentes['num_asistentes'] < $capacitacion['cupo']){
                                                      ?>
                                                        <button class="btn btn-lg btn-success" style="width:100%" data-toggle="modal" data-target="#modalRegistro">
                                                            <span class="glyphicon glyphicon-list-alt"></span> Registrarse al curso
                                                        </button>
                                                      <?php
                                                      }else{
                                                      ?>
                                                        <h4 style="color:#c0392b;font-weight:bold">Lo sentimos, se ha completado el cupo para el curso :(</h4>
                                                      <?php
                                                      }
                                                       ?>
                                                       <button class="btn btn-danger" data-toggle="modal" data-target="#modalComprobantePago" style="width:100%">Comprobante de pago</button>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h2 class="text-center" style="margin-top:20px;">CONTENIDO</h2>
                                                <p>
                                                    <?php echo nl2br($capacitacion['contenido']); ?>
                                                </p>

                                            </div>
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
                                    <h3>Recientes</h3>
                                    <ul class="posts-list margin-top-10">
                                    <?php 
                                        $query = "SELECT capacitacion.id_capacitacion, capacitacion.titulo, capacitacion.img, capacitacion.fecha_registro, detalle_capacitacion.fecha_inicio, detalle_capacitacion.fecha_fin FROM capacitacion INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion ORDER BY fecha_inicio DESC LIMIT 5";
                                        $row_ultimos = mysql_query($query,$conectar) or die(mysql_error());
                                        while($last_articulos = mysql_fetch_assoc($row_ultimos)){
                                    ?>
                                        <li>
                                            <div class="recent-post">
                                                <a href="articulo.php?articulo=<?php echo $last_articulos['id_capacitacion']; ?>">
                                                    <img class="pull-left" style="width:54px;" src="system/administrador/<?php echo $last_articulos['img']; ?>" alt="thumb1">
                                                </a>
                                                <a href="articulo.php?articulo=<?php echo $last_articulos['id_capacitacion']; ?>" class="posts-list-title"><?php echo $last_articulos['titulo']; ?></a>
                                                <br>
                                                <span class="recent-post-date">
                                                    <?php 
                                                    if(!empty($last_articulos['fecha_inicio']) && !empty($last_articulos['fecha_fin'])){
                                                        echo '<span>'.date('d/m/Y',$last_articulos['fecha_inicio']).' al '.date('d/m/Y',$last_articulos['fecha_fin']).'</span>';
                                                    }else{
                                                        if(!empty($last_articulos['fecha_inicio'])){
                                                            echo '<span>'.date('d/m/Y',$last_articulos['fecha_inicio']).'</span>';
                                                        }else{
                                                            echo '<span>'.date('d/m/Y',$last_articulos['fecha_fin']).'</span>';
                                                        }
                                                    }
                                                     ?>
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    <?
                                        }
                                    ?>

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


                <!-- Modal registrarse -->
                <div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="modalRegistro">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="miForm" action="" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="asd">Registro de participante</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-12" id="divMostrar"></div>
                                        <div class="col-md-12">
                                            <label for="correo_electronico">* Correo Electronico</label>
                                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="correo">* Telefono</label>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="lada" placeholder="lada">
                                                </div>
                                                <div class="col-sm-8">
                                                   <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono" required> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="nombre">* Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="apellido_paterno">* Apellido Paterno</label>
                                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="apellido_materno">Apellido Materno</label>
                                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="empresa">Empresa</label>
                                            <input type="text" class="form-control" id="empresa" name="empresa">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="comentario">Comentario</label>
                                            <textarea class="form-control" name="comentario" id="comentario" rows="3"></textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" id="correo_capacitacion" name="correo_capacitacion" value="<?php echo $capacitacion['correo_capacitacion']; ?>">
                                    <input type="hidden" id="telefono_capacitacion" name="telefono_capacitacion" value="<?php echo $capacitacion['telefono_capacitacion']; ?>">
                                    <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo time() ?>">
                                    <input type="hidden" id="id_capacitacion" name="id_capacitacion" value="<?php echo $_GET['curso']; ?>">
                                    <input type="hidden" id="titulo" name="titulo" value="<?php echo $capacitacion['titulo']; ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" id="crear_registro" name="crear_registro" value="1" class="btn btn-primary">Crear registro</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Modal cargar comprobante de pago -->
                <div class="modal fade" id="modalComprobantePago" tabindex="-1" role="dialog" aria-labelledby="modalRegistro">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="miForm" action="" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"  style="color: #c0392b" id="">Cargar Comprobante de pago</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-12" id="divMostrar"></div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                  <label for="codigo">* Codigo de usuario</label>
                                                    <input type="text" class="form-control" name="codigo" placeholder="#Codigo de usuario" required>
                                                </div>
                                                <div class="col-sm-8">
                                                  <label for="correo_electronico">* Correo Electronico</label>
                                                   <input type="text" class="form-control" id="correo_electronico" name="correo_electronico" placeholder="Correo electronico" required> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="comprobante_pago">* Comprobante de pago</label>
                                            <input type="file" class="form-control" id="comprobante_pago" name="comprobante_pago" required>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" id="correo_capacitacion" name="correo_capacitacion" value="<?php echo $capacitacion['correo_capacitacion']; ?>">
                                    <input type="hidden" id="telefono_capacitacion" name="telefono_capacitacion" value="<?php echo $capacitacion['telefono_capacitacion']; ?>">
                                    <input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo time() ?>">
                                    <input type="hidden" id="id_capacitacion" name="id_capacitacion" value="<?php echo $_GET['curso']; ?>">
                                    <input type="hidden" id="titulo" name="titulo" value="<?php echo $capacitacion['titulo']; ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" id="cargar_comprobante" name="cargar_comprobante" value="1" class="btn btn-primary">Enviar comprobante de pago</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




            <?php 
            include("footer.php");
             ?>
                <!-- End Footer -->
                <!-- JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
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
               <!-- <script type="text/javascript" src="main.js" type="text/javascript"></script>-->

                <script>
                  $(function(){
                    $('#crear_registro').on('click', function(e){
                      e.preventDefault();

                      var correo_electronico = $('#correo_electronico').val();
                      var telefono = $('#telefono').val();
                      var nombre = $('#nombre').val();
                      var apellido_paterno = $('#apellido_paterno').val();

                      if(correo_electronico == ''){
                        $('#correo_electronico').css("border-color", "#e74c3c",),
                        $('#correo_electronico').focus();
                      }
                      else if(telefono == ''){
                        $('#telefono').css("border-color", "#e74c3c",),
                        $('#telefono').focus();
                      }

                      else if(nombre == ''){
                        $('#nombre').css("border-color", "#e74c3c",),
                        $('#nombre').focus();
                      }
                      else if(apellido_paterno == ''){
                        $('#apellido_paterno').css("border-color", "#e74c3c",),
                        $('#apellido_paterno').focus();
                      }else{
                        var nombre = $('#nombre').val();
                        var correo_electronico = $('#correo_electronico').val();

                        var datosEnviados = 
                        {
                          'correo_electronico': $('#correo_electronico').val(),
                          'lada': $('#lada').val(),
                          'telefono': $('#telefono').val(),
                          'nombre': $('#nombre').val(),
                          'apellido_paterno': $('#apellido_paterno').val(),
                          'apellido_materno': $('#apellido_materno').val(),
                          'empresa': $('#empresa').val(),
                          'comentario': $('#comentario').val(),
                          'correo_capacitacion': $('#correo_capacitacion').val(),
                          'telefono_capacitacion': $('#correo_electronico').val(),
                          'fecha_registro': $('#fecha_registro').val(),
                          'id_capacitacion': $('#id_capacitacion').val(),
                          'titulo': $('#titulo').val()
                        }

                        $.ajax({
                          type: "POST",
                          url: "insertar.php",
                          data: (datosEnviados),
                          beforeSend: function(){
                           // $('#divMostrar').show();
                           // $('#divMostrar').html('Procesando Datos');
                          },
                          success: function(respuesta){
                            //$('#divMostrar').hide();
                            if(respuesta == 1){
                              //$('#divMostrar').html('<p class="alert alert-success">Registrado correctamente</p>');
                              $('#modalRegistro').modal('toggle');
                              $("#miForm")[0].reset();
                                swal({
                                  type: 'success',
                                  title: 'Datos registrados correctamente, ahora recibiras un correo',
                                })
                            }else{
                              $('#divMostrar').html('<p class="alert alert-danger">Este correo ya ha sido utilizado, por favor usar otro.</p>');
                              $( "#divMostrar" ).delay( 1500 ).slideUp( 400 );

                            }
                          }


                        });
                      }

                    })
                  })
                </script>
        </body>
    </html>
    <!-- === END FOOTER === -->
<?php
}else{
    include('pages-404.html');
}
 ?>