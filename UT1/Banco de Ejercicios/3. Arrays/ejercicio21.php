<?php
    //Tienes dos arrays de novedades.
    $novedades1 = [1, 2, 3];
    $novedades2 = [4, 5, 6];

    // Combínalos con array_merge.
    $arrayCombinado = array_merge($novedades1, $novedades2);

    // Elimina posibles posiciones que ya no
    // sean consecutivas después de un unset y muestra el resultado final con índices consecutivos.
?>