<?php
require_once __DIR__ . '/funciones.php';

$generos = ['ciencia' => 'Ciencia', 'fantasia' => 'Fantasía', 'terror' => 'Terror'];
$valores = ['genero' => '', 'destacado' => false, 'observaciones' => ''];
$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($esPost) {
    $genero = $_POST['genero'] ?? '';
    if (!is_string($genero)) {
        $errores['genero'] = 'Debe ser texto.';
    } elseif (!in_array($genero, array_keys($generos), true)) {
        $errores['genero'] = 'Elige un género válido.';
    } else {
        $valores['genero'] = $genero;
    }

    $destacado = $_POST['destacado'] ?? null;
    if ($destacado === null) {
        $valores['destacado'] = false;
    } elseif ($destacado === '1') {
        $valores['destacado'] = true;
    } else {
        $errores['destacado'] = 'Valor de destacado no válido.';
    }

    $observaciones = $_POST['observaciones'] ?? '';
    if (is_string($observaciones)) {
        $valores['observaciones'] = trim($observaciones);
    } else {
        $errores['observaciones'] = 'Debe ser texto.';
    }
}

$pruebas = [
    'Género "aventura"' => ['genero' => 'aventura', 'destacado' => '1', 'observaciones' => 'Texto <b>con</b> "comillas"'],
    'Género como array' => ['genero' => ['ciencia'], 'observaciones' => 'Prueba'],
    'Destacado "2"' => ['genero' => 'terror', 'destacado' => '2', 'observaciones' => 'Prueba'],
    'Destacado como array' => ['genero' => 'terror', 'destacado' => ['1'], 'observaciones' => 'Prueba'],
    'Observaciones como array' => ['genero' => 'fantasia', 'destacado' => '1', 'observaciones' => ['Prueba']],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 8 - Lista, casilla y texto</title>
</head>
<body>
    <h1>Género, destacado y observaciones</h1>

    <?php if ($esPost && $errores === []): ?>
        <p>
            Datos válidos: género <?= e($valores['genero']) ?>,
            <?= $valores['destacado'] ? 'destacado' : 'no destacado' ?>.
        </p>
    <?php endif; ?>

    <form method="post" action="ej08.php">
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Elige un género</option>
                <?php foreach ($generos as $valor => $texto): ?>
                    <option value="<?= e($valor) ?>" <?= $valores['genero'] === $valor ? 'selected' : '' ?>><?= e($texto) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['genero'])): ?>
                <span><?= e($errores['genero']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label>
                <input type="checkbox" name="destacado" value="1" <?= $valores['destacado'] ? 'checked' : '' ?>>
                Destacado
            </label>
            <?php if (isset($errores['destacado'])): ?>
                <span><?= e($errores['destacado']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="observaciones">Observaciones</label><br>
            <textarea id="observaciones" name="observaciones" rows="4" cols="40"><?= e($valores['observaciones']) ?></textarea>
            <?php if (isset($errores['observaciones'])): ?>
                <span><?= e($errores['observaciones']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="ej08.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>
</body>
</html>
