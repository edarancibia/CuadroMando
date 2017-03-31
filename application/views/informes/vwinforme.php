<div class="container">
	<div class="row">
		<h4>Informe y análisis de resultados Indicadores</h4>
	</div>
</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<label>1.Información general</label>
			<table class="table">

				<tr>
					<td>Nombre unidad:</td>
					<td><?= $unidad->descripcion;  ?></td>
				</tr>
				<tr>
					<td>Fecha del informe:</td>
					<td><?= date('d-m-Y'); ?></td>
				</tr>
				<tr>
					<td>Responsable:</td>
					<td><?= $this->session->userdata('user'); ?></td>
				</tr>
			</table>

			<br>
			<label>2.Información medición del indicador</label>
			<table class="table table-hover" border="1">
				<tr>
					<td>Código de característica:</td>
					<td><?= $caracteristica->caracteristica;?></td>
				</tr>
				<tr>
					<td>Nombre del indicador:</td>
					<td><?= $caracteristica->descripcion; ?></td>
				</tr>
				<tr>
					<td>Fórmula del indicador:</td>
					<td><?= $caracteristica->formula1. '/'. $caracteristica->formula2; ?></td>
				</tr>
				<tr>
					<td>Resultado:</td>
					<td><?= $datos->numeradores. ' / '.$datos->denominadores.' = '. intval($datos->res).'%';?></td>
				</tr>
				<tr>
					<td>Umbral de cumplimiento:</td>
					<td><?= $caracteristica->umbralDesc .'%'; ?></td>
				</tr>
				<td>Periodo:</td>
				<td></td>
			</table>
		</div>
	</div>

</body>