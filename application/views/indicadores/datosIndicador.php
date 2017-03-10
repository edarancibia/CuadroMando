
<div class="container">

	<div class="row">
		<fieldset>
			<legend><h5>Resumen de caracteristica</h5></legend>
			<table class="table table-caract">
				<tr>
					<td>Característica: </td>
					<td>
						<?= $caracteristicas->codigo; ?>
					</td>
				</tr>
				<tr>
					<td>Responsable: </td>
					<td></td>
				</tr>
				<tr>
					<td>Umbral cumplimiento: </td>
					<td>
						<?= $caracteristicas->umbralDesc; ?>
					</td>
				</tr>
				<tr>
					<td>Porcentaje de avance: </td>
					<td></td>
				</tr>
				<tr>
					<td>Fecha cumplimiento: </td>
					<td></td>
				</tr>
				<tr>
					<td>Observación:</td>
					<td><textarea id="txtObs" class="form-control"></textarea></td>
				</tr>
			</table>
		</fieldset>
		<div>

		<table class="table table-indicadores" border="1">
			<tr>
				<td>Id</td>
				<td>Elementos medibles</td>
			</tr>
			<?php foreach ($indicadores as $row) {
				echo "<tr>";
				echo    "<td>".$row['idIndicador']."</td>";
				echo    "<td>".$row['descripcion']."</td>";
				echo "</tr>";
			} ?>
		</table>

		</div>
	</div>
</div>