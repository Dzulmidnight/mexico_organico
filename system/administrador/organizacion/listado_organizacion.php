<div class="col-lg-12">
	<div class="row">
		<?php 
			$query = "SELECT * FROM organizacion";
			$consultar = mysql_query($query,$kafeprod_bio) or die(mysql_error());

		?>
			<table class="table table-bordered table-condensed" style="font-size:12px;">
				<thead>
					<tr>
						<th>Ciclos</th>
						<!--<th>Id</th>-->
						<th>Organización</th>
						<th>Username</th>
						<th>Password</th>
						<th>Ubicación</th>
						<th>Descripción</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($row_organizacion = mysql_fetch_assoc($consultar)){
						$query = "SELECT idciclo FROM ciclo WHERE idorganizacion = $row_organizacion[idorganizacion]";
						$ejecutar = mysql_query($query,$kafeprod_bio) or die(mysql_error());
						$numero_ciclos = mysql_num_rows($ejecutar);
					?>
						<tr>
							<td>
								<a class="<?php if($numero_ciclos == 0){ echo 'btn btn-sm btn-default disabled'; }else{ echo 'btn btn-sm btn-info'; } ?>" href="?menu=organizacion&listado_ciclo&id_org=<?php echo $row_organizacion['idorganizacion']; ?>">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="badge"><?php echo $numero_ciclos; ?></span>
								</a>
								<a class="btn btn-sm btn-success" href="?menu=organizacion&add_ciclo&id_org=<?php echo $row_organizacion['idorganizacion']; ?>">Nuevo</a>
							</td>
							<!--<td><?php echo $row_organizacion['idorganizacion']; ?></td>-->
							<td>ID: <?php echo $row_organizacion['idorganizacion']; ?> <a href="?menu=organizacion&detail_organizacion=<?php echo $row_organizacion['idorganizacion']; ?>"><?php echo $row_organizacion['organizacion']; ?></a></td>
							<td><?php echo $row_organizacion['username']; ?></td>
							<td><?php echo $row_organizacion['password']; ?></td>
							<td><?php echo $row_organizacion['ubicacion']; ?></td>
							<td><?php echo $row_organizacion['descripcion']; ?></td>
						</tr>

					<?php
					}
					 ?>
					
				</tbody>
			</table>
	</div>
</div>