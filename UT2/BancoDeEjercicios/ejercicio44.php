<?php

declare(strict_types=1);

class Autor
{
    public function __construct(
        public readonly string $nombre,
        public readonly string $codigo
    ) {}
}

class Categoria
{
    public function __construct(
        private string $nombre
    ) {
        $this->nombre = trim($this->nombre);
        if ($this->nombre === '') {
            throw new InvalidArgumentException('El nombre de la categoría no puede estar vacío');
        }
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function renombrar(string $nombre): void
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new InvalidArgumentException('El nombre de la categoría no puede estar vacío');
        }
        $this->nombre = $nombre;
    }
}

class Libro
{
    public function __construct(
        private string $titulo,
        public readonly Autor $autor,
        public readonly Categoria $categoria
    ) {}

    public function ficha(): string
    {
        return "{$this->titulo} | {$this->autor->nombre} | {$this->categoria->nombre()}";
    }
}

$autor = new Autor('Frank Herbert', 'AUT-01');
$categoria = new Categoria('Ciencia ficción');

$dune = new Libro('Dune', $autor, $categoria);
$mesias = new Libro('El mesías de Dune', $autor, $categoria);

echo $dune->ficha() . PHP_EOL;
echo $mesias->ficha() . PHP_EOL;

$categoria->renombrar('Narrativa');

echo $dune->ficha() . PHP_EOL;
echo $mesias->ficha() . PHP_EOL;
