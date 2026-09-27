<?php
/*
Un libro cuesta 24,90 €. Tiene un descuento del 15 % y después se aplica un IVA del 4 %. Calcula
precio descontado, IVA y precio final. Usa al menos un operador de asignación compuesto.
*/
    $precio = 24.90;
    $descuento = 15;
    $iva = 4;

    $importeDescuento = $precio * $descuento / 100;
    $precioDescontado = $precio - $importeDescuento;

    $importeIva = $precioDescontado * $iva / 100;

    $precioFinal = $precioDescontado;
    $precioFinal += $importeIva;

    echo "Precio descontado: $precioDescontado <br>";
    echo "IVA: $importeIva <br>";
    echo "Precio finanl: $precioFinal <br>"
?>