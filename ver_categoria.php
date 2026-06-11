<html>
    <?php
        $catid= $_POST['catid'];
        $db = new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames");

        $consulta = "SELECT * FROM juegos WHERE catid= ".$catid;

        //echo "<h1>".$consulta."</h1>";
        $juegoscat = $db->query($consulta);

        while($juego = $juegoscat->fetch_assoc()) {
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