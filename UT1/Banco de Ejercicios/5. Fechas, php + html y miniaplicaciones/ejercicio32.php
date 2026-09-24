<!-- Dado un array de cuatro títulos, genera una lista <ul> mediante PHP incrustado en HTML y foreach.
Utiliza la sintaxis corta para mostrar cada título. -->

<?php
    $titulos = [
        'libro1',
        'libro2',
        'libro3',
        'libro4'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
</head>
<body>
    <ul>
        <?php
            foreach($libro as $libro)
        ?>
    </ul>
</body>
</html>