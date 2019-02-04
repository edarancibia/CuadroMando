<div class="container">
	 <div class="row">
        <div class="col-md-6 col-md-offset-1">
        	<table class="table">
        		<tr>
        			<td><strong>Indicador:  </strong></td>
        			<td> <?php echo $indicador->descripcion; ?></td>
        		</tr>
        	</table>
        	<form method="POST" action="<?php echo base_url().'index.php/Informe/Informe';?>">
        	<input type="hidden" name="idIndicador" value="<?php echo $indicador->idIndicador;?>">
        	<input type="hidden" name="idUnidad" value="<?php echo $_REQUEST['idUnidad'];?>">
			<div class="form-group">
					        
			    <div class="input-group">
				      <select class="form-control" id="cboAnio3" name="cboAnio3">
				       	<option value="2017">2017</option>
				        <option value="2018">2018</option>
						<option value="2018">2019</option>
						<option value="2018">2020</option>
						<option value="2018">2021</option>
				      </select>
				       <span class="input-group-addon">-</span>
				       <select class="form-control" id="cboCuarto" name="cboCuarto">
				          <option value="1">Trimestre 1</option>
				          <option value="2">Trimestre 2</option>
				          <option value="3">Trimestre 3</option>
				          <option value="4">Trimestre 4</option>
				     </select>
				</div>
			</div>
			<?php $url2 = 'index.php/Welcome/home?idUnidad=';?>
				<br>
				<button type="submit" name="btnPeriodo" class="btn btn-success">Informe <i class="fa fa-file-text-o" aria-hidden="true"></i></button>
				<a href='<?php echo base_url(). $url2 . $_REQUEST["idUnidad"]; ?>' class="btn btn-success">Volver atras <span class="glyphicon"><i class="fa fa-arrow-left" aria-hidden="true"></i></span></a> 
			</form>
		</div>
			
    </div>
</div>
</body>
</html>