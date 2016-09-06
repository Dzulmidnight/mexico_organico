<?php 
include ("system/connections/conexion.php");
mysql_select_db($database, $conectar);

$row_informacion = mysql_query("SELECT * FROM informacion_web", $conectar) or die(mysql_error());
$informacion_web = mysql_fetch_assoc($row_informacion);
 ?>
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
            <!-- End Contact Details -->
            <!-- Sample Menu -->
            <div class="col-md-4 margin-bottom-20">
                <h3 class="margin-bottom-10">Menu</h3>
                <ul class="menu">
                    <li>
                        <a class="fa-tasks" href="index.php">Inicio</a>
                    </li>
                    <li>
                        <a class="fa-users" href="nosotros.php">Nosotros</a>
                    </li>
                    <li>
                        <a class="fa-comments" href="articulos.php">Articulos</a>
                    </li>
                    <li>
                        <a class="fa-coffee" href="sitios_interes.php">Sitios de Interes</a>
                    </li>
                    <li>
                        <a class="fa-cloud" href="biblioteca.php">Biblioteca</a>
                    </li>
                    <li>
                        <a class="fa-envelope" href="contact.php">Contactanos</a>
                    </li>


                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- End Sample Menu -->
        </div>
    </div>
</div>