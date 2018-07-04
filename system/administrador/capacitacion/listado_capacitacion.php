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

	if(isset($_POST['eliminar_capacitacion']) && $_POST['eliminar_capacitacion'] == 1){
		$id_capacitacion = $_POST['id_capacitacion'];
		$img = $_POST['img_capacitacion'];
		if(!empty($img)){
			unlink($img);
		}
		$deleteSQL = sprintf("DELETE FROM capacitacion WHERE id_capacitacion = %s",
			GetSQLValueString($id_capacitacion, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$deleteSQL = sprintf("DELETE FROM detalle_capacitacion WHERE fk_id_capacitacion = %s",
			GetSQLValueString($id_capacitacion, "int"));		
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());


		$deleteSQL = sprintf("DELETE FROM articulo_tag WHERE id_capacitacion = %s",
			GetSQLValueString($id_capacitacion, "int"));
		$eliminar = mysql_query($deleteSQL,$conectar) or die(mysql_error());

		$mensaje = "Curso eliminado";

	}
	$fecha_actual = time();
	//$query = "SELECT nota.*,  usuario.username FROM nota INNER JOIN usuario ON nota.idusuario = usuario.idusuario";
	//$query = "SELECT articulo.*, usuario.username FROM articulo INNER JOIN usuario ON articulo.autor = usuario.idusuario";

	$query = "SELECT capacitacion.*, detalle_capacitacion.cupo, detalle_capacitacion.lugar, detalle_capacitacion.fecha_inicio, detalle_capacitacion.fecha_fin, detalle_capacitacion.tipo_curso, detalle_capacitacion.costo, usuario.username FROM capacitacion INNER JOIN usuario ON capacitacion.fk_id_usuario INNER JOIN detalle_capacitacion ON capacitacion.id_capacitacion = detalle_capacitacion.fk_id_capacitacion GROUP BY capacitacion.id_capacitacion";
	$row_capacitacion = mysql_query($query,$conectar) or die(mysql_error());
	$total_capacitacion = mysql_num_rows($row_capacitacion);
?>
<style>
	.informacion{
		color: #d35400;
	}
	.activo{
		color: #2ecc71;
	}
	.cancelado{
		color: #e74c3c;
	}
	.Suspendido{
		color: #e67e22;
	}
   
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

</style>

<h3>Listado de Capacitaciones</h3>

<?php 
	function consultarEstatus($tipo_curso,$estatus,$id){
		$color = '';
		if($estatus == 'ACTIVO'){
			$color = 'activo';
		}else if($estatus == 'SUSPENDIDO'){
			$color = 'suspendido';
		}else if($estatus == 'FINALIZADO'){
			$color = 'cancelado';
		}
		echo "
			<span class='".$color." glyphicon glyphicon-bookmark'></span>
			<b>
				".$tipo_curso." (id: ".$id.")
			</b>
			";

	}
 ?>

<table class="table table-condensed table-bordered" style="font-size:12px;">
	<thead>
		<tr>
			<th colspan="9">
				<b>
					Estatus: <span class="activo glyphicon glyphicon-bookmark" data-toggle="tooltip" title="Activo"></span> <span class="suspendido glyphicon glyphicon-bookmark" data-toggle="tooltip" title="Suspendido"></span> <span class="cancelado glyphicon glyphicon-bookmark" data-toggle="tooltip" title="Finalizado"></span>
				</b>
			</th>
		</tr>
		<tr class="success">
			<th class="text-center">
				<span class="informacion glyphicon glyphicon-info-sign" data-toggle="tooltip" title="Tipo de curso"></span> Tipo
			</th>
			<th class="text-center">
				<span class="informacion glyphicon glyphicon-info-sign" data-toggle="tooltip" title="Duración del curso"></span> Fechas
			</th>
			<th class="text-center">
				Asistentes
			</th>
			<th class="text-center">
				Titulo
			</th>
			<th class="text-center" style="width:500px;">
				Descripción
			</th>
			<th class="text-center">
				Contenido
			</th>

			<!--<th class="text-center">
				Tag(s)
			</th>-->
			<th class="text-center">
				Adm
			</th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if($total_capacitacion == 0){
			echo "<tr class='info text-center'><td colspan='9'>No se encontraron capacitaciones</td></tr>";
		}else{
			while($capacitacion = mysql_fetch_assoc($row_capacitacion)){
				/// ha finalizado el curso
				if($fecha_actual > $capacitacion['fecha_fin']){
					$estatus = "FINALIZADO";

					$query = sprintf("UPDATE capacitacion SET estatus = %s WHERE id_capacitacion = %s",
					           GetSQLValueString($estatus, "text"),
					           GetSQLValueString($capacitacion['id_capacitacion'], "int"));
					$update = mysql_query($query,$conectar) or die(mysql_error());

				}else{ /// el curso aun esta vigente

				}

				$fecha = date('d/m/Y',$capacitacion['fecha_registro']);

				$query = "SELECT COUNT(fk_id_participante) AS 'total_participantes' FROM capacitacion_participante WHERE fk_id_capacitacion = $capacitacion[id_capacitacion]";
				$consultar = mysql_query($query, $conectar) or die(mysql_error());
				$total = mysql_fetch_assoc($consultar);

				$query = "SELECT COUNT(fk_id_participante) AS 'total_participantes' FROM capacitacion_participante WHERE fk_id_capacitacion = $capacitacion[id_capacitacion] AND estatus = 'VERIFICADO'";
				$consultar = mysql_query($query, $conectar) or die(mysql_error());
				$total_verificado = mysql_fetch_assoc($consultar);


				$limite_participantes = $total['total_participantes'].' / '.$capacitacion['cupo'].'(<b style="color: #27ae60">'.$total_verificado['total_participantes'].'</b>)';

			?>
				<tr>
					<!-- tipo de la capacitación -->
					<td>
						<?php 
						consultarEstatus($capacitacion['tipo_curso'], $capacitacion['estatus'], $capacitacion['id_capacitacion']);
						 ?>
					</td>
					<!-- fecha de la capacitación -->
					<td>
						<?php 
						$inicio = date('d/m/Y', $capacitacion['fecha_inicio']);
						$fin = date('d/m/Y', $capacitacion['fecha_fin']);

						echo '<b>'.$inicio.'</b> al <b>'.$fin.'</b>';
						 ?>
					</td>
					<!-- cupo del curso -->
					<td>
						<a href="?menu=capacitacion&lista_asistentes=<?php echo $capacitacion['id_capacitacion']; ?>">
							<span class="glyphicon glyphicon-th-list"></span> Ver lista
						</a>
						<p>
							<?php echo $limite_participantes; ?>
						</p>
					</td>

					<!-- titulo de la capacitación -->
					<td>
						<?php echo $capacitacion['titulo']; ?>
					</td>
					<!-- descripción de la capacitación -->
					<td style="width:500px;">
						<?php echo substr($capacitacion['descripcion'], 0,200); ?>
					</td>
					<!-- contenido de la capacitacion -->
					<td>
						<a href="#" data-toggle="modal" data-target="#myModal<?php echo $capacitacion['id_capacitacion'];?>">Ver contenido</a>
					</td>


					<!-- tags de la capacitación -->
					<!--<td>
						<?php 
						$query_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE id_capacitacion = $capacitacion[id_capacitacion]";
						$row_tags = mysql_query($query_tags,$conectar) or die(mysql_error());
						while($tags = mysql_fetch_assoc($row_tags)){
							echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
						}
						 ?>
					</td>-->
					<!-- nombre administrador -->
					<td>
						<?php echo $capacitacion['username']; ?>
					</td>
					<!-- botones de acciones -->
					<td>
						<div class="dropdown">
							<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Acciones <span class="caret"></span>
							</button>
								<ul class="dropdown-menu" aria-labelledby="dLabel">
									<li>
										<a class="" data-toggle="modal" data-target="#modalInformacion<?php echo $capacitacion['id_capacitacion']; ?>" href="#"><span aria-hidden="true" class="glyphicon glyphicon-info-sign"></span> Información</a>									
									</li>
									<li>
										<a class="" data-toggle="tooltip" title="Editar información" href="?menu=capacitacion&listado&detalle_capacitacion=<?php echo $capacitacion['id_capacitacion']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span> Editar</a>									
									</li>
									<li>
										<form action="" method="POST">
											<button class="btn btn-link" data-toggle="tooltip" title="Eliminar curso" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_capacitacion" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span> Eliminar</button>
											<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
											<input type="hidden" name="id_capacitacion" value="<?php echo $capacitacion['id_capacitacion']; ?>">
											<input type="hidden" name="img_capacitacion" value="<?php echo $capacitacion['img']; ?>">
										</form>
									</li>
									<li class="divider"></li>
									<form action="">
										<li>
											<button class="btn btn-link" data-toggle="tooltip" title="Eliminar curso" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_capacitacion" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span> Suspender</button>
											<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
											<input type="hidden" name="id_capacitacion" value="<?php echo $capacitacion['id_capacitacion']; ?>">
											<input type="hidden" name="img_capacitacion" value="<?php echo $capacitacion['img']; ?>">
										</li>
										<li>
											<button class="btn btn-link" data-toggle="tooltip" title="Eliminar curso" type="submit" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');" name="eliminar_capacitacion" value="1"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span> Cancelar</button>
											<!--<a class="btn btn-sm btn-danger" href=""><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></a>-->
											<input type="hidden" name="id_capacitacion" value="<?php echo $capacitacion['id_capacitacion']; ?>">
											<input type="hidden" name="img_capacitacion" value="<?php echo $capacitacion['img']; ?>">
										</li>
									</form>
								</ul>
						</div>
					</td>

				</tr>


				<!-- Modal contenido curso-->
				<div class="modal fade" id="myModal<?php echo $capacitacion['id_capacitacion'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title text-center" id="myModalLabel" style="color:#2c3e50"><?php echo $capacitacion['titulo']; ?></h4>
				      </div>
				      <div class="modal-body" style="color:#34495e">
				      	<div class="row">
				      		<div class="col-md-12">
						      <?php //nl2br

						      	echo "<div class='col-xs-12'><p class='text-justify'>".$capacitacion['contenido']."</p></div>";



						      /*$nota = sprintf("SELECT contenido,contenido_descripcion,descripcion_img  FROM nota WHERE id_capacitacion = %s",
						        GetSQLValueString($capacitacion['id_capacitacion'],"int"));
						      $ejecutar = mysql_query($nota,$conectar) or die(mysql_error());
						      $titulo_nota = mysql_fetch_assoc($ejecutar);

						      $query_segmento = sprintf("SELECT * FROM nota_segmento WHERE id_capacitacion  = %s",
						      GetSQLValueString($capacitacion['id_capacitacion'],"int"));

						      $ejecutar = mysql_query($query_segmento,$conectar) or die(mysql_error());*/


							?>	
				      		</div>
				      	</div>
				      </div>
				      <div class=" modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>
				  </div>
				</div>

				<!-- Modal consultar información-->
				<div class="modal fade" id="modalInformacion<?php echo $capacitacion['id_capacitacion'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title text-center" id="myModalLabel" style="color:#2c3e50">
				        	Información del curso <span style="color:red"><?php echo $capacitacion['titulo']; ?></span>
				        </h4>
				      </div>
				      <div class="modal-body" style="color:#34495e">
                    <div class="row">
                        <div class="bio-row">
                            <p>
                                <span>Tipo de curso: </span>
                                <?php echo $capacitacion['tipo_curso']; ?>
                            </p>
                        </div>
                        <div class="bio-row">
                            <p>
                                <span>Creador: </span>
                                <?php echo $capacitacion['username']; ?>
                            </p>
                        </div>

                        <div class="bio-row">
                            <p>
                                <span>Cupo: </span>
                                <?php echo $capacitacion['cupo']; ?>
                            </p>
                        </div>
                        <div class="bio-row">
                            <p>
                                <span>Costo por persona: </span>
                                $ <?php echo $capacitacion['costo']; ?> MXN
                            </p>
                        </div>
                        <div class="bio-row">
                            <p>
                                <span>Correo de contacto: </span>
                                <?php echo $capacitacion['correo_capacitacion']; ?>
                            </p>
                        </div>
                        <div class="bio-row">
                            <p>
                                <span>Telefono de contacto: </span>
                                <?php echo $capacitacion['telefono_capacitacion']; ?>
                            </p>
                        </div>
                        <div class="bio-row">
                            <p>
                                <span>Dirección: </span>
                                <?php echo $capacitacion['lugar']; ?>
                            </p>
                        </div>
                    </div>
				      </div>
				      <div class=" modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>
				  </div>
				</div>

			<?php
			}
		}
		?>
	</tbody>
</table>