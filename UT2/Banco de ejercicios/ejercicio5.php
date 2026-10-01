<?php
    $catalogo = [
        ['titulo' => 'Dune', 'paginas' => 412],
        ['titulo' => 'It', 'paginas' => 1504],
        ['titulo' => 'Drácula', 'paginas' => 336],
    ];

    $etiquetas = array_map(
        fn (array $libro): string  => "{libro['titulo']} - {libro['paginas'} páginas",
        $catalogo 
    );
    
    print_r($etiquetas);
?>