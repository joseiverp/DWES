<?php
require_once __DIR__ . '/funciones.php';

$paginasTexto = '';
$paginas = null;
$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($esPost) {
    $entrada = $_POST['paginas'] ?? '';

    if (!is_string($entrada)) {
        $errores['paginas'] = 'Debe ser texto.';
    } else {
        $paginasTexto = trim($entrada);
        $numero = filter_var($paginasTexto, FILTER_VALIDATE_INT);

        if ($numero === false) {
            $errores['paginas'] = 'Escribe un número entero.';
        } elseif ($numero < 1 || $numero > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        } else {
            $paginas = $numero;
        }
    }
}

$pruebas = [
    '"1"' => ['paginas' => '1'],
    '"3000"' => ['paginas' => '3000'],
    '"0"' => ['paginas' => '0'],
    '"3001"' => ['paginas' => '3001'],
    '"12abc"' => ['paginas' => '12abc'],
    '"12.5"' => ['paginas' => '12.5'],
    'Array' => ['paginas' => ['412']],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 7 - Validar páginas antes de convertir</title>
</head>
<body>
    <h1>Páginas</h1>

    <p>Con el fragmento original, (int) "12abc" vale <?= (int) '12abc' ?>, por eso se aceptaba.</p>

    <form method="post" action="ej07.php">
        <label for="paginas">Páginas</label>
        <input id="paginas" name="paginas" type="text" value="<?= e($paginasTexto) ?>">
        <?php if (isset($errores['paginas'])): ?>
            <span><?= e($errores['paginas']) ?></span>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $paginas !== null): ?>
        <p>Número aceptado: <?= $paginas ?> (<?= gettype($paginas) ?>)</p>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="ej07.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>
</body>
</html>
