<!DOCTYPE html>
<html lang="es">
<!-- Esto conecta a la base de datos -->
  <?php 
  $db= new mysqli("192.168.1.48", "marco", "cfl408", "discoverygames"); //RED PRINCIPAL
  //$db = new mysqli("localhost", "root", "", "discoverygames"); //RED DE PRUEBA
  if ($db -> connect_error) {
   die("Error de conexion: " . $db->connect_error);    
   }
  $consulta = "SELECT id, nombre FROM categorias";
  $categorias= $db->query($consulta);
  ?>

<!-- Inicio del Head-->
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
      .card-img-top {
        width: 100%;    /*Ocupa todo el ancho de la carta */
        height: 320px; /* altura fija */
        /* object-fit: cover;*/   /* recorta sin deformar, */
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
            <!-- <li><a href="sobrenosotros.php" class="nav-link px-2 text-white">Sobre nosotros</a></li>
            <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Explora juegos...." aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Buscar</button> -->
      </form>
          </ul>
        </div>
      </div>
    </header>

<!-- Botones destacados-->


    <div class="p-3">
    <center>
    <h3 class="center text-white"> ¡Ayudanos a subir mas juegos y categorias!</h3>
    <a href=subir_juego.php type="button" class="btn btn-success btn-lg">Subir Juego</a>
    <a href=subir_categoria.php type="button" class="btn btn-success btn-lg">Subir Categoria</a>
    </div>
    
    <center>
    <?php
    $letras = array_merge(range('A', 'Z'), ['0-9', 'Todos']);
    foreach($letras as $letra):
    if($letra === 'Todos'){
        $href = "main.php";
    } elseif($letra === '0-9'){
        $href = "main.php?letra=0-9";
    } else {
        $href = "main.php?letra=$letra";
    }
    $activa = (isset($_GET['letra']) && $_GET['letra'] === $letra) ? 'btn-secondary' : 'btn-outline-secondary';
?>
    <a href="<?= $href ?>" class="btn <?= $activa ?>"><?= $letra ?></a>
<?php endforeach; ?>
</center> <br>

<!--Fin Botones destacados-->

  <center>
<!-- Grilla con los juegos, 3 x 3-->
<?php
$porPagina = 8;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if($pagina < 1) $pagina = 1;
$inicio = ($pagina - 1) * $porPagina;

// Leer categoría si viene en la URL
$categoriaId = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;
$letra = isset($_GET['letra']) ? $_GET['letra'] : null;

//filtrar por letra
$condiciones = [];
if($categoriaId) $condiciones[] = "j.catid = $categoriaId";
if($letra === '0-9'){
    $condiciones[] = "j.nombre REGEXP '^[0-9]'";
} elseif($letra){
    $letraSegura = $db->real_escape_string($letra);
    $condiciones[] = "j.nombre LIKE '$letraSegura%'";
}
$where = count($condiciones) ? "WHERE " . implode(" AND ", $condiciones) : "";

// Total respetando el filtro
$resultadoTotal = $db->query("SELECT COUNT(*) AS total FROM juegos j $where");
$totalJuegos = $resultadoTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalJuegos / $porPagina);

$consulta = "
    SELECT j.*, c.nombre AS categoria
    FROM juegos j
    LEFT JOIN categorias c ON j.catid = c.id
    $where
    ORDER BY j.id DESC
    LIMIT $inicio, $porPagina
";
$juegos = $db->query($consulta);

echo '<div class="container">';
echo '<div class="row row-cols-1 row-cols-md-4 g-4">';

while($juego = $juegos->fetch_assoc()){

    echo '
    <div class="col">
        <a href="fichadejuego.php?id='.$juego['id'].'" class="card-link text-decoration-none">
            <div class="card h-100 bg-dark border-secondary text-center shadow-sm">
                
                <img src="img/portada/'.$juego['portada'].'" class="card-img-top" alt="'.$juego['nombre'].'">

                <div class="card-body"> 
                    <h5 class="card-title text-light">'.$juego['nombre'].'</h5>
                    <p class="card-text text-light">'.$juego['descripcion'].'</p>
                </div>

                <div class="card-footer">
                    <small class="text-light">'.$juego['categoria'].'</small>
                </div>
            </div>
        </a>
    </div>';
}

echo '</div>';
echo '</div>';
?>
<!-- Remplaza los "..." con algunas imagenes de ejemplo!!!!-->
</center>


<!-- Fin de la grilla-->
<center>
<!-- Navegador de paginas-->
<?php
echo '<div class="d-flex justify-content-center mt-4">';
echo '<div class="btn-group" role="group">';

$params = [];
if($categoriaId) $params[] = "categoria=$categoriaId";
if($letra) $params[] = "letra=$letra";
$baseUrl = count($params) ? "?" . implode("&", $params) . "&pagina=" : "?pagina=";

for($i = 1; $i <= $totalPaginas; $i++){
    $clase = ($i == $pagina) ? 'btn btn-secondary' : 'btn btn-outline-secondary';
    echo '<a href="'.$baseUrl.$i.'" class="'.$clase.'">'.$i.'</a>';
}

echo '</div>';
echo '</div>';
?>
</center>

    <!-- 4. PIE DE PÁGINA (Footer) -->
    <footer class="py-3 my-4 border-top border-secondary text-center">
      <p class="text-secondary">&copy; 2026 Discovery Games Wiki</p>
    </footer>
    <?php
      $db->close();
    ?>
</body>
</html>