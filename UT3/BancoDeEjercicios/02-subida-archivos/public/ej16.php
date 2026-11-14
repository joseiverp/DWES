<?php
require_once __DIR__ . '/../config/funciones.php';

$extension = MIMES_PERMITIDOS['image/png'];
$destino = prepararDestino($extension);
$nombre = $destino['nombre'];

$base = $nombre === null ? '' : pathinfo($nombre, PATHINFO_FILENAME);
$baseCorrecta = preg_match('/\A[a-f0-9]{32}\z/', $base) === 1;
$directorio = directorioPortadas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 16 - Nombre y destino controlados</title>
</head>
<body>
    <h1>Nombre y destino para un archivo image/png</h1>

    <?php if ($destino['error'] !== null): ?>
        <p>Error de preparación: <?= e($destino['error']) ?></p>
    <?php else: ?>
        <ul>
            <li>Nombre generado: <?= e($nombre) ?></li>
            <li>Parte anterior a la extensión: <?= e($base) ?> (<?= strlen($base) ?> caracteres)</li>
            <li>¿32 caracteres hexadecimales? <?= $baseCorrecta ? 'Sí' : 'No' ?></li>
            <li>Destino: storage/portadas/<?= e($nombre) ?></li>
            <li>¿Ya existe un archivo con ese nombre? <?= file_exists($destino['ruta']) ? 'Sí' : 'No' ?></li>
        </ul>
    <?php endif; ?>

    <h2>Directorio storage/portadas</h2>
    <ul>
        <li>¿Existe? <?= is_dir($directorio) ? 'Sí' : 'No' ?></li>
        <li>¿PHP puede escribir? <?= is_writable($directorio) ? 'Sí' : 'No' ?></li>
    </ul>

    <p><a href="ej16.php">Generar otro nombre</a></p>
</body>
</html>
