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
				</tr>
				<tr>
					<td>Nuevo encargado</td>
					<td><select id="cboNuevo" class="form-control">
						<?php
						foreach ($users as  $item)
						   echo '<option value="'.$item['rut_num'].'">'.$item['a_pat'].' '.$item['a_mat'].' '.$item['nombre'].'</option>';
						?>
					</select></td>
				</tr>
				<tr>
					<td></td>
					<td><button type="button" id="btnReemplaza" class="btn btn-success">Aceptar</button></td>
				</tr>
			</table>
		</div>
	</div>

				<div id="dialog-confirmReemplaza" title="Guardando datos">
  				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Seguro que desea cambiar el responsable?</p>
			</div>
</div>

</body>
</html>