<?php

declare(strict_types=1);
require_once __DIR__ . '\..\src\datos.php';
require_once __DIR__ . '\..\src\funciones.php';

$id = (int)$_GET['id'] ?? 0;

// Falta obtener el videojuego
$videojuego = buscarPorId($videojuegos, $id);

if ($videojuego === null) {
    // Completa el tratamiento del caso en el que el videojuego no existe.
    echo 'Videojuego no encontrado';
}
// Fuera del if, no llega a nada más
    // exit;
?>

<?php
// Prepara las fechas y los valores que necesita la ficha.
foreach($videojuegos as $videojuego){
    $fechaLanzamiento = $videojuegos['fechaLanzamiento'];// De dónde saco la fecha??
}

$fechaLanzamiento = new DateTimeImmutable($fechaLanzamiento);
$hoy = new DateTimeImmutable('today');
$diasTranscurridos = $fechaLanzamiento->diff($hoy);//0? Habrá que calcular algo, no?
// days no es un método
$diasTranscurridos = $diasTranscurridos->days;
$finNovedad = null;
$estado = '';

// COMPLETAR los cálculos anteriores utilizando los datos del videojuego.
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ficha del videojuego</title>
</head>
<body>
    <h1><?= htmlspecialchars($videojuego['titulo'] ?? '') ?></h1>

    <dl>
        <dt>Estudio</dt>
        <dd><?= htmlspecialchars($videojuego['estudio'] ?? '') ?></dd>

        <dt>Género</dt>
        <dd><?= htmlspecialchars($videojuego['genero'] ?? '') ?></dd>

        <dt>Plataforma</dt>
        <dd><?= htmlspecialchars($videojuego['plataforma'] ?? '') ?></dd>

        <dt>Precio</dt>
        <dd>
            <?php if ($videojuego !== null): ?>
                <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
            <?php endif; ?>
        </dd>

        <dt>Puntuación</dt>
        <dd><?= $videojuego['puntuacion'] ?? '' ?></dd>

        <dt>Fecha de lanzamiento</dt>
        <dd><?= $videojuego['fechaLanzamiento'] ?? '' ?></dd>

        <dt>Días desde el lanzamiento</dt>
        <dd><?= $diasTranscurridos?></dd>

        <dt>Fin del periodo de novedad</dt>
        <dd><!-- COMPLETAR --></dd>

        <dt>Estado</dt>
        <dd><!-- COMPLETAR --></dd>
    </dl>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
