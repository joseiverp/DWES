<?php

declare(strict_types=1);

$archivo = $_FILES['portada'] ?? null;
$estructuraValida = is_array($archivo)
    && isset($archivo['error'], $archivo['size'])
    && is_int($archivo['error'])
    && is_int($archivo['size'])
    && isset($archivo['tmp_name'])
    && is_string($archivo['tmp_name']);

    if ($archivo !== null && !$estructuraValida) {
        $errores['portada'] = 'Entrada no válida.';
    }

    if ($archivo['error'] === UPLOAD_ERR_OK)
?>

<form method="post" enctype="multipart/form-data">
    <input name="titulo">
    <input name="portada" type="file" accept="image/jpeg,image/png,image/webp">
    <button type="submit">Guardar</button>
</form>

