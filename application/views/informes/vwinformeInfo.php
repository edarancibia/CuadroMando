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
					<td><input type="hidden" name="textIdindicador" id="textIdindicador" value="<?= $_REQUEST['idIndicador']; ?>"></td>
				</tr>
				<tr>
					<td>Fecha del informe:</td>
					<td><?= $datos->fecha; ?></td>
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
					<td>
						<input type="text" name="txtresultado" id="txtresultado" class="form-control" value="<?= $datos->resultadoDet;?>" disabled="true">
					</td>
				</tr>
				<tr>
					<td>Umbral de cumplimiento:</td>
					<td><?= $caracteristica->umbralDesc .'%'; ?></td>
				</tr>
				<td>Periodo:</td>
				<td><input type="text" name="txtperiodo" id="txtperiodo" class="form-control" value="<?= $datos->periodo;?>" disabled="true"></td>
			</table>
		</div>

		<div class="col-md-6 col-md-offset-3">
			<fieldset>
				<label for="comentarios">4.Cometarios:</label>
				<textarea name="comentarios" id="comentarios" class="form-control" disabled="true"><?= $datos->comentarios;?></textarea>

				<label for="plan">Plan de mejora:</label>
				<textarea name="plan" id="plan" class="form-control" disabled="true"><?= $datos->plan;?></textarea>
			</fieldset>
			<br>
			<div>

				<a href="<?= 'http://localhost/CuadroMando/index.php/Indicadores/MisIndicadores?idUnidad='.$idUnidad.'' ;?>" class="btn btn-success">Volver atras <span class="glyphicon glyphicon-circle-arrow-left"></span></a>
			</div>
		</div>

		<div id="dialog-confirm" title="Informe de indicador">
  			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea guardar el informe? Una vez hecho no podrá ser modificado.</p>
		</div>
	</div>
<br><br>
</body>