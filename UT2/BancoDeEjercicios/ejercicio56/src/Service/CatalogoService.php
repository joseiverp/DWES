<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;

class CatalogoService
{
    public function __construct(
        private LibroRepository $repo
    ) {}

    /**
     * @return Libro[]
     */
    public function disponibles(): array
    {
        return array_values(array_filter(
            $this->repo->todos(),
            fn (Libro $l): bool => $l->estaDisponible()
        ));
    }

    /**
     * @return string[]
     */
    public function titulosDisponibles(): array
    {
        return array_map(
            fn (Libro $l): string => $l->titulo(),
            $this->disponibles()
        );
    }
}
