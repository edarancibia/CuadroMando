<div class="container">
	<div class="row">
	<!--<label class="lblnombre"><?php //echo $nomUnidad;?></label>-->
	  <div class="col-md-9 col-md-offset-1" >
		<table class="table table-hover table-responsive" >
			<tr>
				<th style="display: none;"></th>
				<th>Servicio</th>
				<th>Caracteristica</th>
				<th></th>
				<th>Indicador</th>
				<th></th>
				<th></th>
			</tr>
			<?php 

			if (empty($indicaReemplaza)) {
				echo "<h3>Usted no tiene indicadores asignados en esta unidad.</h3>";
			}else{
				//$idUnidad = $_GET['idUnidad'];
				foreach ($indicaReemplaza as $row) {
					echo "<tr>";
					echo 	"<td width=100 style='display:none'>".$row['idUnidad']."</td>";
					echo 	"<td width=100>".$row['unidad']."</td>";
					echo 	"<td width=100>".$row['Caracteristica']."</td>";
					echo 	"<td width=150>".$row['sub']."</td>";
					echo 	"<td width=400>".$row['descripcion']."</td>";
					echo 	"<td width=50><a href=".base_url() ."index.php/Indicadores/detalleIndicador?idIndicador=".$row["idIndicador"]."&idUnidad= class='btn btn-warning'>Evaluar <span class='glyphicon'><i class='fa fa-pencil' aria-hidden='true'></i></span></a></td>";
					//echo 	"<td width=50><a href=".base_url()."index.php/Informe/Informe?idIndicador=".$row["idIndicador"]."&idUnidad=".$idUnidad." class='btn btn-info'>Informe <i class='fa fa-file-text-o' aria-hidden='true'></i></a></td>";
					echo 	"<td width=50><a href=".base_url()."index.php/Informe/periodo?idIndicador=".$row["idIndicador"]."&idUnidad=".$row["idUnidad"]." class='btn btn-info'>Informe  <i class='fa fa-file-text-o' aria-hidden='true'></i></a></td>";
					echo "</tr>";
				};
			}
			?>
		</table>
	  </div>
	</div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Informe trimestral</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-xs-12 col-md-3 col-lg-6">
			    <div class="form-group">
					        
			    	<div class="input-group">
					      <select class="form-control" id="cboAnio3" name="cboAnio3">
					       	<option value="2017">2017</option>
					        <option value="2018">2018</option>
					      </select>
					       <span class="input-group-addon">-</span>
					       <select class="form-control" id="cboCuarto">
					          <option value="0" selected="selected">Seleccione periodo</option>
					          <option value="1">Trimestre 1</option>
					          <option value="2">Trimestre 2</option>
					          <option value="3">Trimestre 3</option>
					          <option value="4">Trimestre 4</option>
					     </select>
					    </div>
					</div>
			</div>
			
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnModalOkreemplazar" id="btnModalOkreemplazar" name="btnModalOk">Crear informe</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>