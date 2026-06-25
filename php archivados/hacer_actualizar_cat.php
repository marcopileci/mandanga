<html>
<head></head>
<body>
	<?php 
		$miDB = new mysqli("localhost", "marco", "cfl408", "discoverygames");
		
		$juegoid = $_POST['juegoid'];
		$catid = $_POST['catselect'];
	
		$consulta = "UPDATE juegos SET catid=".$catid." WHERE id=".$juegoid;
		$resultado = $miDB->query($consulta);
		
		if($resultado){
			echo "<h2>Categoria actualizada con exito</h2>";
		} else {
			echo "<h2>Error. No se actualizo</h2>";
		}
		
		
		
		
		$miDB->close()
	?>

	<a href="http://localhost/discoverygames/listar_todo.php">Volver al inicio</a>
	<a href="http://localhost/discoverygames/listar_sin_categoria.php">Volver a sin categoria</a>
</body>
</html>