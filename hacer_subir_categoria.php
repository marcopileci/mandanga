    <?php
    $db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames");
    if ($db -> connect_error) {
        die("Error de conexion: " . $db->connect_error);    
    }

    $consulta = "SELECT nombre, id FROM categorias";
    $categorias= $db->query($consulta);

        ?>
<html>
    <body>
        <?php
            $nombre = trim($_POST['nombre']);

            $consulta = "INSERT INTO categorias (nombre) VALUES ('".$nombre."')";

            //Comprobar si hay espacios vacios
            //El HTML tiene la etiqueta requiered pero lo pongo aca tambine por las dudas
            if (
                $nombre == "" 
            ) {
                echo "<script>
                alert('Uno o mas campos estan vacios. Completelos antes de subir una categoria.');
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
                alert('Ha ocurrido un error al subir la categoria :(');
                </script>";
        }
        ?>

        <?php $db->close();
        ?>
    </body>
</html>