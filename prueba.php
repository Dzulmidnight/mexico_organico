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
                        Felicidades, se han registrado sus datos correctamente. A continuación se muestra su <b>Codigo de usuario</b> y las instrucciones para poder cargar el comprobante de pago del curso.
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <h4 style="color:red">
                          Instrucciones para cargar el comprobante de pago
                        </h4>
                        <ol>
                          <li>#Codigo: <b><?php echo $codigo ?></b></li>
                          <li>Debe ingresar a la dirección: </li>
                          <li>Seleccionar el idioma en el que desea utilizar el sistema.</li>
                        </ol>
                      </td>
                    </tr>

                    <!--<tr>
                      <td style="text-align:justify;padding-top:10px;"><i>Congratulations , your data have been recorded correctly. Below is your <b>#SPP and password needed to log in </b>: <a href="http://d-spp.org/?OPP" target="_new">www.d-spp.org/?OPP</a></i>, once you have logged you are advised to change your password on the Information OPP section, in that section are data which can be modified if be necessary.</td>
                    </tr>-->
                <tr>
                  <td colspan="2">
                    Cualquier duda o pregunta puede ponerse en contacto al correo: soporte@d-spp.org o Telefono: 2342343
                  </td>
                </tr>
              </tbody>
            </table>

        </body>
        </html>