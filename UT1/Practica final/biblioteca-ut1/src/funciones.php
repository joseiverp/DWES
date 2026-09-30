<?php
    declare(strict_types=1);

    function buscarPorId(array $libros, int $id): ?array {
        foreach ($libros as $libro) {
            if ($libro["id"] === $id) {
                return $libro;
            }
        }
        return null;
    }

    function filtrarPorGenero(array $libros, string $genero): array {
        $resultado = [];

        foreach ($libros as $libro) {
            if ($libro["genero"] === $genero) {
                $resultado[] =$libro;
            }
        }
        return $resultado;
    }

    function filtrarDisponibles(array $libros): array {
        $disponibles = [];

        foreach ($libros as $libro) {
            if($libro["disponible"])
                $disponibles[] = $libro;
        }
        return $disponibles;
    }

    function calcularMediaPaginas(array $libros): float {
        $sumaPaginas = 0;

        if(count($libros) === 0) {
            return 0.0;
        }

        foreach ($libros as $libro) {
            $sumaPaginas += $libro["paginas"];
        }
        $mediaPaginas = $sumaPaginas / count($libros);
        return $mediaPaginas;
    }

    function obtenerLibroMasLargo(array $libros): ?array {

        $libroMasLargo = null;

        foreach ($libros as $libro) {
            if ($libroMasLargo === null || $libro["paginas"] > $libroMasLargo["paginas"]) {
                $libroMasLargo = $libro;
            }
        }

        return $libroMasLargo;
    }

    function ordenarPorTitulo(array $libros): array {
        $ordenados = 0;
}
?>