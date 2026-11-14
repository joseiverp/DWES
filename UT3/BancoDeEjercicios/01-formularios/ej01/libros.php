<?php
require_once __DIR__ . '/../funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1 - libros.php</title>
</head>
<body>
    <h1>Petición a libros.php</h1>

    <p>REQUEST_METHOD: <strong><?= e($_SERVER['REQUEST_METHOD']) ?></strong></p>

    <h2>$_GET</h2>
    <pre><?= volcar($_GET) ?></pre>

    <p><a href="libros.php?q=Dune">Probar GET libros.php?q=Dune</a></p>
    <p><a href="libro-editar.php?id=3">Ir a libro-editar.php?id=3</a></p>
</body>
</html>
