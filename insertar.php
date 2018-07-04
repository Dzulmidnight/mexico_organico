<?php
session_start();
require_once("system/connections/conexion.php");
require_once("system/connections/mail.php");
mysql_select_db($database, $conectar);

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
	$nombre = $_POST['nombre'];
	$correo_electronico = $_POST['correo_electronico'];
	$id_capacitacion = $_POST['id_capacitacion'];
 
 	$query = "SELECT contacto_participante.correo_electronico FROM contacto_participante INNER JOIN participante ON contacto_participante.fk_id_participante = participante.id_participante INNER JOIN capacitacion_participante ON contacto_participante.fk_id_participante = capacitacion_participante.fk_id_participante WHERE correo_electronico = '$correo_electronico' AND capacitacion_participante.fk_id_capacitacion = '$id_capacitacion'";
 	$resultado = mysql_query($query, $conectar) or die(mysql_error());
 	$fila = mysql_num_rows($resultado);

    if($fila == 0){

		if(isset($_POST['fecha_registro'])){
			$fecha_registro = $_POST['fecha_registro'];
		}else{
			$fecha_registro = '';
		}
		if(isset($_POST['id_capacitacion'])){
			$id_capacitacion = $_POST['id_capacitacion'];
		}else{
			$id_capacitacion = '';
		}
		if(isset($_POST['titulo'])){
			$titulo = $_POST['titulo'];
		}else{
			$titulo = '';
		}
		if(isset($_POST['lada'])){
			$lada = $_POST['lada'];
		}else{
			$lada = '';
		}
		if(isset($_POST['telefono'])){
			$telefono = $_POST['telefono'];
		}else{
			$telefono = '';
		}
		if(isset($_POST['nombre'])){
			$nombre = $_POST['nombre'];
		}else{
			$nombre = '';
		}
		if(isset($_POST['apellido_paterno'])){
			$apellido_paterno = $_POST['apellido_paterno'];
		}else{
			$apellido_paterno = '';
		}
		if(isset($_POST['apellido_materno'])){
			$apellido_materno = $_POST['apellido_materno'];
		}else{
			$apellido_materno = '';
		}
		if(isset($_POST['empresa'])){
			$empresa = $_POST['empresa'];
		}else{
			$empresa = '';
		}
		if(isset($_POST['comentario'])){
			$comentario = $_POST['comentario'];
		}else{
			$comentario = '';
		}

        $telefono_completo = $lada.' '.$telefono;
        $estatus = 'EN ESPERA';

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

        $query = sprintf("INSERT INTO participante (codigo, nombre, apellido_paterno, apellido_materno, empresa, comentario, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s, %s)", 
           GetSQLValueString($elcodigo, "text"),
           GetSQLValueString($nombre, "text"),
           GetSQLValueString($apellido_paterno, "text"),
           GetSQLValueString($apellido_materno, "text"),
           GetSQLValueString($empresa, "text"),
           GetSQLValueString($comentario, "text"),
           GetSQLValueString($fecha_registro, "int"));

        $insertar = mysql_query($query, $conectar) or die(mysql_error());

        $id_participante = mysql_insert_id($conectar);
        /// creamos los datos de contacto del participante
        $query = sprintf("INSERT INTO contacto_participante (fk_id_participante, correo_electronico, lada, telefono, fecha_registro) VALUES (%s, %s, %s, %s, %s)", 
           GetSQLValueString($id_participante, "int"),
           GetSQLValueString($correo_electronico, "text"),
           GetSQLValueString($lada, "text"),
           GetSQLValueString($telefono, "text"),
           GetSQLValueString($fecha_registro, "int"));
        $insertar = mysql_query($query, $conectar) or die(mysql_error());
        /// creamos la relacion entre la capacitacion y el participante
        $query = sprintf("INSERT INTO capacitacion_participante (fk_id_capacitacion, fk_id_participante, estatus) VALUES (%s, %s, %s)", 
           GetSQLValueString($id_capacitacion, "int"),
           GetSQLValueString($id_participante, "int"),
           GetSQLValueString($estatus, "text"));
        $insertar = mysql_query($query, $conectar) or die(mysql_error());

        $destinatario = $correo_electronico;
        if(isset($_POST['correo_capacitacion'])){
        	$correo_capacitacion = $_POST['correo_capacitacion'];
        }else{
        	$correo_capacitacion = '';
        }
        if(isset($_POST['telefono_capacitacion'])){
        	$telefono_capacitacion = $_POST['telefono_capacitacion'];
        }else{
        	$telefono_capacitacion = '';
        }
        //// ENVIAMOS EL CORREO
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
                    <img src="http://mexorganico.com/assets/img/menu.png" alt="Mexico Organico" width="120" height="120" />
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
                          <li>Debe ingresar a la pagina web <a href="http://mexorganico.com/index.php">Mexico Organico</a></li>
                          <li>Seleccione la pestaña <a href="http://mexorganico.com/capacitacion.php">"Capacitación"</a></li>
                          <li>Localicé su curso y de clic en leer más, una vez realizado esto podra visualizar el boton(rojo) para <span style="color:red">"Cargar el Comprobante de pago"</span>. </li>
                          <li>Debera ingresar el correo electronico con el que dio de alta sus datos e ingresar el siguiente #Codigo: <b>'.$elcodigo.'</b></li>
                          <li>Tambien debera cargar la imagen del comprobante de pago.</li>
                          <li>Dicha información sera verificada por los administradores, en caso de no haber ningun problema, recibira un correo de confirmación.</li>
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
      echo 1;
    }else{
    	echo 0;
    }

 ?>