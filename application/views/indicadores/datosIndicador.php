
<div class="container">

	<div class="row">
		<fieldset>
			<legend><h5>Evaluación periódica</h5></legend>
			<table class="table table-caract centrar">
				<tr>
					<td><input type="hidden" name="txtIdindicador" id="txtIdindicador" value="<?= $indicador->idIndicador; ?>"></td>
					<td></td>
				</tr>
				<tr>
					<td>Característica: </td>
					<td>
						<?= $indicador->caracteristica; ?>
					</td>
				</tr>
				<tr>
					<td>Descripción: </td>
					<td><?= $indicador->descripcion; ?></td>
				</tr>
				<tr>
					<td>Umbral cumplimiento: </td>
					<td>
						<?= $indicador->umbralDesc; ?>
					</td>
				</tr>
				<tr>
					<td>Porcentaje de avance: </td>
					<td></td>
				</tr>

			</table>
		</fieldset>

		<?
			$fecha = getdate();
			$mes = $fecha['mon'];
			$anio = $fecha['year'];
			$nombreMes = '';

			switch ($mes) {
				case 1:
					$nombreMes = 'Enero';
					break;
				case 2:
					$nombreMes = 'Febrero';
					break;
				case 3:
					$nombreMes = 'Marzo';
					break;
				case 4:
					$nombreMes = 'Abril';
					break;
				case 5:
					$nombreMes = 'Mayo';
					break;
				case 6:
					$nombreMes = 'Junio';
					break;
				case 7:
					$nombreMes = 'Julio';
					break;
				case 8:
					$nombreMes = 'Agosto';
					break;
				case 9:
					$nombreMes = 'Septiembre';
					break;
				case 10:
					$nombreMes = 'Octubre';
					break;
				case 11:
					$nombreMes = 'Noviembre';
					break;
				case 12:
					$nombreMes = 'Diciembre';
					break;
			}
		?>
		<div><p>Periodo: <?= $nombreMes .' '.$anio; ?></p></div>

		<div class="col-md-5 centrar" align="center">
			<table border="1" class="table tabla-evaluaIndicador">
				<tr>
					<th>Fórmula</th>
					<th></th>
				</tr>
				<tr>
					<td><?= $indicador->formula1; ?></td>
					<td><input type="text" name="txtvalor1" class="form-control input-sm" id="txtvalor1"></td>
				</tr>
				<tr>
					<td><?= $indicador->formula2; ?></td>
					<td><input type="text" name="txtvalor2" class="form-control input-sm" id="txtvalor2"></td>
				</tr>
				<tr>
					<td>% Cumplimiento</td>
					<td></td>
				</tr>				
			</table>

			<div>
				<button type="button" name="btnGuadar" id="btnGuadar" class="btn btn-success">
				Guardar <span class="glyphicon glyphicon-floppy-disk"></span></button> 
				<button type="button" name="btnVolver" id="btnVolver" class="btn btn-success">Volver atras <span class="glyphicon glyphicon-circle-arrow-left"></span></button> 
			</div>

		</div>
	</div>
</div>
<br><br>