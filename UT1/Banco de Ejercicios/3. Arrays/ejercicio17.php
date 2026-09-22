<?php

// Cada libro debe ser un array asociativo.
$libro1 = [
    'titulo' => 'La Odisea',
    'autor' => 'Bojack Horseman'
];

$libro2 = [
    'titulo' => 'La camba',
    'autor' => 'Juan Sonbra'
];

$libro3 = [
    'titulo' => 'Seleccion',
    'autor' => 'deunchj'
];

$libro4 = [
    'titulo' => 'Saslion',
    'autor' => 'Bosahan'
];

// Crea un array con al menos cuatro libros.
$libros = [
    $libro1,
    $libro2,
    $libro3,
    $libro4
];

// Muestra título y autor de todos los libros.
foreach ($libros as $libro) {
    echo $libro['titulo'] . " - " . $libro['autor'] . "<br>";
}
?>