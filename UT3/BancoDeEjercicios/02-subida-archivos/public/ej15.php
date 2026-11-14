<?php
require_once __DIR__ . '/../config/funciones.php';

$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$datos = null;
$errores = [];
$extension = null;

if ($esPost) {
    $recepcion = recibirPortada($_FILES);

    if ($recepcion['estado'] !== 'ok') {
        $errores['portada'] = $recepcion['error'] ?? 'No se ha seleccionado ningún archivo.';
    } else {
        $archivo = $_FILES['portada'];
        $mime = detectarMime($archivo['tmp_name']);
        $datos = [
            'name (cliente)' => (string) $archivo['name'],
            'type (cliente)' => (string) $archivo['type'],
            'MIME detectado por finfo' => $mime === false ? 'no se pudo detectar' : $mime,
        ];

        $comprobacion = comprobarArchivo($archivo['size'], $archivo['tmp_name']);

        if ($comprobacion['error'] !== null) {
            $errores['portada'] = $comprobacion['error'];
        } else {
            $extension = $comprobacion['extension'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 15 - Formato por el contenido</title>
</head>
<body>
    <h1>Detectar el formato por el contenido</h1>

    <form method="post" action="ej15.php" enctype="multipart/form-data">
        <input name="portada" type="file">
        <button type="submit">Comprobar</button>
    </form>

    <?php if ($datos !== null): ?>
        <h2>Datos del archivo</h2>
        <ul>
            <?php foreach ($datos as $clave => $valor): ?>
                <li><?= e($clave) ?>: <?= e($valor) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (isset($errores['portada'])): ?>
        <p>Archivo rechazado: <?= e($errores['portada']) ?></p>
    <?php elseif ($extension !== null): ?>
        <p>Archivo aceptado. Extensión que se usará: <strong><?= e($extension) ?></strong></p>
    <?php endif; ?>
</body>
</html>
