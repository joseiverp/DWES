<?php

declare(strict_types=1);

$datos = [
    ['titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
    ['titulo' => 'Solaris', 'paginas' => 216, 'disponible' => false],
    ['titulo' => 'Drácula', 'paginas' => 418, 'disponible' => true],
    ['titulo' => 'El Hobbit', 'paginas' => 310, 'disponible' => true],
];

function titulosDisponiblesHasta(array $datos, int $maximo): array
{
    if ($maximo < 1) {
        throw new InvalidArgumentException("El máximo debe ser al menos 1");
    }

    $filtrados = array_filter(
        $datos,
        fn (array $d): bool => $d['disponible'] && $d['paginas'] <= $maximo
    );

    return array_values(array_map(fn (array $d): string => $d['titulo'], $filtrados));
}

class Libro
{
    public function __construct(
        private string $titulo,
        private int $paginas,
        private bool $disponible
    ) {}

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
}

class CatalogoService
{
    /**
     * @param Libro[] $libros
     */
    public function __construct(
        private array $libros
    ) {}

    /**
     * @return string[]
     */
    public function titulosDisponiblesHasta(int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException("El máximo debe ser al menos 1");
        }

        $filtrados = array_filter(
            $this->libros,
            fn (Libro $l): bool => $l->estaDisponible() && $l->paginas() <= $maximo
        );

        return array_values(array_map(fn (Libro $l): string => $l->titulo(), $filtrados));
    }
}

$librosObjetos = array_map(
    fn (array $d): Libro => new Libro($d['titulo'], $d['paginas'], $d['disponible']),
    $datos
);
$servicio = new CatalogoService($librosObjetos);

$valoresPrueba = [400, 500, 100];

foreach ($valoresPrueba as $val) {
    $resFunc = titulosDisponiblesHasta($datos, $val);
    $resServ = $servicio->titulosDisponiblesHasta($val);

    echo "Max $val (función): " . (empty($resFunc) ? '[]' : implode(', ', $resFunc)) . PHP_EOL;
    echo "Max $val (servicio): " . (empty($resServ) ? '[]' : implode(', ', $resServ)) . PHP_EOL;
}

try {
    titulosDisponiblesHasta($datos, 0);
} catch (InvalidArgumentException $e) {
    echo "Capturada función (0): " . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->titulosDisponiblesHasta(0);
} catch (InvalidArgumentException $e) {
    echo "Capturada servicio (0): " . $e->getMessage() . PHP_EOL;
}
