<?php
require_once("system/connections/conexion.php"); 
require_once("system/connections/mail.php"); 

mysql_select_db($database, $conectar); 
//CONNECT TO PDO


//CHECH IF USERNAME EXISTS 
if (isset($_POST))
{
    $emailposted=$_POST["correo_electronico"];
        // Validate email
    if (!filter_var($emailposted, FILTER_VALIDATE_EMAIL) === false) {
        $activito=2;

        $query = "SELECT COUNT(contacto_participante.fk_id_participante) AS 'total' FROM contacto_participante INNER JOIN participante ON contacto_participante.fk_id_participante = participante.id_participante INNER JOIN capacitacion_participante ON contacto_participante.fk_id_participante = capacitacion_participante.fk_id_participante WHERE contacto_participante.correo_electronico = $emailposted";
        $row_query = mysql_query($query, $conectar) or die(mysql_error());
        $verificar = mysql_fetch_assoc($row_query);



        if ($verificar['total'] != 0)
        {
            echo "<div class='alert alert-success '><i class='fa fa-check'></i> Email disponible</div> <input id='emailchecker' type='hidden' value='1' name='emailchecker'>  ";   
            }else {
                echo "<div class='alert alert-danger '><i class='fa fa-close'></i> Email NO disponible <input id='emailchecker' type='hidden' value='0' name='emailchecker'></div>";
            }
        }else {
            echo("<div class='alert alert-danger '><i class='fa fa-close'></i> $emailposted, No es un email válido <input id='emailchecker' type='hidden' value='0' name='emailchecker'></div>");
        }
}
