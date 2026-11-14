<?php
require_once __DIR__ . '/funciones.php';

$valores = ['titulo' => '', 'autor' => ''];
$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($esPost) {
    foreach (['titulo', 'autor'] as $campo) {
        $entrada = $_POST[$campo] ?? '';

        if (is_string($entrada)) {
            $valores[$campo] = trim($entrada);
        } else {
            $errores[$campo] = 'Debe ser texto.';
        }
    }

    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'Escribe el título.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'El título no puede superar los 120 caracteres.';
        }
    }

    if (!isset($errores['autor']) && $valores['autor'] === '') {
        $errores['autor'] = 'Escribe el autor.';
    }
}

$pruebas = [
    'Título vacío' => ['titulo' => '', 'autor' => 'Frank Herbert'],
    'Título con tres espacios' => ['titulo' => '   ', 'autor' => 'Frank Herbert'],
    'Título "A"' => ['titulo' => 'A', 'autor' => 'Frank Herbert'],
    'Título de 120 caracteres' => ['titulo' => str_repeat('á', 120), 'autor' => 'Frank Herbert'],
    'Título de 121 caracteres' => ['titulo' => str_repeat('á', 121), 'autor' => 'Frank Herbert'],
    'Autor vacío' => ['titulo' => 'Dune', 'autor' => ''],
    'Autor " Ursula K. Le Guin "' => ['titulo' => 'Terramar', 'autor' => ' Ursula K. Le Guin '],
    'Título como array' => ['titulo' => ['Dune'], 'autor' => 'Frank Herbert'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 6 - Validar título y autor</title>
</head>
<body>
    <h1>Título y autor</h1>

    <form method="post" action="ej06.php">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" name="titulo" type="text" value="<?= e($valores['titulo']) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="autor">Autor</label>
            <input id="autor" name="autor" type="text" value="<?= e($valores['autor']) ?>">
            <?php if (isset($errores['autor'])): ?>
                <span><?= e($errores['autor']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>
        <?php foreach ($valores as $campo => $valor): ?>
            <p>
                <?= e($campo) ?>:
                <?= isset($errores[$campo]) ? 'rechazado' : 'aceptado' ?>
                · texto normalizado [<?= e($valor) ?>]
                · <?= mb_strlen($valor, 'UTF-8') ?> caracteres
            </p>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="ej06.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>
</body>
</html>
