<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-1">
		<p><i class="fa fa-info-circle" aria-hidden="true"></i>
		Lista de Indicadores sin datos o bajo el umbral de cumpliento durante el trimestre actual.</p>
			<table id="tabla-preview" border="1" class="table tabla-preview table-hover" style="font-size: 12px;">
				<thead style="background-color: white;">
					<th>Característica</th>
					<th>Umbral</th>
					<th>Indicador</th>
					<th>Avance</th>
					<th>Unidad</th>

				</thead>
				<tbody>
					<?php
					foreach ($info as $item) {
						echo '<tr>
								<td>'.$item['Caracteristica'].'</td>
								<td>'.$item['umbralDesc'].'</td>
								<td>'.$item['descripcion'].'</td>
								<td class="danger" width="100"><div class="progress">
									  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'.$item['res'].'"
									  aria-valuemin="0" aria-valuemax="100" style="width:'.$item['res'].'%">
									    '.$item['res'].'%  
									  </div>
									</div></td>
								<td>'.$item['Unidad'].'</td>
								<td style="display:none">'.$item['evaluacion'].'</td>
							  </tr>';
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>