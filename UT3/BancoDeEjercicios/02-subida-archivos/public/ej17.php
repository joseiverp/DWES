<?php
require_once __DIR__ . '/../config/funciones.php';

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$paginas = null;
$portadaActual = null;
$guardado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ficha = leerFicha($_POST);
    $valores = $ficha['valores'];
    $errores = $ficha['errores'];
    $paginas = $ficha['paginas'];

    $portada = comprobarPortada($_FILES);
    if ($portada['error'] !== null) {
        $errores['portada'] = $portada['error'];
    }

    if ($errores === [] && $portada['extension'] !== null) {
        $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
        $directorio = $simularFallo ? directorioPortadas() . '/no-existe' : null;
        $destino = prepararDestino($portada['extension'], $directorio);

        if ($destino['error'] !== null) {
            $errores['portada'] = $destino['error'];
        } elseif (move_uploaded_file($portada['tmp'], $destino['ruta'])) {
            $portadaActual = $destino['nombre'];
        } else {
            $errores['portada'] = 'No se pudo guardar la portada.';
        }
    }

    $guardado = $errores === [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 17 - Mover solo una operación válida</title>
</head>
<body>
    <h1>Nuevo libro con portada</h1>

    <?php if ($guardado): ?>
        <p>Libro guardado: <strong><?= e($valores['titulo']) ?></strong> con <?= $paginas ?> páginas.</p>
        <p>Portada: <?= $portadaActual === null ? 'sin portada' : e($portadaActual) ?></p>
        <p><a href="ej17.php">Añadir otro libro</a></p>
    <?php else: ?>
        <form method="post" action="ej17.php" enctype="multipart/form-data">
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
                <label for="portada">Portada (opcional, JPEG, PNG o WebP, máximo 2 MiB)</label>
                <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
                <?php if (isset($errores['portada'])): ?>
                    <span><?= e($errores['portada']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="simularFallo" value="1">
                    Simular fallo al preparar el destino
                </label>
            </p>
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>
</body>
</html>
