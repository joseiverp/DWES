<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    $textoLimpio = trim(strtolower($texto));
    return $textoLimpio;
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    $resultado = null;

    foreach ($videojuegos as $videojuego) {
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
        if ($videojuego['plataforma'] === $plataforma) {
            $mismoPlataforma[] = $videojuego;
        }
    }

    return $mismoPlataforma;
}

function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    $texto = normalizarTexto($resultado);

    if ($texto === 'null') {
        return $videojuegos;
    }

    foreach ($videojuego as $videojuegos) {
        $titulo = normalizarTexto($videojuego['titulo']);
        $estudio = normalizarTexto($videojuego['estudio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
        // if ($titulo in $texto && str_contains($estudio, $texto)) {
        if (str_containt($titulo, $texto) || str_containt($estudio, $texto) ) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

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
