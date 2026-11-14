<?php
require_once __DIR__ . '/../config/funciones.php';

$casos = [
    'Clave portada ausente' => [],
    'UPLOAD_ERR_NO_FILE' => ['portada' => ['name' => '', 'type' => '', 'tmp_name' => '', 'error' => UPLOAD_ERR_NO_FILE, 'size' => 0]],
    'UPLOAD_ERR_OK' => ['portada' => ['name' => 'dune.png', 'type' => 'image/png', 'tmp_name' => '/tmp/php123', 'error' => UPLOAD_ERR_OK, 'size' => 5000]],
    'UPLOAD_ERR_INI_SIZE' => ['portada' => ['name' => 'grande.png', 'type' => 'image/png', 'tmp_name' => '', 'error' => UPLOAD_ERR_INI_SIZE, 'size' => 0]],
    'UPLOAD_ERR_PARTIAL' => ['portada' => ['name' => 'dune.png', 'type' => 'image/png', 'tmp_name' => '', 'error' => UPLOAD_ERR_PARTIAL, 'size' => 0]],
    'Estructura incorrecta (portada[])' => ['portada' => ['name' => ['dune.png'], 'type' => ['image/png'], 'tmp_name' => ['/tmp/php123'], 'error' => [0], 'size' => [5000]]],
];

$respuestas = [];

foreach ($casos as $nombre => $files) {
    $errores = [];
    $recepcion = recibirPortada($files);

    if ($recepcion['estado'] === 'ausente') {
        $respuesta = 'No llega la clave portada: se continúa sin nueva portada.';
    } elseif ($recepcion['estado'] === 'sin-archivo') {
        $respuesta = 'No se ha seleccionado archivo: se continúa sin nueva portada.';
    } elseif ($recepcion['estado'] === 'ok') {
        $respuesta = 'Recepción correcta: se pasa a comprobar tamaño y formato.';
    } else {
        $errores['portada'] = $recepcion['error'];
        $respuesta = 'Error: ' . $errores['portada'] . ' No se examina el MIME ni se mueve el archivo.';
    }

    $respuestas[$nombre] = $respuesta;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 13 - Ausencia y error de recepción</title>
</head>
<body>
    <h1>Respuestas para cada caso preparado</h1>

    <table border="1" cellpadding="6">
        <tr>
            <th>Caso</th>
            <th>Respuesta</th>
        </tr>
        <?php foreach ($respuestas as $caso => $respuesta): ?>
            <tr>
                <td><?= e($caso) ?></td>
                <td><?= e($respuesta) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
