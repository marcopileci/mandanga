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
            //Subir Imagen a la tabla del servidor
            $target_dir = __DIR__ . "/img/portada/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Comprobar si el archivo es realmente una imagen o no
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
            }
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
                }

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "Imagen subida correctamente";
            } else {
                echo "<script>
                    alert('Error al subir la imagen');
                    window.location.href = 'subir_juego.php';
                    </script>";
                }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            }

            //Tomar todos los datos y subirlos la PHP
            //trim sirve para eliminar espacios innecesarios al inicio y final de un texto
            $nombre = trim($_POST['nombre']);
            $catid = $_POST['catid'];
            $descripcion = trim($_POST['descripcion']);
            $resenia = trim($_POST['resenia']);
            $portada = $_FILES['fileToUpload']['name'];
            $consulta = "INSERT INTO juegos (nombre, catid, descripcion, resenia, portada) VALUES ('".$nombre."', ".$catid.", '".$descripcion."', '".$resenia."', '".$portada."')";
            
            //Comprobar si hay espacios vacios
            //El HTML tiene la etiqueta requiered pero lo pongo aca tambine por las dudas
            if (
                $nombre == "" ||
                empty($_POST['catid']) ||
                $descripcion == "" ||
                $resenia == "" ||
                $_FILES['fileToUpload']['error'] == 4
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
                alert('Juego agregado correctamente');
                window.location.href = 'subir_juego.php';
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
