<?php
declare(strict_types=1);

namespace Jose\Biblioteca\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

abstract class Libro {
    public function __construct(
        private string $titulo,
        private string $autor,
        private int $paginas,
        private string $genero,
        private int $unidades,
        private ?DateTimeImmutable $fechaAlta,
        private bool $destacado,
        private string $observaciones
    )
    {
        $this->titulo = trim($this->titulo);
        $this->autor = trim($this->autor);

        if ($this->titulo === '' || mb_strlen($this->titulo, 'UTF-8') > 120) {
            throw new InvalidArgumentException('titulo de mas de 120 caracteres');
        }

        if ($this->autor === '' || mb_strlen($this->autor, 'UTF-8') > 100) {
            throw new InvalidArgumentException('Autor de mas de 100 caracteres');
        }
        if ()
    }


    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @return string
     */
    public function getAutor(): string
    {
        return $this->autor;
    }

    /**
     * @return int
     */
    public function getPaginas(): int
    {
        return $this->paginas;
    }

    /**
     * @return string
     */
    public function getGenero(): string
    {
        return $this->genero;
    }

    /**
     * @return int
     */
    public function getUnidades(): int
    {
        return $this->unidades;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getFechaAlta(): ?DateTimeImmutable
    {
        return $this->fechaAlta;
    }

    /**
     * @return bool
     */
    public function isDestacado(): bool
    {
        return $this->destacado;
    }

    /**
     * @return string
     */
    public function getObservaciones(): string
    {
        return $this->observaciones;
    }
}