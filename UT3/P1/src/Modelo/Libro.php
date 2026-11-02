<?php

declare(strict_types=1);

namespace Jose\Biblioteca\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

abstract class Libro
{
    public function __construct(
        private string $titulo,
        private string $autor,
        private int $paginas,
        private string $genero,
        private int $unidades,
        private ?DateTimeImmutable $fechaAlta = null,
        private bool $destacado = false,
        private string $observaciones = ''
    ) {
        $this->titulo = trim($this->titulo);
        $this->autor = trim($this->autor);
        $this->observaciones = trim($this->observaciones);

        // validamos los limites antes de aceptar los datos
        if ($this->titulo === '' || mb_strlen($this->titulo, 'UTF-8') > 120) {
            throw new InvalidArgumentException('El título no es válido.');
        }

        if ($this->autor === '' || mb_strlen($this->autor, 'UTF-8') > 100) {
            throw new InvalidArgumentException('El autor no es válido.');
        }

        if ($this->paginas < 1 || $this->paginas > 3000) {
            throw new InvalidArgumentException('Las páginas deben estar entre 1 y 3000.');
        }

        if (!in_array($this->genero, ['ciencia', 'fantasia', 'terror'], true)) {
            throw new InvalidArgumentException('El género no es válido.');
        }

        if ($this->unidades < 1 || $this->unidades > 50) {
            throw new InvalidArgumentException('Las unidades deben estar entre 1 y 50.');
        }

        if (mb_strlen($this->observaciones, 'UTF-8') > 300) {
            throw new InvalidArgumentException('Las observaciones no pueden superar 300 caracteres.');
        }
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getPaginas(): int
    {
        return $this->paginas;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function getUnidades(): int
    {
        return $this->unidades;
    }

    public function getFechaAlta(): ?DateTimeImmutable
    {
        return $this->fechaAlta;
    }

    public function getDestacado(): bool
    {
        return $this->destacado;
    }

    public function getObservaciones(): string
    {
        return $this->observaciones;
    }

    abstract public function getTipo(): string;

    abstract public function costeReposicionCentimos(): int;
}
