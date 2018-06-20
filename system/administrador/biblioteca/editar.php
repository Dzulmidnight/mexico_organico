<div class="col-lg-8" style="padding:0px;">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="panel panel-warning">
				  <div class="panel-heading">
				    <h3 class="panel-title">
				    	Detalle documento id: <span style="color:red"><?php echo $biblioteca['idbiblioteca']; ?></span>
				    </h3>
				  </div>
				  <div class="panel-body">
					<div class="row">
					  	<div class="col-lg-12">
					  		<div class="row">
								<div class="col-md-4">
									<p class="alert alert-info" style="padding:7px;">Usuario: <strong style="color:#c0392b"><?php echo $biblioteca['username']; ?></strong></p>
									<input type="hidden" name="idusuario" value="<?php echo $biblioteca['idusuario']; ?>">
								</div>	
								<div class="col-md-4">
									<p class="alert alert-info" style="padding:7px;">Fecha: <strong style="color:#c0392b"><?php echo $fecha; ?></strong></p>
									<input type="hidden" name="idusuario" value="<?php echo $biblioteca['idusuario']; ?>">
								</div>
								<div class="col-md-4">
									<label>Tipo de documento</label>
									<select class="form-control" name="tipo_documento" id="">
										<option value="">Tipo de documento</option>
										<option <?php if($biblioteca['tipo_documento'] == 'BIBLIOTECA'){echo 'selected'; } ?> value="BIBLIOTECA">Biblioteca</option>
										<option <?php if($biblioteca['tipo_documento'] == 'NORMA'){echo 'selected'; } ?> value="NORMA">Norma</option>
										<option <?php if($biblioteca['tipo_documento'] == 'REGLAMENTO'){echo 'selected'; } ?> value="REGLAMENTO">Reglamento</option>
									</select>
								</div>

								<div class="col-md-12">
									<label for="">Tags: </label>
									<?php 
									$query_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE articulo_tag.idbiblioteca = $biblioteca[idbiblioteca]";
									$row_articulo_tag = mysql_query($query_tags,$conectar) or die(mysql_error());
									while($tags = mysql_fetch_assoc($row_articulo_tag)){
										echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
									}
									?>
								</div>

								<div class="col-md-8">
									<label for="titulo">Titulo Documento</label>
									<input type="text" class="form-control" name="titulo" placeholder="Titulo biblioteca" value="<?php echo $biblioteca['titulo']; ?>">
								</div>
								
								<div class="col-md-2">
									<p><b>Archivo</b></p>
									<a class="btn btn-sm btn-success" href="<?php echo $biblioteca['archivo']; ?>">Descargar Archivo</a>
								</div>
								<div class="col-md-12">
									<label for="descripcion">Descripción</label>
									<textarea class="form-control" name="descripcion" id="" rows="6"><?php echo $biblioteca['descripcion']; ?></textarea>
									
								</div>
								<div class="col-md-12">
									<label for="nuevo_archivo">Reemplazar Archivo</label>
									<input type="file" class="form-control" name="nuevo_archivo">
								</div>


								<div class="col-lg-12">
									<hr>
									<input type="hidden" name="idbiblioteca" value="<?php echo $biblioteca['idbiblioteca']; ?>">
									<input type="hidden" name="actualizar_documento" value="1">
									<input type="hidden" name="archivo_actual" value="<?php echo $biblioteca['archivo']; ?>">
									<input class="btn btn-success" type="submit" value="Actualizar Documento">
								</div>
							</div>
					  	</div>
					</div>
				  </div>
				</div>
			</form>
		</div>