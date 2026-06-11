<html>
<head></head>
<body>

<?php

// Conectar con la base
$miDB = new mysqli("localhost", "marco", "cfl408", "discoverygames");

// Capturar valor del formulario
$catid = $_POST['catselect'];

// Preparar consulta
$consulta = "SELECT * FROM juegos WHERE catid = $catid";

// Ejecutar consulta
$resultado = $miDB->query($consulta);

echo "<form action='ficha_juego.php' method='get'>
		<SELECT name='id' id='id'>";

while ($categoria = $resultado->fetch_assoc()) {
    echo "<option value='".$categoria['id']."'>".$categoria['nombre']."</option>";
}

echo "</select>";

$miDB->close();

echo "<button type='submit'>Ficha tecnica</button>";
?>

</body>
</html>