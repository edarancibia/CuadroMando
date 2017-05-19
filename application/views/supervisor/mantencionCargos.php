<div class="container">
	<div class="row col-md-6 col-md-offset-2">
		<div class="row">
			<h4>Mantención de responsables</h4>
			<label>Cargo: </label>
			<select id="cboCargo" class="form-control">
				<?php
					foreach ($cargos as  $item)
					   echo '<option value="'.$item->idCargo.'">'.$item->descripcion.'</option>';
					?>
			</select>

			<br>
			<label>Unidad: </label>
			<select id="cboUnidad" class="form-control">
				<?php
					foreach ($unidades as $item) {
						echo '<option value="'.$item->idUnidad.'">'.$item->descripcion.'</option>';
					}
				?>
			</select>

			<br>
			<label>Indicador</label>
			<table id="records_table" class="table table-hover" border="1"></table>
		</div>
	</div>
</div>