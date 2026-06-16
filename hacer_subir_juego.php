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
            $nombre = $_POST['nombre'];
            $catid = $_POST['catid'];
            $descripcion = $_POST['descripcion'];
            $resenia = $_POST['resenia'];
            

            $consulta = "INSERT INTO juegos (nombre, catid, descripcion, resenia) VALUES ('".$nombre."', ".$catid.", '".$descripcion."', '".$resenia."')";

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
