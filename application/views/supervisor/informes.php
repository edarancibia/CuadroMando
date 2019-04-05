<div class="container">
<form method="POST" action="<?php echo base_url('index.php/Informe/Reports'); ?>">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">

			Periodo: 
			<select id="cboTrimestre" name="cboTrimestre">
				<option value="1">1 Trimestre</option>
				<option value="2">2 Trimestre</option>
				<option value="3">3 Trimestre</option>
				<option value="4">4 Trimestre</option>
			</select>

			<select id="cboanio6" name="cboanio6">
				<option value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
				<option value="2020">2020</option>
				<option value="2021">2021</option>
			</select>

			<select id="cboUnidad" name="cboUnidad">
			<?php
				foreach ($unidades as $item) {
					echo '<option value="'.$item->idUnidad.'">'.$item->descripcion.'</option>';
				}
			?>
			</select>

			<button type="button" class='btn btn-success' id="btnReport2">Ver Lista <i class="fa fa-search" aria-hidden="true"></i></button>

			<br><br>

			<table class="table table-responsive table-hover table-striped header-fixed tabla-informe" id="table-reports">
				<thead>
					<th>Característica</th>
					<th>Indicador</th>
					<th>Responsable</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</form>
</div>
</body>
</html>