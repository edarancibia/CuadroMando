<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
		Unidad:
			<select id="cboUnidadEditaUmbral" name="cboUnidadEditaUmbral">
			<?php
				foreach ($unidadesUmbral as $item) {
					echo '<option value="'.$item->idUnidad.'">'.$item->descripcion.'</option>';
				}
			?>
			</select>

			<button type="button" class='btn btn-success' id="btnEditIndex5">Ver Lista <i class="fa fa-search" aria-hidden="true"></i></button>

			<br><br>

			<table class="table table-responsive table-hover table-striped header-fixed tabla-informe" id="table-edit-umbral">
				<thead>
					<th>Característica</th>
					<th>Categoría</th>
					<th>Indicador</th>
					<th>Responsable</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>

<!-- Modal -->
<div id="modalEditUmbral" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Periodo</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="<?php echo base_url('index.php/Indicadores/EditIndex2'); ?>">
        <input type="text" name="txtidndicador" id="txtidndicador" class="form-control" style="display: none;">

			Año:
			<select id="cboanio7" name="cboanio7" class="form-control">
				<option value="2017">2017</option>
				<option value="2018">2018</option>
			</select>

      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-success">Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
    </form>

  </div>
</div>
</html>