<?php
    $host= $_SERVER["HTTP_HOST"];
    $url= $_SERVER["REQUEST_URI"];
?>
            <div id="hornav" class="bottom-border-shadow">
                <div class="container no-padding border-bottom">
                    <div class="row">
                        <div class="col-md-11 no-padding">
                            <div class="visible-lg">
                                <ul id="hornavmenu" class="nav navbar-nav">
                                    <li class="hidden-xs hidden-sm">
                                        <a href="index.php" style="padding-top:0px;padding-bottom:0px;"><img src="assets/img/menu.png" alt=""></a>
                                    </li>
                                    <li class="visible-xs visible-sm" >
                                        <a <?php if(strpos($url, 'index.php') !== FALSE){ echo 'class="active"'; } ?> style="hover:white" href="index.php">Inicio</a>
                                    </li>
                                    <li>
                                        <a <?php if(strpos($url, 'nosotros.php') !== FALSE){ echo 'class="active"'; } ?> href="nosotros.php">Nosotros</a>
                                    </li>

                                    <li>
                                        <a <?php if(strpos($url, 'articulos.php') !== FALSE){ echo 'class="active"'; } ?> href="articulos.php">Articulos</a>
                                    </li>
                                    <li>
                                        <a <?php if(strpos($url, 'capacitacion.php') !== FALSE){ echo 'class="active"'; } ?> href="capacitacion.php">Capacitación</a>
                                    </li>

                                    <li>
                                        <a <?php if(strpos($url, 'sitios_interes.php') !== FALSE){ echo 'class="active"'; } ?> href="sitios_interes.php">Sitios de interés</a>
                                    </li>
                                    <li>
                                    	<a <?php if(strpos($url, 'biblioteca.php') !== FALSE){ echo 'class="active"'; } ?> href="biblioteca.php">Biblioteca</a>
                                    </li>
                                    <li>
                                    	<a <?php if(strpos($url, 'normas_reglamentos.php') !== FALSE){ echo 'class="active"'; } ?> href="normas_reglamentos.php">Normas y Reglamentos</a>
                                    </li>

                                    <!--<li>
                                        <span>Biblioteca</span>
                                        <ul>
                                            <li>
                                                <a <?php if(strpos($url, 'normas.php') !== FALSE){ echo 'class="active"'; } ?> href="normas.php">Normas</a>
                                            </li>
                                            <li>
                                                <a <?php if(strpos($url, 'reglamentos.php') !== FALSE){ echo 'class="active"'; } ?> href="reglamentos.php">Reglamentos</a>
                                            </li>
                                        </ul>
                                    </li>-->
                                    <!--<li>
                                        <a href="biblioteca.php"><span class="fa-font ">Biblioteca</span></a>
                                    </li>-->
                                    <li>
                                        <a <?php if(strpos($url, 'contact.php') !== FALSE){ echo 'class="active"'; } ?> href="contact.php">Contactanos</a>
                                    </li>
                                    <li>
                                        <a <?php if(strpos($url, 'login.php') !== FALSE){ echo 'class="active"'; } ?> href="login.php">Login</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-md-1 no-padding">
                            <ul class="social-icons rounded color pull-right">
                                <!--<li class="social-rss">
                                    <a href="#" target="_blank" title="RSS"></a>
                                </li>-->
                                <li class="social-twitter">
                                    <a href="#" target="_blank" title="Twitter"></a>
                                </li>
                                <li class="social-facebook">
                                    <a href="https://www.facebook.com/MexicOrganico" target="_blank" title="Facebook"></a>
                                </li>
                                <!--<li class="social-googleplus">
                                    <a href="#" target="_blank" title="Google+"></a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>