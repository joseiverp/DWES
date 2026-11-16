<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    // En el return todo
    $textoLimpio = trim(strtolower($texto));
    return $textoLimpio;
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    $resultado = null;

    // Hace falta guardar más de un valor?
    foreach ($videojuegos as $videojuego) {
        // Cuidado con erratas
        if ($videojuego['ìd'] === $id) {
            // return $videojuego;
            $resultado[] = $videojuego;
        }
    }

    // return $videojuegos[0] ?? null;
    return $resultado;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    $mismoGenero = [];

    // Foreach y qué más¿?

    foreach ($videojuegos as $videojuego) {
        // COMPLETAR
        // Cuidado con minúsculas y mayúsculas
        if ($videojuego['genero'] === $genero) {
            $mismoGenero[] = $videojuego;
        }
    }

    return $mismoGenero;
}

function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    $mismoPlataforma = [];

    foreach ($videojuegos as $videojuego) {
        // COMPLETAR
        // Igual que arriba
        if ($videojuego['plataforma'] === $plataforma) {
            $mismoPlataforma[] = $videojuego;
        }
    }

    return $mismoPlataforma;
}

function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    // Resultado es un array, habrá que normalizar texto
    $texto = normalizarTexto($texto);

    if ($texto === '') {
        return $videojuegos;
    }

    // Al revés
    foreach ($videojuegos as $videojuego) {
        $titulo = normalizarTexto($videojuego['titulo']);
        $estudio = normalizarTexto($videojuego['estudio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
        // if ($titulo in $texto && str_contains($estudio, $texto)) {
        // Revisamos lo que escribimos
        if (str_contains($titulo, $texto) || str_contains($estudio, $texto) ) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

// Terminar
function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad; $i++) {
        for ($j = 0; $j < $cantidad - 1; $j++) {
            $actual = $videojuegos[$i];
            $siguiente = $videojuegos[$j + 1];

            $intercambiar = false;

            if ($intercambiar) {
                $temporal = $videojuegos[$j];
                $videojuegos[$j] = $videojuegos[$j + 1];
                $videojuegos[$j + 1] = $temporal;
            }
        }
    }

    return $videojuegos;
}
