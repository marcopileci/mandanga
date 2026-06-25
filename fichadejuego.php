
 <?php 
  $db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames"); //RED PRINCIPAL
  //$db = new mysqli("localhost", "root", "", "discoverygames"); //RED DE PRUEBA
  if ($db -> connect_error) {
   die("Error de conexion: " . $db->connect_error);    
   }
  $consulta = "SELECT id, nombre FROM categorias";
  $categorias= $db->query($consulta);
  ?>



<!doctype html>
<html lang="es" data-bs-theme="dark">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Discovery Games Wiki - Ficha de Juego</title>
    <link rel="icon" type="image/png" href="img/icon_placeholder.png">
    <!-- Conexión directa a Bootstrap por Internet (Para que no se rompa el diseño) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    
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
      .card-game {
        transition: transform 0.2s;
      }
      .card-game:hover {
        transform: scale(1.05);
      }
    </style>
  </head>
  <body>

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
           <!-- <li><a href="sobrenosotros.php" class="nav-link px-2 text-white">Sobre nosotros</a></li>
            <form class="d-flex" role="search"> -->
      </form>
          </ul>
        </div>
      </div>
    </header>


    <main>
      <?php
        if (!isset($_GET['id'])){
      header('Location: main.php');
      exit;
      }
      $id = (int)$_GET['id'];
      $consulta= $db->prepare("SELECT j.*, c.nombre AS categoria FROM juegos j LEFT JOIN categorias c ON j.catid = c.id WHERE j.id = ?");
      $consulta->bind_param("i", $id);
      $consulta->execute();
      $result = $consulta->get_result();
      $juego = $result->fetch_assoc();
      if (!$juego) {
        echo "Juego no encontrado";
        exit;
      }
    echo '
      <!-- 2. SECCIÓN PRINCIPAL -->
      <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5 bg-body-tertiary rounded-4 shadow-lg">
          
          <!-- Lado de la Imagen -->
          <div class="col-10 col-sm-8 col-lg-5 mx-auto">
            <img
              src="img/portada/'.$juego['portada'].'"
              class="d-block mx-lg-auto img-fluid rounded-3 shadow-lg border border-secondary"
              alt="'.$juego['nombre'].'"
              style="width: 500px; height: 500px; object-fit: full;"
              loading="lazy"
              />
          </div>
          
          <!-- Lado del Contenido -->
          <div class="col-lg-7">
            <div class="mb-2">
              <a class="badge bg-danger text-uppercase fw-bold" href="main.php?categoria='.$juego['catid'].'">'.$juego['categoria'].'</a>
            </div>
            <h1 class="display-4 fw-bold text-body-emphasis lh-1 mb-3">'.$juego['nombre'].'</h1>
            <h3 class="h5 text-info mt-4">Sinopsis:</h3>
            <p class="lead">
              '.$juego['descripcion'].'</p>
            
            <div class="p-3 bg-dark bg-opacity-50 rounded-3 border border-secondary mt-4">
              <h3 class="h6 text-warning fw-bold text-uppercase mb-2">⭐ Reseña:</h3>
              <p class="mb-0 text-light-emphasis italic">'.$juego['resenia'].'</p>
            </div>
          </div>

        </div>
      </div>
      '
      ?>
      <!-- Divisor estético oficial de Bootstrap -->
      <div class="b-example-divider"></div>

      <!-- 3. SECCIÓN DE RECOMENDADOS -->
      <div class="container px-4 py-5">
        <h2 class="pb-2 border-bottom border-secondary text-white mb-4">Juegos Recomendados</h2>
        
        <div class="row row-cols-2 row-cols-md-4 g-4 py-3">
          
          <!-- Juegos Recomendados -->
          <?php
          // Traer solo juegos de la misma categoría, excluyendo el juego actual
          $catid = $juego['catid']; // catid del juego al que se hizo click
          
          $consulta_rec = $db->prepare("
              SELECT j.*, c.nombre AS categoria
              FROM juegos j
              LEFT JOIN categorias c ON j.catid = c.id
              WHERE 
              j.catid = ? AND j.id != ?
              ORDER BY j.id DESC
              LIMIT 4
          ");
          $consulta_rec->bind_param("ii", $catid, $id);
          $consulta_rec->execute();
          $juegos_rec = $consulta_rec->get_result();

          while($row = $juegos_rec->fetch_assoc()):
          ?>
              <div class="col">
                  <a class="card h-100 bg-dark border-secondary text-center shadow-sm card-game" 
                    href="fichadejuego.php?id=<?php echo $row['id']; ?>">
                      <div class="p-3">
                          <img src="img/portada/<?php echo $row['portada']; ?>" 
                              class="card-img-top rounded" 
                              alt="<?php echo $row['nombre']; ?>" 
                              style="height: 150px; object-fit: cover;">
                      </div>
                      <div class="card-body pt-0">
                          <p class="card-text fw-bold text-white mb-0"><?php echo $row['nombre']; ?></p>
                      </div>
                  </a>
              </div>
          <?php endwhile; ?>
    </main>

    <!-- 4. PIE DE PÁGINA (Footer) -->
    <footer class="py-3 my-4 border-top border-secondary text-center">
      <p class="text-secondary">&copy; 2026 Discovery Games Wiki</p>
    </footer>

    <!-- Scripts oficiales de Bootstrap al final -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  <?php
      $db->close();
  ?>
</html>