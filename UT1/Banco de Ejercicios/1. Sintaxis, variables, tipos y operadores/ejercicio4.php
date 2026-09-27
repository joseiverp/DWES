<?php
/*
Sin ejecutar el código, indica el valor final de cada variable y explica especialmente la diferencia
entre == y ===.
*/
    $a = (5 == "5");        // = true                Comparamos valores                   
    $b = (5 === "5");       // = false               Comprobamos valores y tipo de dato
    $c = (10 > 5 && 3 < 2); // = false               No se cumplen ambas condiciones
    $d = !$b || $c;         // = true                
?>