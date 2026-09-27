<?php
    /*
    El siguiente fragmento contiene varios errores de sintaxis o de uso básico. Reescríbelo para que
    funcione y explica cada corrección.
    <?php
    $Titulo = "Dune"
    $paginas = "412";
    const max_prestamos = 3;
    $disponible = TRUE
    Echo "Libro: " + $Titulo;
    $puede = $paginas > 400 && $disponible = true;
    */

    $Titulo = "Dune";
    $paginas = 412;
    const MAX_PRESTAMOS = 3;
    $disponible = true;
    echo "Libro: " . $Titulo;
    $puede = $paginas > 400 && $disponible === true;
?>