<?php
require_once __DIR__ . '/funciones.php';

$entrada = $_GET['q'] ?? '';
$q = is_string($entrada) ? trim($entrada) : '';
$error = is_string($entrada) ? null : 'La búsqueda no es una entrada válida.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 4 - Buscar mediante GET</title>
</head>
<body>
    <h1>Buscar libros</h1>

    <form method="get" action="ej04.php">
        <label for="q">Buscar</label>
        <input id="q" name="q" type="search" value="<?= e($q) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($error !== null): ?>
        <p><?= e($error) ?></p>
    <?php elseif ($q === ''): ?>
        <p>No has escrito ninguna búsqueda.</p>
    <?php else: ?>
        <p>Has buscado: <strong><?= e($q) ?></strong></p>
    <?php endif; ?>

    <h2>Pruebas</h2>
    <ul>
        <li><a href="ej04.php">Sin q</a></li>
        <li><a href="ej04.php?q=Dune">q=Dune</a></li>
        <li><a href="ej04.php?q[]=Dune">q[]=Dune</a></li>
        <li><a href="ej04.php?q=%3Cb%3EDune%3C%2Fb%3E">q=&lt;b&gt;Dune&lt;/b&gt;</a></li>
    </ul>
</body>
</html>
