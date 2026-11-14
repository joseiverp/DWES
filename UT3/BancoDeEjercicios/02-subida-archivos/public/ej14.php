<?php
require_once __DIR__ . '/../config/funciones.php';

$tamanos = [0, 1, 2097152, 2097153];
$directivas = ['upload_max_filesize', 'post_max_size', 'max_file_uploads', 'file_uploads'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 14 - Límite de tamaño</title>
</head>
<body>
    <h1>Límite de tamaño: 2 MiB</h1>

    <table border="1" cellpadding="6">
        <tr>
            <th>Tamaño (bytes)</th>
            <th>Resultado</th>
        </tr>
        <?php foreach ($tamanos as $tamano): ?>
            <tr>
                <td><?= $tamano ?></td>
                <td><?= tamanoValido($tamano) ? 'Aceptado' : 'Rechazado: la portada debe ocupar entre 1 byte y 2 MiB.' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Configuración del PHP que atiende esta petición</h2>
    <ul>
        <?php foreach ($directivas as $directiva): ?>
            <li><?= e($directiva) ?> = <?= e((string) ini_get($directiva)) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
