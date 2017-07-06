
<div class="container">

	<div class="row">
		<fieldset>
			<legend><h5>Evaluación periódica</h5></legend>
			<table class="table table-caract centrar">
				<tr>
					<td><input type="hidden" name="txtIdindicador" id="txtIdindicador" value="<?php echo $indicador->idIndicador; ?>"></td>
					<td></td>
				</tr>
				<tr>
					<td>Característica: </td>
					<td>
						<?php echo $indicador->caracteristica . ' '. $indicador->desc_subUn; ?>
					</td>
				</tr>
				<tr>
					<td>Descripción: </td>
					<td><?php echo $indicador->descripcion; ?></td>
				</tr>
				<tr>
					<td>Umbral cumplimiento: </td>
					<td>
						<?php echo $indicador->umbralDesc; ?>
					</td>
				</tr>

			</table>
		</fieldset>

		<?php
			$fecha = getdate();
			$mes = $fecha['mon'];
			$anio = $fecha['year'];
			$nombreMes = '';
			$url2 = 'index.php/Indicadores/MisIndicadores?idUnidad=';
			
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
		<div class="row">
		    <div class="col-xs-12 col-md-3">
		      <div class="form-group">
		        
		        <div class="input-group">
		          <select class="form-control" id="cboAnio">
		        	<option value="2017">2017</option>
		        	<option value="2018">2018</option>
		        </select>
		        <span class="input-group-addon">-</span>
		          <select class="form-control" id="cbomes">
		          	<option value="0" selected="selected">Seleccione mes</option>
		        	<option value="1">Enero</option>
		        	<option value="2">Febrero</option>
		        	<option value="3">Marzo</option>
		        	<option value="4">Abril</option>
		        	<option value="5">Mayo</option>
		        	<option value="6">Junio</option>
		        	<option value="7">Julio</option>
		        	<option value="8">Agosto</option>
		        	<option value="9">Septiembre</option>
		        	<option value="10">Octubre</option>
		        	<option value="11">Noviembre</option>
		        	<option value="12">Diciembre</option>
		        </select>
		        </div>
		      </div>
		    </div>
		</div>

		<div class="col-md-5 centrar" align="center">
			<table border="1" class="table tabla-evaluaIndicador">
				<tr>
					<th>Fórmula</th>
					<th></th>
				</tr>
				<tr>
					<td><?php echo $indicador->formula1; ?></td>
					<td><input type="text" name="txtvalor1" class="form-control input-sm" id="txtvalor1"></td>
				</tr>
				<tr>
					<td><?php echo $indicador->formula2; ?></td>
					<td><input type="text" name="txtvalor2" class="form-control input-sm" id="txtvalor2"></td>
				</tr>
				<tr>
					<td>% Cumplimiento</td>
					<td><input type="text" name="txtresultado" id="txtresultado" class="form-control" disabled="true"></td>
				</tr>				
			</table>

			<div>
				<button type="button" name="btnGuadar" id="btnGuadar" class="btn btn-success">
				Guardar <span><i class="fa fa-floppy-o" aria-hidden="true"></i></span></button> 
				<a href='<?php echo base_url(). $url2 . $_REQUEST["idUnidad"]; ?>' class="btn btn-success">Volver atras <span class="glyphicon"><i class="fa fa-arrow-left" aria-hidden="true"></i></span></a> 
			</div>

		</div>
	</div>

			<div id="dialog-confirm2" title="Guardando datos">
  				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea guardar los datos? Una vez hecho no podrán ser modificados.</p>
			</div>
</div>
<br><br>

</body>