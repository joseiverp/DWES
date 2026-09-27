<?php
/*
Indica qué tipo tiene cada valor y escribe después una conversión explícita adecuada cuando tenga
sentido
*/
    $a = 25;    // Entero
    $b = 25.0;  // Decimal 
    $c = "25";  // String
    $d = true;  // boolean
    $e = null;  // null

    $numero = (int)$c;
    $decimal = (float)$a;
    $texto = (string)$b;
    $booleano = (bool)$a;
?>