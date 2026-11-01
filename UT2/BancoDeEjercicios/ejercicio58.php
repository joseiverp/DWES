<?php

declare(strict_types=1);

enum EstadoEjemplar: string
{
    case Disponible = 'disponible';
    case Prestado = 'prestado';
    case Perdido = 'perdido';
}

class Ejemplar
{
    public function __construct(
        private string $codigo,
        private EstadoEjemplar $estado = EstadoEjemplar::Disponible
    ) {}

    public function codigo(): string
    {
        return $this->codigo;
    }

    public function estado(): EstadoEjemplar
    {
        return $this->estado;
    }

    public function prestar(): void
    {
        if ($this->estado !== EstadoEjemplar::Disponible) {
            throw new LogicException("No se puede prestar desde el estado {$this->estado->value}");
        }
        $this->estado = EstadoEjemplar::Prestado;
    }

    public function devolver(): void
    {
        if ($this->estado !== EstadoEjemplar::Prestado) {
            throw new LogicException("No se puede devolver desde el estado {$this->estado->value}");
        }
        $this->estado = EstadoEjemplar::Disponible;
    }

    public function marcarPerdido(): void
    {
        if ($this->estado === EstadoEjemplar::Perdido) {
            throw new LogicException("El ejemplar ya está perdido");
        }
        $this->estado = EstadoEjemplar::Perdido;
    }
}

$e01 = new Ejemplar('E-01', EstadoEjemplar::Disponible);

$e01->prestar();
echo "{$e01->codigo()} -> {$e01->estado()->value}" . PHP_EOL;

$e01->devolver();
echo "{$e01->codigo()} -> {$e01->estado()->value}" . PHP_EOL;

$e01->prestar();
echo "{$e01->codigo()} -> {$e01->estado()->value}" . PHP_EOL;

$e01->marcarPerdido();
echo "{$e01->codigo()} -> {$e01->estado()->value}" . PHP_EOL;

try {
    $e01->devolver();
} catch (LogicException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

$e02 = new Ejemplar('E-02', EstadoEjemplar::Disponible);
try {
    $e02->devolver();
} catch (LogicException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

echo "Estado final {$e01->codigo()}: {$e01->estado()->value}" . PHP_EOL;
echo "Estado final {$e02->codigo()}: {$e02->estado()->value}" . PHP_EOL;
