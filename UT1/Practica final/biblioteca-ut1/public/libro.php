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

    <h2>1. Lee el id mediante GET</h2>

    <?php
        $id = $_GET['id'] ?? 'Id no encontrado'; 
        $id = (int)$id;
    ?>

    <?php foreach(buscarPorId($libros, $id) as $libro): ?>
        <?php if($libro['id'] === $id): ?>
            <h3><?php echo "hola" ?></h3>

        <?php endif; ?>

    <?php endforeach; ?>

    

</body>
</html>