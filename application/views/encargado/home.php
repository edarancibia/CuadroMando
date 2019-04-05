<div class="container">
	<div class="row divHeaderHomeS">
		<p><h4>Ver por:</h4></p>
		<br>
		<div class="col-xs-3">
			<a href="#" class="btn btn-primary btn-lg" id="linkUnidades">Unidad <i class="fa fa-stethoscope" aria-hidden="true"></i></a>
		</div>
	</div>
</div>
<br>
</div>

<div class="row">
	<div id="divUnidades" style="display: none;" class="col-md-6 col-md-offset-3">
	<table class="table" border="1">
		<tr><th>Servicio</th></tr>
		<?php foreach ($servicios2 as $row): ?>
		    <tr>
		        <td><a class="btn btn-default" href="<?php echo base_url().'index.php/Indicadores/ResultIndex_?idUnidad='.$row['idUnidad']?>">
		        	<?php echo $row['descripcion'];?></a></td>
		    </tr>
		<?php endforeach; ?>
	</table>
	</div>
</div>



<br><br>

</body>