<div class="container">
	<div class="row">
		<h3>Reemplazar Usuario</h3>
		<div class="col-xs-12 col-md-8">
			<table class="table">
				<tr>
					<td>Encargado actual</td>
					<td><select id="cboActual" class="form-control">
						<?php
						foreach ($users as  $item)
						   echo '<option value="'.$item['rut_num'].'">'.$item['a_pat'].' '.$item['a_mat'].' '.$item['nombre'].'</option>';
						?>
					</select></td>
					<td><button type="button" id="btnReemplaza" class="btn btn-success">Aceptar</button></td>
				</tr>
			</table>

			<table class="table table-responsive table-hover table-striped header-fixed tabla-informe" id="table-lista-reemplazo">
				<thead>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="modalAsignaReemplazo" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Asignar nuevo responsable</h4>
      </div>
      <div class="modal-body">
      		<input type="hidden" name="hiddenIndicador" id="hiddenIndicador">
			<select id="cboNuevoResp" class="form-control">
				<?php
					foreach ($users as  $item)
						echo '<option value="'.$item['rut_num'].'">'.$item['a_pat'].' '.$item['a_mat'].' '.$item['nombre'].'</option>';
				?>
			</select>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-success" id="btnReemplazaOK">Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
</body>

</html>