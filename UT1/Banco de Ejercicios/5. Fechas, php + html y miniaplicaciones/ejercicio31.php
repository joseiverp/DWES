<?php
    // Crea dos fechas fijas, 2026-09-01 y 2026-09-18, y usa diff para mostrar cuántos días hay entre ellas.
    $fecha1 = new DateTimeImmutable('2026-09-01');
    $fecha2 = new DateTimeImmutable('2026-09-18');

    $diferencia = $fecha1->diff($fecha2);
    echo "Dias de diferencia: " .  $diferencia->days;