    <?php
    $db = new mysqli("localhost", "root", "", "discoverygames");
    if ($db -> connect_error) {
        die("Error de conexion: " . $db->connect_error);    
    }

    $consulta = "SELECT nombre, id FROM categorias";
    $categorias= $db->query($consulta);

        ?>
<html>
    <body>
          <?php
            $nombre = $_POST['nombre'];

            $consulta = "INSERT INTO categorias (nombre) VALUES ('".$nombre."')";

            $resultado = $db->query($consulta);
            if($resultado > 0){
                echo "Categoria agregado.";
            } else {echo "Error";
            }
         ?>

         <?php $db->close();
         ?>
    </body>
</html>