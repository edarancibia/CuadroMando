<div class="container">
	<div class="row">
	<label class="lblnombre"><?php echo $nomUnidad;?></label>
	  <div class="col-md-9 col-md-offset-1" >
		<table class="table table-hover table-responsive" >
			<tr>
				<th>Caracteristica</th>
				<th></th>
				<th>Indicador</th>
				<th></th>
				<th></th>
			</tr>
			<?php 

			if (empty($indica)) {
				echo "<h3>Usted no tiene indicadores asignados en esta unidad.</h3>";
			}else{
				$idUnidad = $_GET['idUnidad'];
				foreach ($indica as $row) {
					echo "<tr>";
					echo 	"<td width=100>".$row['Caracteristica']."</td>";
					echo 	"<td width=150>".$row['sub']."</td>";
					echo 	"<td width=400>".$row['descripcion']."</td>";
					echo 	"<td width=50><a href=".base_url() ."index.php/Indicadores/detalleIndicador?idIndicador=".$row["idIndicador"]."&idUnidad=".$idUnidad." class='btn btn-warning'>Evaluar <span class='glyphicon glyphicon-pencil'></span></a></td>";
					echo 	"<td width=50><a href=".base_url()."index.php/Informe/Informe?idIndicador=".$row["idIndicador"]."&idUnidad=".$idUnidad." class='btn btn-info'>Informe <i class='fa fa-file-text-o' aria-hidden='true'></i></a></td>";
					echo "</tr>";
				};
			}
			?>
		</table>
	  </div>
	</div>
</div>
</body>