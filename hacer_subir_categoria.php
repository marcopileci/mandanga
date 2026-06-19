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

            //Comprobar si hay espacios vacios
            //El HTML tiene la etiqueta requiered pero lo pongo aca tambine por las dudas
            if (
                $nombre == "" ||
            ) {
                echo "<script>
                alert('Uno o mas campos estan vacios. Completelos antes de subir un juego.');
                window.history.back();
                </script>";
                exit;
            }

            $resultado = $db->query($consulta);
            if($resultado >0){
            echo "<script>
                alert('Categoria agregada correctamente');
                window.location.href = 'subir_categoria.php';
                </script>";
        } else {echo "<script>
                alert('Ha ocurrido un error al subir el juego :(');
                </script>";
        }
        ?>

        <?php $db->close();
        ?>
    </body>
</html>