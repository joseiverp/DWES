<?php
    /* 
    A partir de un catálogo, muestra libros disponibles con menos de 500 páginas. Cuenta además cuántos
    cumplen ambas condiciones.
    */

    $libro1 = [
        'titulo' => 'La Odisea',
        'autor' => 'Juan Pedro',
        'paginas' => 100,
        'disponible' => true
    ];

    $libro2 = [
        'titulo' => 'La camba',
        'autor' => 'Jose Miguel',
        'paginas' => 501,
        'disponible' => false
    ];

    $libro3 = [
        'titulo' => 'Seleccion',
        'autor' => 'Luis Miguel',
        'paginas' => 600,
        'disponible' => false
    ];

    $libro4 = [
        'titulo' => 'Saslion',
        'autor' => 'Laura Monsta',
        'paginas' => 120,
        'disponible' => true
    ];

    $catalogo = [$libro1, $libro2, $libro3, $libro4];

    $contador = 0;

    foreach($catalogo as $libro) {
        if ($libro['disponible'] && $libro['paginas'] < 500) {
            echo $libro['titulo'] . "<br>";
            $contador++;
        }
    }
    echo "Numero de libros: " . $contador;
?>