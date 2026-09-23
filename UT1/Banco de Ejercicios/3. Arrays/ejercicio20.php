<?php
    // Dado un array numérico con las páginas de ocho libros.
    $paginas = [133, 472, 42, 425, 673, 734, 743, 77];
    
    //ordénalo de menor a mayor.
    sort($paginas);
    
    // Muestra mínimo, máximo y media.
    $minimo = min($paginas);
    $maximo = max($paginas);
    $cantidad = count($paginas);

    echo "minimo: " . $minimo . "<br>";
    echo "maximo: " . $maximo;
    
    //  calcula la suma recorriendo el array.
?>