<?php
require_once __DIR__ . '/../funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1 - libro-editar.php</title>
</head>
<body>
    <h1>Petición a libro-editar.php</h1>

    <p>REQUEST_METHOD: <strong><?= e($_SERVER['REQUEST_METHOD']) ?></strong></p>

    <h2>$_GET (parámetros de la URL)</h2>
    <pre><?= volcar($_GET) ?></pre>

    <h2>$_POST (cuerpo de la petición)</h2>
    <pre><?= volcar($_POST) ?></pre>

    <form method="post" action="libro-editar.php?id=3">
        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" type="text" value="Solaris">
        <button type="submit">Enviar POST a libro-editar.php?id=3</button>
    </form>

    <p><a href="libros.php">Volver a libros.php</a></p>
</body>
</html>
