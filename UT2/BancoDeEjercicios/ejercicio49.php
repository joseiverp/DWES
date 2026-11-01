<?php

declare(strict_types=1);

class LibroNoDisponibleException extends RuntimeException {}

class Libro
{
    private bool $disponible = true;

    public function __construct(
        private string $titulo
    ) {
        $this->titulo = trim($this->titulo);
        if ($this->titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío');
        }
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException("El libro '{$this->titulo}' no está disponible");
        }
        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

$dune = new Libro('Dune');

$dune->prestar();

try {
    $dune->prestar();
} catch (LibroNoDisponibleException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

echo "Disponibilidad tras rechazo: " . ($dune->estaDisponible() ? 'true' : 'false') . PHP_EOL;

$dune->devolver();
$dune->prestar();
echo "Operación de préstamo completada correctamente. Disponibilidad: " . ($dune->estaDisponible() ? 'true' : 'false') . PHP_EOL;

try {
    new Libro('   ');
} catch (InvalidArgumentException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}
