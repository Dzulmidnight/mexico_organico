<h3>Listado Articulos</h3>
<?php 
	//$query = "SELECT nota.*,  usuario.username FROM nota INNER JOIN usuario ON nota.idusuario = usuario.idusuario";
	$query = "SELECT articulo.*, usuario.username FROM articulo INNER JOIN usuario ON articulo.autor = usuario.idusuario";
	$row_articulo = mysql_query($query,$conectar) or die(mysql_error());
	$total_articulo = mysql_num_rows($row_articulo);
?>
<table class="table table-bordered" style="font-size:12px;">
	<thead>
		<tr class="success">
			<th class="text-center">Id</th>
			<th class="text-center">Titulo</th>
			<th class="text-center">Descripcion</th>
			<th class="text-center">Imagen</th>
			<th class="text-center">Tag(s)</th>
			<th class="text-center">Autor</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if($total_articulo == 0){
			echo "<tr class='info text-center'><td colspan='7'>No Se Encontraron Articulos</td></tr>";
		}else{
			while($articulo = mysql_fetch_assoc($row_articulo)){
				$fecha = date('d/m/Y',$articulo['fecha_registro']);
			?>
				<tr>
					<td>
						<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal<?php echo $articulo['idarticulo'];?>"><?php echo $articulo['idarticulo']; ?> <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					</td>
					<td><?php echo $articulo['titulo']; ?></td>
					<td><?php echo substr($articulo['contenido'], 0,200); ?></td>
					<td><img style="width:100px;" src="<?php echo $articulo['img'] ?>" class="img-thumbnail" alt=""></td>
					<td>
					<?php 
					$query_tags = "SELECT articulo_tag.*, tags.nombre FROM articulo_tag INNER JOIN tags ON articulo_tag.idtag = tags.idtag WHERE idarticulo = $articulo[idarticulo]";
					$row_tags = mysql_query($query_tags,$conectar) or die(mysql_error());
					while($tags = mysql_fetch_assoc($row_tags)){
						echo "<a  style='margin:1px;' href='#'><span class='label label-success'>".$tags['nombre']."</span></a>";
					}
					 ?>
					</td>
					<td><?php echo $articulo['username']; ?></td>
				</tr>


				<!-- Modal -->
				<div class="modal fade" id="myModal<?php echo $articulo['idarticulo'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title text-center" id="myModalLabel" style="color:#2c3e50"><?php echo $articulo['titulo']; ?></h4>
				      </div>
				      <div class="modal-body" style="color:#34495e">
				      	<div class="row">
				      		<div class="col-md-12">
						      <?php //nl2br

						      	echo "<div class='col-xs-12'><p class='text-justify'>".$articulo['contenido']."</p></div>";



						      /*$nota = sprintf("SELECT contenido,contenido_descripcion,descripcion_img  FROM nota WHERE idarticulo = %s",
						        GetSQLValueString($articulo['idarticulo'],"int"));
						      $ejecutar = mysql_query($nota,$conectar) or die(mysql_error());
						      $titulo_nota = mysql_fetch_assoc($ejecutar);

						      $query_segmento = sprintf("SELECT * FROM nota_segmento WHERE idarticulo  = %s",
						      GetSQLValueString($articulo['idarticulo'],"int"));

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
			<?php
			}
		}
		?>
	</tbody>
</table>