<?php
    // Crea un DateTimeImmutable con el momento actual y calcula una fecha de devolución 15 días
    // después. Muestra ambas fechas.

    $momentoActual = new DateTimeImmutable();
    $devolucion = $momentoActual->modify('+15 days');

    echo "Momento actual: " . $momentoActual->format('d/m/Y') . "<br>";
    echo "Fecha de devolución: " . $devolucion->format('d/m/Y');