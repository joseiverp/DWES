<?php
require_once __DIR__ . '/../config/funciones.php';

$portadas = portadasGuardadas();
$pruebas = [
    'Nombre inexistente' => str_repeat('0', 32) . '.png',
    'Recorrido de directorios' => '../secreto.txt',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 18 - Servir portadas</title>
</head>
<body>
    <h1>Portadas guardadas en storage/portadas</h1>

    <?php if ($portadas === []): ?>
        <p>Todavía no hay portadas.</p>
    <?php endif; ?>

    <?php foreach ($portadas as $nombre): ?>
        <figure>
            <img src="/portada.php?nombre=<?= e($nombre) ?>" alt="Portada" width="100">
            <figcaption><?= e($nombre) ?></figcaption>
        </figure>
    <?php endforeach; ?>

    <h2>Pruebas que deben responder 404</h2>
    <ul>
        <?php foreach ($pruebas as $texto => $nombre): ?>
            <li>
                <a href="/portada.php?nombre=<?= e(urlencode($nombre)) ?>"><?= e($texto) ?>: <?= e($nombre) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
