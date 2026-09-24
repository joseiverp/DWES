<!-- Dado un array de cuatro títulos, genera una lista <ul> mediante PHP incrustado en HTML y foreach.
Utiliza la sintaxis corta para mostrar cada título. -->

<?php

$titulos = [
    "Dune",
    "1984",
    "El Hobbit",
    "Fundación"
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros</title>
</head>

<body>

    <ul>
        <?php foreach ($titulos as $titulo): ?>
            <li><?= $titulo ?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>


