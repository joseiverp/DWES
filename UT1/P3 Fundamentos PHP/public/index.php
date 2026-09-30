<?php
    // Limites para saber si el retraso es leve o grave
    const LIMITE_LEVE = 3;
    const LIMITE_GRAVE = 4;

    // Cogemos los datos de la URL y ponemos un valor por defecto
    $tipo = $_GET['tipo'] ?? 'externo';
    $dias = $_GET['dias'] ?? 0;
    $renovacion = $_GET['renovacion'] ?? 'no';
    
    // Convertimos dias a entero
    $dias = (int)$dias;

    // Para mostrar el tipo de forma segura en HTML
    $tipoSeguro = htmlspecialchars($tipo);

    // Ponemos el limite de dias segun el tipo
    $maxDias = match($tipo) {
        'alumno' => 15,
        'profesor' => 30,
        'externo' => 7 // ppuede cambiar se a 'default'
    };

    // Si tiene renovacion, añadimos 7 dias excepto si es externo
    if ($renovacion === 'si' && $tipo != 'externo') {
        $maxDias += 7; 
    }
    
    // Al principio no hay retraso
    $diasRetraso = 0;

    // Si se pasa del limite calculamos los dias de retraso
    if ($dias > $maxDias) {
        $diasRetraso = $dias - $maxDias;
    }

    // Comprobamos en que situacion se encuentra
    if ($dias === $maxDias) {
        $situacion = 'último día';
    } elseif($dias < $maxDias) {
        $situacion = 'correcta';
    } elseif ($diasRetraso <= LIMITE_LEVE){
        $situacion = 'retraso leve';
    } elseif ($diasRetraso >= LIMITE_GRAVE) {
        $situacion = 'retraso grave';
    }

    // Calculamos la penalizacion
    $penalizacion = $diasRetraso * 0.5;

    // Mostramos la informacion del usuario
    echo "El usuario es $tipoSeguro, ha utilizado $dias días, su límite es de $maxDias días,
    por lo que se encuentra en situación $situacion <br>";

    // Mostramos la penalizacion
    echo "La penalización es de $penalizacion € <br>";

    // Mostramos los dias de retraso, como maximo 10
    for ($i = 1; $i <= $diasRetraso && $i <= 10; $i++) {
        echo "$i días de retraso <br>";
    }

    // Si hay mas de 10 dias ponemos los tres puntos
    if ($diasRetraso > 10) {
        echo '... <br>';
    }

?>