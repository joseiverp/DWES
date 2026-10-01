<?php
    function aplicar(int $n, callable $callback): int {
        return $callback($n);
    }

    function doble(int $n): int {
        return $n * 2;
    }

    function cuadrado(int $n) {
        return $n * $n;
    }

    $resultado1 = aplicar(5, 'doble');
    $resultado2 = aplicar(5, 'cuadrado');

?>