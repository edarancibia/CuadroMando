
<div class="container">
<form method="POST" action="<?= base_url('index.php/Indicadores/Result'); ?>">
  <div class="row col-xs-6">
  		<select id="cboanio5" name="cboanio5">
  			<option value="2017">2017</option>
  		</select>

      <select id="trimestre" name="trimestre">
      	<option value="1">1 Trimestre</option>
      	<option value="2">2 Trimestre</option>
      	<option value="3">3 Trimestre</option>
      	<option value="4">4 Trimestre</option>
      </select>
      <!--<input type="submit" name="buscaTrimestre" id="buscaTrimestre" class="btn btn-default" value="Ver Periodo">-->
      <button type="submit" name="buscaTrimestre" class="btn-success btn">Buscar <i class="fa fa-search" aria-hidden="true"></i></button>
      <input type="hidden" name="idUnidad" id="idUnidad" value='<?php echo $_REQUEST['idUnidad'] ?>'>

      <button type="button" id="btnFiltrar" class="btn btn-info">Filtrar resultados <i class="fa fa-filter" aria-hidden="true"></i></button>
     
  </div>
  <br/>

<div class="row">
	<br/>
	<?php
	echo "<label class='lblnombre'>" .$unidad."</label>";
	//echo '<strong>'.$unidad->descripcion.'</strong>';
	$m1 = 'Mes 1';
	$m2 = 'Mes 2';
	$m3 = 'Mes 3';

	if (isset($_POST['buscaTrimestre'])) {
		$trimestre = $_POST["trimestre"];
		
		switch ($trimestre) {
		  case 1:
			  	$m1 = 'ENERO';
			  	$m2 = 'FEBRERO';
			  	$m3 = 'MARZO';
		   break;

		   case 2:
		   		$m1 = 'ABRIL';
		   		$m2 = 'MAYO';
		   		$m3 = 'JUNIO';
		   	break;

		   	case 3:
		   		$m1 = 'JULIO';
		   		$m2 = 'AGOSTO';
		   		$m3 = 'SEPTIEMBRE';
		   	break;

		   	case 4:
		   		$m1 = 'OCTUBRE';
		   		$m2 = 'NOVIEMBRE';
		   		$m3 = 'DICIEMBRE';
		   	break;
		  		
		   default:
		  	# code...
		   break;
		}
	}


		
	?>

	<div class="col-md-11 col-md-offset-1" style="overflow: scroll; height: 500px;">
		<table class="table tablaListaIndS table-hover" border=1 id="tablaUnidad">
		<thead>
		 <tr>
		 	
			<th>CARACTERÍSTICA</th>
			<th>INDICADOR</th>
			<th>UMBRAL</th>
			<th>FÓRMULA</th>
			<th><?php echo $m1 .' |'.$m2 . ' |' .$m3. ' |';?></th>
			<th>TRIMESTRE</th>
			<th></th>
		 </tr>
		 </thead>
		 <tbody>

	<?php
	//echo $idAmbito;
	if (isset($_POST["buscaTrimestre"])) {
		$trimestre = $_POST["trimestre"];
		$anio = $_POST['cboanio5'];

		
		switch ($trimestre) {
			case 1:
				echo "<h4 style='width:200px'>Primer trimestre ".$anio. "</h4>";
				break;
			case 2:
				echo "<h4 style='width:200px'>Segundo trimestre ".$anio."</h4>";
				break;
			case 3:
				echo "<h4 style='width:200px'>Tercer trimestre ".$anio."</h4>";
				break;
			case 4:
				echo "<h4 style='width:200px'>Cuarto trimestre ".$anio."</h4>";
				break;
			default:
				
				break;
		}


		if (empty($indicadoresUnidad)) {
			echo "<tr>";
	 		echo "no hay resultados";
	 		echo "</tr>";
	} else{

		 	foreach ($indicadoresUnidad as $row) {
				echo "<tr>";
					echo "<td width=50 style='display:none;'>".$row['idIndicador']."</td>";
					echo "<td width=50>".$row['Caracteristica']." ".$row['desc_subUn']."</td>";
					echo "<td width=150>".$row['descripcion']."</td>";
					echo "<td width=30>".$row['umbralDesc']."</td>";
					echo "<td width=200'>".$row['formula1']."<hr>".$row['formula2']."<br/><br/></td>";
					//echo "<td width=80>".substr($row['fecha'], 0,10) ."</td>";
					echo "<td width=220 style='font-size:14px;'>".$row['denominador']."<hr>".$row['numerador']."<hr>" ."<strong>".$row['resultados']."%</strong></td>
					<td width=50 bgcolor='#f5f5dc' style='font-size:14px;'>".$row['denominadores']."<hr>".$row['numeradores']."<hr><strong>".intval($row['res'])."</strong></td>";
					
					echo '<td width=100><div class="progress">
						  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'.$row['res'].'"
						  aria-valuemin="0" aria-valuemax="100" style="width:'.$row['res'].'%">
						    '.$row['res'].'%  
						  </div>
						</div></td>';
					echo '<td width=30><button data-id='.$row["idIndicador"].' class="btnmail2" type="button"><i class="fa fa-envelope-o" aria-hidden="true"></i></button></td>';
					echo "<td width=30 style='display:none'>".$row['evaluacion']."</td>";
				echo "<tr>";
			};
		}
	}
 	?>
 		  </tbody>
		</table>
	</div>
</div>
</form>
</div>

<div id="dialog-form" title="Nuevo correo">
  <form>
    <fieldset>
      <label for="txtmail">Destinatario</label>
      <input type="text" name="txtmail" id="txtmail"  class="text ui-widget-content ui-corner-all">
      <label for="txtasunto">Asunto</label>
      <input type="text" name="txtasunto" id="txtasunto"  class="text ui-widget-content ui-corner-all">
      <label for="txtmensaje">Mensaje</label>
      <textarea id="txtmensaje" name="txtmensaje" class="mensaje text ui-widget-content ui-corner-all"></textarea>
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>

</div>
</body>