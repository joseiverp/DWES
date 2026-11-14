<?php
require_once __DIR__ . '/../config/funciones.php';

$portadaActual = '67d1fdf96a80248d69cf0468a7646f3d.png';

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$errorPortada = null;
$erroresGenerales = [];
$paginas = null;
$guardado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ficha = leerFicha($_POST);
    $valores = $ficha['valores'];
    $errores = $ficha['errores'];
    $paginas = $ficha['paginas'];

    $portada = comprobarPortada($_FILES);
    $errorPortada = $portada['error'];

    if ($errores === [] && $errorPortada === null && $portada['extension'] !== null) {
        $destino = prepararDestino($portada['extension']);

        if ($destino['error'] !== null) {
            $erroresGenerales[] = $destino['error'];
        } elseif (move_uploaded_file($portada['tmp'], $destino['ruta'])) {
            $portadaActual = $destino['nombre'];
        } else {
            $erroresGenerales[] = 'No se pudo guardar la portada.';
        }
    }

    $guardado = $errores === [] && $errorPortada === null && $erroresGenerales === [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 21 - Formulario con portada</title>
</head>
<body>
    <h1>Ficha de libro</h1>

    <?php if ($guardado): ?>
        <p>Libro guardado: <strong><?= e($valores['titulo']) ?></strong> con <?= $paginas ?> páginas.</p>
    <?php endif; ?>

    <?php if ($portadaActual !== null): ?>
        <p>Portada actual: <?= e($portadaActual) ?></p>
        <img src="/portada.php?nombre=<?= e($portadaActual) ?>" alt="Portada actual" width="120">
    <?php else: ?>
        <p>Sin portada.</p>
    <?php endif; ?>

    <?php foreach ($erroresGenerales as $error): ?>
        <p><?= e($error) ?></p>
    <?php endforeach; ?>

    <?php if (!$guardado): ?>
        <form method="post" action="ej21.php" enctype="multipart/form-data">
            <p>
                <label for="titulo">Título</label>
                <input id="titulo" name="titulo" type="text" value="<?= e($valores['titulo']) ?>">
                <?php if (isset($errores['titulo'])): ?>
                    <span><?= e($errores['titulo']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="paginas">Páginas</label>
                <input id="paginas" name="paginas" type="text" value="<?= e($valores['paginas']) ?>">
                <?php if (isset($errores['paginas'])): ?>
                    <span><?= e($errores['paginas']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="portada">Nueva portada (opcional, JPEG, PNG o WebP, máximo 2 MiB)</label>
                <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
                <?php if ($errorPortada !== null): ?>
                    <span><?= e($errorPortada) ?></span>
                <?php endif; ?>
            </p>
            <button type="submit">Guardar</button>
        </form>
    <?php else: ?>
        <p><a href="ej21.php">Volver al formulario</a></p>
    <?php endif; ?>
</body>
</html>
