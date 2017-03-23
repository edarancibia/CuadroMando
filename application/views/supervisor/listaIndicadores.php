<div class="row">
	<div class="col-md-6 col-md-offset-1" >
		<table class="table tablaListaIndS table-hover">
		 <tr>
			<th>Caracteristica</th>
			<th>Indicador</th>
			<th>Umbral</th>
			<th>Formula</th>
		 </tr>
	<? 
	if (empty($indicadoresAmbito)) {
	 	echo "no hay resultados";
	 } else{
	 	foreach ($indicadoresAmbito as $row) {
			echo "<tr>";
				echo "<td>".$row['Caracteristica']." ".$row['desc_subUn']."</td>";
				echo "<td>".$row['descripcion']."</td>";
				echo "<td>".$row['umbralDesc']."</td>";
				echo "<td>".$row['formula1']."</td>";
			echo "<tr>";
		};
	 }
 ?>
		</table>
	</div>
</div>