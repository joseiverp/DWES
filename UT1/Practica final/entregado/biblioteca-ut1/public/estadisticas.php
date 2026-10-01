<?php
    declare(strict_types=1);
    require_once __DIR__ . "/../src/datos.php";
    require_once __DIR__ . "/../src/funciones.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas PHP</title>
</head>
<body>
    <h2>1. Número total de libros.</h2>
    <?php $numLibros = 0;?>

    <?php foreach($libros as $libro): ?>
        <?php $numLibros +=1;?>     
    <?php endforeach; ?>
    <p>Numero total de libros: <?php echo $numLibros; ?></p>
</body>
</html>