<div class="container">
	<div class="row">
		<table class="table table-hover tabla-selectInd">
			<tr>
				<th>Id</th>
				<th>Caracteristica</th>
				<th></th>
				<th>Indicador</th>
			</tr>
			<?php foreach ($indica as $row) {
				echo "<tr>";
				echo 	"<td>".$row['idIndicador']."</td>";
				echo 	"<td>".$row['Caracteristica']."</td>";
				echo 	"<td>".$row['sub']."</td>";
				echo 	"<td>".$row['descripcion']."</td>";
				echo 	"<td><a href=#>Evaluar</a></td>";
				echo "</tr>";
			};
			?>
		</table>
	</div>
</div>