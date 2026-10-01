<?php
    $factor = 3;
    
    $multiplicar = fn (int $n): int => $n * $factor;

    $resultado = $multiplicar(10);

    echo $resultado;
?>