<?php
    //Tienes dos arrays de novedades.
    $novedades1 = [1, 2, 3];
    $novedades2 = [4, 5, 6];

    // Combínalos con array_merge.
    $todasNovedades = array_merge($novedades1, $novedades2);

    // Elimina posibles posiciones que ya no sean consecutivas después de un unset
    unset($todasNovedades[1]);

    $todasNovedades = array_values($todasNovedades);

    // muestra el resultado final con índices consecutivos.
    foreach ($todasNovedades as $novedades) echo $novedades . "<br>";
    ?>