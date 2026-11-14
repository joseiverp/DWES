<?php
require_once __DIR__ . '/../funciones.php';

$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$valor = '';
$mensaje = '';

if ($esPost) {
    $entrada = $_POST['email'] ?? null;

    if ($entrada === null) {
        $mensaje = 'El campo email no ha llegado.';
    } elseif (!is_string($entrada)) {
        $mensaje = 'El correo debe ser texto.';
    } else {
        $valor = trim($entrada);
        $email = filter_var($valor, FILTER_VALIDATE_EMAIL);
        $mensaje = $email === false ? 'El correo no es válido.' : 'Correo válido: ' . $email;
    }
}

$pruebas = [
    '"lector@example.org"' => ['email' => 'lector@example.org'],
    '" lector@example.org "' => ['email' => ' lector@example.org '],
    '"lector@"' => ['email' => 'lector@'],
    'Sin campo email' => [],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 9 - filter_var</title>
</head>
<body>
    <h1>Contacto (variante $_POST + filter_var)</h1>

    <form method="post" action="filter-var.php">
        <label for="email">Correo</label>
        <input id="email" name="email" type="text" value="<?= e($valor) ?>">
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="filter-var.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>

    <p><a href="filter-input.php">Ir a la variante filter_input</a></p>
</body>
</html>
