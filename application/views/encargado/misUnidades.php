<!DOCTYPE html>
<html>
<head>
	<title>Mis Unidades</title>
</head>
<body>
<div class="container">
	<div class="row">
	<h3>Mis Unidades</h3>
	<input type="hidden" name="txtIdUnidad" value="">
		<?php
		foreach ($unidades as $row) {
			echo '<li><a href='.base_url().'index.php/Indicadores/MiUnidad?idUnidad='.$row->idUnidad.'>'.$row->descripcion.'</a></li>';
		}
		?>
	</div>
</div>
</body>
</html>