<div class="container">
	<div class="row divHeaderHomeS">
		<p><h4>Ver por:</h4></p>
		<br>
		<div class="col-xs-3">
			<a href="#" class="btn btn-warning btn-lg" id="linkAmbitos">Ámbito <i class="fa fa-hospital-o" aria-hidden="true"></i></a>
		</div>
		<div class="col-xs-3">
			<a href="#" class="btn btn-primary btn-lg" id="linkUnidades">Unidad <i class="fa fa-stethoscope" aria-hidden="true"></i></a>
		</div>
		<div class="col-xs-3">
			<a href="<?php echo base_url().'index.php/Indicadores/Preview'?>" class="btn btn-info btn-lg" id="btnPreview">Vista rápida <i class="fa fa-bar-chart" aria-hidden="true"></i></a>
		</div>
	</div>
</div>
<br>
<div class="row">
  <div id="divAmbitos" style="display: none;" class="col-md-8 col-md-offset-1">
	<table class="table" border="1">
		<tr>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=1'?>">Dignidad del paciente</a></td>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=2'?>">Gestión de la calidad</a></td>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=3'?>">Acceso,oportunidad y continuidad de la atención</a></td>
		</tr>
		<tr>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=4'?>">Competencias del recurso humano</a></td>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=5'?>">Registros</a></td>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=6'?>">Seguridad del equipamiento</a></td>
		</tr>
		<tr>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=7'?>">Seguridad de las instalaciones</a></td>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=9'?>">Gestión clínica</a></td>
			<td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/VistaAmbitos2?idAmbito=23'?>">Servicios de apoyo</a></td>
		</tr>
	</table>
  </div>
</div>

<div class="row">
	<div id="divUnidades" style="display: none;" class="col-md-6 col-md-offset-3">
	<table class="table" border="1">
		<tr><th>Servicio</th></tr>
		<?php foreach ($servicios2 as $row): ?>
		    <tr>
		        <td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/ResultIndex?idUnidad='.$row['idUnidad']?>">
		        	<?php echo $row['descripcion'];?></a></td>
		    </tr>
		<?php endforeach; ?>
	</table>
	</div>
</div>



<br><br>

</body>