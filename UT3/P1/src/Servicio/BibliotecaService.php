<?php

declare(strict_types=1);

namespace Juan\Biblioteca\Servicio;
use Juan\Biblioteca\Modelo\Libro;

class BibliotecaService {

    public function __construct(private array $libros) {}
    
    public function todos(): array {
        return $this->libros;
    }

    public function agregar(Libro $libro): void {
        $libros[] = $libro;
    }

    public function filtrar (
        string $q,
        string $genero,
        string $tipo,
    ): array {
        $texto = self:: normalizar($q);

        return array_filter(
            $this->todos(),
            fn(Libro $1) => (str_contains(self::normalizar($l->titulo()), $texto)
                || str_contains(self)
            )
        );
    }

    public function filas(array $libros): array {
        return array_map(
            fn(Libro $l) => [
                "titulo" => $l->titulo(),
                "autor" => $l->autor(),
                "paginas" => $l->paginas(),
                "genero" => $l->genero(),
                "tipo" => $l->getTipo(),
                "unidades" => $l->uidades(),
                "fechaAlta" => $l->fechaAlta() ?->format('Y-m-D') ?? "Sin fecha",
                "destacado" => $l->destacado(),
                "observaciones" => $l->observaciones(),
                "costeCentimos" => $l->costeRepositorioCentimos(),
            ],
            $libros
        );
    }

    public function resumen(array $libros): array {
        return array_reduce(
            $this->todos,
            fn(array $carry, Libro $l) => [
                "titulo" => ++$carry["titulo"],
                "unidades" => 
            ]
        )
    }
        
        
}