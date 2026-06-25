    <?php 
    $db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames"); //RED PRINCIPAL
    //$db = new mysqli("localhost", "root", "", "discoverygames"); //RED DE PRUEBA
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
    <title>Sobre Nosotros - Discovery Games Wiki</title>
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

<!-- Botones destacados-->
 <div class="py-2 text-center">
  <h2 class="d-inline text-white">Sobre Nosotros y Discovery Games</h2>
    <div class="py-5 text-white">
      Under Construction...
    </div>
  </div>
    <!-- 4. PIE DE PÁGINA (Footer) -->
    <footer class="py-3 my-4 border-top border-secondary text-center">
      <p class="text-secondary">&copy; 2026 Discovery Games Wiki</p>
    </footer>
    <?php
      $db->close();
    ?>
</body>
</html>