    <?php 
    $db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames");
    if ($db -> connect_error) {
        die("Error de conexion: " . $db->connect_error);    
    }

    $consulta = "SELECT id, nombre FROM categorias";
    $categorias= $db->query($consulta);

    ?>
    <html>  
        <body>
         <?php
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["ImagenASubir"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
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

            $nombre = $_POST['nombre'];
            $catid = $_POST['catid'];
            $descripcion = $_POST['descripcion'];
            $resenia = $_POST['resenia'];

            $consulta = "INSERT INTO juegos (nombre, catid, descripcion, resenia, portada) VALUES ('".$nombre."', ".$catid.", '".$descripcion."', '".$resenia."', '".$portada."')";

           $resultado = $db->query($consulta);
          if($resultado >0){
              echo "Juegos agregado.";
         } else {echo "Error";
       }
  //      echo "<h1>". $consulta ."</h1>";
         ?>

         <?php $db->close();
         ?>
</body>
</html>
