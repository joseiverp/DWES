<?php
require_once __DIR__ . '/../src/archivos.php';

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = $metodo === 'POST';

$anterior = null;
if (isset($_GET['anterior'])) {
    if (!cartelValido($_GET['anterior'])) {
        http_response_code(404);
        exit('Cartel no encontrado.');
    }
    $anterior = $_GET['anterior'];
}
$esSustitucion = $anterior !== null;

$error = null;
$mensaje = null;
$nuevo = null;

if ($esPost) {
    $tamanoPeticion = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);

    if ($tamanoPeticion > LIMITE_POST) {
        $error = 'El envío supera el tamaño máximo que admite el servidor (8 MiB).';
    } else {
        $archivo = $_FILES['imagen'] ?? null;
        $validacion = validarImagen($archivo);

        if ($validacion['error'] !== null) {
            $error = $validacion['error'];
        } elseif ($validacion['extension'] === null) {
            if ($esSustitucion) {
                $mensaje = 'No se ha cambiado el cartel.';
            } else {
                $error = 'Selecciona una imagen.';
            }
        } else {
            $resultado = $esSustitucion
                ? sustituirCartel($archivo['tmp_name'], $validacion['extension'], $anterior)
                : guardarImagen($archivo['tmp_name'], $validacion['extension']);

            if ($resultado['error'] !== null) {
                $error = $resultado['error'];
            } else {
                $nuevo = $resultado['nombre'];
                $mensaje = $esSustitucion ? 'Cartel sustituido correctamente.' : 'Cartel guardado correctamente.';
            }
        }
    }
}

$accion = $esSustitucion ? 'subir.php?anterior=' . $anterior : 'subir.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $esSustitucion ? 'Sustituir cartel' : 'Subir cartel' ?></title>
</head>
<body>
    <h1><?= $esSustitucion ? 'Sustituir cartel' : 'Subir cartel' ?></h1>

    <?php if ($mensaje !== null): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>

    <?php if ($nuevo !== null): ?>
        <img src="imagen.php?nombre=<?= e($nuevo) ?>" alt="Cartel <?= e($nuevo) ?>" width="300">
        <p><?= e($nuevo) ?></p>
    <?php else: ?>
        <?php if ($esSustitucion): ?>
            <p>Cartel actual:</p>
            <img src="imagen.php?nombre=<?= e($anterior) ?>" alt="Cartel actual <?= e($anterior) ?>" width="300">
        <?php endif; ?>

        <form action="<?= e($accion) ?>" method="post" enctype="multipart/form-data">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg,image/png,image/webp">

            <?php if ($error !== null): ?>
                <p><?= e($error) ?></p>
            <?php endif; ?>

            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <a href="index.php">Volver a la galería</a>
</body>
</html>
