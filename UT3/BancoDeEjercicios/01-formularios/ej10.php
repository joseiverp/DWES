<?php
require_once __DIR__ . '/funciones.php';

$fechaTexto = '';
$fecha = null;
$errores = [];
$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($esPost) {
    $entrada = $_POST['fechaAlta'] ?? '';

    if (!is_string($entrada)) {
        $errores['fechaAlta'] = 'Debe ser texto.';
    } else {
        $fechaTexto = trim($entrada);

        if ($fechaTexto !== '') {
            try {
                $creada = DateTimeImmutable::createFromFormat('!Y-m-d', $fechaTexto);
            } catch (ValueError) {
                $creada = false;
            }

            if ($creada === false || $creada->format('Y-m-d') !== $fechaTexto) {
                $errores['fechaAlta'] = 'Fecha no válida.';
            } else {
                $fecha = $creada;
            }
        }
    }
}

$pruebas = [
    'Cadena vacía' => ['fechaAlta' => ''],
    '2026-10-24' => ['fechaAlta' => '2026-10-24'],
    '2026-02-31' => ['fechaAlta' => '2026-02-31'],
    '24/10/2026' => ['fechaAlta' => '24/10/2026'],
    'Array' => ['fechaAlta' => ['2026-10-24']],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 10 - Fecha opcional</title>
</head>
<body>
    <h1>Fecha de alta</h1>

    <form method="post" action="ej10.php">
        <label for="fechaAlta">Fecha de alta (opcional)</label>
        <input id="fechaAlta" name="fechaAlta" type="text" placeholder="AAAA-MM-DD" value="<?= e($fechaTexto) ?>">
        <?php if (isset($errores['fechaAlta'])): ?>
            <span><?= e($errores['fechaAlta']) ?></span>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <h2>Resultado</h2>
        <?php if ($fecha === null): ?>
            <p>Sin fecha: el valor es null.</p>
        <?php else: ?>
            <p>Fecha válida: objeto <?= e(get_class($fecha)) ?> con valor <?= e($fecha->format('Y-m-d')) ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <p>Sin la comparación final, PHP convertiría 2026-02-31 en
        <?= e(DateTimeImmutable::createFromFormat('!Y-m-d', '2026-02-31')->format('Y-m-d')) ?>.</p>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="ej10.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>
</body>
</html>
