
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
					<td><input type="text" name="txtresultado" id="txtresultado" class="form-control" disabled="true"></td>
				</tr>				
			</table>

			<div>
				<button type="button" name="btnGuadar" id="btnGuadar" class="btn btn-success">
				Guardar <span class="glyphicon glyphicon-floppy-disk"></span></button> 
				<a href="<?= base_url('index.php/Indicadores/MisIndicadores?idUnidad='.$unidad.'')?>" class="btn btn-success">Volver atras <span class="glyphicon glyphicon-circle-arrow-left"></span></a> 
			</div>

		</div>
	</div>

			<div id="dialog-confirm2" title="Guardando datos">
  				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea guardar los datos? Una vez hecho no podrán ser modificados.</p>
			</div>
</div>
<br><br>
<script type="text/javascript">
	var indicador = $('#txtIdindicador').val();
	var fecha;
	//var baseUrl = 'http://localhost/CuadroMando/index.php/';
	var baseUrl = window.location.origin+'/CuadroMando/index.php/';

	$.ajax({ // - - - COMPRUEBA SI HAY ALGUNA EVALUACION DURANTE EL PERIODO ACTUAL
			type: 'post',
			url: baseUrl+'Indicadores/validateDate',
			data: {fecha: fecha, idIndicador: indicador},
			success: function(data){
				console.log('validacion '+data);
				if (data == 1) {
					console.log('No se puede');
					$("#txtvalor1").attr('disabled','disabled');
					$("#txtvalor2").attr('disabled','disabled');
					$("#btnGuadar").attr('disabled','disabled');
				}else{
					console.log('Si se puede');
					$('#txtvalor1').focus();
				}
			},
			error: function(){
				console.log('error ajax validacion');
			}
		});
</script>
</body>