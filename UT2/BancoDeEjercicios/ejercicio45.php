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

    public function cambiarEstado(EstadoEjemplar $estado): void
    {
        $this->estado = $estado;
    }
}

$e01 = new Ejemplar('E-01', EstadoEjemplar::Disponible);
$e02 = new Ejemplar('E-02', EstadoEjemplar::Prestado);
$e03 = new Ejemplar('E-03', EstadoEjemplar::Perdido);

$ejemplares = [$e01, $e02, $e03];

foreach ($ejemplares as $ejemplar) {
    echo "{$ejemplar->codigo()} - {$ejemplar->estado()->name} ({$ejemplar->estado()->value})" . PHP_EOL;
}

$disponibles = array_filter(
    $ejemplares,
    fn (Ejemplar $e): bool => $e->estado() === EstadoEjemplar::Disponible
);

foreach ($disponibles as $d) {
    echo "Disponible: {$d->codigo()}" . PHP_EOL;
}

$entradas = ['prestado', 'perdido', 'reservado'];

foreach ($entradas as $entrada) {
    $nuevoEstado = EstadoEjemplar::tryFrom($entrada);
    $nuevoEstado !== null ? $e01->cambiarEstado($nuevoEstado) : print("Estado no válido: $entrada" . PHP_EOL);
    echo "Estado actual de {$e01->codigo()}: {$e01->estado()->value}" . PHP_EOL;
}

echo "Valores admitidos:" . PHP_EOL;
foreach (EstadoEjemplar::cases() as $caso) {
    $cantidad = count(array_filter($ejemplares, fn (Ejemplar $e): bool => $e->estado() === $caso));
    echo "- {$caso->value}: $cantidad ejemplares" . PHP_EOL;
}
