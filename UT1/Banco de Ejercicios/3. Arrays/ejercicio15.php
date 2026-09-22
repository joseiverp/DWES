<?php
    //Crear un array con cinco generos
    $generos = ["Fantasia", "Terror", "Ciencia ficcion", "Romance", "Historia"];

    // Añadir un sexto sexto genero
    $generos[] = "Comedia";

    // Cambiar el tercer genero
    $generos[2] = 'Anime';

    //eliminar el primero
    unset($generos[0]);

    // Mostrar todos los valores usando foreach
    foreach ($generos as $genero) {
        echo $genero . "<br>";
    }

?>