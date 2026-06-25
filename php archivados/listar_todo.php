<html>
<head></head>
<body>
	<?php 
		$miDB = new mysqli("localhost", "marco", "cfl408", "discoverygames");
		
		$consulta = "SELECT * FROM juegos";
		
		$listado = $miDB->query($consulta);
		while($juego=$listado->fetch_assoc()){
			echo "
			<form action='cambiarcat.php' method='post'>
			
			<textarea readonly name='descripcion' rows='10'>".$juego['descripcion']."</textarea><br>
			<textarea readonly name='resenia' rows='10'>".$juego['resenia']."</textarea><br>
			<input type='text' readonly name='catid' value='".$juego['catid']."'><br>
			<input type='text' hidden readonly name='juegoid' value='".$juego['id']."'><br>
			<button>Cambiar categoria</button>
			</form>
			
			";
		}
		
		$miDB->close();
	
	?>
</body>
</html>
