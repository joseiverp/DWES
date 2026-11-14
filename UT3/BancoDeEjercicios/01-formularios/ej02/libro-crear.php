<?php
require_once __DIR__ . '/../funciones.php';

$paginas = $_POST['paginas'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2 - Datos recibidos</title>
</head>
<body>
    <h1>Datos recibidos</h1>

    <h2>$_POST</h2>
    <pre><?= volcar($_POST) ?></pre>

    <p>Tipo con el que llega paginas: <strong><?= e(gettype($paginas)) ?></strong></p>

    <p><a href="formulario.html">Volver al formulario</a></p>
</body>
</html>
