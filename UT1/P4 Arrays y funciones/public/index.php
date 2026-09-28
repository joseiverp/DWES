<?php

    require_once __DIR__ . "/../src/datos.php";
    require_once __DIR__ . "/../src/funciones.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de libros</title>
</head>
<body>
    <h1>Catálogo de libros</h1>

    <?php foreach($libros as $libro): ?>
        
        <h2><?php echo $libro["titulo"]; ?></h2>

        <p>Autor: <?php echo $libro["autor"]; ?></p>
        <p>Género: <?php echo $libro["genero"]; ?></p>
        <p>Páginas: <?php echo $libro["paginas"]; ?></p>
    <?php endforeach; ?>
</body>
</html>