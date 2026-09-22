<?php
    /* Recorre un catálogo y muestra únicamente los libros cuyo autor sea 'Ursula K. Le Guin'. No uses
    array_filter.
    */
    $libro1 = [
    'titulo' => 'La Odisea',
    'autor' => 'Bojack Horseman'
    ];
    
    $libro2 = [
        'titulo' => 'La camba',
        'autor' => 'Ursula K. Le Guin'
    ];
    
    $libro3 = [
        'titulo' => 'Seleccion',
        'autor' => 'deunchj'
    ];
    
    $libro4 = [
        'titulo' => 'Saslion',
        'autor' => 'Ursula K. Le Guin'
    ];

    $catalogo = [$libro1, $libro2, $libro3, $libro4];

    foreach($catalogo as $libro) {
        if ($libro['autor'] == 'Ursula K. Le Guin') {
            echo $libro['titulo'] . " - " . $libro['autor'] . "<br>";
        }
    }
?>