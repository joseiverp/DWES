<?php

declare(strict_types=1);

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
            throw new LogicException('El libro ya está prestado');
        }
        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

$dune = new Libro(10, 'Dune', 412);
$solaris = new Libro(20, 'Solaris', 216);

echo "Dune: {$dune->id()} - {$dune->titulo()} ({$dune->paginas()} págs) - " . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;
echo "Solaris: {$solaris->id()} - {$solaris->titulo()} ({$solaris->paginas()} págs) - " . ($solaris->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

$dune->prestar();
echo "Dune tras prestar: " . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;
echo "Solaris: " . ($solaris->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

$dune->devolver();
echo "Dune tras devolver: " . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;
echo "Solaris: " . ($solaris->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

$dune->prestar();
try {
    $dune->prestar();
} catch (LogicException $e) {
    echo "Capturada LogicException: " . $e->getMessage() . PHP_EOL;
}
echo "Estado Dune: " . ($dune->estaDisponible() ? 'Disponible' : 'Prestado') . PHP_EOL;

try {
    new Libro(30, 'Inválido', 0);
} catch (InvalidArgumentException $e) {
    echo "Capturada InvalidArgumentException: " . $e->getMessage() . PHP_EOL;
}
