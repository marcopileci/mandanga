<html>
<head></head>
<body>

	<?php 
		$miDB = new mysqli("localhost", "marco", "cfl408", "discoverygames");
		
		
		$descripcion = $_POST['descripcion'];
		$resenia = $_POST['resenia'];
		$catid = $_POST['catid'];
		$juegoid=$_POST['juegoid'];
		
		
		$consulta = "SELECT * FROM categorias";
		
		$categorias = $miDB->query($consulta);
	
		
		echo "<p>Descripcion:
		<br>".$descripcion."
		<br>Reseña:
		<br>".$resenia."
		
		
		<form action='hacer_actualizar_cat.php' method='post'>
		<input type='text' hidden name='juegoid' value='".$juegoid."'>
		<SELECT name='catselect' id='catselect'>";
		
		while($categoria=$categorias->fetch_assoc()){
		
			echo "<option value='".$categoria['id']."'>".$categoria['nombre']."</option>";
		
		
		
		}
		
		
		echo "</SELECT>";
	
		$miDB->close();
	?>

	<button>cambiar categoria</button>
	
	</form>

</body>
</html>