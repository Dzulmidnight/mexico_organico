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
                <h2>MÉXICO ORGÁNICO S.C</h2>
                <p>
                    MEXICO ORGÁNICO, ASESORÍA Y CAPACITACIÓN, es una “SOCIEDAD CIVIL” integrada por profesionistas con una amplia experiencia en los temas de producción orgánica y temas afines, para poder apoyar a cualquier interesado a lograr un desarrollo integral tanto en sus actividades productivas como organizativas y comerciales.
                </p>
                <p>
                    MEXICO ORGÁNICO, ASESORÍA Y CAPACITACIÓN, está constituida de manera legal en la ciudad de Oaxaca de Juárez, el 1 de abril del 2016.
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

<!-- Footer -->
<div id="footer" class="background-grey">
    <div class="container">
        <div class="row">
            <!-- Copyright -->
            <div class="col-md-8">
                <p class="pull-left">
                    Copyright © MÉXICO ORGÁNICO, ASESORÍA Y CAPACITACIÓN S.C
                </p>
            </div>
            <div id="copyright" class="col-md-4">
                <p class="pull-right">Design by <a href="http://inforganic.net/">Inforganic.net</a></p>
            </div>
            <!-- End Copyright -->
        </div>
    </div>
</div>
<!-- End Footer -->