<html>
<head></head>
<body>

	<?php 
	 //conectar con la base

	
		$miDB = new mysqli("localhost", "marco", "cfl408", "discoverygames");
		
	 //preparar la consulta
		$consulta = "SELECT * FROM categorias";
		
		//ejecutar la consulta
		$categorias = $miDB->query($consulta);
	
		//conformar el form
		echo "<form action='traer_por_cat.php' method='post'>
		<SELECT name='catselect' id='catselect'>";
		
		while($categoria=$categorias->fetch_assoc()){
		
			echo "<option value='".$categoria['id']."'>".$categoria['nombre']."</option>";
		}
		
		
		echo "</SELECT>";
	
		$miDB->close();
	?>

	<button>Ver juegos de esta categoria</button>
	
	</form>

</body>
</html>