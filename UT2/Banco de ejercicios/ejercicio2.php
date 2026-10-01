<?php

$iva = 0.21;

$calcularPrecio = function (float $precio) use ($iva): float
{
    return $precio * (1 + $iva);
};

$resultado = $calcularPrecio(100.0);

echo $resultado;