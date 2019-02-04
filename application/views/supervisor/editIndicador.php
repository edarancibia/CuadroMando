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
        <h4 class="modal-title">Modificar umbral</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="txtidndicadorumbral" id="txtidndicadorumbral" class="form-control" >
        Umbral actual:
        <input type="text" name="txtumbralactual" id="txtumbralactual" class="form-control" disabled="true">

        Nuevo umbral:
        <input type="text" name="txtnuevoumbral" id="txtnuevoumbral" class="form-control">

        Tipo:
        <select id="cboTipoUmbral" class="form-control">
        	<option value=">=">>=</option>
        	<option value="<="><=</option>
          <option value="<=">=</option>
        </select>

        Descripción:
        <textarea id="desIndEdita" class="form-control"></textarea>

        Formula:
        <textarea id="f1edita" class="form-control"></textarea>

        <textarea id="f2edita" class="form-control"></textarea>

      </div>
      <div class="modal-footer">
      	<button type="button" id="btnEditUmbral" class="btn btn-success">Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>
</html>