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
        $portada = "";

        if(isset($_FILES['portada']) && $_FILES['portada']['error'] == 0){

            $nombreArchivo = basename($_FILES['portada']['name']);

            $rutaDestino = "img/" . $nombreArchivo;

            if(move_uploaded_file($_FILES['portada']['tmp_name'], $rutaDestino)){
                $portada = $rutaDestino;
            }else{
                die("No se pudo subir la imagen");
            }
        }




            $nombre = $_POST['nombre'];
            $catid = $_POST['catid'];
            $descripcion = $_POST['descripcion'];
            $resenia = $_POST['resenia'];

            $consulta = "INSERT INTO juegos (nombre, catid, descripcion, resenia, portada) VALUES ('".$nombre."', ".$catid.", '".$descripcion."', '".$resenia."', '".$portada"')";

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
