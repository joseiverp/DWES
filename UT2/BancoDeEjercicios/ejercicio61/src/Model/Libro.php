<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\LibroNoDisponibleException;
use InvalidArgumentException;

class Libro
{
    public function __construct(
        private int $id,
        private string $titulo,
        private int $paginas,
        private bool $disponible = true
    ) {
        $this->titulo = trim($this->titulo);

        if ($this->id <= 0 || $this->titulo === '' || $this->paginas <= 0) {
            throw new InvalidArgumentException('Datos inválidos para Libro');
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException("El libro con id {$this->id} no está disponible");
        }
        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}
