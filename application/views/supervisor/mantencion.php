<div class="container">
	<div class="row col-md-6 col-md-offset-1">
		<h4>Módulo de mantención</h4>

		<table class="table" style="font-size: 12px;">
			<tr>
				<td>Unidad</td>
				<td><select id="cboUnidades" name="cboUnidades" class="form-control input">
					<?php
					foreach ($unidades as  $item)
					   echo '<option value="'.$item->idUnidad.'">'.$item->descripcion.'</option>';
					?>
				</select></td>
			</tr>

			<tr>
				<td>Caracteristica</td>
				<td><input type="text" name="txtCaracteristica" id="txtCaracteristica" class="form-control input" placeholder="Código caracteristica"></td>
			</tr>
			<tr>
				<td>Sub Unidades</td>
				<td ><div class="checkboxes">
					<label><input type="checkbox" name="chksubu1" id="chksubu1" value="Hospitalizacion">Hospitalización</label>
					<label><input type="checkbox" name="chksubu2" id="chksubu2" value="Medicina">Medicina</label>
					<label><input type="checkbox" name="chksubu3" id="chksubu3" value="Gineco Obstetricia">Gineco Obst</label>
					<label><input type="checkbox" name="chksubu4" id="chksubu4" value="Cirugia adulto">Cirugia adulto</label>
					<label><input type="checkbox" name="chksubu5" id="chksubu5" value="Cirugia infantil">Cirugia infantil</label>
					<label><input type="checkbox" name="chksubu6" id="chksubu6" value="Pediatria">Pediatria</label>
					
					<label><input type="checkbox" name="chksubu7" id="chksubu7" value="Pab gral">Pab gral</label>
					<label><input type="checkbox" name="chksubu8" id="chksubu8" value="CMA">CMA</label>
					<label><input type="checkbox" name="chksubu9" id="chksubu9" value="Pab gobs">Pab gobs</label>
					<label><input type="checkbox" name="chksubu10" id="chksubu10" value="Pabellon">Pabellon</label>
					<label><input type="checkbox" name="chksubu11" id="chksubu11" value="Upc">UPC</label>
					<label><input type="checkbox" name="chksubu12" id="chksubu12" value="UPP">UPP</label>
					<label><input type="checkbox" name="chksubu13" id="chksubu13" value="Neo">Neo</label>
					<label><input type="checkbox" name="chksubu14" id="chksubu14" value="Neo">Farmacia</label>
					</div>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Descripción</td>
				<td><textarea name="txtDescIndicador" id="txtDescIndicador" class="form-control"></textarea></td>
			</tr>
			<tr>
				<td>Umbral</td>
				<td><input type="number" name="txtUmbral" id="txtUmbral" class="form-control input"></td>
			</tr>
			<tr>
				<td>Tipo umbral</td>
				<td><select name="cboTipUmbral" id="cboTipUmbral" class="form-control input">
					<option value="1">Es igual</option>
					<option value="2">Mayor o igual</option>
					<option value="3">Menor o igual</option>
				</select></td>
			</tr>
			<tr>
				<td>Fórmula</td>
				<td><textarea name="txtf1" id="txtf1" class="form-control"></textarea></td>
			</tr>
			<tr>
				<td>/</td>
				<td><textarea name="txtf2" id="txtf2" class="form-control"></textarea></td>
			</tr>
			<tr>
				<td>Responsable</td>
				<td><select name="cboResponsable" id="cboResponsable" class="form-control input">
					<?php
					foreach ($cargos as  $item)
					   echo '<option value="'.$item->idCargo.'">'.$item->descripcion.'</option>';
					?>
				</select></td>
			</tr>
			<tr>
				<td></td>
				<td><button type="button" name="btnGuardaIndicador" id="btnGuardaIndicador" class="btn btn-success">Guardar <i class="fa fa-floppy-o" aria-hidden="true"></i></button></td>
			</tr>
		</table>
	</div>
</div>

	<div id="dialog-confirm3" title="Nuevo Indicador">
  				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea guardar el nuevo indicador? </p>
	</div>
</body>