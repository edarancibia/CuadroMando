<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
			Año:
			<select id="cboanio7" name="cboanio7" >
				<option value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
				<option value="2020">2020</option>
				<option value="2021">2021</option>
			</select>

			Mes: 
			<select id="cbomes2" name="cbomes2">
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
		Unidad:
			<select id="cboUnidad2" name="cboUnidad2">
			<?php
				foreach ($unidades as $item) {
					echo '<option value="'.$item->idUnidad.'">'.$item->descripcion.'</option>';
				}
			?>
			</select>

			<button type="button" class='btn btn-success' id="btnEditIndex">Ver Lista <i class="fa fa-search" aria-hidden="true"></i></button>

			<br><br>

			<table class="table table-responsive table-hover table-striped header-fixed tabla-informe" id="table-edit">
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
<div id="modalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar Datos</h4>
      </div>
      <div class="modal-body">
      
        <input type="text" name="txtidndicador" id="txtidndicador" class="form-control" style="display: none;">
        <input type="text"  id="txtperiodo4" style="display: none;" >

			<table class="table" >
				<tr>
					<td>Característica: </td>
					<td> <input type="text" id="txtCarac" class="form-control" readonly>
					</td>
				</tr>
				<tr>
					<td>Indicador: </td>
					<td colspan="2"><textarea id="txtIdIndicador3" class="form-control" readonly></textarea></td>
					
				</tr>
				<tr>
					<td>Fecha:</td>
					<td><input type="text" id="txtfecha" class="form-control" readonly></td>
					<td><input type="date" id="txtfecha_n" class="form-control"></td>
				</tr>
				<tr>
					<td>Fórmula: </td>
					<td><textarea id="txtformula1_" class="form-control" readonly></textarea></td>
					<td><input type="text" name="txtf1" id="txtf1" class="form-control"></td>
				</tr>
				<tr>
					<td></td>
					<td><textarea id="txtformula2_" class="form-control" readonly></textarea></td>
					<td><input type="text" name="txtf2" id="txtf2" class="form-control"></td>
				</tr>
			</table>
			
      </div>
      <div class="modal-footer">
      	<button type="button" id="btnEditaDatos" class="btn btn-success">Aceptar <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>


</html>