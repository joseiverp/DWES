<?php

if ($videojuego === null) {
    // Completa el tratamiento del caso en el que el videojuego no existe.
    ?>
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Videojuego no encontrado</title>
    </head>
    <body>
    </body>
    </html>
    <?php
    exit;
}

// Prepara las fechas y los valores que necesita la ficha.
$fechaLanzamiento = ;// De dónde saco la fecha??
$hoy = new DateTimeImmutable();
$diasTranscurridos = 0; //0? Habrá que calcular algo, no?
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
        <dd><!-- COMPLETAR --></dd>

        <dt>Días desde el lanzamiento</dt>
        <dd><!-- COMPLETAR --></dd>

        <dt>Fin del periodo de novedad</dt>
        <dd><!-- COMPLETAR --></dd>

        <dt>Estado</dt>
        <dd><!-- COMPLETAR --></dd>
    </dl>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
