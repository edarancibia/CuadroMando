<div class="container">
<form method="POST" action="<?= base_url('index.php/Indicadores/VistaAmbitos'); ?>">
  <div class="row col-xs-6">
      <select id="trimestre" name="trimestre">
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
	<div class="col-md-9 col-md-offset-1" >
		<table class="table tablaListaIndS table-hover" border=1>
		 <tr>
			<th>Caracteristica</th>
			<th>Indicador</th>
			<th>Umbral</th>
			<th>Formula</th>
			<th>Mes 1 |Mes 2 |Mes 3|</th>
			<th>Trimestre</th>
		 </tr>

	<? 
	//echo $idAmbito;
	if (isset($_POST["buscaTrimestre"])) {
		$trimestre = $_POST["trimestre"];
		$idAmbito2 = $_POST["idAmbito"];

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
				# code...
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
					echo "<td width=120 style='font-size:14px;'>".$row['numerador']."<hr>".$row['denominador']."<hr>" ."<strong>".$row['resultados']."%</strong></td>
					<td width=50 style='font-size:14px;'>".$row['numeradores']."<hr>".$row['denominadores']."<hr><strong>".intval($row['resultados'])."</strong></td>";
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
</body>