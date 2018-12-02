<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-1">
			<table class="table" >
				<tr>
					<td>Característica: </td>
					<td><?php echo $info->cod_c; ?>
						<input type="hidden" name="txtIdIndicador2" id="txtIdIndicador2" value="<?php echo $info->idIndicador;?>">
						<input type="hidden" name="txtperiodo3" id="txtperiodo3" value="<?php echo $info->periodo;?>">
					</td>
				</tr>
				<tr>
					<td>Indicador: </td>
					<td><?php echo $info->descripcion; ?></td>
				</tr>
				<tr>
					<td>Fecha:</td>
				</tr>
				<tr>
					<td>Fórmula: </td>
					<td><?php echo $info->formula1; ?></td>
					<td><input type="text" name="txtf1" id="txtf1" class="form-control" value="<?php echo $info->denominador; ?>"></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $info->formula2; ?></td>
					<td><input type="text" name="txtf2" id="txtf2" class="form-control" value="<?php echo $info->numerador; ?>"></td>
				</tr>
				<tr>
					<td><button class="btn btn-success" id="btnModDatos" type="button">Modificar <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
					</td>
					<td><a  href="<?php echo base_url('index.php/Indicadores/EditIndex');?>" class="btn btn-danger">Volver <i class="fa fa-arrow-left" aria-hidden="true"></i></a></td>
				</tr>
			</table>
		</div>
	</div>

	<div id="dialog-confirm4" title="Modificando datos">
  				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea guardar los cambios?.</p>
	</div>
</div>
</body>
</html>