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
                      Datos de registro al Curso: <span style="color: #27ae60">Nombre del Curso</span>
                    </h3>
                  </th>
                </tr>
              </thead>
              <tbody>
                    <tr>
                      <td colspan="2" style="text-align:justify;padding-top:30px;">
                        Felicidades, se han registrado sus datos correctamente. A continuación se muestra su <b>Numero de usuario</b> y las instrucciones para poder cargar el comprobante de pago del curso.
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <h4 style="color:red">
                          Instrucciones para cargar el comprobante de pago
                        </h4>
                        <ol>
                          <li>#Usuario: aasdf3423</li>
                          <li>Debe ingresar a la dirección: </li>
                          <li>Seleccionar el idioma en el que desea utilizar el sistema.</li>
                          <li>Después de seleccionar el idioma, debe seleccionar la opción "Organización de Pequeños Productores"(OPP) o dar clic en el siguiente link <a href="http://d-spp.org/esp/?OPP">Español</a> o en <a href="http://d-spp.org/en/?OPP">Ingles</a> </li>
                          <li>Debe de iniciar sesión con su usuario(#SPP): <span style="color:#27ae60;">'.$spp.'</span> y su contraseña: <span style="color:#27ae60;">'.$psswd.'</span> </li>
                          <li>Una vez que ha iniciado sesión debe seleccionar la opción "Solicitudes" > "Nueva Solicitud"</li>
                          <li>Después de realizar esos pasos se mostrara la Solicitud electronica donde deberá completar la información correspondiente y al finalizar dar clic en “Enviar Solicitud”.</li>
                          <li>Después de enviar la solicitud, el Organismo de Certificación correspondiente le enviara la cotización por medio del sistema, la cual también le llegara a los correos dados de alta en la solicitud.</li>
                        </ol>
                      </td>
                    </tr>
                    <!--<tr>
                      <td style="text-align:justify;padding-top:10px;"><i>Congratulations , your data have been recorded correctly. Below is your <b>#SPP and password needed to log in </b>: <a href="http://d-spp.org/?OPP" target="_new">www.d-spp.org/?OPP</a></i>, once you have logged you are advised to change your password on the Information OPP section, in that section are data which can be modified if be necessary.</td>
                    </tr>-->

                <tr>
                  <td colspan="2" align="left">
                    <b style="color:red">
                      Datos bancario
                    </b>
                    <br>
                    <p>
                      Pais / Country: <span style="color:#27ae60;">'.$_POST['pais'].'</span>
                    </p>
                    <p>
                    <p>
                      Nombre / Name: <span style="color:#27ae60;">'.$_POST['nombre'].'</span>
                    </p>
                    <p>
                      Abreviación / Short name: <span style="color:#27ae60;">'.$_POST['abreviacion'].'</span>
                    </p>
                  </td>
                </tr>

                <tr>
                  <td colspan="2">
                    Cualquier duda o pregunta puede ponerse en contacto al correo: soporte@d-spp.org o Telefono: 2342343
                  </td>
                </tr>
              </tbody>
            </table>

        </body>
        </html>