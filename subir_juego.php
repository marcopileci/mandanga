    <?php 
    //$db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames"); //RED PRINCIPAL
    $db = new mysqli("localhost", "root", "", "discoverygames"); //RED DE PRUEBA
    if ($db -> connect_error) {
        die("Error de conexion: " . $db->connect_error);    
    }

    $consulta = "SELECT id, nombre FROM categorias";
    $categorias= $db->query($consulta);

    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discovery Games Wiki</title>
    <link rel="icon" type="image/png" href="img/icon_placeholder.png">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <style>
      /* Estilos personalizados simples para que combine con el diseño de Bootstrap */
      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(255, 255, 255, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }
      body {
        background-color: #212529;
      }
      .card-game {
        transition: transform 0.2s;
      }
      .card-game:hover {
        transform: scale(1.05);
      }
    </style>
</head>
<!--Inicio del body -->
<body>
  <!--Inicio Encabezado-->
  <!-- 1. BARRA DE NAVEGACIÓN -->
    <header class="p-3 text-bg-dark border-bottom border-secondary">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a class="d-flex align-items-center mb-2 mb-lg-0 text-info text-decoration-none fw-bold fs-5 me-4">
            Discovery Games Wiki
          </a>
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="main.php" class="nav-link px-2 text-white">Inicio</a></li>   
            <li class="nav-item dropdown">

    <!--Dropdown de categorias -->        
    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
       data-bs-toggle="dropdown" aria-expanded="false">
        Categorías
    </a>
    <ul class="dropdown-menu">
      <?php
        while($categoria = $categorias->fetch_assoc()){
          echo '<li>
                  <a class="dropdown-item" href="main.php?categoria='.$categoria['id'].'">
                      '.$categoria['nombre'].'
                  </a>
                </li>';
          }
      ?>
    </ul>
</li>
            <li><a href="sobrenosotros.php" class="nav-link px-2 text-white">Sobre nosotros</a></li>
            <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Explora juegos...." aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
          </ul>
        </div>
      </div>
    </header>

<!-- FORM-->
<form action="hacer_subir_juego.php" method="post" enctype="multipart/form-data">>
  <div class="form-group text-white">
    <label class="text-white" maxlength="160">Nombre del juego</label>
    <textarea type="text" class="form-control" name="nombre" id="formGroupExampleInput" placeholder="NiGHTS into Dreams..." required></textarea>
  <div class="form-group">
    <label>Escoje la categoria</label>
    <select class="form-control" name="catid" id="exampleFormControlSelect1">
<?php
    $consulta = "SELECT id, nombre FROM categorias";
    $categorias= $db->query($consulta);

     while($categoria = $categorias->fetch_assoc()){
        echo "<option value='".$categoria['id']."'>".$categoria['nombre']."</option>";
        }
?>
    </select>
      </div>
      <div class="form-group">
    <label>Descripcion</label>
    <textarea class="form-control" name="descripcion" id="exampleFormControlTextarea1" rows="3" maxlength="500" placeholder="Escápate al mundo de los sueños y embárcate en una aventura aérea como NiGHTS en 
    este clásico de Sega Saturn..."></textarea>
  </div>
    <div class="form-group">
    <label>Reseña</label>
    <textarea maxlength="500" class="form-control" name="resenia" id="exampleFormControlTextarea1" rows="3" placeholder="NiGHTS into Dreams es un juego realmente hermoso y extrañamente nostálgico. La estética y la música son especialmente agradables. Todo esto combinado crea una sensación similar a un sueño febril, y me encanta. Los productores y creadores de la serie Sonic the Hedgehog también participaron en la creación de este juego, y se nota fácilmente al jugarlo. El único punto negativo que tengo es que es demasiado corto..."></textarea>
  </div>
  <div>
   <label> Seleciona un archivo para subir una portada: </label>
   <input type="file" name="fileToUpload" id="fileToUpload" required>
   <!-- <input type="submit" value="Upload Image" name="submit"> -->
  </div>


  <button type="submit" class="btn btn-primary btn-lg center">Subir Juego</button>
  </div>
  
</form>

    <!-- 4. PIE DE PÁGINA (Footer) -->
    <footer class="py-3 my-4 border-top border-secondary text-center">
      <p class="text-secondary">&copy; 2026 Discovery Games Wiki</p>
    </footer>
    <?php
      $db->close();
    ?>
</body>
</html>