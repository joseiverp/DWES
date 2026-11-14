<?php
require_once __DIR__ . '/../config/funciones.php';

$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$titulo = '';
$portada = null;
$estructuraCorrecta = false;

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    $titulo = is_string($entrada) ? trim($entrada) : '';
    $portada = $_FILES['portada'] ?? null;
    $estructuraCorrecta = estructuraValida($portada);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 12 - Recibir una portada</title>
</head>
<body>
    <h1>Recibir portada</h1>

    <h2>Envío normal (name="portada")</h2>
    <form method="post" action="ej12.php" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
        </p>
        <p>
            <label for="portada">Portada</label>
            <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
        </p>
        <button type="submit">Enviar</button>
    </form>

    <h2>Envío con name="portada[]"</h2>
    <form method="post" action="ej12.php" enctype="multipart/form-data">
        <input name="titulo" type="hidden" value="Dune">
        <input name="portada[]" type="file" accept="image/jpeg,image/png,image/webp">
        <button type="submit">Enviar como array</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>
        <p>Título recibido en $_POST: [<?= e($titulo) ?>]</p>

        <?php if ($portada === null): ?>
            <p>No ha llegado la clave portada en $_FILES.</p>
        <?php elseif (!$estructuraCorrecta): ?>
            <p>La portada no tiene la estructura de un único archivo:</p>
            <pre><?= e(print_r($portada, true)) ?></pre>
        <?php else: ?>
            <p>Estructura correcta.</p>
            <ul>
                <li>error: <?= $portada['error'] ?></li>
                <li>size: <?= $portada['size'] ?> bytes</li>
                <li>name (lo envía el cliente, no es fiable): <?= e((string) $portada['name']) ?></li>
                <li>type (lo envía el cliente, no es fiable): <?= e((string) $portada['type']) ?></li>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
