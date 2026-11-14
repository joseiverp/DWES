<?php
require_once __DIR__ . '/funciones.php';

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$paginas = null;
$guardado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (array_keys($valores) as $campo) {
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

    if (!isset($errores['paginas'])) {
        $numero = filter_var($valores['paginas'], FILTER_VALIDATE_INT);

        if ($numero === false || $numero < 1 || $numero > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        } else {
            $paginas = $numero;
        }
    }

    $guardado = $errores === [];
}

$pruebas = [
    'Dune con paginas="12abc"' => ['titulo' => 'Dune', 'paginas' => '12abc'],
    'Título con comillas' => ['titulo' => 'El "gran" libro', 'paginas' => '0'],
    'Título como array' => ['titulo' => ['Dune'], 'paginas' => '412'],
    'Envío válido' => ['titulo' => 'Dune', 'paginas' => '412'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 11 - Formulario completo</title>
</head>
<body>
    <h1>Nuevo libro</h1>

    <?php if ($guardado): ?>
        <p>Libro guardado: <strong><?= e($valores['titulo']) ?></strong> con <?= $paginas ?> páginas.</p>
        <p><a href="ej11.php">Añadir otro libro</a></p>
    <?php else: ?>
        <form method="post" action="ej11.php">
            <p>
                <label for="titulo">Título</label>
                <input id="titulo" name="titulo" type="text" value="<?= e($valores['titulo']) ?>">
                <?php if (isset($errores['titulo'])): ?>
                    <span><?= e($errores['titulo']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="paginas">Páginas</label>
                <input id="paginas" name="paginas" type="number" min="1" max="3000" value="<?= e($valores['paginas']) ?>">
                <?php if (isset($errores['paginas'])): ?>
                    <span><?= e($errores['paginas']) ?></span>
                <?php endif; ?>
            </p>
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="ej11.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>
</body>
</html>
