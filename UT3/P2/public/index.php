<?php
require_once __DIR__ . '/../src/archivos.php';

$carteles = listarCarteles();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de carteles</title>
</head>
<body>
    <h1>Galería de carteles</h1>

    <a href="subir.php">Subir cartel</a>

    <?php if ($carteles === false): ?>
        <p>No se ha podido cargar la galería.</p>
    <?php elseif ($carteles === []): ?>
        <p>Todavía no hay carteles</p>
    <?php else: ?>
        <?php foreach ($carteles as $nombre): ?>
            <div>
                <img src="imagen.php?nombre=<?= e($nombre) ?>" alt="Cartel <?= e($nombre) ?>" width="300">
                <p><?= e($nombre) ?></p>
                <a href="subir.php?anterior=<?= e($nombre) ?>">Sustituir</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
