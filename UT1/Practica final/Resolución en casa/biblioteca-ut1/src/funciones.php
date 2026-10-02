<?php
    
    declare(strict_types=1);

    function buscarPorId(array $libros, int $id): ?array {
        
        foreach($libros as $libro) {
            if($libro['id'] === $id){
                return $libro;
            }
        }

        return null;
    }

    function filtrarPorGenero(array $libros, string $genero): array {
        
        $librosMismoGenero = [];

        foreach($libros as $libro) {
            if($libro['genero'] === $genero) {
                $librosMismoGenero[] = $libro;
            }
        }

        return $librosMismoGenero;
    }

    function filtrarPorDisponibilidad(array $libros, bool $disponible): array {

        $librosDisponibles = [];

        foreach($libros as $libro) {
            if($libro['disponible'] === $disponible) {
                $librosDisponibles[] = $libro;
            }
        }

        return $librosDisponibles;
    }

    function buscarPorTexto(array $libros, string $texto): array {

        $resultado = [];
        $texto = strtolower($texto);

        foreach($libros as $libro) {
            if(str_contains(strtolower($libro['titulo']), $texto) ||
                str_contains(strtolower($libro['autor']), $texto)
            ) {
                $resultado[] = $libro;
            }
        }

        return $resultado;
    }

    function calcularMediaPaginas(array $libros): float {

        if(count($libros) === 0) {
            return 0.0;
        }

        $totalPaginas = 0;

        foreach($libros as $libro) {
            $totalPaginas += $libro['paginas'];
        }

        return $totalPaginas / count($libros);
    }

    function ordenarPorTitulo(array $libros): array{

        $ordenados = $libros;
        $cantidad = count($ordenados);

        for ($i = 0; $i < $cantidad; $i++) {
            for($j = 0; $j < $cantidad - 1; $j++) {
                $libroActual = strtolower($ordenados[$j]['titulo']);
                $libroSiguiente = strtolower($ordenados[$j+1]['titulo']);

                if($libroActual > $libroSiguiente) {
                    $temporal = $ordenados[$j];
                    $ordenados[$j] = $ordenados[$j + 1];
                    $ordenados[$j + 1] = $temporal;
                }
            }
        }

        return $ordenados;
    }

    function ordenarPorPaginas (array $libros): array {

        $ordenado = $libros; 
        $cantidadLibros = count($ordenado);

        for ($i = 0; $i < $cantidadLibros; $i++) {
            for ($j = 0; $j < $cantidadLibros - 1; $j++) {
                $libroActual = $ordenado[$j]['paginas'];
                $libroSiguiente = $ordenado[$j + 1]['paginas'];

                if ($libroActual > $libroSiguiente) {
                    $temporal = $ordenado[$j];
                    $ordenado[$j] = $ordenado [$j + 1];
                    $ordenado[$j + 1] = $temporal;
                }
            }
        }

        return $ordenado;
    }

    function libroMasLargo(array $libros): ?array {
        if(count($libros) === 0){
            return null;
        }

        $libroMasLargo = $libros[0];

        foreach ($libros as $libro) {
            if($libro['paginas'] > $libroMasLargo ['paginas']) {
                $libroMasLargo = $libro;
            }
        }

        return $libroMasLargo;
    }

    function contarPorGenero(array $libros): array {
        $resultado = [];

        foreach($libros as $libro) {
            $genero = $libro['genero'];

            if(isset($resultado[$genero])){
                $resultado[$genero]++;
            } else {
                $resultado[$genero] = 1; 
            }
        }

        return $resultado;
    }
?>