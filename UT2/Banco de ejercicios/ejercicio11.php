<?php

    $catalogo = [
        ['titulo' => 'Dune', 'paginas' => 412],
        ['titulo' => 'It', 'paginas' => 1504],
        ['titulo' => 'Drácula', 'paginas' => 336],
    ];

    $clave = array_search(
        'terror',
        $generos,
        true,
    );
    if ($clave !== false) {
        echo $clave;
    }

    // 1


    // hacer hasta el ejercicio 13, para la proxima clase: 06/10/26
?>