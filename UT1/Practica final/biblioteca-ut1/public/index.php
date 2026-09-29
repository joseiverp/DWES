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

    <h2>1. Lista todos los libros.</h2>

    <?php foreach($libros as $libro): ?>
        
        <h3><?php echo $libro["titulo"]; ?></h3>

        <p>Id: <?php echo $libro["id"]; ?></p>
        <p>Autor: <?php echo $libro["autor"]; ?></p>
        <p>Género: <?php echo $libro["genero"]; ?></p>
        <p>Páginas: <?php echo $libro["paginas"]; ?></p>
        <p>Disponible: <?php echo $libro["disponible"]; ?></p>
        <p>Fecha de alta: <?php echo $libro["fechaAlta"]; ?></p>
        <br>
    <?php endforeach; ?>
    
    <h2>2. Permite filtrar por genero mediante GET.</h2>
    <?php $genero = $_GET['genero'] ?? 'Genero no encontrado'; ?>

    <?php foreach($libros as $libro): ?>
        <?php if($libro['genero'] === $genero): ?>
            
            <h3><?php echo $libro["titulo"]; ?></h3>
            <p>Id: <?php echo $libro["id"]; ?></p>
            <p>Autor: <?php echo $libro["autor"]; ?></p>
            <p>Género: <?php echo $libro["genero"]; ?></p>
            <p>Páginas: <?php echo $libro["paginas"]; ?></p>
            <p>Disponible: <?php echo $libro["disponible"]; ?></p>
            <p>Fecha de alta: <?php echo $libro["fechaAlta"]; ?></p>
            <br>

        <?php endif; ?>   

    <?php endforeach; ?>
    <br>


    <h2>3. Permite filtrar por disponibilidad mediante GET.</h2>

    <?php
        $disponibilidad = $_GET['disponible'] ?? 'No disponible';
    ?>

    <?php foreach($libros as $libro): ?>
        <?php if($libro['disponible'] === $disponibilidad): ?>
            
            <h3><?php echo $libro["titulo"]; ?></h3>
            <p>Id: <?php echo $libro["id"]; ?></p>
            <p>Autor: <?php echo $libro["autor"]; ?></p>
            <p>Género: <?php echo $libro["genero"]; ?></p>
            <p>Páginas: <?php echo $libro["paginas"]; ?></p>
            <p>Disponible: <?php echo $libro["disponible"]; ?></p>
            <p>Fecha de alta: <?php echo $libro["fechaAlta"]; ?></p>
            <br>
            
        <?php endif; ?>   

    <?php endforeach; ?>

    <h2>4. Permite buscar texto en titulo o autor mediante ?q=.</h2>

    <?php
        $buscarCampo = $_GET['q'] ?? 'Título o Autor no encontrado';
    ?>

    <?php foreach($libros as $libro): ?>
        <?php if($libro['titulo'] === $buscarCampo ||
            $libro['autor'] === $buscarCampo): ?>
            
            <h3><?php echo $libro["titulo"]; ?></h3>
            <p>Id: <?php echo $libro["id"]; ?></p>
            <p>Autor: <?php echo $libro["autor"]; ?></p>
            <p>Género: <?php echo $libro["genero"]; ?></p>
            <p>Páginas: <?php echo $libro["paginas"]; ?></p>
            <p>Disponible: <?php echo $libro["disponible"]; ?></p>
            <p>Fecha de alta: <?php echo $libro["fechaAlta"]; ?></p>
            <br>
            
        <?php endif; ?>   

    <?php endforeach; ?>
    
    <h2>6. Muestra el número de resultados.</h2>

    

</body>
</html>