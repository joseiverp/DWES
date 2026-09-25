<?php
    const LIMITE_LEVE = 3;
    const LIMITE_GRAVE = 4;

    $tipo = $_GET['tipo'] ?? 'externo';
    $dias = $_GET['dias'] ?? 0;
    $renovacion = $_GET['renovacion'] ?? 'no';

    $dias = (int)$dias;

    $maxDias = match($tipo) {
        'alumno' => 15,
        'profesor' => 30,
        'externo' => 7
    };

    if ($renovacion === 'si' && $tipo != 'externo') {
        $maxDias += 7; 
    }
    
    if ($dias > $maxDias) {
        $diasRetraso = $dias - $maxDias;
    }

    echo $tipo . '<br>';
    echo $dias . '<br>';
    echo $renovacion . '<br>';
    echo $maxDias;


?>