<div class="container">
	<div class="row">
		<h4>Informe y análisis de resultados Indicadores</h4>
	</div>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<label>1.Información general</label>
			<table class="table">

				<tr>
					<td>Nombre unidad:</td>
					<td><?php echo $unidad->descripcion;  ?></td>
					<td><input type="hidden" name="textIdindicador_" id="textIdindicador_" value="<?php echo $_REQUEST['idIndicador']; ?>">
					<input type="hidden" name="txtperiodo3" id="txtperiodo3" value="<?php echo $periodo; ?>">
					</td>

				</tr>
				<tr>
					<td>Fecha del informe:</td>
					<td><input type="text" id="txtfechaInforme2" class="form-control" value="<?= $datos->fecha; ?>" readonly></td>
					<td><input type="date" id="txtfechaInforme" class="form-control"></td>
				</tr>
				<tr>
					<td>Responsable:</td>
					<td><?php echo $resp; //$this->session->userdata('user'); ?></td>
				</tr>
			</table>

			<br>
			<label>2.Información medición del indicador</label>
			<table class="table table-hover tabla-informe" border="1">
				<tr>
					<td>Código de característica:</td>
					<td><?php echo $caracteristica->caracteristica;?></td>
				</tr>
				<tr>
					<td>Nombre del indicador:</td>
					<td><?php echo $caracteristica->descripcion; ?></td>
				</tr>
				<tr>
					<td>Fórmula del indicador:</td>
					<td><?php echo $caracteristica->formula1. '/'. $caracteristica->formula2; ?></td>
				</tr>
				<tr>
					<td>Resultado:</td>
					<td>
						<input type="text" name="txtresultado_" id="txtresultado_" class="form-control tabla-informe" value="<?= $datos2->denominadores. ' / '.$datos2->numeradores.' = '. intval($datos2->res).'%';?>" >
					</td>
				</tr>
				<tr>
					<td>Umbral de cumplimiento:</td>
					<td><?php echo $caracteristica->umbralDesc .'%'; ?></td>
				</tr>
				<td>Periodo:</td>
				<td><input type="text" name="txtperiodo_" id="txtperiodo_" class="form-control" value="<?php echo $datos->periodoDet;?>"></td>
			</table>
		</div>

		<div class="col-md-6 col-md-offset-3">
			<fieldset>
				<label for="comentarios_">3.Comentarios:</label>
				<textarea name="comentarios_" id="comentarios_" class="form-control" ><?php echo $datos->comentarios;?></textarea>

				<label for="plan_">Plan de mejora:</label>
				<textarea name="plan_" id="plan_" class="form-control" ><?php echo $datos->plan;?></textarea>
			</fieldset>
			<br>
			<div>
				<button type="button" class="btn btn-success" id="btnModInforme">Guardar <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
				
				<!--<button type="button" class="btn btn-success" id="btnVolver">Volver Atrás <i class="fa fa-arrow-left" aria-hidden="true"></i></button>-->
			
			</div>
		</div>
		</div>

	</div>
<br><br>
</body>
