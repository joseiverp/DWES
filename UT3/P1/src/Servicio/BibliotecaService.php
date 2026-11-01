<?php

declare(strict_types=1);

namespace Jose\Biblioteca\Servicio;

use Jose\Biblioteca\Modelo\Libro;

class BibliotecaService
{
    public function __construct(
        private array $libros
    ) {
    }

    public function todos(): array
    {
        return $this->libros;
    }

    public function agregar(Libro $libro): void
    {
        $this->libros[] = $libro;
    }

    public function filtrar(
        string $q,
        string $genero,
        string $tipo,
        bool $soloDestacados
    ): array {
        $qNormalizado = mb_strtolower(trim($q), 'UTF-8');

        // aplicamos los filtros activos combinados con AND
        $filtrados = array_filter($this->libros, function (Libro $libro) use ($qNormalizado, $genero, $tipo, $soloDestacados): bool {
            $filtroQ = ($qNormalizado === '')
                || str_contains(mb_strtolower($libro->getTitulo(), 'UTF-8'), $qNormalizado)
                || str_contains(mb_strtolower($libro->getAutor(), 'UTF-8'), $qNormalizado);

            $filtroGenero = ($genero === '') || ($libro->getGenero() === $genero);
            $filtroTipo = ($tipo === '') || ($libro->getTipo() === $tipo);
            $filtroDestacados = !$soloDestacados || $libro->getDestacado();

            return $filtroQ && $filtroGenero && $filtroTipo && $filtroDestacados;
        });

        return array_values($filtrados);
    }

    public function filas(array $libros): array
    {
        return array_map(function (Libro $libro): array {
            $fecha = $libro->getFechaAlta();
            return [
                'titulo' => $libro->getTitulo(),
                'autor' => $libro->getAutor(),
                'paginas' => $libro->getPaginas(),
                'genero' => $libro->getGenero(),
                'tipo' => $libro->getTipo(),
                'unidades' => $libro->getUnidades(),
                'fechaAlta' => $fecha !== null ? $fecha->format('Y-m-d') : 'Sin fecha',
                'destacado' => $libro->getDestacado(),
                'observaciones' => $libro->getObservaciones(),
                'costeCentimos' => $libro->costeReposicionCentimos(),
            ];
        }, $libros);
    }

    public function resumen(array $libros): array
    {
        return array_reduce(
            $libros,
            function (array $acum, Libro $libro): array {
                $acum['titulos']++;
                $acum['unidades'] += $libro->getUnidades();
                $acum['paginas'] += $libro->getPaginas();
                $acum['costeCentimos'] += $libro->costeReposicionCentimos();
                return $acum;
            },
            [
                'titulos' => 0,
                'unidades' => 0,
                'paginas' => 0,
                'costeCentimos' => 0,
            ]
        );
    }
}
