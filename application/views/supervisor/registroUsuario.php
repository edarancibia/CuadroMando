<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
			<h3>Creación de nuevo Usuario</h3>
			<table class="table">
				<tr>
					<td>Rut</td>
					<td><input type="text" id="txtrutUsernew" name="txtrutUsernew" class="form-control"></td>
					<td><input type="hidden" id="txthiddenrutusu"></td>
				</tr>
				<tr>
					<td>Apellido paterno</td>
					<td><input type="text" name="txtuserapat" id="txtuserapat" class="form-control"></td>
				</tr>
				<tr>
					<td>Apellido materno</td>
					<td><input type="text" name="txtuseramat" id="txtuseramat" class="form-control"></td>
				</tr>
				<tr>
					<td>Nombres</td>
					<td><input type="text" name="txtusernom" id="txtusernom" class="form-control"></td>
				</tr>
				<tr>
					<td>Contraseña:</td>
					<td><input type="text" name="txtpassUsernew" id="txtpassUsernew" class="form-control"></td>
				</tr>

				<tr>
						<td>Perfil:</td>
						<td><select id="cboPerfilUser" class="form-control">
							<option value="0">Encargado de calidad</option>
							<option value="1">Supervisor</option>
						</select></td>
					</tr>
					<tr>
						<td>Cargo:</td>
						<td><input type="text" id="txtrescargo" class="form-control"></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" id="txtresmail" class="form-control"></td>
					</tr>

				<tr>
					<td>Servicio:</td>
						<td>
						
							<select id="cboUnidad" class="form-control">
								<?php
									foreach ($unidadesUser as $item) {
										echo '<option value="'.$item->idUnidad.'">'.$item->descripcion.'</option>';
									}
								?>
							</select>
						</td>
					</tr>
				<tr>
					<td><button type="button" class="btn btn-success" id="btnokUsernew">Aceptar</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>