<?php

    require_once __DIR__ . "/../src/datos.php";
    require_once __DIR__ . "/../src/funciones.php";
    
    $hoy = new DateTimeImmutable();
    $fechaRevision = $hoy->modify("+30 days");

    // if (isset($_GET["genero"])) {        // No entiendo exactamente que hace esto
    //     echo $_GET["genero"];            
    // }
    $genero = $_GET["genero"] ?? null;
    $disponible =$_GET["disponible"] ?? null;
    $librosMostrar = $libros;

    if($genero !== null) {
        $librosMostrar = filtrarPorGenero($libros, $genero);
    }

    if($disponible !== null) {
        $librosMostrar = filtrarDisponibles($librosMostrar);
    }

    $totalLibros = count($librosMostrar);
    $mediaPaginas = calcularMediaPaginas($librosMostrar);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de libros</title>
</head>
<body>
    <h1>Catálogo de libros</h1>

    <p>Libros encontrados: <?= $totalLibros ?></p>
    <p>Media de páginas: <?= $mediaPaginas ?></p>

    <?php foreach($librosMostrar as $libro): ?>
        <?php $fechaAlta = new DateTimeImmutable($libro["fechaAlta"]); ?>
        <?php $diferencia = $fechaAlta->diff($hoy); ?>
        <?php $diasPasados = $diferencia->days; ?>

        
        <h2><?= htmlspecialchars($libro["titulo"]) ?></h2>
        
        <p>Autor: <?= htmlspecialchars($libro["autor"]) ?></p>
        <p>Género: <?= htmlspecialchars($libro["genero"]) ?></p>
        <p>Páginas: <?= $libro["paginas"] ?></p>
        
        <?php if($libro['disponible']): ?>
            <p>Disponible: Sí</p>
            <?php else: ?>
                <p>Disponible: No</p>
        <?php endif; ?>

        <p>Días desde el alta: <?= $diasPasados ?></p>

    <?php endforeach; ?>
    <p>
        Próxima revisión del catálogo:
        <?= $fechaRevision->format("d/m/Y"); ?>
    </p>

</body>
</html>