<?php

declare(strict_types=1);

abstract class RecursoBiblioteca
{
    public function __construct(
        private int $id,
        protected string $titulo
    ) {
        $this->titulo = trim($this->titulo);
        if ($this->id <= 0 || $this->titulo === '') {
            throw new InvalidArgumentException('Datos inválidos para RecursoBiblioteca');
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

    abstract public function tipo(): string;

    final public function origen(): string
    {
        return 'Biblioteca';
    }
}

class Libro extends RecursoBiblioteca
{
    public function __construct(
        int $id,
        string $titulo,
        private int $paginas
    ) {
        parent::__construct($id, $titulo);
        if ($this->paginas <= 0) {
            throw new InvalidArgumentException('Las páginas deben ser positivas');
        }
    }

    public function tipo(): string
    {
        return 'libro';
    }

    public function ficha(): string
    {
        return "Libro: {$this->titulo} ({$this->paginas} págs)";
    }
}

class Revista extends RecursoBiblioteca
{
    public function __construct(
        int $id,
        string $titulo,
        private int $numero
    ) {
        parent::__construct($id, $titulo);
        if ($this->numero <= 0) {
            throw new InvalidArgumentException('El número debe ser positivo');
        }
    }

    public function tipo(): string
    {
        return 'revista';
    }

    public function ficha(): string
    {
        return "Revista: {$this->titulo} (Nº {$this->numero})";
    }
}

$recursos = [
    new Libro(10, 'Dune', 412),
    new Revista(20, 'Ciencia', 7),
];

foreach ($recursos as $recurso) {
    echo "ID: {$recurso->id()} | Título: {$recurso->titulo()} | Tipo: {$recurso->tipo()} | Origen: {$recurso->origen()}" . PHP_EOL;
    echo $recurso->ficha() . PHP_EOL;
}
