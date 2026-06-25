<?php

$conexion = mysqli_connect("localhost", "marco", "cfl408", "discoverygames");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['img']) && isset($_POST['id'])) {

    $nuevaImg = $_POST['img'];
    $idJuego = (int)$_POST['id'];

    $sql = "UPDATE juegos SET img = ? WHERE id = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nuevaImg, $idJuego);

    if (mysqli_stmt_execute($stmt)) {
        echo "Imagen actualizada correctamente";
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);

} else {
    echo "Faltan los campos 'portada' o 'id'.";
}

mysqli_close($conexion);

?>