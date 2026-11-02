<?php

declare(strict_types=1);

class OperacionBibliotecaException extends RuntimeException {}
class LibroNoDisponibleException extends OperacionBibliotecaException {}

class Libro
{
    public function __construct(
        private string $titulo,
        private bool $disponible = true
    ) {}

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
}

/**
 * @param array<int, Libro> $libros
 */
function prestarPorId(array $libros, int $id): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException("ID no positivo: $id");
    }

    if (!isset($libros[$id])) {
        throw new OperacionBibliotecaException("Libro con ID $id ausente en el sistema");
    }

    $libros[$id]->prestar();
}

$libros = [
    10 => new Libro('Dune', true),
    20 => new Libro('Solaris', false),
];

$ids = [10, 10, 20, 99, 0];

foreach ($ids as $id) {
    try {
        prestarPorId($libros, $id);
        echo "Préstamo realizado" . PHP_EOL;
    } catch (LibroNoDisponibleException $e) {
        echo "[LibroNoDisponibleException ID $id]: " . $e->getMessage() . PHP_EOL;
    } catch (OperacionBibliotecaException $e) {
        echo "[OperacionBibliotecaException ID $id]: " . $e->getMessage() . PHP_EOL;
    } catch (InvalidArgumentException $e) {
        echo "[InvalidArgumentException ID $id]: " . $e->getMessage() . PHP_EOL;
    } finally {
        echo "Fin de operación $id" . PHP_EOL;
    }
}

echo "Disponibilidad final Dune (10): " . ($libros[10]->estaDisponible() ? 'true' : 'false') . PHP_EOL;
echo "Disponibilidad final Solaris (20): " . ($libros[20]->estaDisponible() ? 'true' : 'false') . PHP_EOL;
