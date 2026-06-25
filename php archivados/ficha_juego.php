<html>
<body>
<?php

// Conectar con la base
$miDB = new mysqli("localhost", "marco", "cfl408", "discoverygames");

// Capturar valor del formulario
$id = (int)$_GET['id'];

//Preparar consulta
$consulta= "SELECT * FROM juegos WHERE id = $id";

// Ejecutar consulta
$resultado = $miDB->query($consulta);
?>
</body>
</html>