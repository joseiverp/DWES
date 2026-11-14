<?php
require_once __DIR__ . '/../funciones.php';

$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$mensaje = '';
$despuesDeCambiar = null;

if ($esPost) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email === null) {
        $mensaje = 'El campo email no ha llegado.';
    } elseif ($email === false) {
        $mensaje = 'El correo no es válido.';
    } else {
        $mensaje = 'Correo válido: ' . $email;
    }

    $_POST['email'] = 'cambiado@example.org';
    $despuesDeCambiar = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
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
    <title>Ejercicio 9 - filter_input</title>
</head>
<body>
    <h1>Contacto (variante filter_input)</h1>

    <form method="post" action="filter-input.php">
        <label for="email">Correo</label>
        <input id="email" name="email" type="text">
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>
        <p><?= e($mensaje) ?></p>
        <p>Tras cambiar $_POST['email'] a "cambiado@example.org", filter_input devuelve:</p>
        <pre><?= volcar($despuesDeCambiar) ?></pre>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <?php foreach ($pruebas as $texto => $campos): ?>
        <form method="post" action="filter-input.php">
            <?= camposOcultos($campos) ?>
            <button type="submit"><?= e($texto) ?></button>
        </form>
    <?php endforeach; ?>

    <p><a href="filter-var.php">Ir a la variante filter_var</a></p>
</body>
</html>
