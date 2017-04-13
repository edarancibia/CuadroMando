<div class="container">
<form method="POST" action="<?= base_url('index.php/Indicadores/VistaAmbitos'); ?>">
  <div class="row col-xs-6">
      <select id="trimestre" name="trimestre">
        <option value="0" SELECTED>Seleccione un periodo</option>
      	<option value="1">1 Trimestre</option>
      	<option value="2">2 Trimestre</option>
      	<option value="3">3 Trimestre</option>
      	<option value="4">4 Trimestre</option>
      </select>
      <!--<input type="submit" name="buscaTrimestre" id="buscaTrimestre" class="btn btn-default" value="Ver Periodo">-->
      <button type="submit" name="buscaTrimestre" class="btn-success btn">Buscar <i class="fa fa-search" aria-hidden="true"></i></button>
      <input type="hidden" name="idAmbito" id="idAmbito" value='<? echo $_REQUEST['idAmbito'] ?>'>
  </div>
  <br/>

<div class="row">
	<br/>
	<?
	print_r($ambito);
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

	<div class="col-md-10 col-md-offset-1" >
		<table class="table tablaListaIndS table-hover" border=1>
		 <tr>
			<th>CARACTERÍSTICA</th>
			<th>INDICADOR</th>
			<th>UMBRAL</th>
			<th>FÓRMULA</th>
			<th><? echo $m1 .' |'.$m2 . ' |' .$m3. ' |';?></th>
			<th>TRIMESTRE</th>
		 </tr>

	<? 
	//echo $idAmbito;
	if (isset($_POST["buscaTrimestre"])) {
		$trimestre = $_POST["trimestre"];
		$idAmbito2 = $_POST["idAmbito"];
		//print_r($ambito);
		if ($trimestre == 0) {
			echo "<script>alert('Seleccione una opcion');</script>";
		}
		
		switch ($trimestre) {
			case 1:
				echo "<h4>Primer trimestre</h4>";
				break;
			case 2:
				echo "<h4>Segundo trimestre</h4>";
				break;
			case 3:
				echo "<h4>Tercer trimestre</h4>";
				break;
			case 4:
				echo "<h4>Cuarto trimestre</h4>";
				break;
			default:
				
				break;
		}


		if (empty($indicadoresAmbito)) {
	 		echo "no hay resultados";
	} else{

		 	foreach ($indicadoresAmbito as $row) {
				echo "<tr>";
					echo "<td width=50>".$row['Caracteristica']." ".$row['desc_subUn']."</td>";
					echo "<td width=150>".$row['descripcion']."</td>";
					echo "<td width=30>".$row['umbralDesc']."</td>";
					echo "<td width=200'>".$row['formula1']."<hr>".$row['formula2']."<br/><br/></td>";
					//echo "<td width=80>".substr($row['fecha'], 0,10) ."</td>";
					echo "<td width=190 style='font-size:14px;'>".$row['numerador']."<hr>".$row['denominador']."<hr>" ."<strong>".$row['resultados']."%</strong></td>
					<td width=50 bgcolor='#f5f5dc' style='font-size:14px;'>".$row['numeradores']."<hr>".$row['denominadores']."<hr><strong>".intval($row['resultados'])."</strong></td>";
					echo '<td width=30><button class="btnmail" type="button"><i class="fa fa-envelope-o" aria-hidden="true"></i></button></td>';
					//echo "<td width=150>".$row['fechas']."<br/>".$row['resultados']."</td>";
					/*echo '<td width=100><div class="progress">
						  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'.$row['resultado'].'"
						  aria-valuemin="0" aria-valuemax="100" style="width:'.$row['resultado'].'%">
						    '.$row['resultado'].'%  
						  </div>
						</div></td>';*/
				echo "<tr>";
			};
		}
	}
 	?>
		</table>
	</div>
</div>
</form>
</div>

<div id="dialog-form" title="Nuevo correo">
  <form>
    <fieldset>
      <label for="name">Destinatario</label>
      <input type="text" name="txtmail" id="txtmail"  class="text ui-widget-content ui-corner-all">
      <label for="email">Asunto</label>
      <input type="text" name="txtasunto" id="txtasunto"  class="text ui-widget-content ui-corner-all">
      <label for="txtmensaje">Mensaje</label>
      <textarea id="txtmensaje" name="txtmensaje" class="mensaje text ui-widget-content ui-corner-all"></textarea>
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>

</div>
</body>