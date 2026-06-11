<html>
    <?php 
    $db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames");
    if ($db -> connect_error) {
        die("Error de conexion: " . $db->connect_error);    
    }

    $consulta = "SELECT id, nombre FROM categorias";
    $categorias= $db->query($consulta);

    ?>
    <form action="ver_categoria.php" method="post">
    <select name="catid">
    <?php
    while($categoria = $categorias->fetch_assoc()){
        echo "<option value='".$categoria['id']."'>".$categoria['nombre']."</option>";
        }
    ?>      
</select>
    <button type="submit"> Buscar categoria </button>
    <?php
    $consulta= "SELECT * FROM juegos";

    $juegos= $db->query($consulta);

    while($juego = $juegos->fetch_assoc()) {
        echo "<div>
            <h1>".$juego['nombre']."</h1>
            <h2>".$juego['categoria']."</h2>
            <p>".$juego['descripcion']."</p>
            <p>".$juego['resenia']."</p>
        </div>";
    }
    $db->close();
    ?>
</html>