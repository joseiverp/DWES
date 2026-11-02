<?php

declare(strict_types=1);

class Libro
{
    public function __construct(
        private int $id,
        private string $titulo
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }
}

interface LibroRepository
{
    public function todos(): array;
}

class ArrayLibroRepository implements LibroRepository
{
    public function __construct(
        private array $libros
    ) {}

    public function todos(): array
    {
        return $this->libros;
    }
}

class CatalogoDemostracionRepository implements LibroRepository
{
    public function todos(): array
    {
        return [
            new Libro(10, 'Dune'),
            new Libro(20, 'Solaris'),
        ];
    }
}

function mostrarCatalogo(LibroRepository $repositorio): void
{
    $libros = $repositorio->todos();
    $total = count($libros);

    if ($total === 0) {
        echo "Catálogo vacío" . PHP_EOL;
        return;
    }

    foreach ($libros as $libro) {
        echo "ID: {$libro->id()} | Título: {$libro->titulo()}" . PHP_EOL;
    }
    echo "Total de libros: $total" . PHP_EOL;
}

$repoDemo = new CatalogoDemostracionRepository();
mostrarCatalogo($repoDemo);

$repoArray = new ArrayLibroRepository([
    new Libro(30, 'Drácula'),
    new Libro(40, 'El Hobbit'),
]);
mostrarCatalogo($repoArray);

$repoVacio = new ArrayLibroRepository([]);
mostrarCatalogo($repoVacio);
