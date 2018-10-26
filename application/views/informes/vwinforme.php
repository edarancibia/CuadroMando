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
					<td><?= $unidad->descripcion."-".$datos->desc_subUn;  ?></td>
					<td><input type="hidden" name="textIdindicador" id="textIdindicador" value="<?php echo $_REQUEST['idIndicador']; ?>"></td>
					<td><input type="hidden" name="txtperiodo2" id="txtperiodo2" value="<?php echo $periodo;?>"></td>
				</tr>
				<tr>
					<td>Fecha del informe:</td>
					<td><?php echo date('d-m-Y'); ?></td>
				</tr>
				<tr>
					<td>Responsable:</td>
					<td><?php echo $this->session->userdata('user'); ?></td>
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
						<input type="text" name="txtresultado" id="txtresultado" class="form-control tabla-informe" value="<?= $datos->denominadores. ' / '.$datos->numeradores.' = '. intval($datos->res).'%';?>" disabled="true">
					</td>
				</tr>
				<tr>
					<td>Umbral de cumplimiento:</td>
					<td><?php echo $caracteristica->umbralDesc .'%'; ?></td>
				</tr>
				<td>Periodo:</td>
				<td><input type="text" name="txtperiodo" id="txtperiodo" class="form-control" value="" required="true"></td>
			</table>
		</div>

		<div class="col-md-6 col-md-offset-3">
			<fieldset>
				<label for="comentarios">3.Comentarios:</label>
				<textarea name="comentarios" id="comentarios" class="form-control" required="true"></textarea>

				<label for="plan">Plan de mejora:</label>
				<textarea name="plan" id="plan" class="form-control" required="true"></textarea>
			</fieldset>
			<br>
			<div>
				<button type="button" class="btn btn-success" id="btnGuardaInforme" name="btnGuardaInforme">Guardar <i class="fa fa-floppy-o" aria-hidden="true"></i></button>

				<a href="<?php echo base_url().'index.php/Welcome/home?idUnidad='.$_REQUEST["idUnidad"].''?>" class="btn btn-success">Volver atras <i class="fa fa-arrow-left" aria-hidden="true"></i></a>

				<a id="btnPdf" href="<?php echo base_url().'index.php/Informe/Imprimir?idUnidad='.$_REQUEST["idUnidad"].'&idIndicador='.$_REQUEST['idIndicador'].'&anio='.$_REQUEST["cboAnio3"].'&cuarto='.$_REQUEST["cboCuarto"].''?>" class="btn btn-danger" target="_blanck">Imprimir <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
			</div>
		</div>

		<div id="dialog-confirm" title="Informe de indicador">
  			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea guardar el informe? Una vez hecho no podrá ser modificado. </p>
		</div>
	</div>
<br><br>
</body>
