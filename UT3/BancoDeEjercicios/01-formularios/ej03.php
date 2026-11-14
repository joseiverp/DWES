<?php
require_once __DIR__ . '/funciones.php';

$titulo = '';
$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';

    if (is_string($entrada)) {
        $titulo = trim($entrada);
    } else {
        $errores['titulo'] = 'El título debe ser texto.';
    }
}

$pruebas = [
    'POST sin titulo' => [],
    'titulo=" Dune "' => ['titulo' => ' Dune '],
    'titulo[]=Dune' => ['titulo' => ['Dune']],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3 - Leer POST sin errores de tipo</title>
</head>
<body>
    <h1>Recibir título</h1>

    <form method="post" action="ej03.php">
        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
        <?php if (isset($errores['titulo'])): ?>
            <span><?= e($errores['titulo']) ?></span>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado del POST</h2>
        <p>Valor preparado para el control: [<?= e($titulo) ?>]</p>
        <p>Errores:</p>
        <pre><?= volcar($errores) ?></pre>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <p><a href="ej03.php">Primera visita (GET)</a></p>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="ej03.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>
</body>
</html>
