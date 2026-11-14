<?php
require_once __DIR__ . '/../config/funciones.php';

const MAXIMO_PORTADAS = 3;

function estructuraMultipleValida(mixed $archivos): bool
{
    if (!is_array($archivos)) {
        return false;
    }

    foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $clave) {
        if (!isset($archivos[$clave]) || !is_array($archivos[$clave])) {
            return false;
        }
    }

    $indices = array_keys($archivos['name']);

    foreach (['type', 'tmp_name', 'error', 'size'] as $clave) {
        if (array_keys($archivos[$clave]) !== $indices) {
            return false;
        }
    }

    foreach ($indices as $i) {
        if (!is_string($archivos['name'][$i]) || !is_string($archivos['type'][$i])
            || !is_string($archivos['tmp_name'][$i]) || !is_int($archivos['error'][$i])
            || !is_int($archivos['size'][$i])) {
            return false;
        }
    }

    return true;
}

$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$errores = [];
$errorGeneral = null;
$aceptadas = [];

if ($esPost) {
    $archivos = $_FILES['portadas'] ?? null;
    $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
    $validos = [];

    if (!estructuraMultipleValida($archivos)) {
        $errorGeneral = 'Las portadas no tienen la estructura esperada.';
    } else {
        foreach ($archivos['error'] as $i => $codigo) {
            if ($codigo === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            if ($codigo !== UPLOAD_ERR_OK) {
                $errores[$i] = errorRecepcion($codigo);
                continue;
            }

            $comprobacion = comprobarArchivo($archivos['size'][$i], $archivos['tmp_name'][$i]);

            if ($comprobacion['error'] !== null) {
                $errores[$i] = $comprobacion['error'];
            } else {
                $validos[$i] = ['tmp' => $archivos['tmp_name'][$i], 'extension' => $comprobacion['extension']];
            }
        }

        $recibidos = count($validos) + count($errores);

        if ($recibidos === 0) {
            $errorGeneral = 'No has seleccionado ninguna portada.';
        } elseif ($recibidos > MAXIMO_PORTADAS) {
            $errorGeneral = 'Puedes enviar como máximo ' . MAXIMO_PORTADAS . ' portadas.';
            $errores = [];
        }
    }

    if ($errorGeneral === null && $errores === []) {
        $movidas = [];
        $contador = 0;

        foreach ($validos as $i => $valido) {
            $contador++;
            $destino = prepararDestino($valido['extension']);

            if ($destino['error'] !== null) {
                $errorGeneral = $destino['error'];
                break;
            }

            $falloProvocado = $simularFallo && $contador === 2;

            if ($falloProvocado || !move_uploaded_file($valido['tmp'], $destino['ruta'])) {
                $errorGeneral = 'No se pudo guardar la portada ' . ($i + 1) . '. No se ha guardado ninguna.';
                break;
            }

            $movidas[] = $destino['nombre'];
        }

        if ($errorGeneral === null) {
            $aceptadas = $movidas;
        } else {
            foreach ($movidas as $nombre) {
                retirarPortada($nombre);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 20 - Varias portadas</title>
</head>
<body>
    <h1>Subir hasta <?= MAXIMO_PORTADAS ?> portadas</h1>

    <form method="post" action="ej20.php" enctype="multipart/form-data">
        <p>
            <input name="portadas[]" type="file" accept="image/jpeg,image/png,image/webp" multiple>
        </p>
        <p>
            <label>
                <input type="checkbox" name="simularFallo" value="1">
                Provocar un fallo en el segundo movimiento
            </label>
        </p>
        <button type="submit">Subir</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>

        <?php if ($errorGeneral !== null): ?>
            <p><?= e($errorGeneral) ?></p>
        <?php endif; ?>

        <?php foreach ($errores as $i => $error): ?>
            <p>Archivo <?= $i + 1 ?>: <?= e($error) ?></p>
        <?php endforeach; ?>

        <?php if ($aceptadas !== []): ?>
            <p>Portadas guardadas:</p>
            <?php foreach ($aceptadas as $nombre): ?>
                <img src="/portada.php?nombre=<?= e($nombre) ?>" alt="Portada" width="100">
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
