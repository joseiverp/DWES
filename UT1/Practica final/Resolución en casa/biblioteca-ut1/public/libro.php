<?php
    declare(strict_types=1);

    require_once __DIR__ . '\..\src\datos.php';
    require_once __DIR__ . '\..\src\funciones.php';

    $id = $_GET['id'] ?? null;

    $libro = null;

    if ($id !== null) {
        $id = (int) $id;
        $libro= buscarPorId($catalogo, $id);
    }
    if($libro === null){
        echo 'No se ha encontrado un libro asociado a ese id';
    }else {
        foreach ($libro as $clave => $valor) {
            if ($clave === 'disponible') {
                echo $clave . ': ' . ($valor ? 'Disponible' : 'No disponible') . '<br>';
            } else {
                echo $clave . ': ' . $valor . '<br>';
            }
        }

    }

?>