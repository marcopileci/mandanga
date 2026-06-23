    <?php 
    $db = new mysqli("localhost", "root", "", "discoverygames");
    if ($db -> connect_error) {
        die("Error de conexion: " . $db->connect_error);    
    }

    $consulta = "SELECT id, nombre FROM categorias";
    $categorias= $db->query($consulta);

    ?>
    <html>  
        <body>
        <?php

        // Tomar los datos del formulario
        $nombre = trim($_POST['nombre']);
        $catid = $_POST['catid'];
        $descripcion = trim($_POST['descripcion']);
        $resenia = trim($_POST['resenia']);
        $portada = $_FILES['fileToUpload']['name'];

        // Comprobar campos vacíos
        if (
            $nombre == "" ||
            empty($catid) ||
            $descripcion == "" ||
            $resenia == "" ||
            $_FILES['fileToUpload']['error'] == 4
        ) {
            echo "<script>
                alert('Uno o más campos están vacíos.');
                window.history.back();
            </script>";
            exit;
        }

        // Configuración de la imagen
        $target_dir = __DIR__ . "/img/portada/";
        $target_file = $target_dir . basename($portada);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $uploadOk = 1;

        // Verificar que sea una imagen real
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if ($check === false) {
            echo "<script>
            alert('El archivo no es una imagen válida.');
            window.history.back();
            </script>";
            $uploadOk = 0;
        }

        // Verificar tamaño (500 KB)
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "<script>
            alert('La imagen supera el tamaño permitido. (500MB)');
            window.history.back();
            </script>";
            $uploadOk = 0;
        }

        // Verificar extensión permitida
        if (
            $imageFileType != "jpg" &&
            $imageFileType != "jpeg" &&
            $imageFileType != "png" &&
            $imageFileType != "gif"
        ) {
            echo "<script>
                alert('Solo se permiten archivos JPG, JPEG, PNG y GIF.');
                window.history.back();
                </script>";
            $uploadOk = 0;
        }

        // Si alguna validación falló, detener ejecución
        if ($uploadOk == 0) {
            echo "<script>
                alert('La imagen no pudo ser subida.');
                window.history.back();
            </script>";
            exit;
        }

        // Subir imagen
        if (!move_uploaded_file(
            $_FILES["fileToUpload"]["tmp_name"],
            $target_file
        )) {
            echo "<script>
                alert('Error al subir la imagen');
                window.location.href = 'subir_juego.php';
            </script>";
            exit;
        }

        // Guardar en la base de datos
        $consulta = "
            INSERT INTO juegos
            (nombre, catid, descripcion, resenia, portada)
            VALUES
            ('$nombre', $catid, '$descripcion', '$resenia', '$portada')
        ";

        $resultado = $db->query($consulta);

        if ($resultado) {
            echo "<script>
                alert('Juego agregado correctamente');
                window.location.href = 'subir_juego.php';
            </script>";
        } else {
            echo "<script>
                alert('Ha ocurrido un error al guardar el juego');
                window.history.back();
            </script>";
        }

        $db->close();
    
?>

</body>
</html>
