<?php
    // Muestra el timestamp actual y la fecha actual con formato dd/mm/AAAA HH:mm.
    // Configura Europe/Madrid antes de formatear
    
    date_default_timezone_set('Europe/Madrid');
    
    $ahora = time();

    echo "Timestamp actual: " . $ahora . "<br>";

    echo "Fecha actual: " . date('d/m/Y H:i', $ahora);