<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;
use App\Exception\LibroNoDisponibleException;

$dune = new Libro(10, 'Dune', true);
$solaris = new Libro(20, 'Solaris', false);
$dracula = new Libro(30, 'Drácula', true);

$libros = [$dune, $solaris, $dracula];
$repo = new ArrayLibroRepository($libros);
$servicio = new CatalogoService($repo);

echo "Disponibles inicialmente: " . implode(', ', $servicio->titulosDisponibles()) . PHP_EOL;

$servicio->prestarPorId(10);
echo "Disponibles tras prestar 10: " . implode(', ', $servicio->titulosDisponibles()) . PHP_EOL;
echo "estaDisponible() de Dune en colección inicial: " . ($dune->estaDisponible() ? 'true' : 'false') . PHP_EOL;

try {
    $servicio->prestarPorId(10);
} catch (LibroNoDisponibleException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->prestarPorId(99);
} catch (InvalidArgumentException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

echo "Disponibles tras rechazos: " . implode(', ', $servicio->titulosDisponibles()) . PHP_EOL;
