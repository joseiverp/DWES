<?php
    declare(strict_types=1);

    require_once __DIR__ . '\..\src\datos.php';
    require_once __DIR__ . '\..\src\funciones.php';

    $libros = $catalogo;
    $resultado = $libros;

    $genero = $_GET['genero'] ?? null;
    $disponible = $_GET['disponible'] ?? null;
    $q = $_GET['q'] ?? null;
    $orden = $_GET['orden'] ?? null;

    //filtrar por genero
    if($genero !== null) {
        $resultado = filtrarPorGenero($libros, (string)$genero);
    }

    // filtrar por disponibilidad

    if($disponible !== null
        && ($disponible === '0' || $disponible === '1')) {
            $resultado = filtrarPorDisponibilidad(
                $resultado,
                $disponible === '1'
            );
    }

    if ($q !== null){
        $resultado = buscarPorTexto($resultado, (string)$q);
    }

    if ($orden === 'titulo') {
        $resultado = ordenarPorTitulo($resultado);
    } elseif ($orden === 'paginas') {
        $resultado = ordenarPorPaginas($resultado);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <p>Numero de resultados: <?= count($resultado); ?></p>

    <p><a href="estadisticas.php">Ver estadisticas</a></p>

    <ul>

        <?php foreach($resultado as $libro): ?>
            <li>
                <?= htmlspecialchars($libro['titulo']) ?>
                - <?=htmlspecialchars($libro['autor']) ?>
                - <?=htmlspecialchars($libro['genero']) ?>
                - <?=$libro['paginas'] ?> Páginas
                - <?=$libro['disponible'] ? 'Disponible' : 'No disponible' ?> 
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>